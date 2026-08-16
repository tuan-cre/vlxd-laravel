<div class="d-flex justify-content-between align-items-center mb-3 bg-white rounded-3 px-3 py-2 shadow-sm">
    <p class="text-muted mb-0 small">
        Showing <strong>{{ $products->total() }}</strong> products
        @if(request()->hasAny(['category_id','brand_id','min_price','max_price']))
            <span class="text-primary ms-1">· Filtered</span>
        @endif
    </p>
    <div class="d-flex align-items-center gap-2">
        <label class="text-muted small mb-0">Sort:</label>
        <select id="sortSelect" class="form-select form-select-sm" style="width:auto;">
            <option value="">Default</option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="best_selling" {{ request('sort') == 'best_selling' ? 'selected' : '' }}>Best Selling</option>
        </select>
        <span class="vr mx-1"></span>
        <button type="button" class="btn btn-sm {{ (request('per_page') ?? 12) == 12 ? 'btn-dark' : 'btn-outline-dark' }}" onclick="setPerPage(12)" title="3-column grid">
            <i class="bi bi-grid"></i>
        </button>
        <button type="button" class="btn btn-sm {{ request('per_page') == 6 ? 'btn-dark' : 'btn-outline-dark' }}" onclick="setPerPage(6)" title="2-column grid">
            <i class="bi bi-grid-3x2"></i>
        </button>
    </div>
</div>

<div id="productGridContent" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @forelse($products as $product)
    <div class="col">
        <div class="product-card card">
            <div class="card-img-wrapper">
                <img src="{{ asset('images/products/' . ($product->thumbnail ?? 'placeholder.jpg')) }}" alt="{{ $product->name }}">
                @if($product->sale_price > 0)
                    <span class="badge bg-danger product-badge">-{{ round((1 - $product->sale_price / $product->price) * 100) }}%</span>
                @endif
                <div class="product-actions">
                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-light w-100">
                        <i class="bi bi-eye me-1"></i> View Details
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($product->category)
                    <div class="product-category">{{ $product->category->name }}</div>
                @endif
                <h6 class="card-title">
                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
                </h6>
                <div class="product-price">
                    @if($product->sale_price > 0)
                        {{ number_format($product->sale_price) }}đ
                        <span class="original-price">{{ number_format($product->price) }}đ</span>
                    @else
                        {{ number_format($product->price) }}đ
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-primary-custom btn-sm w-100">
                        <i class="bi bi-cart-plus me-1"></i> Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="bi bi-inbox display-1 text-muted"></i>
        <h5 class="mt-3 text-muted">No products found</h5>
        <p class="text-muted">Try adjusting your filters</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary-custom">View All Products</a>
    </div>
    @endforelse
</div>

<div class="mt-4 d-flex justify-content-center" id="paginationLinks">
    {{ $products->withQueryString()->links('pagination::simple-bootstrap-5') }}
</div>
