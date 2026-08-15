<?php
// Add role_id column to employees and customers if missing and populate default values
require_once(__DIR__ . '/../model/database.php');

$db = new PDO('mysql:host=localhost;dbname=vlxd_db;charset=utf8mb4', 'root', '');
// Use DATABASE::connect if available
try {
    $db = DATABASE::connect();
} catch (Exception $e) {
    // Keep using the manual PDO
}

// Employees
$res = $db->query("SHOW COLUMNS FROM employees LIKE 'role_id'");
if ($res->rowCount() == 0) {
    $db->exec("ALTER TABLE employees ADD COLUMN role_id INT DEFAULT 3 AFTER user_id");
    echo "Added role_id to employees\n";
    $db->exec("UPDATE employees SET role_id = 3 WHERE role_id IS NULL OR role_id = 0");
}

// Customers
$res = $db->query("SHOW COLUMNS FROM customers LIKE 'role_id'");
if ($res->rowCount() == 0) {
    $db->exec("ALTER TABLE customers ADD COLUMN role_id INT DEFAULT 2 AFTER user_id");
    echo "Added role_id to customers\n";
    $db->exec("UPDATE customers SET role_id = 2 WHERE role_id IS NULL OR role_id = 0");
}

echo "Migration for role_id complete.\n";

?>
