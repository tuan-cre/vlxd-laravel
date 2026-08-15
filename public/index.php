<?php 
session_start();

// Xử lý session khi quay lại từ admin
// Nếu đang có session admin mà không phải từ trang admin, khôi phục session public
if(isset($_SESSION["admin_login"]) && !isset($_GET["from_admin"])){
    if(isset($_SESSION["public_user_backup"])){
        $_SESSION["nguoidung"] = $_SESSION["public_user_backup"];
        unset($_SESSION["public_user_backup"]);
        unset($_SESSION["admin_login"]);
        unset($_SESSION["customer_id"]); // Reset customer_id cache
    }
}

require("../model/database.php");
require("../model/session_helper.php");
require("../model/view_tracker.php");
require("../model/danhmuc.php");
require("../model/sanpham.php");
require("../model/thuonghieu.php");
require("../model/giohang.php");
require("../model/diachi.php");
require("../model/donhang.php");
require("../model/donhangct.php");
require("../model/site_info.php");

$dm = new DANHMUC();
$danhmuc = $dm->layDanhMuc();
$sp = new SANPHAM();
$th = new THUONGHIEU();
$sanphamnoibat = $sp->laySanPhamNoiBat(4); // Lấy 4 sản phẩm nổi bật
$mathangxemnhieu = $sp->laySanPhamXemNhieu(4); // Lấy 4 sản phẩm xem nhiều
$sanphambanchay = $sp->laySanPhamBanChay(8); // Lấy sản phẩm bán chạy nhất

$site_info_model = new SITE_INFO();
$site_info = $site_info_model->getSiteInfo();

if(isset($_REQUEST["action"])){
    $action = $_REQUEST["action"];
}
else{
    $action="null"; 
}


