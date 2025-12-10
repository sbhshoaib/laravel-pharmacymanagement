@extends('layouts.app')

@section('title', 'Sales')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Sales</h1>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Create New Sale
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
                            <th scope="col" class="ps-4">Invoice #</th>
                            <th scope="col">Date</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Payment Method</th>
                            <th scope="col" class="text-end">Amount</th>
                            <th scope="col" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($sales) > 0)
                            @foreach($sales as $sale)
                                <tr>
                                    <td class="ps-4">
                                        <strong>INV-{{ str_pad($sale->Sale_ID, 6, '0', STR_PAD_LEFT) }}</strong>
                                    </td>
                                    <td>{{ $sale->Date }}</td>
                                    <td>
                                        {{ $sale->customer_name ?? 'Guest Customer' }}
                                    </td>
                                    <td>
                                        @if($sale->Payment_Method == 'cash')
                                            <span class="badge bg-success">Cash</span>
                                        @elseif($sale->Payment_Method == 'card')
                                            <span class="badge bg-primary">Card</span>
                                        @elseif($sale->Payment_Method == 'mobile_banking')
                                            <span class="badge bg-info">Mobile Banking</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $sale->Payment_Method }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end">৳ {{ number_format($sale->Total_Amount, 2) }}</td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('sales.show', $sale->Sale_ID) }}" class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <form action="{{ route('sales.destroy', $sale->Sale_ID) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to void this sale? This will return all items to inventory.')" title="Void Sale">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center py-4">No sales found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
