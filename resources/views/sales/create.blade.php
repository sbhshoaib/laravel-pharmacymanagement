@extends('layouts.app')

@section('title', 'Create Sale')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 38px;
        border: 1px solid #ced4da;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    .medicine-details {
        display: none;
        transition: all 0.3s ease;
    }
    .cart-item {
        transition: all 0.3s ease;
    }
    .cart-item:hover {
        background-color: #f8f9fa;
    }
    .product-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
    }
    .customer-section {
        transition: all 0.3s ease;
    }
    .barcode-scanner {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 1rem;
        background-color: #f9fafc;
        margin-bottom: 1rem;
    }
    .prescription-preview {
        max-width: 100%;
        max-height: 200px;
        border-radius: 5px;
        border: 1px solid #dee2e6;
        margin-top: 10px;
        display: none;
    }
    .verification-steps {
        list-style-type: none;
        padding-left: 0;
        margin-top: 15px;
    }
    .verification-steps li {
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 5px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
    }
    .verification-steps .step-icon {
        margin-right: 10px;
        width: 24px;
        height: 24px;
        line-height: 24px;
        text-align: center;
        border-radius: 50%;
        background-color: #e9ecef;
    }
    .verification-steps .step-pending .step-icon {
        background-color: #e9ecef;
        color: #6c757d;
    }
    .verification-steps .step-loading .step-icon {
        background-color: #cfe2ff;
        color: #0d6efd;
    }
    .verification-steps .step-success .step-icon {
        background-color: #d1e7dd;
        color: #198754;
    }
    .verification-steps .step-error .step-icon {
        background-color: #f8d7da;
        color: #dc3545;
    }
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
        border-width: 0.2em;
    }
    .verification-result {
        max-height: 400px;
        overflow-y: auto;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 15px;
        margin-top: 15px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Create Sale</h1>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Sales
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form id="saleForm" action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <!-- Prescription Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary bg-gradient text-white py-3">
                        <h5 class="mb-0"><i class="fas fa-file-medical me-2"></i> Prescription</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="prescription_file" class="form-label fw-bold">Upload Prescription (optional)</label>
                                    <input type="file" class="form-control" id="prescription_file" name="prescription_file" accept="image/*">
                                    <div class="form-text">Supported formats: JPG, PNG, GIF (Max 2MB)</div>
                                </div>
                                <img id="prescription_preview" class="prescription-preview" alt="Prescription Preview">
                            </div>
                            <div class="col-md-4">
                                <div class="d-grid gap-2 mt-4">
                                    <button type="button" id="verifyPrescriptionBtn" class="btn btn-outline-primary" disabled>
                                        <i class="fas fa-check-circle me-2"></i> Verify Prescription
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary bg-gradient text-white py-3">
                        <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i> Add Products</h5>
                    </div>
                    <div class="card-body">
                        <!-- Barcode Scanner Section -->
                        <div class="barcode-scanner mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-9">
                                    <div class="form-group mb-0">
                                        <label for="barcode_input" class="form-label fw-bold">Scan Barcode</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="barcode_input" placeholder="Scan or enter barcode">
                                            <button class="btn btn-outline-primary" type="button" id="searchByBarcode">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <div class="form-text"><i class="fas fa-barcode me-1"></i> Quick add with barcode</div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Selection -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="medicine_id" class="form-label fw-bold">Select Medicine</label>
                                <select id="medicine_id" class="form-select">
                                    <option value="">Select Medicine</option>
                                    @foreach($medicines as $medicine)
                                        <option value="{{ $medicine->id }}" data-stock="{{ $medicine->stock_quantity }}" data-price="{{ $medicine->unit_price }}">
                                            {{ $medicine->name }} - {{ $medicine->generic_name }} (Stock: {{ $medicine->stock_quantity }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="medicine-details mt-3 mb-3 p-3 border rounded bg-light">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Medicine Info</label>
                                        <div>
                                            <span id="medicineName" class="fw-bold"></span> 
                                            (<span id="genericName"></span>)
                                        </div>
                                        <div class="text-muted" id="medicineDetails"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="price" class="form-label fw-bold">Price</label>
                                        <input type="number" step="0.01" class="form-control" id="price" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label fw-bold">Quantity</label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" id="decreaseQty">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" class="form-control" id="quantity" value="1" min="1">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" id="increaseQty">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="subtotal" class="form-label fw-bold">Subtotal</label>
                                        <input type="number" step="0.01" class="form-control" id="subtotal" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" id="addToCartBtn" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i> Add to Cart
                                </button>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h5 class="mb-3">Cart Items</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="cartTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Medicine</th>
                                            <th class="text-center">Unit Price</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-end">Subtotal</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="emptyCart">
                                            <td colspan="5" class="text-center py-4">No items added to cart yet</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-light">
                                            <td colspan="3" class="text-end fw-bold">Total:</td>
                                            <td class="text-end fw-bold" id="cartTotal">৳ 0.00</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary bg-gradient text-white py-3">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i> Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="customer_type" id="existingCustomer" value="existing">
                                <label class="form-check-label" for="existingCustomer">Existing Customer</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="customer_type" id="guestCustomer" value="guest" checked>
                                <label class="form-check-label" for="guestCustomer">Guest Customer</label>
                            </div>
                        </div>

                        <div id="existingCustomerSection" class="customer-section" style="display: none;">
                            <div class="mb-3">
                                <label for="customer_id" class="form-label fw-bold">Select Customer</label>
                                <select name="customer_id" id="customer_id" class="form-select">
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->Customer_ID }}">
                                            {{ $customer->Name }} - {{ $customer->Phone }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Customer Details</label>
                                <div id="customerDetails" class="p-2 border rounded">
                                    <p class="text-muted mb-0 small">Select a customer to view details</p>
                                </div>
                            </div>
                        </div>

                        <div id="guestCustomerSection" class="customer-section">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> Proceeding as guest customer
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label fw-bold">Payment Method</label>
                            <select name="payment_method" class="form-select" required>
                                <option value="cash">Cash</option>
                                <option value="card">Credit/Debit Card</option>
                                <option value="mobile_banking">Mobile Banking</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Total Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">৳</span>
                                <input type="text" class="form-control form-control-lg bg-light" id="displayTotal" value="0.00" readonly>
                                <input type="hidden" name="total_amount" id="totalAmount" value="0">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="completeOrderBtn" disabled>
                                <i class="fas fa-check-circle me-2"></i> Complete Sale
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Prescription Verification Modal -->
<div class="modal fade" id="verifyPrescriptionModal" tabindex="-1" aria-labelledby="verifyPrescriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifyPrescriptionModalLabel">Verify Prescription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-center mb-3">
                            <img id="modal_prescription_preview" class="img-fluid rounded border" style="max-height: 300px;" alt="Prescription">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mb-3">Verification Process</h6>
                        <ul class="verification-steps">
                            <li id="step-ocr" class="step-pending">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <div class="d-flex align-items-center">
                                        <span class="step-icon"><i class="fas fa-file-alt"></i></span>
                                        <span class="step-text">Extracting text from image...</span>
                                    </div>
                                    <div class="step-actions" style="display:none;">
                                        <button type="button" class="btn btn-sm btn-outline-info view-response" data-step="ocr">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-warning retry-step" data-step="ocr">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li id="step-ai-extract" class="step-pending">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <div class="d-flex align-items-center">
                                        <span class="step-icon"><i class="fas fa-brain"></i></span>
                                        <span class="step-text">AI processing text...</span>
                                    </div>
                                    <div class="step-actions" style="display:none;">
                                        <button type="button" class="btn btn-sm btn-outline-info view-response" data-step="ai-extract">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-warning retry-step" data-step="ai-extract">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li id="step-bmdc" class="step-pending">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <div class="d-flex align-items-center">
                                        <span class="step-icon"><i class="fas fa-id-card"></i></span>
                                        <span class="step-text">Finding BMDC registration number...</span>
                                    </div>
                                    <div class="step-actions" style="display:none;">
                                        <button type="button" class="btn btn-sm btn-outline-info view-response" data-step="bmdc">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-warning retry-step" data-step="bmdc">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li id="step-verify" class="step-pending">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <div class="d-flex align-items-center">
                                        <span class="step-icon"><i class="fas fa-check-circle"></i></span>
                                        <span class="step-text">Verifying with BMDC database...</span>
                                    </div>
                                    <div class="step-actions" style="display:none;">
                                        <button type="button" class="btn btn-sm btn-outline-info view-response" data-step="verify">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-warning retry-step" data-step="verify">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="verification-result" id="verification-result">
                    <div class="text-center p-4">
                        <p class="text-muted">Verification results will appear here</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- API Response Modal -->
<div class="modal fade" id="apiResponseModal" tabindex="-1" aria-labelledby="apiResponseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="apiResponseModalLabel">API Response</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Step</label>
                    <div id="responseStep" class="p-2 bg-light rounded"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Response</label>
                    <pre id="apiResponseData" class="p-3 bg-light rounded" style="max-height: 400px; overflow-y: auto;"></pre>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        console.log("Document ready");
        
        // Initialize modals
        const verifyModal = new bootstrap.Modal(document.getElementById('verifyPrescriptionModal'));
        const apiResponseModal = new bootstrap.Modal(document.getElementById('apiResponseModal'));
        
        // Store cart items
        let cartItems = [];
        let currentMedicineId = null;
        let currentStock = 0;
        
        // Store API responses
        let apiResponses = {
            'ocr': null,
            'ai-extract': null,
            'bmdc': null,
            'verify': null
        };
        
        // Create barcode mapping
        const barcodeMap = {};
        $("#medicine_id option").each(function() {
            const id = $(this).val();
            const barcode = $(this).data('barcode');
            if (id && barcode) {
                barcodeMap[barcode] = id;
            }
        });
        
        // Prescription handling
        $('#prescription_file').on('change', function(e) {
            const file = this.files[0];
            if (file) {
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#prescription_preview').attr('src', e.target.result).show();
                    $('#modal_prescription_preview').attr('src', e.target.result);
                    $('#verifyPrescriptionBtn').prop('disabled', false);
                }
                reader.readAsDataURL(file);
            } else {
                $('#prescription_preview').hide();
                $('#verifyPrescriptionBtn').prop('disabled', true);
            }
        });
        
        // Prescription verification
        $('#verifyPrescriptionBtn').on('click', function() {
            // Reset steps
            $('.verification-steps li').removeClass('step-loading step-success step-error').addClass('step-pending');
            $('#verification-result').html('<div class="text-center p-4"><p class="text-muted">Verification in progress...</p></div>');
            
            // Show modal
            verifyModal.show();
            
            // Start verification process
            verifyPrescription();
        });
        
        function verifyPrescription() {
            // Get the prescription file
            const prescriptionFile = $('#prescription_file')[0].files[0];
            if (!prescriptionFile) {
                alert('Please select a prescription file first');
                return;
            }
            
            // Reset steps and results
            $('.verification-steps li').removeClass('step-loading step-success step-error').addClass('step-pending');
            $('.step-actions').hide();
            apiResponses = {
                'ocr': null,
                'ai-extract': null,
                'bmdc': null,
                'verify': null
            };
            $('#verification-result').html('<div class="text-center p-4"><p class="text-muted">Verification in progress...</p></div>');
            
            // Step 1: Upload the prescription and OCR
            uploadPrescription();
        }
        
        function uploadPrescription() {
            const prescriptionFile = $('#prescription_file')[0].files[0];
            const formData = new FormData();
            formData.append('prescription_file', prescriptionFile);
            
            updateStep('step-ocr', 'loading', 'Uploading prescription...');
            
            $.ajax({
                url: '{{ route("prescription.upload") }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Store response
                    apiResponses.ocr = response;
                    
                    if (!response.success) {
                        updateStep('step-ocr', 'error', 'Failed to upload prescription');
                        $('#verification-result').html(`<div class="alert alert-danger">${response.message}</div>`);
                        showStepActions('ocr');
                        return;
                    }
                    
                    updateStep('step-ocr', 'success', 'Prescription uploaded successfully');
                    showStepActions('ocr');
                    
                    // Proceed to OCR extraction
                    extractTextWithOCR(response.image_path);
                },
                error: function(xhr) {
                    updateStep('step-ocr', 'error', 'Upload failed');
                    $('#verification-result').html(`<div class="alert alert-danger">Error uploading file: ${xhr.statusText}</div>`);
                    showStepActions('ocr');
                }
            });
        }
        
        function extractTextWithOCR(imagePath) {
            updateStep('step-ai-extract', 'loading', 'Extracting text with OCR...');
            
            $.ajax({
                url: '{{ route("prescription.extractText") }}',
                type: 'POST',
                data: {
                    image_path: imagePath
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Store response
                    apiResponses['ai-extract'] = response;
                    
                    if (!response.success) {
                        updateStep('step-ai-extract', 'error', 'OCR text extraction failed');
                        $('#verification-result').html(`<div class="alert alert-danger">${response.message}</div>`);
                        showStepActions('ai-extract');
                        return;
                    }
                    
                    updateStep('step-ai-extract', 'success', 'Text extracted successfully');
                    showStepActions('ai-extract');
                    
                    // Proceed to BMDC extraction
                    extractBMDC(response.extracted_text);
                },
                error: function(xhr) {
                    updateStep('step-ai-extract', 'error', 'OCR processing failed');
                    $('#verification-result').html(`<div class="alert alert-danger">Error extracting text: ${xhr.statusText}</div>`);
                    showStepActions('ai-extract');
                }
            });
        }
        
        function extractBMDC(extractedText) {
            updateStep('step-bmdc', 'loading', 'Finding BMDC registration number...');
            
            $.ajax({
                url: '{{ route("prescription.extractBmdc") }}',
                type: 'POST',
                data: {
                    extracted_text: extractedText
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Store response
                    apiResponses.bmdc = response;
                    
                    if (!response.success) {
                        updateStep('step-bmdc', 'error', 'Failed to extract BMDC number');
                        $('#verification-result').html(`<div class="alert alert-danger">${response.message}</div>`);
                        showStepActions('bmdc');
                        return;
                    }
                    
                    updateStep('step-bmdc', 'success', `Found BMDC number: ${response.bmdc_number}`);
                    showStepActions('bmdc');
                    
                    // Proceed to doctor verification
                    verifyDoctor(response.bmdc_number);
                },
                error: function(xhr) {
                    updateStep('step-bmdc', 'error', 'AI processing failed');
                    $('#verification-result').html(`<div class="alert alert-danger">Error processing with AI: ${xhr.statusText}</div>`);
                    showStepActions('bmdc');
                }
            });
        }
        
        function verifyDoctor(bmdcNumber) {
            updateStep('step-verify', 'loading', 'Verifying with BMDC database...');
            
            $.ajax({
                url: '{{ route("prescription.verifyDoctor") }}',
                type: 'POST',
                data: {
                    bmdc_number: bmdcNumber
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Store response
                    apiResponses.verify = response;
                    
                    if (!response.success) {
                        updateStep('step-verify', 'error', 'Doctor verification failed');
                        $('#verification-result').html(`
                            <div class="alert alert-danger">
                                <h5><i class="fas fa-exclamation-triangle me-2"></i> Verification Failed</h5>
                                <p>${response.message}</p>
                            </div>
                        `);
                        showStepActions('verify');
                        return;
                    }
                    
                    // Show success result
                    updateStep('step-verify', 'success', 'Doctor verified successfully');
                    showStepActions('verify');
                    
                    // Display doctor information
                    const doctor = response.doctor_info;
                    let statusClass = doctor.status.includes('ACTIVE') ? 'bg-success' : 'bg-warning';
                    
                    $('#verification-result').html(`
                        <div class="alert alert-success">
                            <h5><i class="fas fa-check-circle me-2"></i> Verified Doctor</h5>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Doctor Information</h6>
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <th>Name</th>
                                        <td>${doctor.name}</td>
                                    </tr>
                                    <tr>
                                        <th>Registration</th>
                                        <td>${doctor.registration}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><span class="badge ${statusClass}">${doctor.status}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Qualification</th>
                                        <td>${doctor.qualification}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        ${response.html ? '<div class="bmdc-details">' + response.html + '</div>' : ''}
                    `);
                    
                    // Store the verification result in a hidden field
                    if (!$('#verified_doctor_id').length) {
                        $('#saleForm').append(`<input type="hidden" name="verified_doctor_id" id="verified_doctor_id" value="${doctor.registration}">`);
                    } else {
                        $('#verified_doctor_id').val(doctor.registration);
                    }
                },
                error: function(xhr) {
                    updateStep('step-verify', 'error', 'BMDC verification failed');
                    $('#verification-result').html(`<div class="alert alert-danger">Error verifying with BMDC: ${xhr.statusText}</div>`);
                    showStepActions('verify');
                }
            });
        }
        
        function updateStep(stepId, status, message) {
            const step = $(`#${stepId}`);
            
            // Remove all status classes
            step.removeClass('step-pending step-loading step-success step-error');
            
            // Add the appropriate status class
            step.addClass(`step-${status}`);
            
            // Update the icon
            let icon = '';
            switch(status) {
                case 'pending':
                    icon = '<i class="fas fa-circle"></i>';
                    break;
                case 'loading':
                    icon = '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>';
                    break;
                case 'success':
                    icon = '<i class="fas fa-check"></i>';
                    break;
                case 'error':
                    icon = '<i class="fas fa-times"></i>';
                    break;
            }
            
            step.find('.step-icon').html(icon);
            step.find('.step-text').text(message);
        }
        
        function showStepActions(stepId) {
            // Only show actions if success or error
            const step = $(`#step-${stepId}`);
            if (step.hasClass('step-success') || step.hasClass('step-error')) {
                step.find('.step-actions').show();
            }
        }
        
        // Handle view response buttons
        $(document).on('click', '.view-response', function() {
            const step = $(this).data('step');
            let stepName = '';
            
            switch(step) {
                case 'ocr':
                    stepName = 'Prescription Upload';
                    break;
                case 'ai-extract':
                    stepName = 'OCR Text Extraction';
                    break;
                case 'bmdc':
                    stepName = 'BMDC Number Extraction';
                    break;
                case 'verify':
                    stepName = 'Doctor Verification';
                    break;
            }
            
            $('#responseStep').text(stepName);
            $('#apiResponseData').text(JSON.stringify(apiResponses[step], null, 2));
            apiResponseModal.show();
        });
        
        // Handle retry buttons
        $(document).on('click', '.retry-step', function() {
            const step = $(this).data('step');
            
            switch(step) {
                case 'ocr':
                    uploadPrescription();
                    break;
                case 'ai-extract':
                    if (apiResponses.ocr && apiResponses.ocr.image_path) {
                        extractTextWithOCR(apiResponses.ocr.image_path);
                    } else {
                        alert('Cannot retry this step. Please start from the beginning.');
                    }
                    break;
                case 'bmdc':
                    if (apiResponses['ai-extract'] && apiResponses['ai-extract'].extracted_text) {
                        extractBMDC(apiResponses['ai-extract'].extracted_text);
                    } else {
                        alert('Cannot retry this step. Please start from the beginning.');
                    }
                    break;
                case 'verify':
                    if (apiResponses.bmdc && apiResponses.bmdc.bmdc_number) {
                        verifyDoctor(apiResponses.bmdc.bmdc_number);
                    } else {
                        alert('Cannot retry this step. Please start from the beginning.');
                    }
                    break;
            }
        });
        
        // Barcode search functionality
        $('#barcode_input').keypress(function(e) {
            if (e.which === 13) { // Enter key
                e.preventDefault();
                searchByBarcode();
            }
        });
        
        $('#searchByBarcode').click(function() {
            searchByBarcode();
        });
        
        function searchByBarcode() {
            const barcode = $('#barcode_input').val().trim();
            if (!barcode) return;
            
            console.log("Searching for barcode:", barcode);
            
            // Try client-side first
            if (barcodeMap[barcode]) {
                $('#medicine_id').val(barcodeMap[barcode]).change();
                $('#barcode_input').val('');
            } else {
                // Try server-side search
                $.ajax({
                    url: '{{ url('') }}/sales/barcode/' + barcode,
                    method: 'GET',
                    success: function(response) {
                        if (response.success && response.medicine) {
                            $('#medicine_id').val(response.medicine.id).change();
                        } else {
                            alert('No medicine found with this barcode');
                        }
                        $('#barcode_input').val('');
                    },
                    error: function() {
                        alert('Error searching for barcode');
                        $('#barcode_input').val('');
                    }
                });
            }
        }
        
        // Medicine selection change
        $('#medicine_id').change(function() {
            const medicineId = $(this).val();
            console.log("Medicine selected:", medicineId);
            
            if (!medicineId) {
                $('.medicine-details').hide();
                return;
            }
            
            currentMedicineId = medicineId;
            const selectedOption = $(this).find('option:selected');
            currentStock = selectedOption.data('stock');
            const price = selectedOption.data('price');
            
            $('#price').val(price);
            $('#quantity').val(1);
            $('#subtotal').val(price);
            
            // Load medicine details
            $.ajax({
                url: '{{ url('') }}/sales/medicine-info/' + medicineId,
                method: 'GET',
                success: function(data) {
                    console.log("Medicine info loaded:", data);
                    if (data) {
                        $('#medicineName').text(data.name);
                        $('#genericName').text(data.generic_name || '');
                        
                        let details = [];
                        if (data.dosage_name) details.push(data.dosage_name);
                        if (data.pharma_name) details.push(data.pharma_name);
                        $('#medicineDetails').text(details.join(' • '));
                        
                        $('.medicine-details').show();
                    }
                },
                error: function() {
                    alert('Error loading medicine details');
                }
            });
        });
        
        // Quantity controls
        $('#increaseQty').click(function() {
            let qty = parseInt($('#quantity').val()) || 1;
            if (qty < currentStock) {
                $('#quantity').val(qty + 1);
                updateSubtotal();
            }
        });
        
        $('#decreaseQty').click(function() {
            let qty = parseInt($('#quantity').val()) || 1;
            if (qty > 1) {
                $('#quantity').val(qty - 1);
                updateSubtotal();
            }
        });
        
        $('#quantity').on('input', function() {
            updateSubtotal();
        });
        
        function updateSubtotal() {
            const price = parseFloat($('#price').val()) || 0;
            const quantity = parseInt($('#quantity').val()) || 1;
            $('#subtotal').val((price * quantity).toFixed(2));
        }
        
        // Add to cart
        $('#addToCartBtn').click(function() {
            if (!currentMedicineId) {
                alert('Please select a medicine first');
                return;
            }
            
            const medicineName = $('#medicineName').text();
            const genericName = $('#genericName').text();
            const price = parseFloat($('#price').val());
            const quantity = parseInt($('#quantity').val()) || 1;
            const subtotal = parseFloat($('#subtotal').val());
            
            console.log("Adding to cart:", { id: currentMedicineId, name: medicineName, quantity, price, subtotal });
            
            // Check if already in cart
            const existingIndex = cartItems.findIndex(item => item.id == currentMedicineId);
            
            if (existingIndex !== -1) {
                // Update existing item
                const newQty = cartItems[existingIndex].quantity + quantity;
                
                if (newQty > currentStock) {
                    alert('Cannot add more than available stock');
                    return;
                }
                
                cartItems[existingIndex].quantity = newQty;
                cartItems[existingIndex].subtotal = price * newQty;
                
                // Update row
                $(`#cart-item-${currentMedicineId} .item-quantity`).text(newQty);
                $(`#cart-item-${currentMedicineId} .item-subtotal`).text('৳ ' + (price * newQty).toFixed(2));
                $(`#cart-item-${currentMedicineId} input[name="quantities[]"]`).val(newQty);
                $(`#cart-item-${currentMedicineId} input[name="subtotals[]"]`).val((price * newQty).toFixed(2));
            } else {
                // Add new item
                cartItems.push({
                    id: currentMedicineId,
                    name: medicineName,
                    genericName: genericName,
                    price: price,
                    quantity: quantity,
                    subtotal: subtotal
                });
                
                // Add to table
                $('#emptyCart').hide();
                
                const newRow = `
                    <tr id="cart-item-${currentMedicineId}" class="cart-item">
                        <td>
                            <strong>${medicineName}</strong><br>
                            <small class="text-muted">${genericName}</small>
                            <input type="hidden" name="medicine_ids[]" value="${currentMedicineId}">
                        </td>
                        <td class="text-center">
                            ৳ ${price.toFixed(2)}
                            <input type="hidden" name="prices[]" value="${price}">
                        </td>
                        <td class="text-center">
                            <span class="item-quantity">${quantity}</span>
                            <input type="hidden" name="quantities[]" value="${quantity}">
                        </td>
                        <td class="text-end">
                            <span class="item-subtotal">৳ ${subtotal.toFixed(2)}</span>
                            <input type="hidden" name="subtotals[]" value="${subtotal}">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger remove-item" data-id="${currentMedicineId}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                
                $('#cartTable tbody').append(newRow);
            }
            
            // Reset form
            $('#medicine_id').val('');
            $('.medicine-details').hide();
            currentMedicineId = null;
            
            // Update cart total
            updateCartTotal();
        });
        
        // Remove from cart
        $(document).on('click', '.remove-item', function() {
            const id = $(this).data('id');
            console.log("Removing item:", id);
            
            // Remove from array
            cartItems = cartItems.filter(item => item.id != id);
            
            // Remove from DOM
            $(`#cart-item-${id}`).remove();
            
            if (cartItems.length === 0) {
                $('#emptyCart').show();
            }
            
            // Update cart total
            updateCartTotal();
        });
        
        // Update cart total
        function updateCartTotal() {
            let total = 0;
            cartItems.forEach(item => {
                total += item.subtotal;
            });
            
            console.log("Updating cart total:", total);
            $('#cartTotal').text('৳ ' + total.toFixed(2));
            $('#displayTotal').val(total.toFixed(2));
            $('#totalAmount').val(total.toFixed(2));
            
            // Enable/disable checkout button
            $('#completeOrderBtn').prop('disabled', cartItems.length === 0);
        }
        
        // Customer type toggle
        $('input[name="customer_type"]').change(function() {
            const type = $(this).val();
            
            if (type === 'existing') {
                $('#existingCustomerSection').show();
                $('#guestCustomerSection').hide();
            } else {
                $('#existingCustomerSection').hide();
                $('#guestCustomerSection').show();
            }
        });
        
        // Form submission check
        $('#saleForm').submit(function(e) {
            if (cartItems.length === 0) {
                e.preventDefault();
                alert('Please add at least one item to the cart');
                return false;
            }
        });
        
        // Focus on barcode input at start
        $('#barcode_input').focus();
        
        console.log("Setup complete");
    });
</script>
@endsection