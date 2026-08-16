@extends('layouts.app')
@section('title', 'Products - Di Hiền Building Materials')

@section('content')
<section class="py-4" style="background: linear-gradient(135deg, #1a1a2e, #16213e); color:#fff;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2" style="--bs-breadcrumb-divider-color:rgba(255,255,255,0.3);">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Home</a></li>
                <li class="breadcrumb-item active text-white">Products</li>
            </ol>
        </nav>
        <h4 class="fw-bold mb-0">Product Listing</h4>
    </div>
</section>

<div class="container py-4">
    <form id="filterForm" method="GET" action="{{ route('products.index') }}">
        <div class="row g-4">

            {{-- SIDEBAR --}}
            <div class="col-lg-3">
                <div class="filter-sidebar">
                    <div class="filter-header">
                        <i class="bi bi-funnel-fill me-2"></i>Search Filters
                    </div>

                    {{-- Category --}}
                    <div class="filter-section">
                        <div class="filter-section-title" data-bs-toggle="collapse" data-bs-target="#filterCat" role="button">
                            <span><i class="bi bi-tag me-2"></i>Category</span>
                            <i class="bi bi-chevron-down small"></i>
                        </div>
                        <div class="collapse show" id="filterCat">
                            <div class="filter-list">
                                @foreach($categories as $category)
                                <label class="filter-check">
                                    <input type="radio" name="category_id" value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                    <span>{{ $category->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Brand --}}
                    <div class="filter-section">
                        <div class="filter-section-title" data-bs-toggle="collapse" data-bs-target="#filterBrand" role="button">
                            <span><i class="bi bi-award me-2"></i>Brand</span>
                            <i class="bi bi-chevron-down small"></i>
                        </div>
                        <div class="collapse show" id="filterBrand">
                            <div class="filter-list">
                                @foreach($brands as $brand)
                                <label class="filter-check">
                                    <input type="radio" name="brand_id" value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                    <span>{{ $brand->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Price --}}
                    <div class="filter-section">
                        <div class="filter-section-title" data-bs-toggle="collapse" data-bs-target="#filterPrice" role="button">
                            <span><i class="bi bi-cash-stack me-2"></i>Price Range</span>
                            <i class="bi bi-chevron-down small"></i>
                        </div>
                        <div class="collapse show" id="filterPrice">
                            <div class="px-3 pb-3">
                                <div class="d-flex gap-2 align-items-center">
                                    <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Min (đ)" value="{{ request('min_price') }}">
                                    <span class="text-muted">–</span>
                                    <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Max (đ)" value="{{ request('max_price') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button type="button" class="btn btn-primary-custom w-100" onclick="applyFilters()">
                            <i class="bi bi-search me-1"></i> Apply
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2 btn-sm">
                            <i class="bi bi-x-circle me-1"></i> Clear Filters
                        </a>
                    </div>
                </div>
            </div>

            {{-- PRODUCT GRID --}}
            <div class="col-lg-9" id="productGrid">
                @include('product._product-grid')
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let currentPerPage = {{ request('per_page') ?? 12 }};

function getFilterData() {
    const data = {};
    const form = document.getElementById('filterForm');
    const fd = new FormData(form);
    for (const [k, v] of fd.entries()) {
        if (v) data[k] = v;
    }
    data.per_page = currentPerPage;
    const sort = document.getElementById('sortSelect')?.value;
    if (sort) data.sort = sort;
    return data;
}

function applyFilters(page) {
    const data = getFilterData();
    if (page) data.page = page;

    const params = new URLSearchParams(data);
    const url = '{{ route("products.filter") }}?' + params.toString();

    const grid = document.getElementById('productGrid');
    grid.style.opacity = '0.5';
    grid.style.transition = 'opacity 0.2s';

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(json => {
        grid.innerHTML = json.html;
        grid.style.opacity = '1';
        history.pushState(null, '', '{{ route("products.index") }}?' + params.toString());
        bindPagination();
    })
    .catch(() => {
        grid.style.opacity = '1';
    });
}

function setPerPage(n) {
    currentPerPage = n;
    applyFilters();
}

function bindPagination() {
    document.querySelectorAll('#paginationLinks a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page');
            applyFilters(page);
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    bindPagination();

    document.getElementById('sortSelect')?.addEventListener('change', function() {
        applyFilters();
    });

    document.querySelectorAll('#filterForm input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            applyFilters();
        });
    });
});
</script>
@endpush
