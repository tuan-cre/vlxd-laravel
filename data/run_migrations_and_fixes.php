<?php
// Ensure database.php is in model folder
$databasePath = __DIR__ . '/../model/database.php';
if(!file_exists($databasePath)) die("Database configuration not found: $databasePath\n");
require_once($databasePath);
// Runs a sequence of maintenance tasks in a safe order.
// Important: Back up your database before running this script!

$db = DATABASE::connect();
try{
    echo "Running migration: create order_inventory if not exists...\n";
    require_once('migrate_create_order_inventory.php');
    echo "Running migration: add stock_applied if missing...\n";
    require_once('migrate_add_order_stock_applied.php');
    echo "Populating inventory rows from products (products.stock -> inventory) where missing...\n";
    require_once('populate_inventory_from_products.php');
    echo "Recalculating products.stock from inventory...\n";
    require_once('recalculate_products_stock.php');
    echo "Adding coupon points and min_member_level fields if missing...\n";
    require_once('migrate_add_coupon_points_and_minlevel.php');
    echo "Creating customer_coupons table if missing...\n";
    require_once('migrate_create_customer_coupons.php');
    echo "Adding role_id to employees and customers if missing...\n";
    require_once('migrate_add_roleid_to_employee_and_customer.php');
    echo "Ensure a bronze points-based coupon exists...\n";
    require_once('migrate_ensure_bronze_points_coupon.php');
    echo "Normalize existing coupon values (points/min_level)...\n";
    require_once('migrate_fix_coupon_values.php');
    echo "All migrations and fixes executed.\n";
} catch (Exception $e) {
    echo "An error occurred during migration: " . $e->getMessage() . "\n";
}

echo "NOTE: Please verify your backups and run a sample order flow to ensure everything works as expected.\n";
?>
