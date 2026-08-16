<?php include("inc/top.php"); ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none"><i class="bi bi-house"></i> Trang chủ</a></li>
        <li class="breadcrumb-item active">Tin tức</li>
    </ol>
</nav>

<div class="container">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-3"><i class="bi bi-newspaper text-primary me-2"></i>Tin Tức & Kiến Thức Xây Dựng</h1>
        <p class="lead text-muted">Cập nhật thông tin mới nhất về vật liệu xây dựng và xu hướng xây dựng</p>
    </div>

<div class="row g-4">
    <?php if(empty($news)): ?>
    <div class="col-12">
        <div class="alert alert-info border-0 shadow-sm d-flex align-items-center">
            <i class="bi bi-info-circle fs-3 me-3"></i>
            <div>
                <h5 class="mb-1">Chưa có tin tức</h5>
                <p class="mb-0 small">Hiện tại chưa có tin tức nào được đăng. Vui lòng quay lại sau.</p>
            </div>
        </div>
    </div>
    <?php else: ?>
    <?php foreach($news as $n): ?>
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm hover-shadow" style="transition: all 0.3s;">
            <?php if(!empty($n['thumbnail'])): ?>
            <img src="../<?php echo $n['thumbnail']; ?>" class="card-img-top" alt="<?php echo $n['title']; ?>" style="height: 220px; object-fit: cover;">
            <?php else: ?>
            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
            </div>
            <?php endif; ?>
            <div class="card-body p-4">
                <div class="mb-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-tag-fill me-1"></i>Tin tức
                    </span>
                </div>
                <h5 class="card-title fw-bold mb-3" style="min-height: 50px;">
                    <a href="index.php?action=tintuc&id=<?php echo $n['id']; ?>" class="text-decoration-none text-dark">
                        <?php echo $n['title']; ?>
                    </a>
                </h5>
                <?php if(!empty($n['summary'])): ?>
                <p class="card-text text-muted small mb-3"><?php echo substr($n['summary'], 0, 120); ?>...</p>
                <?php endif; ?>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="bi bi-calendar3 me-1"></i><?php echo date("d/m/Y", strtotime($n['created_at'])); ?>
                    </small>
                    <a href="index.php?action=tintuc&id=<?php echo $n['id']; ?>" class="btn btn-sm btn-outline-primary">
                        Đọc thêm <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
</div>

<?php include("inc/bottom.php"); ?>
