<?php
require_once(__DIR__ . '/../model/database.php');
$db = DATABASE::connect();
try{
    $sql = "CREATE TABLE IF NOT EXISTS customer_coupons (
        id INT AUTO_INCREMENT PRIMARY KEY,
        customer_id INT NOT NULL,
        coupon_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
        FOREIGN KEY (coupon_id) REFERENCES coupons(id) ON DELETE CASCADE
    ) ENGINE=InnoDB";
    $db->exec($sql);
    echo "Migration succeeded: 'customer_coupons' created." . PHP_EOL;
} catch(PDOException $e){
    echo "Migration error: " . $e->getMessage() . PHP_EOL;
}
?>
