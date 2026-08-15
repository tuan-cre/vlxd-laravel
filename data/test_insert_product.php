<?php
require_once __DIR__ . '/../model/database.php';
require_once __DIR__ . '/../model/sanpham.php';

$sp = new SANPHAM();
$p = new SANPHAM();
$p->category_id = 1;
$p->brand_id = 1;
$p->name = 'Test Insert Product ' . time();
$p->price = 12345;
$p->sale_price = 0;
$p->unit = 'Cái';
$p->stock = 10;
$p->thumbnail = '';
$p->description = 'Test product description';
$p->content = 'Test product content';
$p->is_featured = 0;

try{
    $res = $sp->themSanPham($p);
    if($res) {
        echo "Product inserted successfully\n";
    } else {
        echo "Insert returned false\n";
    }
} catch(Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

?>
