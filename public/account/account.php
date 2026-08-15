<?php include("inc/top.php"); ?>

<?php
requireLogin();

$cust = new CUSTOMER();
$customer = $cust->layThongTinKhachHang(getCustomerId());
// derive current action and optional show param to compute active state
$action = isset($_GET['action']) ? $_GET['action'] : 'thongtin';
$show = isset($_GET['show']) ? $_GET['show'] : '';

// active helpers
$active_thongtin = ($action === 'thongtin' && $show !== 'doimatkhau') ? 'active' : '';
$active_donhang = ($action === 'donhang') ? 'active' : '';
$active_diachi = ($action === 'diachi') ? 'active' : '';
$active_doimatkhau = (($action === 'thongtin' && $show === 'doimatkhau') || ($action === 'doimatkhau')) ? 'active' : '';
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
            <?php if(!($show === 'doimatkhau' || $action === 'doimatkhau')): ?>
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i> Thông tin cá nhân</h5>
                </div>
                <div class="card-body">
                    <?php if(isset($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>
                    <form method="POST" action="index.php?action=capnhatthongtin" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="fullname" value="<?php echo $customer["fullname"]; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control" value="<?php echo $customer["email"]; ?>" disabled>
                                <small class="text-muted">Email không thể thay đổi</small>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="phone_number" value="<?php echo $customer["phone_number"]; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ngày sinh</label>
                                <input type="date" class="form-control" name="birthday" value="<?php echo $customer["birthday"]; ?>">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giới tính</label>
                                <select class="form-select" name="gender">
                                    <option value="">-- Chọn --</option>
                                    <option value="male" <?php echo $customer["gender"] == "male" ? "selected" : ""; ?>>Nam</option>
                                    <option value="female" <?php echo $customer["gender"] == "female" ? "selected" : ""; ?>>Nữ</option>
                                    <option value="other" <?php echo $customer["gender"] == "other" ? "selected" : ""; ?>>Khác</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ngày tham gia</label>
                                <input type="text" class="form-control" value="<?php echo date("d/m/Y", strtotime($customer["created_at"])); ?>" disabled>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Địa chỉ</label>
                            <textarea class="form-control" name="address" rows="3"><?php echo $customer["address"]; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ảnh đại diện</label>
                            <input type="file" class="form-control" name="avatar" accept="image/*">
                            <small class="text-muted">Định dạng: JPG, PNG. Kích thước tối đa: 2MB.</small>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle me-2"></i> Cập nhật thông tin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <?php else: ?>
            <!-- Change-password uses the same card layout as other account pages -->
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-key me-2"></i> Đổi mật khẩu</h5>
                </div>
                <div class="card-body">
                    <?php if(isset($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>
                    <form method="post" action="index.php?action=doimatkhau">
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu cũ</label>
                            <input type="password" class="form-control" name="old_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" name="new_password" required minlength="6">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" name="new_password2" required minlength="6">
                        </div>
                        <div class="text-end">
                            <a href="index.php?action=thongtin" class="btn btn-secondary">Hủy</a>
                            <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

<?php include("inc/bottom.php"); ?>
