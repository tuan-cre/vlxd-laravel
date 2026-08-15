<?php
require_once __DIR__ . '/../../model/database.php';

$db = DATABASE::connect();
try {
    // Check if employee_code column exists
    $stmt = $db->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'employees' AND COLUMN_NAME = 'employee_code'");
    $stmt->execute();
    $exists = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$exists){
        echo "Column employee_code does not exist in employees table. Nothing to do.\n";
        exit;
    }

    // Drop unique index on employee_code if present
    $idxSql = "SELECT INDEX_NAME FROM INFORMATION_SCHEMA.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='employees' AND COLUMN_NAME='employee_code'";
    $idxStmt = $db->prepare($idxSql);
    $idxStmt->execute();
    $idxRows = $idxStmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($idxRows as $row){
        $idxName = $row['INDEX_NAME'];
        if(!empty($idxName)){
            echo "Dropping index: $idxName\n";
            $db->exec("ALTER TABLE employees DROP INDEX `" . $idxName . "`");
        }
    }

    // Drop the column
    $db->exec("ALTER TABLE employees DROP COLUMN employee_code");
    echo "Dropped column employee_code from employees table.\n";

} catch (PDOException $e){
    echo "Migration failed: " . $e->getMessage() . PHP_EOL;
}

?>
