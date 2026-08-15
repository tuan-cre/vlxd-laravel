<?php
// Tab Nổi bật - hiển thị sản phẩm có is_featured = 1
$products = $sanphamnoibat ?? array();
$empty_message = "Hiện tại chưa có sản phẩm nổi bật";
include("inc/product_list_compact.php");
?>
