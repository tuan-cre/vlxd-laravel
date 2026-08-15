<?php
require_once(__DIR__ . '/../model/database.php');
$db = DATABASE::connect();
try{
    // Check if there's any bronze-level coupon requiring points
    $check = $db->prepare("SELECT id FROM coupons WHERE min_member_level = 'bronze' AND points_cost > 0 LIMIT 1");
    $check->execute();
    if($check->fetch()){
        echo "Bronze points coupon exists; nothing to do.\n";
        exit();
    }

    // Try to update an existing bronze coupon (prefer SAVE20K if present)
    $upd = $db->prepare("UPDATE coupons SET points_cost = :points WHERE code = :code AND min_member_level = 'bronze'");
    $upd->bindValue(':points', 100);
    $upd->bindValue(':code', 'SAVE20K');
    $upd->execute();
    if($upd->rowCount() > 0){
        echo "Updated SAVE20K to be redeemable by 100 points (bronze).\n";
        exit();
    }

    // If SAVE20K not found, try WELCOME10
    $upd->bindValue(':code', 'WELCOME10');
    $upd->execute();
    if($upd->rowCount() > 0){
        echo "Updated WELCOME10 to be redeemable by 100 points (bronze).\n";
        exit();
    }

    // Otherwise insert new bronze points coupon
    $ins = $db->prepare("INSERT INTO coupons (code, discount_type, discount_value, min_order_value, start_date, end_date, usage_limit, status, points_cost, min_member_level) VALUES (:code, 'fixed', 25000, 0, NULL, NULL, 200, 1, :points, 'bronze')");
    $ins->bindValue(':code', 'BRONZE25');
    $ins->bindValue(':points', 100);
    $ins->execute();
    echo "Inserted BRONZE25 redeemable by 100 points (bronze).\n";
} catch(PDOException $e){
    echo "Migration error: " . $e->getMessage() . PHP_EOL;
}
?>
