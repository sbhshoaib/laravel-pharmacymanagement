@extends('layouts.app')

@section('title', 'Medicines')

@section('styles')
<style>
    .medicine-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
    }
    .action-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        margin-right: 4px;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Medicines</h1>
        <a href="{{ route('medicines.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Medicine
        </a>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Generic</th>
                            <th>Dosage</th>
                            <th>Stock</th>
                            <th>Unit Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($medicines as $medicine)
                        <tr>
                            <td>{{ $medicine->id }}</td>
                            <td>
                                @if($medicine->image)
                                    <img src="{{ asset($medicine->image) }}" alt="{{ $medicine->name }}" class="medicine-image">
                                @else
                                    <div class="bg-light text-center medicine-image d-flex align-items-center justify-content-center">
                                        <i class="fas fa-pills text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $medicine->name }}</td>
                            <td>{{ $medicine->generic_name ?? 'N/A' }}</td>
                            <td>{{ $medicine->dosage_name ?? 'N/A' }}</td>
                            <td>
                                @if($medicine->stock_quantity < 10)
                                    <span class="badge bg-danger">{{ $medicine->stock_quantity }}</span>
                                @elseif($medicine->stock_quantity < 30)
                                    <span class="badge bg-warning text-dark">{{ $medicine->stock_quantity }}</span>
                                @else
                                    <span class="badge bg-success">{{ $medicine->stock_quantity }}</span>
                                @endif
                            </td>
                            <td>৳{{ number_format($medicine->unit_price, 2) }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-sm btn-primary action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('medicines.destroy', $medicine->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this medicine?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger action-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">No medicines found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
