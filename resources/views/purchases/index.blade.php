@extends('layouts.app')

@section('title', 'Purchases')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Purchase History</h1>
        <a href="{{ route('purchases.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Add New Purchase
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
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" class="ps-4">#</th>
                            <th scope="col">Medicine</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Batch No.</th>
                            <th scope="col">Purchase Date</th>
                            <th scope="col">Expiry Date</th>
                            <th scope="col" class="text-center">Quantity</th>
                            <th scope="col" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($purchases) > 0)
                            @foreach($purchases as $purchase)
                                <tr>
                                    <td class="ps-4">{{ $purchase->Inventory_ID }}</td>
                                    <td>{{ $purchase->medicine_name }}</td>
                                    <td>{{ $purchase->supplier_name }}</td>
                                    <td>{{ $purchase->Batch_Number }}</td>
                                    <td>{{ $purchase->Purchase_Date }}</td>
                                    <td>
                                        @php
                                            $expiryDate = new DateTime($purchase->Expiry_Date);
                                            $now = new DateTime();
                                            $interval = $now->diff($expiryDate);
                                            $expired = $expiryDate < $now;
                                            $nearExpiry = !$expired && $interval->days <= 30;
                                        @endphp
                                        
                                        @if($expired)
                                            <span class="badge bg-danger">{{ $purchase->Expiry_Date }} (Expired)</span>
                                        @elseif($nearExpiry)
                                            <span class="badge bg-warning text-dark">{{ $purchase->Expiry_Date }} (Expiring Soon)</span>
                                        @else
                                            {{ $purchase->Expiry_Date }}
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $purchase->Quantity }}</td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('purchases.show', $purchase->Inventory_ID) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <form action="{{ route('purchases.destroy', $purchase->Inventory_ID) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this purchase? This will reduce the stock quantity.')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center py-4">No purchase records found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
