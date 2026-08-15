<?php
header('Content-Type: application/json; charset=utf-8');
// Increase time limit for polling (Coze can take 10-20 seconds)
set_time_limit(60); 

if (session_status() == PHP_SESSION_NONE) session_start();

// --- 1. Load Configuration ---
$config_file = __DIR__ . '/../../config/coze.php';
if (!file_exists($config_file)) {
    http_response_code(500);
    echo json_encode(['error' => 'Missing Coze config']);
    exit;
}
require $config_file;

// --- 2. Helper Function (Supports GET & POST) ---
function call_coze($url, $payload = [], $apiKey, $method = 'POST') {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Headers as per docs
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    } else {
        curl_setopt($ch, CURLOPT_HTTPGET, true);
    }

    $resp = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_error($ch);
    curl_close($ch);

    if ($resp === false) {
        return ['status' => 'failed', 'error' => $err];
    }
    return ['status' => 'ok', 'code' => $code, 'json' => json_decode($resp, true)];
}

// --- 3. Validate Input ---
$input = json_decode(file_get_contents('php://input'), true);
$message = trim($input['message'] ?? '');

// User ID logic (Docs say: "defined, generated, and maintained by the user")
$client_user_id = $input['user_id'] ?? ($_SESSION['coze_user_id'] ?? 'web_user_' . bin2hex(random_bytes(4)));
$_SESSION['coze_user_id'] = $client_user_id;

if ($message === '') {
    echo json_encode(['error' => 'Missing message']);
    exit;
}

// --- 4. STEP 1: Initiate Chat (POST) ---
// Docs: "Call the initiate conversation interface... set stream = false, auto_save_history=true"
$init_url = "https://api.coze.com/v3/chat";
$payload = [
    "bot_id" => (string)$COZE_BOT_ID,
    "user_id" => (string)$client_user_id,
    "stream" => false, 
    "auto_save_history" => true, // REQUIRED for non-streaming
    "additional_messages" => [
        [
            "role" => "user",
            "content" => $message,
            "content_type" => "text"
        ]
    ]
];

// If continuing a conversation, add conversation_id
if (!empty($input['conversation_id'])) {
    $payload['conversation_id'] = $input['conversation_id'];
}

$init = call_coze($init_url, $payload, $COZE_API_KEY, 'POST');

// Check for Error 4101 (Auth) or others
if (($init['json']['code'] ?? -1) !== 0) {
    http_response_code(400);
    echo json_encode([
        'error' => 'Coze Init Failed', 
        'code' => $init['json']['code'] ?? 'Unknown',
        'msg' => $init['json']['msg'] ?? 'Check your API Key permissions'
    ]);
    exit;
}

$chat_id = $init['json']['data']['id'];
$conversation_id = $init['json']['data']['conversation_id'];

// --- 5. STEP 2: Poll Status (GET) ---
// Docs: "Periodically poll... until status is completed"
$status = 'in_progress';
$max_retries = 30; // 30 seconds max wait

for ($i = 0; $i < $max_retries; $i++) {
    sleep(1); // Docs recommend "interval more than 1 second"

    $poll_url = "https://api.coze.com/v3/chat/retrieve?chat_id={$chat_id}&conversation_id={$conversation_id}";
    $poll_res = call_coze($poll_url, [], $COZE_API_KEY, 'GET');

    $status = $poll_res['json']['data']['status'] ?? 'unknown';

    if ($status === 'completed') {
        break;
    } elseif ($status === 'failed' || $status === 'canceled') {
        echo json_encode(['error' => 'Chat processing failed', 'status' => $status]);
        exit;
    }
}

if ($status !== 'completed') {
    echo json_encode(['error' => 'Timeout waiting for AI', 'conversation_id' => $conversation_id]);
    exit;
}

// --- 6. STEP 3: Get Messages (GET) ---
// Docs: "Call the list chat messages interface to query the final result"
$list_url = "https://api.coze.com/v3/chat/message/list?chat_id={$chat_id}&conversation_id={$conversation_id}";
$msgs_res = call_coze($list_url, [], $COZE_API_KEY, 'GET');

$reply = "No response text found.";

if (isset($msgs_res['json']['data'])) {
    foreach ($msgs_res['json']['data'] as $msg) {
        // We look for the 'answer' from the 'assistant'
        if ($msg['role'] === 'assistant' && $msg['type'] === 'answer') {
            $reply = $msg['content'];
            // If the bot sends multiple messages, this grabs the last one. 
            // You can concatenate them if preferred.
        }
    }
}

echo json_encode([
    'reply' => $reply,
    'conversation_id' => $conversation_id,
    'user_id' => $client_user_id
]);
?>