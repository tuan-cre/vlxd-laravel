<?php include("inc/top.php"); ?>

<?php
// Brands for filter list
$thuonghieu = $sanpham ? array_unique(array_column($sanpham, 'brand_name')) : [];
?>

<!-- Products & Filters layout -->
<div id="products" class="py-5 bg-light">
    <div class="container-fluid px-4">
        <div class="row g-4">
            <!-- Sidebar - Category & Filter (20%) -->
            <div class="col-lg-3 col-xl-2">
                <div class="product-sidebar p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-grid-3x3-gap me-2 text-primary"></i>Danh mục sản phẩm
                    </h5>
                    <div class="list-group list-group-flush">
                        <a href="index.php" class="list-group-item list-group-item-action d-flex align-items-center px-0 py-2">
                            <i class="bi bi-house me-2 text-secondary"></i>
                            <span class="fw-medium">Tất cả sản phẩm</span>
                        </a>
                        <?php foreach($danhmuc as $dm): ?>
                        <a href="index.php?action=group&id=<?php echo $dm['id']; ?>" class="list-group-item list-group-item-action d-flex align-items-center px-0 py-2 <?php echo (isset($madm) && $madm == $dm['id']) ? 'active' : '' ?>">
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
                                    <input type="number" class="form-control form-control-sm" placeholder="Từ" min="0" />
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" placeholder="Đến" min="0" />
                                </div>
                            </div>
                        </div>

                        <!-- Brand Filter -->
                        <div class="mb-3">
                            <label class="form-label fw-medium">Thương hiệu</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="brand-all" value="all">
                                <label class="form-check-label" for="brand-all">Tất cả thương hiệu</label>
                            </div>
                            <?php foreach($thuonghieu as $th): if(!empty($th)): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="brand-<?php echo md5($th); ?>" value="<?php echo htmlspecialchars($th); ?>">
                                <label class="form-check-label" for="brand-<?php echo md5($th); ?>"><?php echo $th; ?></label>
                            </div>
                            <?php endif; endforeach; ?>
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-3">
                            <label class="form-label fw-medium">Tình trạng</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="stock-all" checked>
                                <label class="form-check-label" for="stock-all">Tất cả</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="stock-available">
                                <label class="form-check-label" for="stock-available">Còn hàng</label>
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

                        <!-- Hidden current category id -->
                        <input type="hidden" id="current-category-id" value="<?php echo isset($madm) ? (int)$madm : ''; ?>" />

                        <button class="btn btn-primary btn-sm w-100">
                            <i class="bi bi-search me-1"></i>Áp dụng
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Grid (80%) -->
            <div class="col-lg-9 col-xl-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="section-heading mb-1 text-primary"><i class="bi bi-grid-3x3-gap-fill"></i> <?php echo $tendm; ?></h3>
                        <small id="product-count" class="text-muted">Hiển thị <?php echo count($sanpham); ?> sản phẩm</small>
                    </div>
                    <div class="d-flex gap-2">
                        <select id="per-page-select" class="form-select form-select-sm" style="width: auto;">
                            <option value="12">12 sản phẩm/trang</option>
                            <option value="24">24 sản phẩm/trang</option>
                            <option value="48">48 sản phẩm/trang</option>
                        </select>
                    </div>
                </div>

                    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center" id="product-container">
