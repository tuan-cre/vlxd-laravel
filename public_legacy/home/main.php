<?php
include("inc/top.php");
?>

<!-- Hero Banner -->
<!-- <div class="hero-banner rounded-4 mb-5 overflow-hidden shadow-lg" style="padding: 6rem 0; background: url('../images/banners/ban.jpg') no-repeat center center; background-size: cover;">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-7 text-white">
                <h1 class="display-4 fw-bold mb-3">Vật Liệu Xây Dựng Chất Lượng Cao</h1>
                <p class="lead mb-4">Đối tác tin cậy cho mọi công trình. Giá tốt - Chất lượng - Giao hàng nhanh</p>
                <div class="d-flex gap-3">
                    <a href="#products" class="btn btn-light btn-lg px-4">
                        <i class="bi bi-grid-3x3-gap me-2"></i> Xem sản phẩm
                    </a>
                    <a href="#!" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-telephone me-2"></i> Liên hệ ngay
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block">
                <i class="bi bi-building text-white" style="font-size: 200px; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div> -->

<!-- Hero Banner Slider -->
<div id="heroCarousel" class="carousel slide hero-banner rounded-4 mb-5 overflow-hidden shadow-lg"
    data-bs-ride="carousel">
    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active"
            style="background: url('../images/banners/ban.jpg') no-repeat center center; background-size: cover; padding: 6rem 0;">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-7 text-white">
                        <h1 class="display-4 fw-bold mb-3">Vật Liệu Xây Dựng Chất Lượng Cao</h1>
                        <p class="lead mb-4">Đối tác tin cậy cho mọi công trình. Giá tốt - Chất lượng - Giao hàng nhanh
                        </p>
                        <div class="d-flex gap-3">
                            <a href="#products" class="btn btn-light btn-lg px-4">
                                <i class="bi bi-grid-3x3-gap me-2"></i> Xem sản phẩm
                            </a>
                            <a href="#!" class="btn btn-outline-light btn-lg px-4">
                                <i class="bi bi-telephone me-2"></i> Liên hệ ngay
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5 text-center d-none d-lg-block">
                        <i class="bi bi-building text-white" style="font-size: 200px; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item"
            style="background: url('../images/banners/bulding.avif') no-repeat center center; background-size: cover; padding: 6rem 0;">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-7 text-white">
                        <h1 class="display-4 fw-bold mb-3">Chất Lượng – Uy Tín – Tiết Kiệm</h1>
                        <p class="lead mb-4">Mang đến vật liệu tốt nhất cho công trình của bạn.</p>
                        <div class="d-flex gap-3">
                            <a href="#products" class="btn btn-light btn-lg px-4">
                                <i class="bi bi-grid-3x3-gap me-2"></i> Xem sản phẩm
                            </a>
                            <a href="#!" class="btn btn-outline-light btn-lg px-4">
                                <i class="bi bi-telephone me-2"></i> Liên hệ ngay
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5 text-center d-none d-lg-block">
                        <i class="bi bi-building text-white" style="font-size: 200px; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item"
            style="background: url('../images/banners/building.jpg') no-repeat center center; background-size: cover; padding: 6rem 0;">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-7 text-white">
                        <h1 class="display-4 fw-bold mb-3">Giải Pháp Xây Dựng Toàn Diện</h1>
                        <p class="lead mb-4">Hỗ trợ bạn từ A-Z với vật liệu chất lượng cao.</p>
                        <div class="d-flex gap-3">
                            <a href="#products" class="btn btn-light btn-lg px-4">
                                <i class="bi bi-grid-3x3-gap me-2"></i> Xem sản phẩm
                            </a>
                            <a href="#!" class="btn btn-outline-light btn-lg px-4">
                                <i class="bi bi-telephone me-2"></i> Liên hệ ngay
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5 text-center d-none d-lg-block">
                        <i class="bi bi-building text-white" style="font-size: 200px; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Carousel Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Products Section -->
