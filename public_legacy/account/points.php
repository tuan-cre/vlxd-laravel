<?php
requireLogin();

require_once(__DIR__ . '/../../model/database.php');
require_once(__DIR__ . '/../../model/coupon.php');
require_once(__DIR__ . '/../../model/customer.php');

$cust = new CUSTOMER();
$customer = $cust->layThongTinKhachHang(getCustomerId());

$cp = new COUPON();

// Handle redeem POST BEFORE any output so header() redirects work
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['coupon_id'])) {
    $coupon_id = intval($_POST['coupon_id']);
    // Kiểm tra lại server-side để chắc chắn không hack được nút disabled
    // (Logic này nên nằm trong model doiMaBoiDiem, ở đây gọi là lớp bảo vệ 2)
    $res = $cp->doiMaBoiDiem($coupon_id, getCustomerId());
    if ($res['success']) {
        $_SESSION['points_message'] = 'Đổi điểm thành công! Mã đã được thêm vào tài khoản của bạn.';
    } else {
        $_SESSION['points_message'] = 'Lỗi khi đổi: ' . ($res['message'] ?? 'Không thể đổi');
    }
    header('Location: index.php?action=doidiem');
    exit();
}

$coupons = $cp->layMaGiamGiaHoatDong();
$redeem_coupons = [];
$other_coupons = [];

$active_thongtin = ($action === 'thongtin' && $show !== 'doimatkhau') ? 'active' : '';
$active_donhang = ($action === 'donhang') ? 'active' : '';
$active_diachi = ($action === 'diachi') ? 'active' : '';
$active_doimatkhau = ($action === 'thongtin' && $show === 'doimatkhau') ? 'active' : '';
$active_doidiem = ($action === 'doidiem') ? 'active' : '';


// Chuẩn hóa level khách hàng
$levels = ['bronze' => 0, 'silver' => 1, 'gold' => 2, 'platinum' => 3];
$cust_level = strtolower(trim($customer['member_level'] ?? 'bronze'));
if (!isset($levels[$cust_level]))
    $cust_level = 'bronze';

$my_coupons = $cp->layCouponCuaKhachHang(getCustomerId());

// Lấy danh sách ID coupon đã sở hữu
$db = DATABASE::connect();
$owned_ids = [];
try {
    $cmdOwned = $db->prepare("SELECT coupon_id FROM customer_coupons WHERE customer_id = :cid");
    $cmdOwned->bindValue(':cid', getCustomerId());
    $cmdOwned->execute();
    while ($r = $cmdOwned->fetch(PDO::FETCH_ASSOC))
        $owned_ids[] = intval($r['coupon_id']);
} catch (PDOException $e) { /* ignore */
}

// --- LOGIC MỚI: Luôn hiển thị coupon đổi điểm, chỉ đánh dấu disabled ---
foreach ($coupons as $c) {
    $c_level = strtolower(trim($c['min_member_level'] ?? 'bronze'));
    if (!isset($levels[$c_level]))
        $c_level = 'bronze';

    // 1. Coupon đổi điểm (points_cost >= 0)
    if (intval($c['points_cost']) >= 0) {
        $reasons = [];

        // Check hạng thành viên
        if ($levels[$cust_level] < $levels[$c_level])
            $reasons[] = 'Cần hạng ' . ucfirst($c['min_member_level']);

        // Check điểm tích lũy
        if (intval($customer['loyalty_points']) < intval($c['points_cost']))
            $reasons[] = 'Thiếu điểm';

        // Check đã sở hữu chưa
        if (in_array(intval($c['id']), $owned_ids))
            $reasons[] = 'Đã sở hữu';

        

        // Lưu lý do vào coupon để hiển thị ở view
        $c['disabled_reasons'] = $reasons;

        // LUÔN ADD vào danh sách hiển thị
        $redeem_coupons[] = $c;
    }
    // 2. Coupon thường (Không đổi điểm, áp dụng checkout)
    else {
        // Coupon thường thì vẫn ẩn nếu không đủ level cho gọn
        if ($levels[$cust_level] >= $levels[$c_level]) {
            $other_coupons[] = $c;
        }
    }
}
?>

<?php include("inc/top.php"); ?>