<?php 
if($sanpham != null){
    foreach($sanpham as $sp):
?>
    <div class="col mb-5">
        <div class="product-card-new h-100">
            <!-- Sale badge-->
            <?php if (!empty($sp["sale_price"]) && $sp["sale_price"] < $sp["price"]){ ?>
            <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Giảm giá</div>
            <?php } ?>
            
            <!-- Stock badge-->
            <?php if ($sp["stock"] <= 0){ ?>
            <div class="badge bg-secondary text-white position-absolute" style="top: 0.5rem; left: 0.5rem">Hết hàng</div>
            <?php } elseif ($sp["stock"] < 10){ ?>
            <div class="badge bg-warning text-dark position-absolute" style="top: 0.5rem; left: 0.5rem">Sắp hết</div>
            <?php } ?>
            
            <div class="product-image-wrapper">
                <a href="index.php?action=detail&id=<?php echo $sp["id"]; ?>">
                    <img class="product-image" src="/images/products/<?php echo $sp["thumbnail"]; ?>" alt="<?php echo $sp["name"]; ?>" />
                </a>

                <?php if($sp["is_featured"] == 1): ?>
                <span class="featured-badge"><i class="bi bi-star-fill"></i></span>
                <?php endif; ?>
            </div>
            <div class="product-details">
                <?php if(!empty($sp["brand_name"])): ?>
                <div class="product-brand"><i class="bi bi-building"></i> <?php echo $sp["brand_name"]; ?></div>
                <?php endif; ?>

                <h3 class="product-name"><a href="index.php?action=detail&id=<?php echo $sp["id"]; ?>"><?php echo $sp["name"]; ?></a></h3>
                    
                    <!-- Brand name -->
                    <?php if (!empty($sp["brand_name"])){ ?>
                    <p class="text-muted small mb-2">
                        <i class="bi bi-award"></i> <?php echo $sp["brand_name"]; ?>
                    </p>
                    <?php } ?>
                    
                    <!-- Unit -->
                    <p class="text-secondary small mb-2">
                        <i class="bi bi-box-seam"></i> Đơn vị: <?php echo $sp["unit"]; ?>
                    </p>
                    
                    <!-- Product price-->
                    <div class="mb-2">
                        <?php 
                        $display_price = !empty($sp["sale_price"]) && $sp["sale_price"] < $sp["price"] ? $sp["sale_price"] : $sp["price"];
                        ?>
                        <?php if (!empty($sp["sale_price"]) && $sp["sale_price"] < $sp["price"]){ ?>
                        <span class="text-muted text-decoration-line-through"><?php echo number_format($sp["price"]); ?>đ</span>
                        <?php } ?>
                        <span class="text-danger fw-bolder fs-5"><?php echo number_format($display_price); ?>đ</span>
                        <span class="text-muted small">/<?php echo $sp["unit"]; ?></span>
                    </div>
            </div>
            <?php if($sp["stock"] > 0): ?>
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
<?php 
    endforeach; 
    }
    else{
        echo '<div class="col-12"><div class="alert alert-info text-center"><i class="bi bi-info-circle"></i> Danh mục này hiện chưa có sản phẩm. Vui lòng xem danh mục khác...</div></div>';
    }
?>              
</div>
<nav id="product-pagination" aria-label="Products pagination" class="mt-4" data-total="<?php echo count($sanpham); ?>" data-page="1" data-per-page="12"></nav>

<?php include("inc/bottom.php"); ?>

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
    if(priceFrom && !isNaN(priceFrom)) filters.price_from = priceFrom;
    if(priceTo && !isNaN(priceTo)) filters.price_to = priceTo;

    const brandAll = document.getElementById('brand-all');
    const brandCheckboxes = document.querySelectorAll('input[id^="brand-"]');
    const selectedBrands = [];
    brandCheckboxes.forEach(cb => {
        if(cb.checked && cb.value && cb.value !== 'all') selectedBrands.push(cb.value);
    });
    if(brandAll && brandAll.checked) {
        // selectedBrands empty -> select all
    } else if(selectedBrands.length) {
        filters.brands = selectedBrands;
    }

    const stockAvailable = document.getElementById('stock-available');
    if(stockAvailable && stockAvailable.checked) {
        filters.in_stock = '1';
    }

    const sortSelect = document.getElementById('product-sort-select');
    let sortVal = sortSelect ? sortSelect.value : '';
    // map select label to sort param
    let sortParam = '';
    switch(sortVal) {
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

    const categoryInput = document.getElementById('current-category-id');
    if(categoryInput && categoryInput.value) filters.category_id = categoryInput.value;

    return filters;
}

