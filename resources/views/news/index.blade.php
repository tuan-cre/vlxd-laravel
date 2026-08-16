@extends('layouts.app')
@section('title', 'News - Di Hiền Building Materials')

@section('content')
<section class="py-4" style="background: linear-gradient(135deg, #1a1a2e, #16213e); color:#fff;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2" style="--bs-breadcrumb-divider-color:rgba(255,255,255,0.3);">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Home</a></li>
                <li class="breadcrumb-item active text-white">News</li>
            </ol>
        </nav>
        <h4 class="fw-bold mb-0"><i class="bi bi-newspaper me-2"></i>News</h4>
    </div>
</section>

<div class="container py-4">

    <div class="section-title">
        <h2>Latest News</h2>
        <p>Stay updated with the latest construction material news</p>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($news as $item)
        <div class="col">
            <div class="news-card card">
                <div class="card-img-wrapper">
                    @if($item->thumbnail)
                        <img src="{{ asset('images/news/' . $item->thumbnail) }}" alt="{{ $item->title }}">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center h-100">
                            <i class="bi bi-newspaper display-4 text-muted"></i>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    @if($item->category)
                        <span class="badge bg-primary mb-2">{{ $item->category }}</span>
                    @endif
                    <h5 class="card-title">
                        <a href="#" class="text-decoration-none" style="color: var(--dark);">{{ $item->title }}</a>
                    </h5>
                    <p class="card-text text-muted">{{ Str::limit($item->summary, 120) }}</p>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted"><i class="bi bi-calendar me-1"></i>{{ $item->created_at->format('d/m/Y') }}</small>
                        @if($item->author ?? false)
                            <small class="text-muted"><i class="bi bi-person me-1"></i>{{ $item->author->fullname ?? '' }}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="empty-cart-icon mb-4">
                <i class="bi bi-newspaper"></i>
            </div>
            <h5 class="fw-bold" style="color:var(--dark);">No news articles yet</h5>
            <p class="text-muted">Check back later for the latest updates</p>
        </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $news->links() }}
    </div>
</div>
@endsection
