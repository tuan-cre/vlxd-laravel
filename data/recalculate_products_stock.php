<?php
$databasePath = __DIR__ . '/../model/database.php';
if(!file_exists($databasePath)) die("Database configuration not found: $databasePath\n");
require_once($databasePath);
$db = DATABASE::connect();
try{
    $sql = "UPDATE products p SET stock = (
        SELECT COALESCE(SUM(i.stock),0) FROM inventory i WHERE i.product_id = p.id
    )";
    $db->exec($sql);
    echo "Products stock recalculated from inventory." . PHP_EOL;
} catch(PDOException $e){
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
?>
