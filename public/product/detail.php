<?php include("inc/top.php"); ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none"><i class="bi bi-house"></i> Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="index.php?action=group&id=<?php echo $sanpham_detail["category_id"]; ?>" class="text-decoration-none"><?php echo $sanpham_detail["category_name"]; ?></a></li>
        <li class="breadcrumb-item active"><?php echo $sanpham_detail["name"]; ?></li>
    </ol>
</nav>
    
<div class="row g-4">
    <div class="col-lg-8">      
        <div class="card product-card border-0 mb-3">
            <div class="card-body p-3">
                <div class="row">
                    <!-- Product Image -->
                    <div class="col-md-6">
                        <div class="position-relative">
                            <?php if($sanpham_detail["sale_price"] > 0 && $sanpham_detail["sale_price"] < $sanpham_detail["price"]): 
                                $discount = round((($sanpham_detail["price"] - $sanpham_detail["sale_price"]) / $sanpham_detail["price"]) * 100);
                            ?>
                            <span class="badge-modern bg-danger position-absolute" style="top: 1rem; right: 1rem; z-index: 10;">
                                -<?php echo $discount; ?>%
                            </span>
                            <?php endif; ?>
                            <img id="main-product-image" class="img-fluid rounded-3 shadow" src="../images/products/<?php echo $sanpham_detail["thumbnail"]; ?>" alt="<?php echo $sanpham_detail["name"]; ?>">
                            <?php if(!empty($product_images)): ?>
                            <div class="mt-3 d-flex flex-wrap gap-2">
                                <?php foreach($product_images as $img): ?>
                                    <div style="width:72px; height:72px; overflow:hidden; border-radius:6px; cursor:pointer;">
                                        <img class="product-thumb" src="../images/products/<?php echo htmlspecialchars($img['image_url']); ?>" data-full="../images/products/<?php echo htmlspecialchars($img['image_url']); ?>" style="width:100%; height:100%; object-fit:cover;" alt="">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="col-md-6">
                        <h3 class="fw-bold mb-2" style="font-size:1.25rem"><?php echo $sanpham_detail["name"]; ?></h3>
                        
                        <div class="mb-3">
                            <span class="badge bg-light text-dark border me-2">
                                <i class="bi bi-award text-warning"></i> <?php echo $sanpham_detail["brand_name"]; ?>
                            </span>
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-folder text-primary"></i> <?php echo $sanpham_detail["category_name"]; ?>
                            </span>
                        </div>
                        
                        <!-- Price -->
                        <div class="mb-3">
                            <?php if($sanpham_detail["sale_price"] > 0 && $sanpham_detail["sale_price"] < $sanpham_detail["price"]): ?>
                            <div class="price-old mb-1"><?php echo number_format($sanpham_detail["price"]); ?>đ</div>
                            <div class="price-display mb-0"><?php echo number_format($sanpham_detail["sale_price"]); ?>đ</div>
                            <?php else: ?>
                            <div class="price-display mb-0"><?php echo number_format($sanpham_detail["price"]); ?>đ</div>
                            <?php endif; ?>
                            <small class="text-muted">/ <?php echo $sanpham_detail["unit"]; ?></small>
                        </div>
                        
                        <!-- Stock Info -->
                        <div class="alert <?php echo $sanpham_detail["stock"] > 0 ? 'alert-success' : 'alert-danger'; ?> d-flex align-items-center mb-3 py-2">
                            <?php if($sanpham_detail["stock"] > 0): ?>
                            <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                            <div>
                                <strong>Còn hàng</strong>
                                <div class="small">Còn <?php echo $sanpham_detail["stock"]; ?> <?php echo $sanpham_detail["unit"]; ?> trong kho</div>
                            </div>
                            <?php else: ?>
                            <i class="bi bi-x-circle-fill fs-4 me-2"></i>
                            <div>
                                <strong>Hết hàng</strong>
                                <div class="small">Vui lòng liên hệ để đặt hàng</div>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Add to Cart Form -->
                        <?php if($sanpham_detail["stock"] > 0): ?>
                        <form method="post">
                            <input type="hidden" name="action" value="chovaogio">
                            <input type="hidden" name="id" value="<?php echo $sanpham_detail["id"]; ?>">
                            <div class="row g-2 mb-2">
                                <div class="col-auto">
                                    <label class="form-label fw-bold">Số lượng:</label>
                                    <input type="number" class="form-control form-control-lg" name="soluong" 
                                           value="1" min="1" max="<?php echo $sanpham_detail["stock"]; ?>" 
                                           style="width: 90px;">
                                </div>
                                <div class="col">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-cart btn-sm text-white btn-modern w-100">
                                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                                    </button>
                                </div>
                            </div>
                        </form>
                        <?php else: ?>
                        <button class="btn btn-secondary btn-lg w-100 btn-modern" disabled>
                            <i class="bi bi-x-circle"></i> Sản phẩm tạm hết hàng
                        </button>
                        <?php endif; ?>
                        
                        <!-- Quick Info -->
                        <div class="border-top pt-2 mt-2">
                            <div class="row text-center g-2">
                                <div class="col-4">
                                    <i class="bi bi-truck text-primary fs-5"></i>
                                    <div class="small mt-1">Giao hàng</div>
                                </div>
                                <div class="col-4">
                                    <i class="bi bi-shield-check text-success fs-5"></i>
                                    <div class="small mt-1">Chính hãng</div>
                                </div>
                                <div class="col-4">
                                    <i class="bi bi-headset text-info fs-5"></i>
                                    <div class="small mt-1">24/7</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Reviews (compact) -->
                        <div class="card mt-3">
                            <div class="card-body p-2">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-0"><i class="bi bi-chat-left-text me-2"></i>Đánh giá</h6>
                                        <div class="small text-muted">Trung bình: <strong><?php echo round($avg['avg_rating'] ?? 0,1); ?></strong> / 5</div>
                                    </div>
                                    <div class="text-end">
                                        <?php if(function_exists('getCurrentUser') && getCurrentUser()): ?>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#reviews-collapse" aria-expanded="false" aria-controls="reviews-collapse">Viết / Xem</button>
                                        <?php else: ?>
                                            <a href="index.php?action=dangnhap" class="btn btn-sm btn-outline-primary">Đăng nhập</a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="collapse" id="reviews-collapse">
                                    <div class="pt-2">
                                        <?php if(!empty($_SESSION['success'])): ?>
                                            <div class="alert alert-success py-2"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
                                        <?php endif; ?>
                                        <?php if(!empty($_SESSION['error'])): ?>
                                            <div class="alert alert-danger py-2"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                                        <?php endif; ?>

                                        <?php if(function_exists('getCurrentUser') && getCurrentUser()): $user = getCurrentUser(); ?>
                                        <form method="post" action="index.php?action=post_review" id="reviews-form" class="mb-2">
                                            <input type="hidden" name="product_id" value="<?php echo $sanpham_detail['id']; ?>">
                                            <div class="mb-2 small">Bạn đã dùng sản phẩm này? Hãy để lại đánh giá.</div>
                                            <div class="mb-2">
                                                <div>
                                                    <?php for($i=5;$i>=1;$i--): ?>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="rating" id="rating<?php echo $i; ?>" value="<?php echo $i; ?>" <?php echo $i===5? 'checked' : ''; ?>>
                                                            <label class="form-check-label small" for="rating<?php echo $i; ?>"><?php echo $i; ?> <i class="bi bi-star-fill text-warning"></i></label>
                                                        </div>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <textarea name="comment" class="form-control form-control-sm" rows="2" placeholder="Viết nhận xét..."></textarea>
                                            </div>
                                            <div class="text-end">
                                                <button class="btn btn-sm btn-primary">Gửi</button>
                                            </div>
                                        </form>
                                        <?php endif; ?>

                                        <!-- Reviews list (compact) -->
                                        <?php if(!empty($reviews)): ?>
                                            <div class="list-group list-group-flush">
                                                <?php foreach($reviews as $r): ?>
                                                    <div class="list-group-item py-2">
                                                        <div class="d-flex">
                                                            <img src="../images/users/<?php echo htmlspecialchars($r['avatar'] ?? 'default.png'); ?>" alt="" class="rounded-circle me-2" style="width:40px;height:40px;object-fit:cover;">
                                                            <div class="flex-grow-1">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div class="small fw-bold"><?php echo htmlspecialchars($r['user_name'] ?? 'Khách'); ?></div>
                                                                    <div class="text-warning small">
                                                                        <?php for($s=0;$s<5;$s++): ?>
                                                                            <?php if($s < $r['rating']): ?>
                                                                                <i class="bi bi-star-fill"></i>
                                                                            <?php else: ?>
                                                                                <i class="bi bi-star"></i>
                                                                            <?php endif; ?>
                                                                        <?php endfor; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="small text-muted"><?php echo date('d/m/Y', strtotime($r['created_at'])); ?></div>
                                                                <div class="mt-1 small"><?php echo nl2br(htmlspecialchars(mb_strimwidth($r['comment'],0,180,'...'))); ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="small text-muted">Chưa có đánh giá nào được duyệt.</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Product Description -->
        <div class="card product-card border-0">
            <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                <h4 class="fw-bold"><i class="bi bi-file-text me-2"></i>Mô tả sản phẩm</h4>
            </div>
            <div class="card-body px-4 pb-4">
                <?php if(!empty($sanpham_detail["description"])): ?>
                <div class="mb-3">
                    <?php echo nl2br($sanpham_detail["description"]); ?>
                </div>
                <?php endif; ?>
                <?php if(!empty($sanpham_detail["content"])): ?>
                <div class="content-detail">
                    <?php echo $sanpham_detail["content"]; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4"> 
        <!-- Đã xem gần đây -->
        <?php 
        $recently_viewed_ids = ViewTracker::getRecentlyViewed(4);
        if(!empty($recently_viewed_ids)):
        ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0 pt-4">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history me-2"></i>
                    Đã xem gần đây
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <?php foreach($recently_viewed_ids as $pid): 
                        $product = $sp->laySanPhamTheoId($pid);
                        if($product):
                    ?>
                    <div class="col-12">
                        <div class="card border-0 hover-shadow" style="transition: all 0.3s ease;">
                            <div class="row g-0">
                                <div class="col-4">
                                    <a href="index.php?action=detail&id=<?php echo $product["id"]; ?>">
                                        <img src="../images/products/<?php echo $product["thumbnail"]; ?>" 
                                                 alt="<?php echo $product["name"]; ?>"
                                                 class="img-fluid rounded-start h-100" 
                                                 style="object-fit: cover; min-height: 64px;">
                                    </a>
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-2">
                                        <a class="text-decoration-none" href="index.php?action=detail&id=<?php echo $product["id"]; ?>">
                                            <h6 class="card-title text-dark mb-1" style="font-size: 0.85rem; line-height: 1.2;">
                                                <?php echo $product["name"]; ?>
                                            </h6>
                                        </a>
                                        <div class="text-danger fw-bold" style="font-size: 0.95rem;">
                                            <?php 
                                            $price = ($product['sale_price'] > 0 && $product['sale_price'] < $product['price']) 
                                                ? $product['sale_price'] : $product['price'];
                                            echo number_format($price); 
                                            ?>đ
                                        </div>
                                        <small class="text-muted">
                                            <i class="bi bi-eye"></i> <?php echo $product["views"]; ?> lượt xem
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Sản phẩm liên quan -->
        <div class="card product-card border-0 sticky-top" style="top: 80px; z-index: 1;">
            <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                <h5 class="fw-bold"><i class="bi bi-grid-3x3 me-2"></i>Sản phẩm liên quan</h5>
            </div>
            <div class="card-body p-3">
                <?php
                foreach($sanpham_lienquan as $sp):  
                    if($sp["id"] != $sanpham_detail["id"]):
                ?>
                <div class="d-flex mb-3 bg-light rounded-3 p-2 hover-shadow">
                    <a href="?action=detail&id=<?php echo $sp["id"]; ?>" class="flex-shrink-0">
                    <img src="../images/products/<?php echo $sp["thumbnail"]; ?>" alt="<?php echo $sp["name"]; ?>" 
                        class="rounded" style="width: 64px; height: 64px; object-fit: cover;" />
                    </a>
                    <div class="flex-grow-1 ms-3">
                        <a class="text-decoration-none text-dark" href="?action=detail&id=<?php echo $sp["id"]; ?>">
                            <h6 class="fw-bold mb-1" style="font-size: 0.9rem;"><?php echo $sp["name"]; ?></h6>
                        </a>
                        <p class="text-muted small mb-1"><i class="bi bi-award"></i> <?php echo $sp["brand_name"]; ?></p>
                        <div>
                            <?php if($sp["sale_price"] > 0 && $sp["sale_price"] < $sp["price"]): ?>
                            <div class="price-old" style="font-size: 0.75rem;"><?php echo number_format($sp["price"]); ?>đ</div>
                            <div class="text-danger fw-bold"><?php echo number_format($sp["sale_price"]); ?>đ</div>
                            <?php else: ?>
                            <div class="text-danger fw-bold"><?php echo number_format($sp["price"]); ?>đ</div>
                            <?php endif; ?>
                            <small class="text-muted">/ <?php echo $sp["unit"]; ?></small>
                        </div>
                    </div>
                </div>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
        </div>
    </div>    
</div>
<!-- The reviews data is now provided by the controller (public/index.php). The detailed review form and list remain below in the page body. -->
<?php include("inc/bottom.php"); ?>

<script>
// Thumbnail click swaps the main image
document.addEventListener('DOMContentLoaded', function(){
    var mainImg = document.getElementById('main-product-image');
    if(!mainImg) return;
    document.querySelectorAll('.product-thumb').forEach(function(thumb){
        thumb.addEventListener('click', function(){
            var full = this.getAttribute('data-full');
            if(full){
                mainImg.src = full;
            }
        });
    });
});
</script>