<div id="products" class="py-5 bg-light">
    <div class="container-fluid px-4">
        <div class="row g-4">
            <!-- Sidebar - Category & Filter (20%) -->
            <div class="col-lg-3 col-xl-2">
                <div class="product-sidebar p-4">
                    <!-- Categories -->
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-grid-3x3-gap me-2 text-primary"></i>Danh mục sản phẩm
                    </h5>
                    <div class="list-group list-group-flush">
                        <a href="index.php"
                            class="list-group-item list-group-item-action d-flex align-items-center px-0 py-2">
                            <i class="bi bi-house me-2 text-secondary"></i>
                            <span class="fw-medium">Tất cả sản phẩm</span>
                        </a>
                        <?php foreach ($danhmuc as $dm): ?>
                            <a href="index.php?action=group&id=<?php echo $dm['id']; ?>"
                                class="list-group-item list-group-item-action d-flex align-items-center px-0 py-2">
                                <i class="bi bi-tag me-2 text-primary"></i>
                                <span><?php echo $dm['name']; ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>

                    <hr class="my-4">

                    <!-- Filters -->
                    <div class="filter-section">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-funnel me-2 text-success"></i>Lọc sản phẩm
                        </h5>

                        <!-- Price Range -->
                        <div class="mb-3">
                            <label class="form-label fw-medium">Khoảng giá</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" placeholder="Từ" min="0">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" placeholder="Đến" min="0">
                                </div>
                            </div>
                        </div>

                        <!-- Brand Filter -->
                        <div class="mb-3">
                            <label class="form-label fw-medium">Thương hiệu</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="brand-all" value="all">
                                <label class="form-check-label" for="brand-all">
                                    Tất cả thương hiệu
                                </label>
                            </div>
                            <?php
                            $thuonghieu = array_unique(array_column($sanpham, 'brand_name'));
                            foreach ($thuonghieu as $th):
                                if (!empty($th)):
                                    ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="brand-<?php echo md5($th); ?>"
                                            value="<?php echo htmlspecialchars($th); ?>">
                                        <label class="form-check-label" for="brand-<?php echo md5($th); ?>">
                                            <?php echo $th; ?>
                                        </label>
                                    </div>
                                <?php endif; endforeach; ?>
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-3">
                            <label class="form-label fw-medium">Tình trạng</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="stock-all" checked>
                                <label class="form-check-label" for="stock-all">
                                    Tất cả
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="stock-available">
                                <label class="form-check-label" for="stock-available">
                                    Còn hàng
                                </label>
                            </div>
                        </div>

                        <!-- Sort Options -->
                        <div class="mb-3">
                            <label class="form-label fw-medium">Sắp xếp</label>
                            <select id="product-sort-select" class="form-select form-select-sm">
                                <option>Mặc định</option>
                                <option>Giá thấp đến cao</option>
                                <option>Giá cao đến thấp</option>
                                <option>Tên A-Z</option>
                                <option>Tên Z-A</option>
                                <option>Mới nhất</option>
                            </select>
                        </div>

                        <button class="btn btn-primary btn-sm w-100">
                            <i class="bi bi-search me-1"></i>Áp dụng
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Grid (80%) -->
            <div class="col-lg-9 col-xl-10">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="section-heading mb-1">
                            <i class="bi bi-grid-3x3-gap me-2"></i>Tất cả sản phẩm
                        </h2>
                        <small id="product-count" class="text-muted">Hiển thị <?php echo count($sanpham); ?> sản
                            phẩm</small>
                    </div>
                    <div class="d-flex gap-2">
                        <select id="per-page-select" class="form-select form-select-sm" style="width: auto;">
                            <option value="12">12 sản phẩm/trang</option>
                            <option value="24">24 sản phẩm/trang</option>
                            <option value="48">48 sản phẩm/trang</option>
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                <div id="product-container" class="row g-4">
                    <?php
                    $count = 0;
                    foreach ($sanpham as $sp):
                        if ($count >= 12)
                            break; // Limit to 12 products for demo
                        $count++;
                        ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <div class="product-card-new h-100">
                                <!-- Product Image -->
                                <div class="product-image-wrapper">
                                    <a href="index.php?action=detail&id=<?php echo $sp["id"]; ?>">
                                        <img class="product-image" src="../images/products/<?php echo $sp["thumbnail"]; ?>"
                                            alt="<?php echo $sp["name"]; ?>" />
                                    </a>

                                    <!-- Quick View Badge -->
                                    <?php if ($sp["is_featured"] == 1): ?>
                                        <span class="featured-badge">
                                            <i class="bi bi-star-fill"></i>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Product Details -->
                                <div class="product-details">
                                    <!-- Brand -->
                                    <?php if (!empty($sp["brand_name"])): ?>
                                        <div class="product-brand">
                                            <i class="bi bi-building"></i> <?php echo $sp["brand_name"]; ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Product Name -->
                                    <h3 class="product-name">
                                        <a href="index.php?action=detail&id=<?php echo $sp["id"]; ?>">
                                            <?php echo $sp["name"]; ?>
                                        </a>
                                    </h3>

                                    <!-- Price -->
                                    <div class="product-price-section">
                                        <?php if ($sp["sale_price"] > 0 && $sp["sale_price"] < $sp["price"]) { ?>
                                            <div class="d-flex align-items-baseline gap-2 mb-1">
                                                <span
                                                    class="product-price-new"><?php echo number_format($sp["sale_price"]); ?>đ</span>
                                                <span
                                                    class="product-price-old"><?php echo number_format($sp["price"]); ?>đ</span>
                                            </div>
                                        <?php } else { ?>
                                            <span class="product-price-new"><?php echo number_format($sp["price"]); ?>đ</span>
                                        <?php } ?>
                                        <div class="product-unit">/ <?php echo $sp["unit"]; ?></div>
                                    </div>

                                    <!-- Stock Status -->
                                    <div class="product-stock">
                                        <?php if ($sp["stock"] > 0): ?>
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                            <span class="text-success">Còn <?php echo number_format($sp["stock"]); ?>
                                                <?php echo $sp["unit"]; ?></span>
                                        <?php else: ?>
                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                            <span class="text-danger">Hết hàng</span>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Action Button -->
                                    <?php if ($sp["stock"] > 0): ?>
                                        <a class="btn-add-cart" href="index.php?action=chovaogio&id=<?php echo $sp["id"]; ?>">
                                            <i class="bi bi-cart-plus-fill"></i> THÊM VÀO GIỎ
                                        </a>
                                    <?php else: ?>
                                        <button class="btn-add-cart disabled" disabled>
                                            <i class="bi bi-x-circle"></i> HẾT HÀNG
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if (count($sanpham) > 12): ?>
                    <nav id="product-pagination" aria-label="Products pagination" class="mt-5"
                        data-total="<?php echo count($sanpham); ?>" data-page="1" data-per-page="12"></nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Top Viewed Products -->
