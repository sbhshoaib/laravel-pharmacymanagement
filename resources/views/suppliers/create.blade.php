@extends('layouts.app')

@section('title', 'Add New Supplier')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Add New Supplier</h1>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Suppliers
        </a>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Name" class="form-label fw-bold">Supplier Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('Name') is-invalid @enderror" id="Name" name="Name" value="{{ old('Name') }}" required autofocus>
                            @error('Name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Contact_Person" class="form-label fw-bold">Contact Person</label>
                            <input type="text" class="form-control @error('Contact_Person') is-invalid @enderror" id="Contact_Person" name="Contact_Person" value="{{ old('Contact_Person') }}">
                            @error('Contact_Person')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control @error('Email') is-invalid @enderror" id="Email" name="Email" value="{{ old('Email') }}">
                            @error('Email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Phone" class="form-label fw-bold">Phone</label>
                            <input type="text" class="form-control @error('Phone') is-invalid @enderror" id="Phone" name="Phone" value="{{ old('Phone') }}">
                            @error('Phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="Address" class="form-label fw-bold">Address</label>
                            <textarea class="form-control @error('Address') is-invalid @enderror" id="Address" name="Address" rows="3">{{ old('Address') }}</textarea>
                            @error('Address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fas fa-save me-2"></i> Save Supplier
                    </button>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