switch($action){
    case "null": 	
    	$sanpham = $sp->laySanPham();
        $show_carousel = true; // Hiển thị carousel ở trang chủ
        include("home/main.php");
        break;
    case "group": 
        if(isset($_REQUEST["id"])){
            $madm = $_REQUEST["id"];
            $dmuc = $dm->layDanhMucTheoId($madm);
            $tendm = $dmuc["name"];   
            $sanpham = $sp->laySanPhamTheoDanhMuc($madm);
            $show_carousel = true; // Hiển thị carousel
            include("product/group.php");
        }
        else{
            $show_carousel = true;
            include("home/main.php");
        }
        break;
    case "detail": 
        if(isset($_GET["id"])){
            $id = $_GET["id"];
            
            // Tăng lượt xem - sử dụng ViewTracker để tránh spam
            ViewTracker::trackView($id);
            
            // lấy thông tin chi tiết sản phẩm
            $sanpham_detail = $sp->laySanPhamTheoId($id);
            // lấy ảnh gallery sản phẩm
            $product_images = $sp->layAnhSanPham($id);
            // lấy các sản phẩm cùng danh mục
            $madm = $sanpham_detail["category_id"];
            $sanpham_lienquan = $sp->laySanPhamTheoDanhMuc($madm);
            $show_carousel = true; // Hiển thị carousel
            // Load reviews data via model here (controller responsibility)
            require_once(__DIR__ . '/../model/danhgia.php');
            $dgModel = new DANHGIA();
            $productId = $id;
            $reviews = $dgModel->layDanhGiaTheoSanPham($productId, 'approved');
            $avg = $dgModel->tinhDiemTrungBinh($productId);
            $stats = $dgModel->thongKeDanhGiaTheoSao($productId);

            include("product/detail.php");
        }
        break;
    case "chovaogio":    
        if(isset($_REQUEST["id"]))
            $id = $_REQUEST["id"];
        if(isset($_REQUEST["soluong"]))
            $soluong = $_REQUEST["soluong"];
        else
            $soluong = 1;

        if(isset($_SESSION['giohang'][$id])){ // nếu đã có trong giỏ thi tăng số lượng
            $soluong += $_SESSION['giohang'][$id];
            $_SESSION['giohang'][$id] = $soluong;
        }
        else{       // nếu chưa thì thêm vào giỏ
            themhangvaogio($id, $soluong);
        }

        //themhangvaogio($_REQUEST["id"], $soluong);

        $giohang = laygiohang();   
        include("cart/cart.php");
        break;
    case "giohang":  
        $giohang = laygiohang();   
        include("cart/cart.php");
        break;
    case "capnhatgio":
        if(isset($_REQUEST["mh"])){
            $mh = $_REQUEST["mh"];
            foreach ($mh as $id => $soluong) {
                if($soluong > 0)
                    capnhatsoluong($id, $soluong);
                else 
                    xoamotmathang($id);                
            }
        }  
        // Re-validate coupon if applied
        if(isset($_SESSION['applied_coupon'])){
            require_once(__DIR__ . '/../model/coupon.php');
            $couponModel = new COUPON();
            $c = $_SESSION['applied_coupon'];
            $subtotal = tinhtiengiohang();
            $res = $couponModel->kiemTraMaGiamGia($c['code'], $subtotal);
            if(!$res['valid']){
                unset($_SESSION['applied_coupon']);
                $_SESSION['coupon_message'] = $res['message'];
            } else {
                $_SESSION['applied_coupon']['discount'] = $res['discount'];
            }
        }
        $giohang = laygiohang();   
        include("cart/cart.php");
        break;
    case "apdungcoupon":
        require_once(__DIR__ . '/../model/coupon.php');
        $couponModel = new COUPON();
        $code = isset($_POST['coupon_code']) ? strtoupper(trim($_POST['coupon_code'])) : '';
        if(empty($code)){
            $_SESSION['coupon_message'] = 'Vui lòng nhập mã giảm giá.';
            $giohang = laygiohang();
            $return_to = isset($_POST['return_to']) ? $_POST['return_to'] : 'cart';
            if($return_to === 'checkout') include("cart/checkout.php"); else include("cart/cart.php");
            break;
        }
        $subtotal = tinhtiengiohang();
        $res = $couponModel->kiemTraMaGiamGia($code, $subtotal);
        if($res['valid']){
            $_SESSION['applied_coupon'] = [
                'id' => $res['coupon']['id'],
                'code' => $res['coupon']['code'],
                'discount' => $res['discount']
            ];
            $_SESSION['coupon_message'] = $res['message'];
        } else {
            unset($_SESSION['applied_coupon']);
            $_SESSION['coupon_message'] = $res['message'];
        }
        $giohang = laygiohang();
        $return_to = isset($_POST['return_to']) ? $_POST['return_to'] : 'cart';
        if($return_to === 'checkout'){
            include("cart/checkout.php");
        } else {
            include("cart/cart.php");
        }
        break;
    case "xoacoupon":
        unset($_SESSION['applied_coupon']);
        $_SESSION['coupon_message'] = 'Đã xóa mã giảm giá.';
        $giohang = laygiohang();
        $return_to = isset($_GET['return_to']) ? $_GET['return_to'] : (isset($_POST['return_to'])?$_POST['return_to']:'cart');
        if($return_to === 'checkout'){
            include("cart/checkout.php");
        } else {
            include("cart/cart.php");
        }
        break;
    case "xoagiohang":  
        xoagiohang();
        $giohang = laygiohang();   
        include("cart/cart.php");
        break;
    case "thanhtoan":
        // Nếu chưa đăng nhập, lưu redirect để quay lại sau khi login
        if(!isLoggedIn()){
            $_SESSION['redirect_after_login'] = 'index.php?action=thanhtoan';
        }
        $giohang = laygiohang();
        include("cart/checkout.php");
        break;
    case "luudonhang": 
        require("../model/customer.php");
        
        $diachi = $_POST["txtdiachi"];
        $note = isset($_POST["txtnote"]) ? $_POST["txtnote"] : '';
        
        $email = $_POST["txtemail"];
        $hoten = $_POST["txthoten"];
        $sodienthoai = $_POST["txtsodienthoai"];
        
        // Kiểm tra khách hàng đã tồn tại chưa
        $cust = new CUSTOMER();
        $existing = $cust->kiemTraKhachHangTonTai($email);
        
        if($existing){
            // Khách hàng cũ
            $customer_id = $existing['id'];
        }
        else{
            // Khách hàng mới - tạo mới
            $user_id = getUserId(); // Dùng helper thay vì session khachhang
            $customer_id = $cust->themKhachHang($hoten, $email, $sodienthoai, $diachi, $user_id);
        }

        // Lưu đơn hàng
        $dh = new DONHANG();
        $tongtien = tinhtiengiohang();
        // Apply coupon if present in session (validate again)
        $coupon_id = null;
        $discount_amount = 0;
        if(isset($_SESSION['applied_coupon'])){
            require_once(__DIR__ . '/../model/coupon.php');
            $couponModel = new COUPON();
            $c = $_SESSION['applied_coupon'];
            $res = $couponModel->kiemTraMaGiamGia($c['code'], $tongtien);
            if($res['valid']){
                $discount_amount = $res['discount'];
                $coupon_id = $res['coupon']['id'];
            } else {
                // If coupon is no longer valid, remove it
                unset($_SESSION['applied_coupon']);
                $_SESSION['coupon_message'] = $res['message'];
            }
        }

        $final_total = max(0, $tongtien - $discount_amount);
        $donhang_id = $dh->themdonhang($customer_id, $hoten, $sodienthoai, $diachi, $final_total, $note, 'COD', $discount_amount, $coupon_id);
        
        // Cập nhật điểm thưởng cho khách hàng
        $cust->capNhatDiemThuong($customer_id, 0, $tongtien);
        
        // lưu chi tiết đơn hàng
        $ct = new DONHANGCT();      
        $giohang = laygiohang();
        foreach($giohang as $id => $item){
            $dongia = $item["price"];
            $soluong = $item["soluong"];
            $thanhtien = $item["thanhtien"];
            $ct->themchitietdonhang($donhang_id,$id,$dongia,$soluong,$thanhtien);
            // Cập nhật tồn kho
            $sp_update = new SANPHAM();
            $sp_info = $sp_update->laySanPhamTheoId($id);
            $stock_moi = $sp_info['stock'] - $soluong;
            // TODO: Thêm phương thức capnhatsoluong trong class SANPHAM
        }
        
        // Decrement coupon usage if applied. If coupon was redeemed by points, remove customer_coupons record instead.
        if($donhang_id && $coupon_id){
            $redeemed_and_allocated = false;
            if(isLoggedIn()){
                require_once(__DIR__ . '/../model/database.php');
                $db = DATABASE::connect();
                $cmd = $db->prepare("SELECT id FROM customer_coupons WHERE customer_id = :cid AND coupon_id = :cpid LIMIT 1");
                $cmd->bindValue(':cid', $customer_id);
                $cmd->bindValue(':cpid', $coupon_id);
                $cmd->execute();
                $row = $cmd->fetch(PDO::FETCH_ASSOC);
                if($row){
                    // Remove allocated coupon (now used)
                    $del = $db->prepare("DELETE FROM customer_coupons WHERE id = :id");
                    $del->bindValue(':id', $row['id']);
                    $del->execute();
                    $redeemed_and_allocated = true;
                }
            }
            if(!$redeemed_and_allocated){
                $couponModel->giamLuotSuDung($coupon_id);
            }
            unset($_SESSION['applied_coupon']);
        }

        // DO NOT send email here synchronously, we will send it after finishing the request to avoid blocking

    // xóa giỏ hàng
    // Show the final order total in message page
    $tongtien = $final_total;
        xoagiohang();
        
        // chuyển đến trang cảm ơn
        include("cart/message.php");

        // Non-blocking server-side email send: flush response and continue sending
        if(function_exists('fastcgi_finish_request')){
            try {
                fastcgi_finish_request();
            } catch(Exception $e) {
                // ignore if not supported or fails
            }
            // Send email (this runs after response is returned to client)
            try {
                require_once(__DIR__ . '/../model/mailer.php');
                $mailer = new MAILER();
                $mailer->sendOrderConfirmation($donhang_id, true);
            } catch(Exception $e) {
                error_log('Mailer exception during post-request send: ' . $e->getMessage());
            }
        } else {
            // Fallback: spawn a background process to send the email so request is not blocked
            $php = '/usr/bin/env php';
            $script = escapeshellarg(__DIR__ . '/../tools/send_order_mail.php');
            $cmd = "$php $script " . escapeshellarg($donhang_id) . " > /dev/null 2>&1 &";
            exec($cmd);
        }
        break;
    case "dangnhap":
    case "login":
        include("account/loginform.php");
        break;
        
    case "xldangnhap":
        $email = $_POST["txtemail"];
        $matkhau = $_POST["txtmatkhau"];
        
        require("../model/nguoidung.php");
        
        $nd = new NGUOIDUNG();
        if($nd->kiemtranguoidunghople($email, $matkhau)){
            // Chỉ cần set session nguoidung
            $_SESSION["nguoidung"] = $nd->laythongtinnguoidung($email);
            
            // Chuyển đến trang thông tin hoặc trang trước đó
            if(isset($_SESSION['redirect_after_login'])){
                $redirect = $_SESSION['redirect_after_login'];
                unset($_SESSION['redirect_after_login']);
                header("location:" . $redirect);
            } else {
                header("location:index.php?action=thongtin");
            }
        }
        else{
            $_SESSION["login_error"] = "Email hoặc mật khẩu không đúng!";
            include("account/loginform.php");
        }
        break;
        
    case "dangky":
    case "register":
        include("account/registerform.php");
        break;
        
    case "xldangky":
        $email = trim($_POST["txtemail"]);
        $matkhau = trim($_POST["txtmatkhau"]);
        $matkhau2 = trim($_POST["txtmatkhau2"]);
        $hoten = trim($_POST["txthoten"]);
        $sodienthoai = trim($_POST["txtsodienthoai"]);
        $diachi = isset($_POST["txtdiachi"]) ? trim($_POST["txtdiachi"]) : '';
        
        $errors = [];
        
        // Validate
        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "Email không hợp lệ";
        }
        if(empty($matkhau) || strlen($matkhau) < 6){
            $errors[] = "Mật khẩu phải có ít nhất 6 ký tự";
        }
        if($matkhau !== $matkhau2){
            $errors[] = "Mật khẩu xác nhận không khớp";
        }
        // Full name and phone are optional now; do not require them for registration
        
        require("../model/nguoidung.php");
        require("../model/customer.php");
        
        $nd = new NGUOIDUNG();
        if($nd->kiemtraemail($email)){
            $errors[] = "Email đã được sử dụng cho tài khoản khác";
        }
        
        if(empty($errors)){
            // Convert empty fields to null where appropriate for users table
            $sodienthoai_user = ($sodienthoai === '') ? NULL : $sodienthoai;
            $hoten_user = ($hoten === '') ? NULL : $hoten;
            $diachi_user = ($diachi === '') ? NULL : $diachi;

            // Tạo tài khoản user (users table no longer stores phone/address)
            $user_id = $nd->themnguoidung($email, $matkhau, $hoten_user, 2);
            
            if($user_id){
                // Kiểm tra email đã mua hàng trước đó chưa
                $cust = new CUSTOMER();
                $existing = $cust->kiemTraKhachHangTonTai($email);
                
                if($existing){
                    // Link customer cũ với user mới
                    $cust->linkVoiUser($existing['id'], $user_id);
                    $_SESSION['register_success'] = "Đăng ký thành công! Tài khoản đã được liên kết với lịch sử mua hàng.";
                } else {
                    // Tạo customer mới
                    $cust->themKhachHang($hoten, $email, $sodienthoai, $diachi, $user_id);
                    $_SESSION['register_success'] = "Đăng ký thành công!";
                }
                
                // Tự động đăng nhập - chỉ set session nguoidung
                $_SESSION["nguoidung"] = $nd->laythongtinnguoidung($email);
                
                header("location:index.php");
                exit();
            } else {
                $errors[] = "Có lỗi xảy ra. Vui lòng thử lại.";
            }
        }
        
        $_SESSION['register_errors'] = $errors;
        $_SESSION['register_data'] = $_POST;
        include("account/registerform.php");
        break;
    case "thongtin":
        requireLogin();
        // Tất cả user đều có thể xem thông tin
        include("account/account.php");
        break;
    case "doidiem":
        // Redemption via points: ensure login then include the page
        requireLogin();
        include('account/points.php');
        break;
    case "doimatkhau":
        requireLogin();
        // If GET (or not POST), render the account page which will show the inline change-password card
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            include("account/account.php");
            break;
        }

        // Handle POST: validate old password then update
        require_once(__DIR__ . '/../model/nguoidung.php');
        $nd = new NGUOIDUNG();
        $user = getCurrentUser();
        if(!$user){
            header('location:index.php');
            exit();
        }

        $old = $_POST['old_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $new2 = $_POST['new_password2'] ?? '';

        if($new !== $new2){
            $_SESSION['error'] = 'Mật khẩu xác nhận không khớp.';
            include("account/account.php");
            break;
        }
        if(strlen($new) < 6){
            $_SESSION['error'] = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
            include("account/account.php");
            break;
        }

        // Verify old password by checking user email and old password
        $email = $user['email'];
        if(!$nd->kiemtranguoidunghople($email, $old)){
            $_SESSION['error'] = 'Mật khẩu cũ không đúng.';
            include("account/account.php");
            break;
        }

        // Update password
        if($nd->doimatkhau($email, $new)){
            $_SESSION['success'] = 'Đổi mật khẩu thành công.';
            // Update session user info if necessary
            $_SESSION['nguoidung'] = $nd->laythongtinnguoidung($email);
            header('location:index.php?action=thongtin');
            exit();
        } else {
            $_SESSION['error'] = 'Có lỗi khi đổi mật khẩu. Vui lòng thử lại.';
            include("account/account.php");
            break;
        }
        
    case "capnhatthongtin":
        requireLogin();
        
        require("../model/customer.php");
        $cust = new CUSTOMER();
        
        $fullname = trim($_POST["fullname"]);
        $phone = trim($_POST["phone_number"]);
        $address = trim($_POST["address"]);
        $birthday = !empty($_POST["birthday"]) ? trim($_POST["birthday"]) : null;
        $gender = !empty($_POST["gender"]) ? trim($_POST["gender"]) : null;
        
        $customer_id = getCustomerId();
        if(!$customer_id){
            $_SESSION["error"] = "Không tìm thấy thông tin khách hàng!";
            header("location:index.php");
            exit();
        }

        
        // Handle avatar upload if provided
        $avatar_rel_path = null;
        if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE){
            // Validate upload
            if($_FILES['avatar']['error'] !== UPLOAD_ERR_OK){
                $_SESSION['error'] = 'Có lỗi khi upload ảnh.';
                header("location:index.php?action=thongtin");
                exit();
            }
            $maxBytes = 2 * 1024 * 1024; // 2MB
            if($_FILES['avatar']['size'] > $maxBytes){
                $_SESSION['error'] = 'Kích thước file không được vượt quá 2MB!';
                header("location:index.php?action=thongtin");
                exit();
            }
            $info = @getimagesize($_FILES['avatar']['tmp_name']);
            if($info === false){
                $_SESSION['error'] = 'Tệp tải lên không phải ảnh hợp lệ.';
                header("location:index.php?action=thongtin");
                exit();
            }
            $mime = $info['mime'] ?? '';
            $allowed = ['image/jpeg','image/png','image/gif'];
            if(!in_array($mime, $allowed)){
                $_SESSION['error'] = 'Chỉ chấp nhận file ảnh JPG, PNG, GIF.';
                header("location:index.php?action=thongtin");
                exit();
            }

            // Move file to images/users/
            $uploadDir = __DIR__ . '/../images/users/';
            if(!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $original = basename($_FILES['avatar']['name']);
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.\-]/', '_', $original);
            $dest = $uploadDir . $filename;
            if(!move_uploaded_file($_FILES['avatar']['tmp_name'], $dest)){
                $_SESSION['error'] = 'Không thể lưu ảnh đại diện. Vui lòng thử lại.';
                header("location:index.php?action=thongtin");
                exit();
            }
            // store relative path used by views
            $avatar_rel_path = 'images/users/' . $filename;
        }

        // Update basic info
        $result = $cust->capNhatThongTin(
            $customer_id,
            $fullname,
            $phone,
            $address,
            $birthday,
            $gender
        );

        // If avatar uploaded, update avatar column
        if($avatar_rel_path !== null){
            $cust->capNhatAvatar($customer_id, $avatar_rel_path);
        }

        if($result){
            $_SESSION["success"] = "Cập nhật thông tin thành công!";
        }

        header("location:index.php?action=thongtin");
        break;

    case "post_review":
        // Handle review submission from product detail page
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('location:index.php'); exit();
        }
        require_once(__DIR__ . '/../model/danhgia.php');
        $dgModel = new DANHGIA();
        $user = getCurrentUser();
        if(!$user){
            $_SESSION['error'] = 'Vui lòng đăng nhập để gửi đánh giá.';
            header('location:' . $_SERVER['HTTP_REFERER']); exit();
        }

        $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

        if($product_id <= 0 || $rating < 1 || $rating > 5){
            $_SESSION['error'] = 'Đánh giá không hợp lệ.';
            header('location:' . $_SERVER['HTTP_REFERER']); exit();
        }

        // Create review object
        $reviewObj = new stdClass();
        $reviewObj->product_id = $product_id;
        $reviewObj->user_id = $user['id'];
        $reviewObj->order_id = null;
        $reviewObj->rating = $rating;
        $reviewObj->comment = $comment;
        // By default set to 'pending' so admin can moderate
        $reviewObj->status = 'pending';

        $insertId = $dgModel->themDanhGia($reviewObj);
        if($insertId){
            $_SESSION['success'] = 'Cảm ơn bạn đã gửi đánh giá. Bài đánh giá sẽ được hiển thị sau khi được duyệt.';
        } else {
            $_SESSION['error'] = 'Có lỗi khi gửi đánh giá. Vui lòng thử lại.';
        }
        header('location:' . $_SERVER['HTTP_REFERER']);
        exit();
        
    case "donhang":
        requireLogin();
        // Tất cả user đều có thể xem đơn hàng của mình
        include("account/orders.php");
        break;
        
    case "chitietdonhang":
        // Chi tiết đơn hàng
        include("account/orderdetail.php");
        break;
        
    case "diachi":
        // Sổ địa chỉ
        include("account/addresses.php");
        break;
        
    case "themdiachi":
        requireLogin();
        
        require("../model/customer.php");
        $cust = new CUSTOMER();
        
        $receiver_name = $_POST["receiver_name"];
        $phone = $_POST["phone_number"];
        $province = $_POST["province"] ?? '';
        $district = $_POST["district"] ?? '';
        $ward = $_POST["ward"] ?? '';
        $address_detail = $_POST["address_detail"];
        $is_default = isset($_POST["is_default"]) ? 1 : 0;
        
        $cust->themDiaChi(
            getCustomerId(),
            $receiver_name,
            $phone,
            $address_detail,
            $province,
            $district,
            $ward,
            $is_default
        );
        
        header("location:index.php?action=diachi");
        break;
        
    case "xoadiachi":
        requireLogin();
        
        $address_id = $_GET["id"];
        $db = DATABASE::connect();
        $sql = "DELETE FROM customer_addresses WHERE id = :id AND customer_id = :customer_id";
        $cmd = $db->prepare($sql);
        $cmd->bindValue(':id', $address_id);
        $cmd->bindValue(':customer_id', getCustomerId());
        $cmd->execute();
        
        header("location:index.php?action=diachi");
        break;
        
    case "setdefault":
        requireLogin();
        
        $address_id = $_GET["address_id"];
        $customer_id = getCustomerId();
        
        $db = DATABASE::connect();
        // Bỏ default của các địa chỉ khác
        $sql = "UPDATE customer_addresses SET is_default = 0 WHERE customer_id = :customer_id";
        $cmd = $db->prepare($sql);
        $cmd->bindValue(':customer_id', $customer_id);
        $cmd->execute();
        
        // Set default cho địa chỉ được chọn
        $sql = "UPDATE customer_addresses SET is_default = 1 WHERE id = :id AND customer_id = :customer_id";
        $cmd = $db->prepare($sql);
        $cmd->bindValue(':id', $address_id);
        $cmd->bindValue(':customer_id', $customer_id);
        $cmd->execute();
        
        header("location:index.php?action=diachi");
        break;
    case "dangxuat":
        unset($_SESSION["nguoidung"]);
        unset($_SESSION["customer_id"]);
        
        // Dọn dẹp tracking cũ khi logout
        ViewTracker::cleanOldTracking();
        
        // chuyển về trang chủ
        $sanpham = $sp->laySanPham();   
        include("home/main.php");
        break;
    case "timkiem":
        if(isset($_REQUEST["keyword"])){
            $keyword = $_REQUEST["keyword"];
            $sanpham = $sp->timKiemSanPham($keyword);
            include("product/group.php");
        }
        break;
    case "filter":
        // AJAX: lọc sản phẩm theo điều kiện gửi về JSON
        $filters = [];
        if(isset($_POST['price_from']) && is_numeric($_POST['price_from'])) {
            $filters['price_from'] = (int)$_POST['price_from'];
        }
        if(isset($_POST['price_to']) && is_numeric($_POST['price_to'])) {
            $filters['price_to'] = (int)$_POST['price_to'];
        }
        if(isset($_POST['brands'])) {
            // Brands may come as array
            $brands = $_POST['brands'];
            if(!is_array($brands)) $brands = [$brands];
            $filters['brands'] = $brands;
        }
        if(isset($_POST['category_id']) && is_numeric($_POST['category_id'])) {
            $filters['category_id'] = (int)$_POST['category_id'];
        }
        if(isset($_POST['in_stock']) && $_POST['in_stock'] == '1') {
            $filters['in_stock'] = true;
        }
        if(isset($_POST['sort_by'])) {
            // sort_by is like 'price_ASC' or 'name_DESC'
            $parts = explode('_', $_POST['sort_by']);
            $filters['sort_by'] = $parts[0] ?? 'id';
            $filters['sort_order'] = strtoupper($parts[1] ?? 'DESC');
        }

        // Pagination
        $page = isset($_POST['page']) && is_numeric($_POST['page']) && (int)$_POST['page'] > 0 ? (int)$_POST['page'] : 1;
        $per_page = isset($_POST['per_page']) && is_numeric($_POST['per_page']) && (int)$_POST['per_page'] > 0 ? (int)$_POST['per_page'] : 12;
        $filters['page'] = $page;
        $filters['per_page'] = $per_page;

        $sanpham = $sp->locSanPham($filters);
        $total = $sp->locSanPhamCount($filters);
        $payload = ['data' => $sanpham, 'total' => $total, 'page' => $page, 'per_page' => $per_page];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload);
        exit();
    case "gioithieu":
        include("about/about.php");
        break;
    case "lienhe":
        include("contact/contact.php");
        break;
    case "guilienhe":
        // Xử lý gửi form liên hệ (có thể lưu vào database hoặc gửi email)
        // Tạm thời chỉ redirect
        header("location:index.php?action=lienhe&success=1");
        break;
    case "danhsachtintuc":
        require("../model/tintuc.php");
        $tt = new TINTUC();
        $news = $tt->layTatCaTinTuc();
        include("news/news.php");
        break;
    case "danhsachbanggia":
        require("../model/price_sheet.php");
        $psModel = new PRICE_SHEET();
        $price_sheets = $psModel->layTatCaBangGia();
        include("price_sheets/index.php");
        break;
    case "tintuc":
        if(isset($_GET["id"])){
            require("../model/tintuc.php");
            $tt = new TINTUC();
            $news_detail = $tt->layTinTucTheoId($_GET["id"]);
            $other_news = $tt->laytintuckhac($_GET["id"], 5);
            include("news/news_detail.php");
        }
        break;
        case "banggia":
            if(isset($_GET["id"])){
                require("../model/price_sheet.php");
                $psModel = new PRICE_SHEET();
                $price_sheet = $psModel->layBangGiaTheoId($_GET["id"]);
                include("price_sheets/detail.php");
            }
            break;
    default:
        break;
}
?>
