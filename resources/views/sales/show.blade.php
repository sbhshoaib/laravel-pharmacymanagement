@extends('layouts.app')

@section('title', 'Sale Details')

@section('styles')
<style>
    .invoice-header {
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #dee2e6;
    }
    .invoice-title {
        color: #2b2d42;
    }
    .invoice-details {
        padding: 1.5rem 0;
    }
    .invoice-footer {
        padding-top: 1.5rem;
        border-top: 1px solid #dee2e6;
    }
    @media print {
        .no-print {
            display: none !important;
        }
        body {
            padding: 0;
            background: #fff;
        }
        .container {
            max-width: 100%;
            width: 100%;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .bg-light {
            background-color: #f8f9fa !important;
            -webkit-print-color-adjust: exact;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <h1 class="mb-0">Sale Details</h1>
        <div>
            <button class="btn btn-outline-primary me-2" onclick="window.print()">
                <i class="fas fa-print me-2"></i> Print
            </button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Sales
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="invoice-header">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-clinic-medical text-white"></i>
                            </div>
                            <h2 class="invoice-title mb-0 fw-bold">ATS Pharmacy</h2>
                        </div>
                        <p class="mb-1">Address: 123 Pharmacy Street, City</p>
                        <p class="mb-1">Phone: +880 1234 567890</p>
                        <p class="mb-0">Email: info@atspharmacy.com</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h2 class="invoice-title mb-3 fw-bold">INVOICE</h2>
                        <p class="mb-1"><strong>Invoice #:</strong> INV-{{ str_pad($sale->Sale_ID, 6, '0', STR_PAD_LEFT) }}</p>
                        <p class="mb-1"><strong>Date:</strong> {{ $sale->Date }}</p>
                        <p class="mb-0"><strong>Staff:</strong> {{ $sale->staff_name }}</p>
                    </div>
                </div>
            </div>
            
            <div class="invoice-details">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="fw-bold">Customer Information</h5>
                        @if($sale->customer_name)
                            <p class="mb-1"><strong>{{ $sale->customer_name }}</strong></p>
                            @if($sale->customer_phone)
                                <p class="mb-1">Phone: {{ $sale->customer_phone }}</p>
                            @endif
                            @if($sale->customer_email)
                                <p class="mb-1">Email: {{ $sale->customer_email }}</p>
                            @endif
                            @if($sale->customer_address)
                                <p class="mb-0">Address: {{ $sale->customer_address }}</p>
                            @endif
                        @else
                            <p class="mb-0">Guest Customer</p>
                        @endif
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h5 class="fw-bold">Payment Information</h5>
                        <p class="mb-1"><strong>Method:</strong> 
                            @if($sale->Payment_Method == 'cash')
                                Cash
                            @elseif($sale->Payment_Method == 'card')
                                Credit/Debit Card
                            @elseif($sale->Payment_Method == 'mobile_banking')
                                Mobile Banking
                            @else
                                {{ $sale->Payment_Method }}
                            @endif
                        </p>
                        <p class="mb-0"><strong>Status:</strong> <span class="badge bg-success">Paid</span></p>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Medicine</th>
                                <th scope="col" class="text-center">Unit Price</th>
                                <th scope="col" class="text-center">Quantity</th>
                                <th scope="col" class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $item->medicine_name }}</strong>
                                        @if($item->generic_name)
                                            <br><small class="text-muted">{{ $item->generic_name }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">৳ {{ number_format($item->Unit_Price, 2) }}</td>
                                    <td class="text-center">{{ $item->Quantity }}</td>
                                    <td class="text-end">৳ {{ number_format($item->Subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Total:</td>
                                <td class="text-end fw-bold">৳ {{ number_format($sale->Total_Amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <div class="invoice-footer">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-0"><strong>Notes:</strong> Thank you for your business!</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-0">Generated on: {{ date('Y-m-d H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
