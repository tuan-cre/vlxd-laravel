@extends('layouts.admin')
@section('title', 'Add New Import Bill')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-0">Add New Import Bill</h1>
            <a href="{{ route('admin.import-bills.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Back</a>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <form action="{{ route('admin.import-bills.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Supplier <span class="text-danger">*</span></label>
                                    <select name="supplier_id" class="form-select" required>
                                        <option value="">-- Select --</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Import Warehouse <span class="text-danger">*</span></label>
                                    <select name="warehouse_id" class="form-select" required>
                                        <option value="">-- Select --</option>
                                        @foreach($warehouses as $wh)
                                            <option value="{{ $wh->id }}" {{ old('warehouse_id') == $wh->id ? 'selected' : '' }}>{{ $wh->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Import Date</label>
                                    <input type="date" name="import_date" class="form-control" value="{{ old('import_date', date('Y-m-d')) }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="note" class="form-control" rows="2">{{ old('note') }}</textarea>
                            </div>
                            <hr>
                            <h5>Import Details</h5>
                            <div id="import-details">
                                <div class="row mb-2 import-row">
                                    <div class="col-md-5">
                                        <select name="details[0][product_id]" class="form-select" required>
                                            <option value="">-- Select Product --</option>
                                            @foreach($products as $prod)
                                                <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="details[0][quantity]" class="form-control" placeholder="Quantity" min="1" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="details[0][import_price]" class="form-control" placeholder="Import Unit Price" min="0" required>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success btn-sm mt-2" id="add-row"><i class="fas fa-plus me-1"></i>Add Row</button>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Save Import Bill</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
    let rowIndex = 1;
    document.getElementById('add-row').addEventListener('click', function() {
        const html = `
            <div class="row mb-2 import-row">
                <div class="col-md-5">
                    <select name="details[${rowIndex}][product_id]" class="form-select" required>
                        <option value="">-- Select Product --</option>
                        @foreach($products as $prod)
                            <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="details[${rowIndex}][quantity]" class="form-control" placeholder="Quantity" min="1" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="details[${rowIndex}][import_price]" class="form-control" placeholder="Import Unit Price" min="0" required>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-times"></i></button>
                </div>
            </div>`;
        document.getElementById('import-details').insertAdjacentHTML('beforeend', html);
        rowIndex++;
    });
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            e.target.closest('.import-row').remove();
        }
    });
</script>
@endpush
