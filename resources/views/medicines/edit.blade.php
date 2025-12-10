@extends('layouts.app')

@section('title', 'Edit Medicine')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .form-group {
        margin-bottom: 1rem;
    }
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 0.375rem 0.75rem;
    }
    .medicine-image-preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 4px;
        margin-top: 10px;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Edit Medicine</h1>
        <a href="{{ route('medicines.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Medicines
        </a>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('medicines.update', $medicine->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label fw-bold">Medicine Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $medicine->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="generic_id" class="form-label fw-bold">Generic Name <span class="text-danger">*</span></label>
                            <select class="form-select @error('generic_id') is-invalid @enderror" id="generic_id" name="generic_id" required>
                                <option value="">Select Generic</option>
                                @foreach($generics as $generic)
                                    <option value="{{ $generic->id }}" {{ old('generic_id', $medicine->generic_id) == $generic->id ? 'selected' : '' }}>
                                        {{ $generic->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('generic_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="unit_price" class="form-label fw-bold">Unit Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">৳</span>
                                <input type="number" step="0.01" class="form-control @error('unit_price') is-invalid @enderror" id="unit_price" name="unit_price" value="{{ old('unit_price', $medicine->unit_price) }}" required>
                                @error('unit_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="stock_quantity" class="form-label fw-bold">Stock Quantity</label>
                            <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $medicine->stock_quantity) }}">
                            @error('stock_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="barcode" class="form-label fw-bold">Barcode</label>
                            <input type="text" class="form-control @error('barcode') is-invalid @enderror" id="barcode" name="barcode" value="{{ old('barcode', $medicine->barcode) }}">
                            @error('barcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dosage_id" class="form-label fw-bold">Dosage Form</label>
                            <select class="form-select @error('dosage_id') is-invalid @enderror" id="dosage_id" name="dosage_id">
                                <option value="">Select Dosage</option>
                                @foreach($dosages as $dosage)
                                    <option value="{{ $dosage->id }}" {{ old('dosage_id', $medicine->dosage_id) == $dosage->id ? 'selected' : '' }}>
                                        {{ $dosage->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dosage_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="pharma_id" class="form-label fw-bold">Manufacturer</label>
                            <select class="form-select @error('pharma_id') is-invalid @enderror" id="pharma_id" name="pharma_id">
                                <option value="">Select Manufacturer</option>
                                @foreach($pharmaceuticals as $pharmaceutical)
                                    <option value="{{ $pharmaceutical->id }}" {{ old('pharma_id', $medicine->pharma_id) == $pharmaceutical->id ? 'selected' : '' }}>
                                        {{ $pharmaceutical->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pharma_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="image" class="form-label fw-bold">Medicine Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @if($medicine->image)
                                <div class="mt-2">
                                    <img src="{{ asset($medicine->image) }}" alt="{{ $medicine->name }}" class="medicine-image-preview">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_id" class="form-label fw-bold">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->Category_ID }}" {{ old('category_id', $medicine->category_id) == $category->Category_ID ? 'selected' : '' }}>
                                        {{ $category->Name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="variations" class="form-label fw-bold">Variations</label>
                            <select class="form-select select2 @error('variations') is-invalid @enderror" id="variations" name="variations[]" multiple>
                                @foreach($variations as $variation)
                                    <option value="{{ $variation->id }}" {{ in_array($variation->id, old('variations', $selectedVariations)) ? 'selected' : '' }}>
                                        {{ $variation->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('variations')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fas fa-save me-2"></i> Update Medicine
                    </button>
                    <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select items",
            allowClear: true
        });
    });
</script>
@endsection
