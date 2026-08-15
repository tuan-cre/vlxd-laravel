<?php
require_once __DIR__ . '/../../model/database.php';

$db = DATABASE::connect();
try {
    // Check if phone_number column exists
    $stmt = $db->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'employees' AND COLUMN_NAME = 'phone_number'");
    $stmt->execute();
    $exists = $stmt->fetch(PDO::FETCH_ASSOC);
    if($exists){
        echo "Column phone_number already exists in employees table.\n";
    } else {
        $sql = "ALTER TABLE employees ADD COLUMN phone_number VARCHAR(20) DEFAULT NULL";
        $db->exec($sql);
        echo "Added phone_number column to employees table.\n";
    }

    // Check email column and add if missing
    $stmt2 = $db->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'employees' AND COLUMN_NAME = 'email'");
    $stmt2->execute();
    $exists2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    if($exists2){
        echo "Column email already exists in employees table.\n";
    } else {
        $sql = "ALTER TABLE employees ADD COLUMN email VARCHAR(100) DEFAULT NULL";
        $db->exec($sql);
        echo "Added email column to employees table.\n";
    }

        // Deduplicate emails if there are duplicates, to ensure we can add a unique index
        // Strategy: For each duplicated email (non-null), keep the first; for others, append '-id' before the domain
        $dupSql = "SELECT email FROM employees WHERE email IS NOT NULL GROUP BY email HAVING COUNT(*) > 1";
        $dupStmt = $db->prepare($dupSql);
        $dupStmt->execute();
        $dups = $dupStmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($dups as $r){
            $email = $r['email'];
            $stmtEmails = $db->prepare("SELECT id, email FROM employees WHERE email = :email ORDER BY id ASC");
            $stmtEmails->execute([':email' => $email]);
            $rows = $stmtEmails->fetchAll(PDO::FETCH_ASSOC);
            // Keep first, adjust the rest
            $first = true;
            foreach($rows as $row){
                if($first){
                    $first = false;
                    continue;
                }
                $id = $row['id'];
                $e = $row['email'];
                // attempt to split local@domain
                if(strpos($e, '@') !== false){
                    list($local, $domain) = explode('@', $e, 2);
                    $newEmail = $local . '+' . $id . '@' . $domain;
                } else {
                    $newEmail = $e . '-' . $id;
                }
                $upd = $db->prepare("UPDATE employees SET email = :newEmail WHERE id = :id");
                $upd->execute([':newEmail' => $newEmail, ':id' => $id]);
                echo "Updated duplicate email for employee id $id to $newEmail\n";
            }
        }

        // Create unique index if not exists
        $idxSql = "SELECT COUNT(1) as cnt FROM INFORMATION_SCHEMA.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='employees' AND INDEX_NAME='uniq_employees_email'";
        $idxStmt = $db->prepare($idxSql);
        $idxStmt->execute();
        $idxRow = $idxStmt->fetch(PDO::FETCH_ASSOC);
        if($idxRow && $idxRow['cnt'] > 0){
            echo "Unique index 'uniq_employees_email' already exists.\n";
        } else {
            $db->exec("ALTER TABLE employees ADD UNIQUE KEY uniq_employees_email (email)");
            echo "Added unique index on employees.email\n";
        }
} catch(PDOException $e){
    echo "Migration failed: " . $e->getMessage() . PHP_EOL;
}

?>
