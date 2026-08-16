<?php include("inc/top.php"); ?>

<div class="row">
    <div class="col-md-8">
        <article class="card shadow mb-4">
            <div class="card-body">
                <?php if(!empty($news_detail['thumbnail'])): ?>
                <img src="../<?php echo $news_detail['thumbnail']; ?>" class="img-fluid rounded mb-4" alt="<?php echo $news_detail['title']; ?>">
                <?php endif; ?>
                
                <h1 class="mb-3"><?php echo $news_detail['title']; ?></h1>
                
                <div class="text-muted mb-4">
                    <i class="bi bi-calendar"></i> <?php echo date("d/m/Y H:i", strtotime($news_detail['created_at'])); ?>
                    <i class="bi bi-person ms-3"></i> Admin
                </div>
                
                <div class="content">
                    <?php echo $news_detail['content']; ?>
                </div>
            </div>
        </article>
        
        <a href="index.php?action=danhsachtintuc" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-list"></i> Tin tức khác</h5>
            </div>
            <div class="card-body">
                <?php if(!empty($other_news)): ?>
                <?php foreach($other_news as $n): ?>
                <div class="mb-3 pb-3 border-bottom">
                    <a href="index.php?action=tintuc&id=<?php echo $n['id']; ?>" class="text-decoration-none">
                        <h6 class="text-dark"><?php echo $n['title']; ?></h6>
                    </a>
                    <small class="text-muted">
                        <i class="bi bi-calendar"></i> <?php echo date("d/m/Y", strtotime($n['created_at'])); ?>
                    </small>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include("inc/bottom.php"); ?>
