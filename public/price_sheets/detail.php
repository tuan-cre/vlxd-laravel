<?php include("inc/top.php"); ?>

<div class="container my-4">
    <div class="row">
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3"><?php echo htmlspecialchars($price_sheet['title']); ?></h4>
                    <?php if(!empty($price_sheet['effective_date'])): ?>
                        <div class="mb-3 text-muted">Áp dụng từ: <?php echo date('d/m/Y', strtotime($price_sheet['effective_date'])); ?></div>
                    <?php endif; ?>
                    <div style="height: 80vh;">
                        <?php if(!empty($price_sheet['web_url'])): ?>
                            <iframe src="../<?php echo htmlspecialchars($price_sheet['web_url']); ?>" frameborder="0" style="width: 100%; height: 100%;"></iframe>
                        <?php else: ?>
                            <div class="alert alert-warning">Không tìm thấy file PDF để hiển thị.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <a href="index.php?action=danhsachbanggia" class="btn btn-secondary mt-3"><i class="bi bi-arrow-left"></i> Quay lại danh sách</a>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-2">Tùy chọn</h6>
                    <?php if(!empty($price_sheet['web_url'])): ?>
                        <a href="../<?php echo htmlspecialchars($price_sheet['web_url']); ?>" class="btn btn-outline-primary w-100 mb-2" target="_blank" rel="noopener">Mở file trong tab mới</a>
                        <a href="../<?php echo htmlspecialchars($price_sheet['web_url']); ?>" class="btn btn-outline-secondary w-100" download>Tải xuống</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("inc/bottom.php"); ?>
