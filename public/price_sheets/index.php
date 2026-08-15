<?php include("inc/top.php"); ?>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none"><i class="bi bi-house"></i> Trang chủ</a></li>
        <li class="breadcrumb-item active">Bảng giá</li>
    </ol>
 </nav>

<div class="container">
    <div class="text-center mb-4">
        <h1 class="display-6 fw-bold"><i class="bi bi-file-earmark-pdf text-primary me-2"></i>Bảng giá sản phẩm</h1>
        <p class="lead text-muted">Tải bảng giá PDF mới nhất tại đây.</p>
    </div>

    <?php if(empty($price_sheets)): ?>
    <div class="alert alert-info">Chưa có bảng giá nào.</div>
    <?php else: ?>
    <div class="row g-3">
        <?php foreach($price_sheets as $ps): ?>
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-1"><?php echo htmlspecialchars($ps['title']); ?></h5>
                    <?php if(!empty($ps['effective_date'])): ?>
                        <p class="text-muted small">Áp dụng từ: <?php echo date('d/m/Y', strtotime($ps['effective_date'])); ?></p>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-transparent border-top-0 text-end">
                    <a href="index.php?action=banggia&id=<?php echo intval($ps['id']); ?>" class="btn btn-primary">Xem bảng giá</a>
                    <a href="../<?php echo htmlspecialchars($ps['web_url']); ?>" class="btn btn-outline-secondary ms-2" target="_blank" rel="noopener">Tải xuống</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php include("inc/bottom.php"); ?>
