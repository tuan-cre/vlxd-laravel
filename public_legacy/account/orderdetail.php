<?php include("inc/top.php"); ?>

<?php
requireLogin();

if(!isset($_GET["id"])){
    header("location:index.php?action=donhang");
    exit();
}

$order_id = $_GET["id"];

// Lấy thông tin đơn hàng
$dh = new DONHANG();
$order = $dh->laydonhangtheoid($order_id);

// Kiểm tra xem đơn hàng có thuộc về khách hàng này không
if(!$order || $order['customer_id'] != getCustomerId()){
    echo "<div class='container my-5'>";
    echo "<div class='alert alert-danger'><i class='bi bi-exclamation-triangle me-2'></i> Không tìm thấy đơn hàng hoặc bạn không có quyền xem đơn hàng này.</div>";
    echo "<a href='index.php?action=donhang' class='btn btn-primary'><i class='bi bi-arrow-left me-2'></i> Quay lại</a>";
    echo "</div>";
    include("inc/bottom.php");
    exit();
}

// Lấy chi tiết đơn hàng
$ct = new DONHANGCT();
$order_details = $ct->layChiTietDonHang($order_id);

$status_class = [1 => 'warning', 2 => 'info', 3 => 'primary', 4 => 'success', 5 => 'danger'];
$status_text = [
    1 => 'Chờ xác nhận',
    2 => 'Đã xác nhận',
    3 => 'Đang giao hàng',
    4 => 'Đã giao hàng',
    5 => 'Đã hủy'
];
?>

<div class="container my-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3><i class="bi bi-receipt me-2"></i> Chi tiết đơn hàng #<?php echo $order["id"]; ?></h3>
                    <p class="text-muted mb-0">Đặt ngày: <?php echo date("d/m/Y H:i", strtotime($order["order_date"])); ?></p>
                </div>
                <div>
                    <a href="index.php?action=donhang" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Thông tin đơn hàng -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i> Danh sách sản phẩm</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Đơn giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($order_details as $item): 
                                    $sp = new SANPHAM();
                                    $product = $sp->laySanPhamTheoId($item['product_id']);
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="../images/products/<?php echo $product['thumbnail']; ?>" alt="<?php echo $product['name']; ?>" 
                                                 class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0"><?php echo $product['name']; ?></h6>
                                                <small class="text-muted">SKU: <?php echo $product['sku'] ?? 'N/A'; ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?php echo number_format($item['unit_price']); ?>đ
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge bg-secondary"><?php echo $item['quantity']; ?></span>
                                    </td>
                                    <td class="text-end align-middle">
                                        <strong class="text-danger"><?php echo number_format($item['total_price']); ?>đ</strong>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                    <td class="text-end">
                                        <h5 class="text-danger mb-0"><?php echo number_format($order['total_money']); ?>đ</h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Thông tin giao hàng và thanh toán -->
        <div class="col-md-4">
            <!-- Trạng thái đơn hàng -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="card-title"><i class="bi bi-info-circle me-2"></i> Trạng thái đơn hàng</h6>
                    <div class="text-center py-3">
                        <span class="badge bg-<?php echo $status_class[$order['status']]; ?> fs-6 px-4 py-2">
                            <?php echo $status_text[$order['status']]; ?>
                        </span>
                    </div>
                    
                    <!-- Timeline trạng thái -->
                    <div class="mt-3">
                        <div class="d-flex align-items-center mb-2 <?php echo $order['status'] >= 1 ? 'text-success' : 'text-muted'; ?>">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <small>Đơn hàng đã đặt</small>
                        </div>
                        <div class="d-flex align-items-center mb-2 <?php echo $order['status'] >= 2 ? 'text-success' : 'text-muted'; ?>">
                            <i class="bi bi-<?php echo $order['status'] >= 2 ? 'check-circle-fill' : 'circle'; ?> me-2"></i>
                            <small>Đã xác nhận</small>
                        </div>
                        <div class="d-flex align-items-center mb-2 <?php echo $order['status'] >= 3 ? 'text-success' : 'text-muted'; ?>">
                            <i class="bi bi-<?php echo $order['status'] >= 3 ? 'check-circle-fill' : 'circle'; ?> me-2"></i>
                            <small>Đang giao hàng</small>
                        </div>
                        <div class="d-flex align-items-center <?php echo $order['status'] >= 4 ? 'text-success' : 'text-muted'; ?>">
                            <i class="bi bi-<?php echo $order['status'] >= 4 ? 'check-circle-fill' : 'circle'; ?> me-2"></i>
                            <small>Đã giao hàng</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Thông tin giao hàng -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="card-title"><i class="bi bi-truck me-2"></i> Thông tin giao hàng</h6>
                    <hr>
                    <p class="mb-1"><strong>Người nhận:</strong></p>
                    <p><?php echo $order['fullname']; ?></p>
                    
                    <p class="mb-1"><strong>Số điện thoại:</strong></p>
                    <p><?php echo $order['phone_number']; ?></p>
                    
                    <p class="mb-1"><strong>Địa chỉ:</strong></p>
                    <p><?php echo $order['address']; ?></p>
                    
                    <?php if(!empty($order['note'])): ?>
                    <p class="mb-1"><strong>Ghi chú:</strong></p>
                    <p class="text-muted fst-italic">"<?php echo $order['note']; ?>"</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Thông tin thanh toán -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title"><i class="bi bi-credit-card me-2"></i> Thanh toán</h6>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phương thức:</span>
                        <strong><?php echo $order['payment_method']; ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Trạng thái:</span>
                        <?php if($order['payment_status'] == 1): ?>
                            <span class="badge bg-success">Đã thanh toán</span>
                        <?php else: ?>
                            <span class="badge bg-warning">Chưa thanh toán</span>
                        <?php endif; ?>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Tổng tiền:</strong>
                        <h5 class="text-danger mb-0"><?php echo number_format($order['total_money']); ?>đ</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("inc/bottom.php"); ?>
