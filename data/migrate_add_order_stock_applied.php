<?php
/* Migration: Add stock_applied column to orders table for tracking whether stock adjustments were applied
   This migration is safe to run on existing DBs and sets default 0 for existing rows.
*/
$databasePath = __DIR__ . '/../model/database.php';
if(!file_exists($databasePath)) {
    die("Database configuration not found at $databasePath\n");
}
require_once($databasePath);
$db = DATABASE::connect();
try {
    // Run only if column does not exist
    $sql_check = "SELECT COUNT(*) AS cnt FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'orders' AND column_name = 'stock_applied'";
    $cnt = $db->query($sql_check)->fetch(PDO::FETCH_ASSOC);
    if(!$cnt || (int)$cnt['cnt'] === 0){
        $sql = "ALTER TABLE orders ADD COLUMN stock_applied TINYINT DEFAULT 0";
        $db->exec($sql);
        echo "Migration succeeded: 'stock_applied' added to orders table." . PHP_EOL;
    } else {
        echo "Migration skipped: 'stock_applied' already exists on orders table." . PHP_EOL;
    }
} catch(PDOException $e) {
    echo "Migration error: " . $e->getMessage() . PHP_EOL;
}
?>