<div class="py-5">
    <div class="container-fluid px-4">
        <style>
            /* views badge similar to featured badge but left aligned */
            .views-badge {
                position: absolute;
                top: 12px;
                left: 12px;
                background: rgba(0, 0, 0, 0.7);
                color: #fff;
                padding: 6px 10px;
                border-radius: 20px;
                font-size: 0.75rem;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                z-index: 20;
            }

            .views-badge i {
                font-size: 0.9rem;
                color: #ffd;
            }
        </style>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="section-heading mb-0" style="font-size:1.4rem;"><i class="bi bi-eye-fill me-2 text-primary"></i>
                Sản phẩm xem nhiều</h3>
            <div>
                <a class="btn btn-sm btn-outline-secondary me-1" href="#topViewedCarousel" role="button"
                    data-bs-slide="prev"><i class="bi bi-chevron-left"></i></a>
                <a class="btn btn-sm btn-outline-secondary" href="#topViewedCarousel" role="button"
                    data-bs-slide="next"><i class="bi bi-chevron-right"></i></a>
            </div>
        </div>

        <?php if (!empty($mathangxemnhieu)): ?>
            <div id="topViewedCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $chunks = array_chunk($mathangxemnhieu, 4);
                    foreach ($chunks as $i => $chunk): ?>
                        <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                            <div class="row g-4">
                                <?php foreach ($chunk as $sp): ?>
                                    <div class="col-xl-3 col-lg-4 col-md-6">
                                        <div class="product-card-new h-100">
                                            <div class="product-image-wrapper">
                                                <a href="index.php?action=detail&id=<?php echo $sp['id']; ?>">
                                                    <img class="product-image"
                                                        src="/images/products/<?php echo htmlspecialchars($sp['thumbnail']); ?>"
                                                        alt="<?php echo htmlspecialchars($sp['name']); ?>">
                                                </a>
                                                <!-- Views badge top-left -->
                                                <span class="views-badge"><i class="bi bi-eye-fill"></i>
                                                    <?php echo number_format($sp['views'] ?? 0); ?></span>
                                                <?php if (!empty($sp['is_featured']) && $sp['is_featured'] == 1): ?>
                                                    <span class="featured-badge"><i class="bi bi-star-fill"></i></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="product-details">
                                                <?php if (!empty($sp['brand_name'])): ?>
                                                    <div class="product-brand"><i class="bi bi-building me-1"></i>
                                                        <?php echo htmlspecialchars($sp['brand_name']); ?></div>
                                                <?php endif; ?>
                                                <h3 class="product-name"><a
                                                        href="index.php?action=detail&id=<?php echo $sp['id']; ?>"><?php echo htmlspecialchars($sp['name']); ?></a>
                                                </h3>
                                                <div class="product-price-section">
                                                    <?php if (!empty($sp['sale_price']) && $sp['sale_price'] < $sp['price']): ?>
                                                        <div class="product-price-new"><?php echo number_format($sp['sale_price']); ?>đ
                                                        </div>
                                                        <div class="product-price-old"><?php echo number_format($sp['price']); ?>đ</div>
                                                    <?php else: ?>
                                                        <div class="product-price-new"><?php echo number_format($sp['price']); ?>đ</div>
                                                    <?php endif; ?>
                                                    <div class="product-unit">/ <?php echo htmlspecialchars($sp['unit'] ?? ''); ?>
                                                    </div>
                                                </div>
                                                <div class="product-stock">
                                                    <?php if (!empty($sp['stock']) && $sp['stock'] > 0): ?>
                                                        <i class="bi bi-check-circle-fill text-success"></i>
                                                        <span class="text-success">Còn <?php echo number_format($sp['stock']); ?>
                                                            <?php echo htmlspecialchars($sp['unit'] ?? ''); ?></span>
                                                    <?php else: ?>
                                                        <i class="bi bi-x-circle-fill text-danger"></i> <span class="text-danger">Hết
                                                            hàng</span>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if (!empty($sp['stock']) && $sp['stock'] > 0): ?>
                                                    <a class="btn-add-cart"
                                                        href="index.php?action=chovaogio&id=<?php echo $sp['id']; ?>"><i
                                                            class="bi bi-cart-plus-fill"></i> THÊM VÀO GIỎ</a>
                                                <?php else: ?>
                                                    <button class="btn-add-cart disabled" disabled><i class="bi bi-x-circle"></i> HẾT
                                                        HÀNG</button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-4 text-muted">Chưa có sản phẩm xem nhiều.</div>
        <?php endif; ?>
    </div>
