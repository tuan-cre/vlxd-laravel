<?php
require_once(__DIR__ . '/../model/database.php');
$db = DATABASE::connect();
try{
    $sql = "ALTER TABLE coupons ADD COLUMN points_cost INT DEFAULT 0, ADD COLUMN min_member_level ENUM('bronze','silver','gold','platinum') DEFAULT 'bronze'";
    $db->exec($sql);
    echo "Migration succeeded: coupons.points_cost and min_member_level added." . PHP_EOL;
} catch(PDOException $e){
    echo "Migration error: " . $e->getMessage() . PHP_EOL;
}
?>
