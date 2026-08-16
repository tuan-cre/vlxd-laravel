@extends('layouts.admin')
@section('title', 'Edit Coupon')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-0">Edit Coupon</h1>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Back</a>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $coupon->code) }}" required>
                                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                                <select name="discount_type" class="form-select" required>
                                    <option value="percent" {{ old('discount_type', $coupon->discount_type) == 'percent' ? 'selected' : '' }}>Percent (%)</option>
                                    <option value="fixed" {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed (VND)</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Value <span class="text-danger">*</span></label>
                                    <input type="number" name="discount_value" class="form-control @error('discount_value') is-invalid @enderror" value="{{ old('discount_value', $coupon->discount_value) }}" required>
                                    @error('discount_value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Min Order Value</label>
                                    <input type="number" name="min_order_value" class="form-control" value="{{ old('min_order_value', $coupon->min_order_value) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $coupon->start_date ? \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d') : '') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $coupon->end_date ? \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Usage Limit</label>
                                    <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit', $coupon->usage_limit) }}" placeholder="Leave empty = unlimited">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Points Cost</label>
                                    <input type="number" name="points_cost" class="form-control" value="{{ old('points_cost', $coupon->points_cost ?? 0) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Minimum Member Level</label>
                                    <select name="min_member_level" class="form-select">
                                        @foreach(['bronze'=>'Bronze', 'silver'=>'Silver', 'gold'=>'Gold', 'platinum'=>'Platinum'] as $val => $label)
                                            <option value="{{ $val }}" {{ old('min_member_level', $coupon->min_member_level) == $val ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="requires_claim" value="1" class="form-check-input" {{ old('requires_claim', $coupon->requires_claim) ? 'checked' : '' }}>
                                    <label class="form-check-label">Requires Claim</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
