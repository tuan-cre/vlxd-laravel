<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Vật Liệu Xây Dựng ABC - Cung cấp VLXD chất lượng cao</title>

    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>/css/theme.css">
    <style>
        /* theme variables are now defined in css/theme.css - keep this style block for other rules */

        /* Note: theme variables moved to css/theme.css for easier changes */

        .navbar-modern {
            background: url('/images/auth/brick.jpeg');
            transition: all 0.3s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-modern:hover {
            background: url('/images/auth/brick.jpeg');
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            transform: translateY(-2px);
        }

        /* Underline effect chỉ cho link thường, KHÔNG cho dropdown */
        .nav-item:not(.dropdown) .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: white;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-item:not(.dropdown) .nav-link:hover::after {
            width: 80%;
        }

        /* Dropdown Menu Modern */
        .dropdown-menu {
            border-radius: 12px;
            padding: 0.5rem;
            margin-top: 0.5rem;
            animation: fadeInDown 0.3s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-strong) 100%);
            color: white !important;
            transform: translateX(5px);
        }

        .dropdown-item:hover i {
            color: white !important;
        }

        /* Search Bar Modern */
        .search-modern {
            position: relative;
        }

        .search-modern input {
            border-radius: 50px;
            padding: 0.6rem 1.2rem;
            border: none;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .search-modern input:focus {
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .search-modern button {
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            border: 2px solid white;
            font-weight: 600;
        }

        /* Product Card Enhanced */
        .product-card-new {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid #f0f0f0;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .product-card-new::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.05) 0%, rgba(var(--primary-strong-rgb), 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
            pointer-events: none;
        }

        .product-card-new:hover::before {
            opacity: 1;
        }

        .product-card-new:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: rgba(var(--primary-rgb), 0.2);
        }

        .product-image-wrapper {
            position: relative;
            overflow: hidden;
            background: #fafafa;
            aspect-ratio: 1;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card-new:hover .product-image {
            transform: scale(1.08);
        }

        .featured-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #ffc107;
            color: #000;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.4);
        }

        .product-details {
            padding: 16px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .product-brand {
            color: #666;
            font-size: 0.8rem;
            margin-bottom: 6px;
            font-weight: 500;
        }

        .product-name {
            font-size: 0.95rem;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 10px;
            min-height: 42px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-name a {
            color: #2c3e50;
            text-decoration: none;
            transition: color 0.2s;
        }

        .product-name a:hover {
            color: var(--primary-color);
        }

        .product-price-section {
            margin-bottom: 8px;
        }

        .product-price-new {
            color: var(--primary-color);
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .product-price-old {
            color: #999;
            font-size: 0.9rem;
            text-decoration: line-through;
            font-weight: 400;
        }

        .product-unit {
            color: #666;
            font-size: 0.85rem;
            margin-top: 2px;
        }

        .product-stock {
            font-size: 0.85rem;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f0f0f0;
        }

        .btn-add-cart {
            background: linear-gradient(135deg, var(--primary-variant) 0%, var(--primary-color) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 0.85rem;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            display: block;
            width: 100%;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            margin-top: auto;
        }

        .btn-add-cart:hover {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(var(--primary-rgb), 0.4);
            color: white;
        }

        .btn-add-cart.disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .btn-add-cart.disabled:hover {
            transform: none;
            box-shadow: none;
        }

        /* Badge Modern */
        .badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        /* Modern Button Effects */
        .btn-modern {
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .btn-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-strong) 100%);
        }

        .btn-cart {
            background: linear-gradient(135deg, var(--primary-variant) 0%, var(--primary-strong) 100%);
            border: none;
        }

        /* Hero Banner Modern */
        .hero-banner {
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            position: relative;
            overflow: hidden;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
            animation: float 20s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            33% {
                transform: translateY(-10px) rotate(1deg);
            }

            66% {
                transform: translateY(5px) rotate(-1deg);
            }
        }

        /* Section Heading */
        .section-heading {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 1rem;
        }

        .section-heading::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-strong) 100%);
            border-radius: 2px;
        }

        /* Floating Chat Button */
        .floating-chat-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .floating-chat-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 30px rgba(37, 211, 102, 0.6);
            color: white;
        }

        .floating-chat-btn i {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Badge notification */
        .chat-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            border: 2px solid white;
        }

        /* Tooltip */
        .floating-chat-btn::before {
            content: 'Chat với chúng tôi';
            position: absolute;
            right: 70px;
            background: #333;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .floating-chat-btn:hover::before {
            opacity: 1;
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Product Sidebar */
        .product-sidebar {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 100px;
            z-index: 10;
        }

        .product-sidebar .list-group-item {
            border: none;
            padding: 0.75rem 0;
            color: #495057;
            transition: all 0.2s ease;
        }

        .product-sidebar .list-group-item:hover {
            background: rgba(var(--primary-rgb), 0.05);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .product-sidebar .list-group-item.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-strong) 100%);
            color: white;
            border-radius: 8px;
        }

        /* Filter Section */
        .filter-section {
            margin-bottom: 1.5rem;
        }

        .filter-section .form-check {
            margin-bottom: 0.5rem;
        }

        .filter-section .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Product Grid Responsive */
        @media (max-width: 991px) {
            .product-sidebar {
                position: static;
                margin-bottom: 2rem;
            }

            .product-sidebar .sticky-top {
                position: static !important;
            }
        }

        @media (max-width: 576px) {
            .product-sidebar {
                margin-left: -15px;
                margin-right: -15px;
                border-radius: 0;
            }
        }

        /* Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.3s ease;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body id="top">

    <!-- Top Bar -->
    <!-- <div class="bg-dark text-white py-2">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-7">
                        <div class="d-flex flex-wrap gap-3 align-items-center">
                            <small><i class="bi bi-telephone-fill me-1 text-success"></i> <strong>Hotline: 0333666999</strong></small>
                            <small class="d-none d-md-inline">|</small>
                            <small class="d-none d-md-inline"><i class="bi bi-envelope-fill me-1 text-primary"></i> lhtuan7924@gmail.com</small>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 text-end">
                        <small><i class="bi bi-truck me-1 text-warning"></i> <strong>Miễn phí ship</strong> đơn từ 5 triệu</small>
                    </div>
                </div>
            </div>
        </div> -->

    <!-- Navigation Modern -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-modern sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <i class="bi bi-building fs-3 me-2"></i>
                <div>
                    <?php
                        if(!isset($site_info)){
                            require_once(__DIR__ . '/../../model/site_info.php');
                            $site_info = (new SITE_INFO())->getSiteInfo();
                        }
                    ?>
                    <div style="font-size: 1.4rem; line-height: 1.2;"><?php echo htmlspecialchars($site_info['site_name'] ?? 'VLXD Di Hiền'); ?></div>
                    <div style="font-size: 0.65rem; font-weight: 400; opacity: 0.9;"><?php echo htmlspecialchars($site_info['tagline'] ?? 'Vật Liệu Xây Dựng Chất Lượng'); ?></div>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link px-3" href="index.php"><i class="bi bi-house-door me-1"></i>
                            Trang chủ</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-grid-3x3-gap me-1"></i> Danh mục sản phẩm
                        </a>
                        <ul class="dropdown-menu shadow border-0" aria-labelledby="navbarDropdown">
                            <?php foreach ($danhmuc as $d): ?>
                                <li><a class="dropdown-item py-2" href="?action=group&id=<?php echo $d["id"]; ?>">
                                        <i class="bi bi-arrow-right-short text-primary me-1"></i>
                                        <?php echo $d["name"]; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link px-3" href="index.php?action=danhsachtintuc"><i
                                class="bi bi-newspaper me-1"></i> Tin tức</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="index.php?action=danhsachbanggia"><i
                                class="bi bi-file-earmark-pdf me-1"></i> Bảng giá</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="index.php?action=gioithieu"><i
                                class="bi bi-info-circle me-1"></i> Giới thiệu</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="index.php?action=lienhe"><i
                                class="bi bi-telephone me-1"></i> Liên hệ</a></li>
                </ul>

                <!-- Search Form Modern -->
                <form class="search-modern d-flex me-3" method="GET" action="index.php">
                    <input type="hidden" name="action" value="timkiem">
                    <div class="input-group">
                        <input class="form-control border-0" type="search" name="keyword" placeholder="Tìm sản phẩm..."
                            style="width:200px;">
                        <button class="btn btn-light" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>

                <div class="d-flex align-items-center">
                    <?php if (isLoggedIn()) {
                        $user = getCurrentUser();
                        $customer = getCustomerInfo();
                        ?>
                        <div class="dropdown me-2">
                            <a class="btn btn-outline-light dropdown-toggle d-flex align-items-center" href="#"
                                role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-2"></i>
                                <div class="text-start">
                                    <div style="font-size: 0.9rem; line-height: 1.2;"><?php echo $user["fullname"]; ?></div>
                                    <?php if ($customer && isset($customer["member_level"])): ?>
                                        <small style="font-size: 0.7rem; opacity: 0.8;">
                                            <?php
                                            $level_text = ['bronze' => '🥉 Đồng', 'silver' => '🥈 Bạc', 'gold' => '🥇 Vàng', 'platinum' => '💎 Bạch Kim'];
                                            echo $level_text[$customer["member_level"]] ?? 'Thành viên';
                                            ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="min-width: 250px;">
                                <li class="px-3 py-2 bg-light">
                                    <div class="small text-muted">Xin chào,</div>
                                    <div class="fw-bold"><?php echo $user["fullname"]; ?></div>
                                    <?php if ($customer && isset($customer["loyalty_points"])): ?>
                                        <div class="small text-primary mt-1">
                                            <i class="bi bi-star-fill"></i>
                                            <?php echo number_format($customer["loyalty_points"]); ?> điểm
                                        </div>
                                    <?php endif; ?>
                                </li>
                                <li>
                                    <hr class="dropdown-divider my-2">
                                </li>
                                <li><a class="dropdown-item py-2" href="index.php?action=thongtin">
                                        <i class="bi bi-person me-2 text-primary"></i> Thông tin tài khoản
                                    </a></li>
                                <li><a class="dropdown-item py-2" href="index.php?action=donhang">
                                        <i class="bi bi-box-seam me-2 text-info"></i> Đơn hàng của tôi
                                    </a></li>
                                <li><a class="dropdown-item py-2" href="index.php?action=doidiem">
                                        <i class="bi bi-gift me-2 text-success"></i> Đổi điểm
                                    </a></li>
                                <li><a class="dropdown-item py-2" href="index.php?action=diachi">
                                        <i class="bi bi-geo-alt me-2 text-warning"></i> Sổ địa chỉ
                                    </a></li>

                                <?php
                                // Kiểm tra nếu là admin hoặc nhân viên
                                if (isAdmin() || isStaff()) {
                                    ?>
                                    <li>
                                        <hr class="dropdown-divider my-2">
                                    </li>
                                    <li><a class="dropdown-item py-2 bg-warning bg-opacity-10" href="../admin/dashboard/"
                                            target="_blank">
                                            <i class="bi bi-speedometer2 me-2 text-danger"></i> <strong>Quản trị hệ
                                                thống</strong>
                                        </a></li>
                                <?php
                                }
                                ?>

                                <li>
                                    <hr class="dropdown-divider my-2">
                                </li>
                                <li><a class="dropdown-item py-2 text-danger" href="index.php?action=dangxuat">
                                        <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                                    </a></li>
                            </ul>
                        </div>
                    <?php } else { ?>
                        <a href="index.php?action=dangnhap" class="btn btn-outline-light me-2">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Đăng nhập
                        </a>
                    <?php } ?>
                    <a href="index.php?action=giohang" class="btn btn-light position-relative">
                        <i class="bi bi-cart3"></i> Giỏ hàng
                        <?php if (demsoluongtronggio() > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php echo demsoluongtronggio(); ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Section-->
    <section class="py-4" style="background: url('/images/auth/wall.jpeg');">
        <div class="container-fluid px-4">