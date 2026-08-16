@extends('layouts.admin')
@section('title', 'Management News')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-0">News</h1>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Add New</a>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="{{ route('admin.news.index') }}" class="row g-2">
                    <div class="col-md-5">
                        <input type="text" name="keyword" class="form-control" placeholder="Search news..." value="{{ request('keyword') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search me-1"></i>Search</button>
                    </div>
                </form>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="50">ID</th>
                            <th width="80">Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Views</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($news as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>
                                @if($article->thumbnail)
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="" width="50" height="50" class="rounded">
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{ $article->title }}</td>
                            <td><span class="badge bg-info">{{ $article->category ?? 'N/A' }}</span></td>
                            <td>{{ $article->author ?? 'Admin' }}</td>
                            <td>{{ $article->views ?? 0 }}</td>
                            <td>
                                @if($article->status == 'published')
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.news.edit', $article) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.news.destroy', $article) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirm delete?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center text-muted">No news articles found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $news->withQueryString()->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
