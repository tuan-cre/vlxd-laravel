<?php
require_once(__DIR__ . '/../model/database.php');
$db = DATABASE::connect();
try{
    // Ensure points_cost is non-negative
    $db->exec("UPDATE coupons SET points_cost = 0 WHERE points_cost IS NULL OR points_cost < 0");
    echo "Normalized points_cost to non-negative values.\n";

    // Ensure min_member_level is one of allowed values, otherwise set to 'bronze'
    $allowed = ['bronze','silver','gold','platinum'];
    $sql = "SELECT id, min_member_level FROM coupons";
    $cmd = $db->prepare($sql);
    $cmd->execute();
    $rows = $cmd->fetchAll(PDO::FETCH_ASSOC);
    foreach($rows as $r){
        $lvl = strtolower(trim($r['min_member_level'] ?? ''));
        if(!in_array($lvl, $allowed)){
            $u = $db->prepare("UPDATE coupons SET min_member_level = 'bronze' WHERE id = :id");
            $u->bindValue(':id', $r['id']);
            $u->execute();
            echo "Updated coupon id {$r['id']} min_member_level to bronze (was: {$r['min_member_level']}).\n";
        } else {
            // ensure it is lowercased
            if($r['min_member_level'] !== $lvl){
                $u = $db->prepare("UPDATE coupons SET min_member_level = :lvl WHERE id = :id");
                $u->bindValue(':lvl', $lvl);
                $u->bindValue(':id', $r['id']);
                $u->execute();
                echo "Normalized coupon id {$r['id']} min_member_level to $lvl.\n";
            }
        }
    }

    echo "Coupon value normalization completed.\n";
} catch(PDOException $e){
    echo "Migration error: " . $e->getMessage() . PHP_EOL;
}
?>