</div>

<!-- Most Sold Products -->
<div class="py-5 bg-white">
    <div class="container-fluid px-4">
        <style>
            .sold-badge {
                position: absolute;
                top: 12px;
                right: 12px;
                background: linear-gradient(90deg, #ff7a18, #ffb199);
                color: #111;
                padding: 6px 10px;
                border-radius: 20px;
                font-size: 0.75rem;
                font-weight: 700;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                z-index: 20;
            }

            .sold-badge i {
                color: #fff;
            }
        </style>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="section-heading mb-0" style="font-size:1.4rem;"><i class="bi bi-basket3 me-2 text-danger"></i>
                Sản phẩm bán chạy</h3>
            <div>
                <a class="btn btn-sm btn-outline-secondary me-1" href="#soldCarousel" role="button"
                    data-bs-slide="prev"><i class="bi bi-chevron-left"></i></a>
                <a class="btn btn-sm btn-outline-secondary" href="#soldCarousel" role="button" data-bs-slide="next"><i
                        class="bi bi-chevron-right"></i></a>
            </div>
        </div>

        <?php if (!empty($sanphambanchay)): ?>
            <div id="soldCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $chunks3 = array_chunk($sanphambanchay, 4);
                    foreach ($chunks3 as $i => $chunk): ?>
                        <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                            <div class="row g-4">
                                <?php foreach ($chunk as $sp): ?>
                                    <div class="col-xl-3 col-lg-4 col-md-6">
                                        <div class="product-card-new h-100">
                                            <div class="product-image-wrapper">
                                                <a href="index.php?action=detail&id=<?php echo $sp['id']; ?>">
                                                    <img class="product-image"
                                                        src="/images/products/<?php echo htmlspecialchars($sp['thumbnail']); ?>"
                                                        alt="<?php echo htmlspecialchars($sp['name']); ?>">
                                                </a>
                                                <span class="sold-badge"><i class="bi bi-fire"></i>
                                                    <?php echo number_format($sp['sold_count'] ?? 0); ?></span>
                                                <?php if (!empty($sp['is_featured']) && $sp['is_featured'] == 1): ?>
                                                    <span class="featured-badge"><i class="bi bi-star-fill"></i></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="product-details">
                                                <?php if (!empty($sp['brand_name'])): ?>
                                                    <div class="product-brand"><i class="bi bi-building me-1"></i>
                                                        <?php echo htmlspecialchars($sp['brand_name']); ?></div>
                                                <?php endif; ?>
                                                <h3 class="product-name"><a
                                                        href="index.php?action=detail&id=<?php echo $sp['id']; ?>"><?php echo htmlspecialchars($sp['name']); ?></a>
                                                </h3>
                                                <div class="product-price-section">
                                                    <?php if (!empty($sp['sale_price']) && $sp['sale_price'] < $sp['price']): ?>
                                                        <div class="product-price-new"><?php echo number_format($sp['sale_price']); ?>đ
                                                        </div>
                                                        <div class="product-price-old"><?php echo number_format($sp['price']); ?>đ</div>
                                                    <?php else: ?>
                                                        <div class="product-price-new"><?php echo number_format($sp['price']); ?>đ</div>
                                                    <?php endif; ?>
                                                    <div class="product-unit">/ <?php echo htmlspecialchars($sp['unit'] ?? ''); ?>
                                                    </div>
                                                </div>
                                                <div class="product-stock">
                                                    <?php if (!empty($sp['stock']) && $sp['stock'] > 0): ?>
                                                        <i class="bi bi-check-circle-fill text-success"></i>
                                                        <span class="text-success">Còn <?php echo number_format($sp['stock']); ?>
                                                            <?php echo htmlspecialchars($sp['unit'] ?? ''); ?></span>
                                                    <?php else: ?>
                                                        <i class="bi bi-x-circle-fill text-danger"></i> <span class="text-danger">Hết
                                                            hàng</span>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if (!empty($sp['stock']) && $sp['stock'] > 0): ?>
                                                    <a class="btn-add-cart"
                                                        href="index.php?action=chovaogio&id=<?php echo $sp['id']; ?>"><i
                                                            class="bi bi-cart-plus-fill"></i> THÊM VÀO GIỎ</a>
                                                <?php else: ?>
                                                    <button class="btn-add-cart disabled" disabled><i class="bi bi-x-circle"></i> HẾT
                                                        HÀNG</button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-4 text-muted">Chưa có sản phẩm bán chạy.</div>
        <?php endif; ?>
    </div>
</div>

<!-- Highlighted / Featured Products -->
<div class="py-5 bg-light">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="section-heading mb-0" style="font-size:1.4rem;"><i class="bi bi-star-fill me-2 text-warning"></i>
                Sản phẩm nổi bật</h3>
            <div>
                <a class="btn btn-sm btn-outline-secondary me-1" href="#featuredCarousel" role="button"
                    data-bs-slide="prev"><i class="bi bi-chevron-left"></i></a>
                <a class="btn btn-sm btn-outline-secondary" href="#featuredCarousel" role="button"
                    data-bs-slide="next"><i class="bi bi-chevron-right"></i></a>
            </div>
        </div>

        <?php if (!empty($sanphamnoibat)): ?>
            <div id="featuredCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $chunks2 = array_chunk($sanphamnoibat, 4);
                    foreach ($chunks2 as $i => $chunk): ?>
                        <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                            <div class="row g-4">
                                <?php foreach ($chunk as $sp): ?>
                                    <div class="col-xl-3 col-lg-4 col-md-6">
                                        <div class="product-card-new h-100">
                                            <div class="product-image-wrapper">
                                                <a href="index.php?action=detail&id=<?php echo $sp['id']; ?>">
                                                    <img class="product-image"
                                                        src="/images/products/<?php echo htmlspecialchars($sp['thumbnail']); ?>"
                                                        alt="<?php echo htmlspecialchars($sp['name']); ?>">
                                                </a>
                                                <?php if (!empty($sp['is_featured']) && $sp['is_featured'] == 1): ?>
                                                    <span class="featured-badge"><i class="bi bi-star-fill"></i></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="product-details">
                                                <?php if (!empty($sp['brand_name'])): ?>
                                                    <div class="product-brand"><i class="bi bi-building me-1"></i>
                                                        <?php echo htmlspecialchars($sp['brand_name']); ?></div>
                                                <?php endif; ?>
                                                <h3 class="product-name"><a
                                                        href="index.php?action=detail&id=<?php echo $sp['id']; ?>"><?php echo htmlspecialchars($sp['name']); ?></a>
                                                </h3>
                                                <div class="product-price-section">
                                                    <?php if (!empty($sp['sale_price']) && $sp['sale_price'] < $sp['price']): ?>
                                                        <div class="product-price-new"><?php echo number_format($sp['sale_price']); ?>đ
                                                        </div>
                                                        <div class="product-price-old"><?php echo number_format($sp['price']); ?>đ</div>
                                                    <?php else: ?>
                                                        <div class="product-price-new"><?php echo number_format($sp['price']); ?>đ</div>
                                                    <?php endif; ?>
                                                    <div class="product-unit">/ <?php echo htmlspecialchars($sp['unit'] ?? ''); ?>
                                                    </div>
                                                </div>
                                                <div class="product-stock">
                                                    <?php if (!empty($sp['stock']) && $sp['stock'] > 0): ?>
                                                        <i class="bi bi-check-circle-fill text-success"></i>
                                                        <span class="text-success">Còn <?php echo number_format($sp['stock']); ?>
                                                            <?php echo htmlspecialchars($sp['unit'] ?? ''); ?></span>
                                                    <?php else: ?>
                                                        <i class="bi bi-x-circle-fill text-danger"></i> <span class="text-danger">Hết
                                                            hàng</span>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if (!empty($sp['stock']) && $sp['stock'] > 0): ?>
                                                    <a class="btn-add-cart"
                                                        href="index.php?action=chovaogio&id=<?php echo $sp['id']; ?>"><i
                                                            class="bi bi-cart-plus-fill"></i> THÊM VÀO GIỎ</a>
                                                <?php else: ?>
                                                    <button class="btn-add-cart disabled" disabled><i class="bi bi-x-circle"></i> HẾT
                                                        HÀNG</button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-4 text-muted">Chưa có sản phẩm nổi bật.</div>
        <?php endif; ?>
    </div>
</div>


<?php
include("inc/bottom.php");
?>

<script>
    // debounce helper
    function debounce(fn, ms) {
        let t;
        return (...args) => {
            clearTimeout(t);
            t = setTimeout(() => fn(...args), ms);
        };
    }

    function getFiltersFromDOM() {
        const filters = {};
        const priceFrom = document.querySelector('input[placeholder="Từ"]').value;
        const priceTo = document.querySelector('input[placeholder="Đến"]').value;
        if (priceFrom && !isNaN(priceFrom)) filters.price_from = priceFrom;
        if (priceTo && !isNaN(priceTo)) filters.price_to = priceTo;

        const brandAll = document.getElementById('brand-all');
        const brandCheckboxes = document.querySelectorAll('input[id^="brand-"]');
        const selectedBrands = [];
        brandCheckboxes.forEach(cb => {
            if (cb.checked && cb.value && cb.value !== 'all') selectedBrands.push(cb.value);
        });
        if (brandAll && brandAll.checked) {
            // selectedBrands empty -> select all
        } else if (selectedBrands.length) {
            filters.brands = selectedBrands;
        }

        const stockAvailable = document.getElementById('stock-available');
        if (stockAvailable && stockAvailable.checked) {
            filters.in_stock = '1';
        }

        const sortSelect = document.getElementById('product-sort-select');
        let sortVal = sortSelect ? sortSelect.value : '';
        // map select label to sort param
        let sortParam = '';
        switch (sortVal) {
            case 'Giá thấp đến cao':
                sortParam = 'price_ASC';
                break;
            case 'Giá cao đến thấp':
                sortParam = 'price_DESC';
                break;
            case 'Tên A-Z':
                sortParam = 'name_ASC';
                break;
            case 'Tên Z-A':
                sortParam = 'name_DESC';
                break;
            case 'Mới nhất':
                sortParam = 'created_at_DESC';
                break;
            default:
                sortParam = 'id_DESC';
        }
        filters.sort_by = sortParam;

        // Page & per_page from DOM
        const perPageSelect = document.getElementById('per-page-select');
        filters.per_page = perPageSelect ? parseInt(perPageSelect.value, 10) : 12;
        // default to page 1 unless otherwise set via applyFilters param
        return filters;
    }

    let currentPage = 1;
    function applyFilters(page = 1) {
        const f = getFiltersFromDOM();
        f.page = page;
        const formData = new FormData();
        if (f.price_from) formData.append('price_from', f.price_from);
        if (f.price_to) formData.append('price_to', f.price_to);
        if (f.brands && f.brands.length) {
            f.brands.forEach(b => formData.append('brands[]', b));
        }
        if (f.in_stock) formData.append('in_stock', f.in_stock);
        if (f.sort_by) formData.append('sort_by', f.sort_by);
        if (f.per_page) formData.append('per_page', f.per_page);
        if (f.page) formData.append('page', f.page);

        fetch('index.php?action=filter', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(result => {
                // result => { data: [...], total: n, page: x, per_page: y }
                renderProducts(result.data || []);
                updateProductCount(result.total || 0);
                currentPage = result.page || f.page || 1;
                renderPagination(result.total || 0, result.per_page || f.per_page, currentPage);
            })
            .catch(err => console.error('Lỗi filter:', err));
    }

    function updateProductCount(n) {
        const countElement = document.getElementById('product-count');
        if (countElement) countElement.textContent = `Hiển thị ${n} sản phẩm`;
    }

    function renderPagination(total, per_page, current_page) {
        const nav = document.getElementById('product-pagination');
        if (!nav) return;
        const totalPages = Math.max(1, Math.ceil(total / per_page));
        // Build pagination
        let html = '<ul class="pagination justify-content-center">';
        // Prev
        const prevClass = (current_page <= 1) ? 'disabled' : '';
        html += `<li class="page-item ${prevClass}"><a class="page-link" href="#" data-page="${Math.max(1, current_page - 1)}">Trước</a></li>`;
        // Page numbers - show up to 5 pages with current centered
        const maxVisible = 5;
        let start = Math.max(1, current_page - Math.floor(maxVisible / 2));
        let end = Math.min(totalPages, start + maxVisible - 1);
        if (end - start + 1 < maxVisible) {
            start = Math.max(1, end - maxVisible + 1);
        }
        for (let p = start; p <= end; p++) {
            const cls = p === current_page ? 'active' : '';
            html += `<li class="page-item ${cls}"><a class="page-link" href="#" data-page="${p}">${p}</a></li>`;
        }
        // Next
        const nextClass = (current_page >= totalPages) ? 'disabled' : '';
        html += `<li class="page-item ${nextClass}"><a class="page-link" href="#" data-page="${Math.min(totalPages, current_page + 1)}">Sau</a></li>`;
        html += '</ul>';
        nav.innerHTML = html;
        // Attach events
        nav.querySelectorAll('a.page-link').forEach(a => {
            a.addEventListener('click', function (e) {
                e.preventDefault();
                const page = parseInt(this.getAttribute('data-page')) || 1;
                if (page !== current_page) applyFilters(page);
            });
        });
    }

    function renderProducts(products) {
        const container = document.getElementById('product-container');
        if (!container) return;
        if (!products || !products.length) {
            container.innerHTML = '<div class="col-12 text-center py-5">Không tìm thấy sản phẩm nào phù hợp.</div>';
            return;
        }

        const html = products.map(sp => {
            const price = parseInt(sp.price) || 0;
            const sale = parseInt(sp.sale_price) || 0;
            const stock = parseInt(sp.stock) || 0;
            return `
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="product-card-new h-100">
                    <div class="product-image-wrapper">
                        <a href="index.php?action=detail&id=${sp.id}">
                            <img class="product-image" src="/images/products/${sp.thumbnail}" alt="${sp.name}" />
                        </a>
                        ${sp.is_featured == 1 ? '<span class="featured-badge"><i class="bi bi-star-fill"></i></span>' : ''}
                    </div>
                    <div class="product-details">
                        ${sp.brand_name ? `<div class="product-brand"><i class="bi bi-building"></i> ${sp.brand_name}</div>` : ''}
                        <h3 class="product-name"><a href="index.php?action=detail&id=${sp.id}">${sp.name}</a></h3>
                        <div class="product-price-section">${(sale > 0 && sale < price) ?
                    `<div class="d-flex align-items-baseline gap-2 mb-1"><span class="product-price-new">${new Intl.NumberFormat('vi-VN').format(sale)}đ</span><span class="product-price-old">${new Intl.NumberFormat('vi-VN').format(price)}đ</span></div>`
                    : `<span class="product-price-new">${new Intl.NumberFormat('vi-VN').format(price)}đ</span>`
                }
                        <div class="product-unit">/ ${sp.unit}</div>
                        </div>
                        <div class="product-stock">${stock > 0 ? `<i class="bi bi-check-circle-fill text-success"></i> <span class="text-success">Còn ${new Intl.NumberFormat('vi-VN').format(stock)} ${sp.unit}</span>` : `<i class="bi bi-x-circle-fill text-danger"></i> <span class="text-danger">Hết hàng</span>`}</div>
                        ${stock > 0 ? `<a class="btn-add-cart" href="index.php?action=chovaogio&id=${sp.id}"><i class="bi bi-cart-plus-fill"></i> THÊM VÀO GIỎ</a>` : `<button class="btn-add-cart disabled" disabled><i class="bi bi-x-circle"></i> HẾT HÀNG</button>`}
                    </div>
                </div>
            </div>`;
        }).join('');
        container.innerHTML = html;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const priceInputs = document.querySelectorAll('input[placeholder="Từ"], input[placeholder="Đến"]');
        // Do not auto-apply filters on input; only apply when user clicks 'Áp dụng'

        const brandCheckboxes = document.querySelectorAll('input[id^="brand-"]');
        brandCheckboxes.forEach(cb => cb.addEventListener('change', function () {
            if (this.id === 'brand-all' && this.checked) {
                brandCheckboxes.forEach(c => { if (c.id !== 'brand-all') c.checked = false; });
            } else if (this.id !== 'brand-all') {
                document.getElementById('brand-all').checked = false;
            }
            // Only update UI on change; apply on button press
        }));

        const stockAll = document.getElementById('stock-all');
        const stockAvailable = document.getElementById('stock-available');
        if (stockAll) stockAll.addEventListener('change', function () { if (this.checked) stockAvailable.checked = false; });
        if (stockAvailable) stockAvailable.addEventListener('change', function () { if (this.checked) stockAll.checked = false; });

        const sortSelect = document.querySelector('select.form-select-sm');
        // Sort select change won't auto-apply; wait for button click
        const applyBtn = document.querySelector('button.btn-primary.btn-sm.w-100');
        if (applyBtn) applyBtn.addEventListener('click', function (e) { e.preventDefault(); applyFilters(1); });

        // Apply per-page change immediately
        const perPageSelect = document.getElementById('per-page-select');
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function () {
                // reset to page 1 when per-page changes
                applyFilters(1);
            });
        }
        // Initialize pagination from data attributes
        const nav = document.getElementById('product-pagination');
        if (nav) {
            const total = parseInt(nav.dataset.total) || 0;
            const per_page = parseInt(nav.dataset.perPage || nav.dataset.per_page) || 12;
            const page = parseInt(nav.dataset.page) || 1;
            renderPagination(total, per_page, page);
        }
    });
</script>