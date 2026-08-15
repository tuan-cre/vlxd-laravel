<?php
$databasePath = __DIR__ . '/../model/database.php';
if(!file_exists($databasePath)) die("Database configuration not found: $databasePath\n");
require_once($databasePath);
require_once(__DIR__ . '/../model/sanpham.php');
$db = DATABASE::connect();
$sp = new SANPHAM();

// Ensure default warehouse exists
$defaultWarehouseId = $sp->getDefaultWarehouseId();
if(!$defaultWarehouseId){
    echo "No warehouse found. Please create a warehouse first.\n";
    exit(1);
}

$sql = 'SELECT id, stock FROM products';
$cmd = $db->prepare($sql);
$cmd->execute();
$products = $cmd->fetchAll(PDO::FETCH_ASSOC);
$countCreated = 0;
foreach($products as $p) {
    $pid = (int)$p['id'];
    $stock = (int)$p['stock'];
    // check if inventory exists for this product
    $check = $db->prepare('SELECT COUNT(*) AS cnt FROM inventory WHERE product_id = :pid');
    $check->bindValue(':pid', $pid);
    $check->execute();
    $row = $check->fetch(PDO::FETCH_ASSOC);
    if((int)$row['cnt'] === 0 && $stock > 0){
        $ins = $db->prepare('INSERT INTO inventory (product_id, warehouse_id, stock) VALUES (:pid, :wid, :stock)');
        $ins->bindValue(':pid', $pid);
        $ins->bindValue(':wid', $defaultWarehouseId);
        $ins->bindValue(':stock', $stock);
        $ins->execute();
        $countCreated++;
        echo "Inserted inventory for product_id=$pid stock=$stock to warehouse_id=$defaultWarehouseId\n";
    }
}
echo "Done. Created $countCreated inventory rows where missing.\n";
?>
