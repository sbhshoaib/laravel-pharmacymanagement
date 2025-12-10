@extends('layouts.app')

@section('title', 'Edit Pharmaceutical')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Edit Pharmaceutical</h1>
        <a href="{{ route('pharmaceuticals.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Pharmaceuticals
        </a>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('pharmaceuticals.update', $pharmaceutical->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Pharmaceutical Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $pharmaceutical->name) }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fas fa-save me-2"></i> Update Pharmaceutical
                    </button>
                    <a href="{{ route('pharmaceuticals.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