<div class="container my-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <?php if (!empty($customer["avatar"])): ?>
                            <img src="../<?php echo $customer["avatar"]; ?>" class="rounded-circle" width="100" height="100"
                                alt="Avatar">
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
                            <strong
                                class="text-warning"><?php echo number_format($customer["loyalty_points"]); ?></strong>
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
                <a href="index.php?action=doidiem" class="list-group-item list-group-item-action <?php echo $active_doidiem; ?>">
                    <i class="bi bi-gift me-2"></i> Đổi điểm
                </a>
                <a href="index.php?action=thongtin&show=doimatkhau" class="list-group-item list-group-item-action <?php echo $active_doimatkhau; ?>">
                    <i class="bi bi-key me-2"></i> Đổi mật khẩu
                </a>
            </div>
        </div>

        <div class="col-md-9">

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Đổi điểm nhận quà</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['points_message'])): ?>
                        <div class="alert alert-info">
                            <?php echo $_SESSION['points_message'];
                            unset($_SESSION['points_message']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <strong>Điểm hiện có: </strong> <span
                            class="text-warning"><?php echo number_format($customer['loyalty_points']); ?></span>
                    </div>

                    <?php if (count($redeem_coupons) == 0 && count($other_coupons) == 0): ?>
                        <div class="alert alert-secondary">Hiện không có mã nào để đổi hoặc áp dụng.</div>
                    <?php else: ?>

                        <?php if (count($redeem_coupons) > 0): ?>
                            <h6 class="mb-3">Mã có thể đổi bằng điểm</h6>
                            <div class="row">
                                <?php foreach ($redeem_coupons as $c): ?>
                                    <?php
                                    // Kiểm tra xem có bị disabled không
                                    $isDisabled = !empty($c['disabled_reasons']);
                                    // Nếu disabled thì thêm class làm mờ và background xám
                                    $cardClass = $isDisabled ? "bg-light text-muted opacity-75 border-secondary" : "border-primary";
                                    ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100 <?php echo $cardClass; ?>">
                                            <div class="card-body">
                                                <h5 class="card-title d-flex justify-content-between align-items-center">
                                                    <?php echo htmlspecialchars($c['code']); ?>
                                                    <?php if ($isDisabled): ?>
                                                        <i class="bi bi-lock-fill text-secondary"></i>
                                                    <?php endif; ?>
                                                </h5>
                                                <p class="card-text">
                                                    <?php if ($c['discount_type'] == 'percent'): ?>
                                                        <strong><?php echo htmlspecialchars($c['discount_value']); ?>%</strong> giảm
                                                    <?php else: ?>
                                                        <strong><?php echo number_format($c['discount_value']); ?>đ</strong> giảm
                                                    <?php endif; ?>
                                                </p>
                                                <p class="small mb-1">
                                                    <?php if (intval($c['points_cost']) > 0): ?>
                                                        Cần: <strong><?php echo number_format($c['points_cost']); ?></strong> điểm
                                                    <?php else: ?>
                                                        Miễn phí
                                                    <?php endif; ?>
                                                </p>
                                                <p class="small mb-0">
                                                    Hạng tối thiểu: <?php echo ucfirst($c['min_member_level']); ?>
                                                </p>
                                            </div>
                                            <div class="card-footer text-end bg-transparent border-top-0">
                                                <?php if (!$isDisabled): ?>
                                                    <form method="POST" action="index.php?action=doidiem">
                                                        <input type="hidden" name="coupon_id" value="<?php echo intval($c['id']); ?>">
                                                        <button class="btn btn-success w-100" type="submit">
                                                            <i class="bi bi-check-circle"></i> Đổi ngay
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <button class="btn btn-secondary w-100" disabled>
                                                        <?php echo htmlspecialchars($c['disabled_reasons'][0]); ?>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (count($other_coupons) > 0): ?>
                            <h6 class="mt-4 mb-3">Các mã khác (áp dụng tại trang thanh toán)</h6>
                            <div class="row">
                                <?php foreach ($other_coupons as $c): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo htmlspecialchars($c['code']); ?></h5>
                                                <p class="card-text">
                                                    <?php if ($c['discount_type'] == 'percent'): ?>
                                                        <?php echo htmlspecialchars($c['discount_value']); ?>% giảm
                                                    <?php else: ?>
                                                        <?php echo number_format($c['discount_value']); ?>đ giảm
                                                    <?php endif; ?>
                                                </p>
                                                <p class="small text-muted">(* Áp dụng trực tiếp tại thanh toán)</p>
                                            </div>
                                            <div class="card-footer text-end">
                                                <form method="POST" action="index.php?action=apdungcoupon">
                                                    <input type="hidden" name="coupon_code"
                                                        value="<?php echo htmlspecialchars($c['code']); ?>">
                                                    <input type="hidden" name="return_to" value="checkout">
                                                    <button class="btn btn-outline-primary w-100" type="submit">Áp dụng</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (!empty($my_coupons)): ?>
                <div class="card mt-3 shadow-sm">
                    <div class="card-header bg-light">
                        <strong>Mã của bạn</strong>
                    </div>
                    <div class="card-body p-2">
                        <ul class="list-group list-group-flush small">
                            <?php foreach ($my_coupons as $mc): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start py-2">
                                    <div>
                                        <span class="fw-bold me-2"><?php echo htmlspecialchars($mc['code']); ?></span>
                                        <div class="text-muted small">
                                            <?php if ($mc['discount_type'] == 'percent'): ?>
                                                <?php echo htmlspecialchars($mc['discount_value']); ?>% giảm
                                            <?php else: ?>
                                                <?php echo number_format($mc['discount_value']); ?>đ giảm
                                            <?php endif; ?>
                                            <?php if (!empty($mc['start_date']) || !empty($mc['end_date'])): ?>
                                                • <span
                                                    class="text-nowrap"><?php echo !empty($mc['end_date']) ? date('Y-m-d', strtotime($mc['end_date'])) : 'Không hạn'; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <?php if (intval($mc['usage_limit']) <= 0): ?>
                                            <span class="badge bg-secondary">Đã sử dụng</span>
                                        <?php else: ?>
                                            <?php if ($mc['status'] == 1): ?>
                                                <span class="badge bg-success">Hoạt động</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Ngưng</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if (intval($mc['usage_limit']) > 0 && $mc['status'] == 1): ?>
                                            <form method="POST" action="index.php?action=apdungcoupon" class="mt-1">
                                                <input type="hidden" name="coupon_code"
                                                    value="<?php echo htmlspecialchars($mc['code']); ?>">
                                                <input type="hidden" name="return_to" value="checkout">
                                                <button class="btn btn-sm btn-outline-primary">Áp dụng</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <div class="card mt-3 shadow-sm">
                    <div class="card-body text-center small text-muted">
                        Bạn chưa có mã giảm giá nào trong tài khoản.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div> <?php include("inc/bottom.php"); ?>