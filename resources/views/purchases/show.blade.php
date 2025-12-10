@extends('layouts.app')

@section('title', 'Purchase Details')

@section('styles')
<style>
    .detail-card {
        padding: 1.5rem;
        background-color: #f9fafc;
        border-radius: 0.5rem;
    }
    .detail-title {
        color: #4361ee;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .detail-value {
        font-weight: 500;
        font-size: 1.1rem;
    }
    .detail-subtitle {
        color: #6c757d;
        font-size: 0.8rem;
    }
    .status-badge {
        font-size: 0.8rem;
        padding: 0.5rem 0.75rem;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Purchase Details</h1>
        <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Purchases
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary bg-gradient text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-capsules me-2"></i> Medicine Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="detail-title">Medicine Name</div>
                                <div class="detail-value">{{ $purchase->medicine_name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="detail-title">Generic Name</div>
                                <div class="detail-value">{{ $purchase->generic_name ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="detail-title">Batch Number</div>
                                <div class="detail-value">{{ $purchase->Batch_Number }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="detail-title">Quantity</div>
                                <div class="detail-value">{{ $purchase->Quantity }} units</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="detail-title">Expiry Date</div>
                                <div class="detail-value">
                                    @php
                                        $expiryDate = new DateTime($purchase->Expiry_Date);
                                        $now = new DateTime();
                                        $interval = $now->diff($expiryDate);
                                        $expired = $expiryDate < $now;
                                        $nearExpiry = !$expired && $interval->days <= 30;
                                    @endphp
                                    
                                    {{ $purchase->Expiry_Date }}
                                    
                                    @if($expired)
                                        <span class="badge bg-danger ms-2">Expired</span>
                                    @elseif($nearExpiry)
                                        <span class="badge bg-warning text-dark ms-2">Expiring Soon</span>
                                    @else
                                        <span class="badge bg-success ms-2">Valid</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary bg-gradient text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-truck me-2"></i> Supplier Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="detail-title">Supplier Name</div>
                                <div class="detail-value">{{ $purchase->supplier_name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="detail-title">Contact Person</div>
                                <div class="detail-value">{{ $purchase->Contact_Person ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="detail-title">Phone</div>
                                <div class="detail-value">{{ $purchase->supplier_phone ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="detail-title">Email</div>
                                <div class="detail-value">{{ $purchase->supplier_email ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary bg-gradient text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Purchase Information</h5>
                </div>
                <div class="card-body">
                    <div class="detail-title">Purchase ID</div>
                    <div class="detail-value mb-3">#{{ $purchase->Inventory_ID }}</div>
                    
                    <div class="detail-title">Purchase Date</div>
                    <div class="detail-value mb-3">{{ $purchase->Purchase_Date }}</div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back
                        </a>
                        <form action="{{ route('purchases.destroy', $purchase->Inventory_ID) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this purchase record? This will reduce the stock quantity.')">
                                <i class="fas fa-trash-alt me-2"></i> Delete Record
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
