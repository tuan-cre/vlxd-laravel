<?php
$databasePath = __DIR__ . '/../model/database.php';
if(!file_exists($databasePath)) {
    die("Database configuration not found at $databasePath\n");
}
require_once($databasePath);
$db = DATABASE::connect();
try {
    $sql = "CREATE TABLE IF NOT EXISTS order_inventory (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        warehouse_id INT NOT NULL,
        quantity INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
        FOREIGN KEY (warehouse_id) REFERENCES warehouses(id) ON DELETE CASCADE
    ) ENGINE=InnoDB";
    $db->exec($sql);
    echo "Migration succeeded: 'order_inventory' created." . PHP_EOL;
} catch(PDOException $e) {
    echo "Migration error: " . $e->getMessage() . PHP_EOL;
}
?>
