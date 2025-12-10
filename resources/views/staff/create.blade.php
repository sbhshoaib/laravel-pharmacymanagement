@extends('layouts.app')

@section('title', 'Add New Staff')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Add New Staff</h1>
        <a href="{{ route('staff.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Staff
        </a>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('staff.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Name" class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('Name') is-invalid @enderror" id="Name" name="Name" value="{{ old('Name') }}" required autofocus>
                            @error('Name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('Email') is-invalid @enderror" id="Email" name="Email" value="{{ old('Email') }}" required>
                            @error('Email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Phone" class="form-label fw-bold">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('Phone') is-invalid @enderror" id="Phone" name="Phone" value="{{ old('Phone') }}" required>
                            @error('Phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Role_ID" class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                            <select class="form-select @error('Role_ID') is-invalid @enderror" id="Role_ID" name="Role_ID" required>
                                <option value="">Select a role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->Role_ID }}" {{ old('Role_ID') == $role->Role_ID ? 'selected' : '' }}>
                                        {{ $role->Role_Name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('Role_ID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('Password') is-invalid @enderror" id="Password" name="Password" required>
                            @error('Password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Password_confirmation" class="form-label fw-bold">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="Password_confirmation" name="Password_confirmation" required>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fas fa-save me-2"></i> Save Staff
                    </button>
                    <a href="{{ route('staff.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