let currentPage = 1;
function applyFilters(page = 1) {
    const f = getFiltersFromDOM();
    f.page = page;
    const formData = new FormData();
    if(f.price_from) formData.append('price_from', f.price_from);
    if(f.price_to) formData.append('price_to', f.price_to);
    if(f.brands && f.brands.length) {
        f.brands.forEach(b => formData.append('brands[]', b));
    }
    if(f.in_stock) formData.append('in_stock', f.in_stock);
    if(f.sort_by) formData.append('sort_by', f.sort_by);
    if(f.category_id) formData.append('category_id', f.category_id);

    fetch('index.php?action=filter', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(result => {
            renderProducts(result.data || []);
            updateProductCount(result.total || 0);
            currentPage = result.page || f.page || 1;
            renderPagination(result.total || 0, result.per_page || f.per_page, currentPage);
        })
        .catch(err => console.error('Lỗi filter:', err));
}

function updateProductCount(n) {
    const countElement = document.getElementById('product-count');
    if(countElement) countElement.textContent = `Hiển thị ${n} sản phẩm`;
}

function renderPagination(total, per_page, current_page) {
    const nav = document.getElementById('product-pagination');
    if(!nav) return;
    const totalPages = Math.max(1, Math.ceil(total / per_page));
    let html = '<ul class="pagination justify-content-center">';
    const prevClass = (current_page <= 1) ? 'disabled' : '';
    html += `<li class="page-item ${prevClass}"><a class="page-link" href="#" data-page="${Math.max(1, current_page-1)}">Trước</a></li>`;
    const maxVisible = 5;
    let start = Math.max(1, current_page - Math.floor(maxVisible/2));
    let end = Math.min(totalPages, start + maxVisible - 1);
    if (end - start + 1 < maxVisible) {
        start = Math.max(1, end - maxVisible + 1);
    }
    for(let p = start; p <= end; p++){
        const cls = p === current_page ? 'active' : '';
        html += `<li class="page-item ${cls}"><a class="page-link" href="#" data-page="${p}">${p}</a></li>`;
    }
    const nextClass = (current_page >= totalPages) ? 'disabled' : '';
    html += `<li class="page-item ${nextClass}"><a class="page-link" href="#" data-page="${Math.min(totalPages, current_page+1)}">Sau</a></li>`;
    html += '</ul>';
    nav.innerHTML = html;
    nav.querySelectorAll('a.page-link').forEach(a => {
        a.addEventListener('click', function(e){
            e.preventDefault();
            const page = parseInt(this.getAttribute('data-page')) || 1;
            if(page !== currentPage) applyFilters(page);
        });
    });
}

function renderProducts(products) {
    const container = document.getElementById('product-container');
    if(!container) return;
    if(!products || !products.length) {
        container.innerHTML = '<div class="col-12 text-center py-5">Không tìm thấy sản phẩm nào phù hợp.</div>';
        return;
    }

    const html = products.map(sp => {
        const price = parseInt(sp.price) || 0;
        const sale = parseInt(sp.sale_price) || 0;
        const stock = parseInt(sp.stock) || 0;
        return `
            <div class="col mb-5">
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
                        <div class="product-price-section">${sale > 0 && sale < price ? `<div class="d-flex align-items-baseline gap-2 mb-1"><span class="product-price-new">${new Intl.NumberFormat('vi-VN').format(sale)}đ</span><span class="product-price-old">${new Intl.NumberFormat('vi-VN').format(price)}đ</span></div>` : `<span class="product-price-new">${new Intl.NumberFormat('vi-VN').format(price)}đ</span>`}
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

document.addEventListener('DOMContentLoaded', function() {
    const brandCheckboxes = document.querySelectorAll('input[id^="brand-"]');
    brandCheckboxes.forEach(cb => cb.addEventListener('change', function() {
        if(this.id === 'brand-all' && this.checked) {
            brandCheckboxes.forEach(c => { if(c.id !== 'brand-all') c.checked = false; });
        } else if (this.id !== 'brand-all') {
            document.getElementById('brand-all').checked = false;
        }
    }));
    const stockAll = document.getElementById('stock-all');
    const stockAvailable = document.getElementById('stock-available');
    if(stockAll) stockAll.addEventListener('change', function() { if(this.checked) stockAvailable.checked = false; });
    if(stockAvailable) stockAvailable.addEventListener('change', function() { if(this.checked) stockAll.checked = false; });
    const applyBtn = document.querySelector('button.btn-primary.btn-sm.w-100');
    if(applyBtn) applyBtn.addEventListener('click', function(e) { e.preventDefault(); applyFilters(1); });

    // Apply per-page change immediately
    const perPageSelect = document.getElementById('per-page-select');
    if(perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            applyFilters(1);
        });
    }
    // Initialize pagination from data attributes
    const nav = document.getElementById('product-pagination');
    if(nav) {
        const total = parseInt(nav.dataset.total) || 0;
        const per_page = parseInt(nav.dataset.perPage || nav.dataset.per_page) || 12;
        const page = parseInt(nav.dataset.page) || 1;
        // renderPagination function is defined in this file
        if(typeof renderPagination === 'function') renderPagination(total, per_page, page);
    }
});
</script>