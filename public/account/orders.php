<?php include("inc/top.php"); ?>

<?php
requireLogin();

$dh = new DONHANG();

// derive current action/show and load customer for sidebar
$action = isset($_GET['action']) ? $_GET['action'] : 'donhang';
$show = isset($_GET['show']) ? $_GET['show'] : '';
$cust = new CUSTOMER();
$customer = $cust->layThongTinKhachHang(getCustomerId());

// active helpers
$active_thongtin = ($action === 'thongtin' && $show !== 'doimatkhau') ? 'active' : '';
$active_donhang = ($action === 'donhang') ? 'active' : '';
$active_diachi = ($action === 'diachi') ? 'active' : '';
$active_doimatkhau = ($action === 'thongtin' && $show === 'doimatkhau') ? 'active' : '';
$active_doidiem = ($action === 'doidiem') ? 'active' : '';

// Lấy danh sách đơn hàng theo customer_id
$customer_id = getCustomerId();
$orders = $dh->laydonhangtheokhachhang($customer_id);
?>

<div class="container my-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <?php if(!empty($customer["avatar"])): ?>
                        <img src="../<?php echo $customer["avatar"]; ?>" class="rounded-circle" width="100" height="100" alt="Avatar">
                        <?php else: ?>
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" 
                             style="width: 100px; height: 100px; font-size: 2.5rem;">
                            <?php echo strtoupper(substr($customer["fullname"], 0, 1)); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <h5 class="mb-1"><?php echo $customer["fullname"]; ?></h5>
                    <p class="text-muted small mb-2"><?php echo $customer["email"]; ?></p>
                    
                    <?php
                    $level_badge = ['bronze' => 'secondary', 'silver' => 'info', 'gold' => 'warning', 'platinum' => 'danger'];
                    $level_text = ['bronze' => '🥉 Đồng', 'silver' => '🥈 Bạc', 'gold' => '🥇 Vàng', 'platinum' => '💎 Bạch Kim'];
                    ?>
                    <span class="badge bg-<?php echo $level_badge[$customer["member_level"]]; ?> mb-3">
                        <?php echo $level_text[$customer["member_level"]]; ?>
                    </span>
                    
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Điểm tích lũy</span>
                            <strong class="text-warning"><?php echo number_format($customer["loyalty_points"]); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Tổng chi tiêu</span>
                            <strong class="text-danger"><?php echo number_format($customer["total_spent"]); ?>đ</strong>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="list-group mt-3 shadow-sm">
                <a href="index.php?action=thongtin" class="list-group-item list-group-item-action <?php echo $active_thongtin; ?>">
                    <i class="bi bi-person me-2"></i> Thông tin tài khoản
                </a>
                <a href="index.php?action=donhang" class="list-group-item list-group-item-action <?php echo $active_donhang; ?>">
                    <i class="bi bi-box-seam me-2"></i> Đơn hàng của tôi
                    <span class="badge bg-primary rounded-pill float-end"><?php echo $customer["total_orders"]; ?></span>
                </a>
                <a href="index.php?action=diachi" class="list-group-item list-group-item-action <?php echo $active_diachi; ?>">
                    <i class="bi bi-geo-alt me-2"></i> Sổ địa chỉ
                </a>
                <a href="index.php?action=doidiem" class="list-group-item list-group-item-action">
                    <i class="bi bi-gift me-2"></i> Đổi điểm
                </a>
                <a href="index.php?action=thongtin&show=doimatkhau" class="list-group-item list-group-item-action <?php echo $active_doimatkhau; ?>">
                    <i class="bi bi-key me-2"></i> Đổi mật khẩu
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i> Lịch sử đơn hàng</h5>
                </div>
                <div class="card-body">
                    <?php if(empty($orders)): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                            <p class="text-muted mt-3">Bạn chưa có đơn hàng nào</p>
                            <a href="index.php" class="btn btn-primary">
                                <i class="bi bi-cart-plus me-2"></i> Mua sắm ngay
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mã ĐH</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Thanh toán</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($orders as $order): ?>
                                    <tr>
                                        <td><strong>#<?php echo $order["id"]; ?></strong></td>
                                        <td><?php echo date("d/m/Y H:i", strtotime($order["order_date"])); ?></td>
                                        <td><strong class="text-danger"><?php echo number_format($order["total_money"]); ?>đ</strong></td>
                                        <td>
                                            <?php
                                            $status_class = [1 => 'warning', 2 => 'info', 3 => 'primary', 4 => 'success', 5 => 'danger'];
                                            $status_text = [
                                                1 => 'Chờ xác nhận',
                                                2 => 'Đã xác nhận',
                                                3 => 'Đang giao',
                                                4 => 'Hoàn thành',
                                                5 => 'Đã hủy'
                                            ];
                                            ?>
                                            <span class="badge bg-<?php echo $status_class[$order['status']]; ?>">
                                                <?php echo $status_text[$order['status']]; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if($order["payment_status"] == 1): ?>
                                                <span class="badge bg-success">Đã thanh toán</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?php echo $order["payment_method"]; ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="index.php?action=chitietdonhang&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> Chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Thống kê -->
                        <div class="row mt-4">
                            <?php
                            $total = count($orders);
                            $completed = count(array_filter($orders, fn($o) => $o['status'] == 4));
                            $pending = count(array_filter($orders, fn($o) => $o['status'] == 1));
                            $total_spent = array_sum(array_column(array_filter($orders, fn($o) => $o['status'] == 4), 'total_money'));
                            ?>
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <h4 class="text-primary"><?php echo $total; ?></h4>
                                    <small class="text-muted">Tổng đơn</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <h4 class="text-success"><?php echo $completed; ?></h4>
                                    <small class="text-muted">Hoàn thành</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <h4 class="text-warning"><?php echo $pending; ?></h4>
                                    <small class="text-muted">Chờ xác nhận</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <h4 class="text-danger"><?php echo number_format($total_spent); ?>đ</h4>
                                    <small class="text-muted">Tổng chi tiêu</small>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("inc/bottom.php"); ?>
