<?php include("inc/top.php"); ?>

<?php
requireLogin();

$cust = new CUSTOMER();
$action = isset($_GET['action']) ? $_GET['action'] : 'diachi';
$show = isset($_GET['show']) ? $_GET['show'] : '';
$customer = $cust->layThongTinKhachHang(getCustomerId());

// active helpers
$active_thongtin = ($action === 'thongtin' && $show !== 'doimatkhau') ? 'active' : '';
$active_donhang = ($action === 'donhang') ? 'active' : '';
$active_diachi = ($action === 'diachi') ? 'active' : '';
$active_doimatkhau = ($action === 'thongtin' && $show === 'doimatkhau') ? 'active' : '';

$addresses = $cust->layDanhSachDiaChi(getCustomerId());
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
                <div class="card-header bg-warning d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark"><i class="bi bi-house me-2"></i> Sổ địa chỉ giao hàng</h5>
                    <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                        <i class="bi bi-plus-circle me-1"></i> Thêm địa chỉ
                    </button>
                </div>
                <div class="card-body">
                    <?php if(empty($addresses)): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-geo-alt text-muted" style="font-size: 4rem;"></i>
                            <p class="text-muted mt-3">Chưa có địa chỉ nào</p>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                <i class="bi bi-plus-circle me-2"></i> Thêm địa chỉ đầu tiên
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach($addresses as $addr): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 <?php echo $addr['is_default'] ? 'border-primary' : ''; ?>">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="mb-0">
                                                <?php echo $addr["receiver_name"]; ?>
                                                <?php if($addr["is_default"]): ?>
                                                <span class="badge bg-primary ms-2">Mặc định</span>
                                                <?php endif; ?>
                                            </h6>
                                        </div>
                                        <p class="mb-1 text-muted">
                                            <i class="bi bi-telephone me-1"></i> <?php echo $addr["phone_number"]; ?>
                                        </p>
                                        <p class="mb-0">
                                            <i class="bi bi-geo-alt me-1"></i>
                                            <?php echo $addr["address_detail"]; ?>
                                            <?php 
                                            $location = array_filter([$addr["ward"], $addr["district"], $addr["province"]]);
                                            if(!empty($location)){
                                                echo ", " . implode(", ", $location);
                                            }
                                            ?>
                                        </p>
                                        <div class="mt-3 d-flex gap-2">
                                            <?php if(!$addr["is_default"]): ?>
                                            <a href="index.php?action=setdefault&address_id=<?php echo $addr['id']; ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-check-circle"></i> Đặt mặc định
                                            </a>
                                            <?php endif; ?>
                                            <a href="index.php?action=xoadiachi&id=<?php echo $addr['id']; ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Xóa địa chỉ này?')">
                                                <i class="bi bi-trash"></i> Xóa
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm địa chỉ -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i> Thêm địa chỉ mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="index.php?action=themdiachi">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tên người nhận <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="receiver_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="phone_number" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tỉnh/Thành phố</label>
                            <input type="text" class="form-control" name="province" placeholder="Hà Nội">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Quận/Huyện</label>
                            <input type="text" class="form-control" name="district" placeholder="Đống Đa">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Phường/Xã</label>
                            <input type="text" class="form-control" name="ward" placeholder="Láng Thượng">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="address_detail" rows="3" required 
                                  placeholder="Số nhà, tên đường..."></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_default" value="1" id="setDefault">
                        <label class="form-check-label" for="setDefault">
                            Đặt làm địa chỉ mặc định
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Lưu địa chỉ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("inc/bottom.php"); ?>
