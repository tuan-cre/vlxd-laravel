@extends('layouts.admin')
@section('title', 'Edit Article')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-0">Edit Article</h1>
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Back</a>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $news->title) }}" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Short Description</label>
                                <textarea name="summary" class="form-control" rows="3">{{ old('summary', $news->summary) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea name="content" class="form-control" rows="12" required>{{ old('content', $news->content) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select">
                                    @foreach(['tin-tuc'=>'News', 'kien-thuc'=>'Knowledge', 'huong-dan'=>'Guides', 'khuyen-mai'=>'Promotions', 'su-kien'=>'Events'] as $val => $label)
                                        <option value="{{ $val }}" {{ old('category', $news->category) == $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Current Image</label>
                                @if($news->thumbnail)
                                    <div class="mb-2"><img src="{{ asset('storage/' . $news->thumbnail) }}" alt="" class="img-fluid rounded"></div>
                                @endif
                                <input type="file" name="thumbnail" class="form-control" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="draft" {{ old('status', $news->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $news->status) == 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save me-1"></i>Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
