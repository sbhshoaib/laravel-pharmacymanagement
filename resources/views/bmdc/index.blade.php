@extends('layouts.app')

@section('title', 'BMDC Verification')

@section('styles')
<style>
    .bmdc-verification {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
    }
    .verification-result {
        max-height: 600px;
        overflow-y: auto;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 15px;
        margin-top: 20px;
    }
    .verification-card {
        transition: all 0.3s ease;
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
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">BMDC Verification</h1>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 verification-card">
                <div class="card-header bg-primary bg-gradient text-white">
                    <h5 class="mb-0"><i class="fas fa-id-card me-2"></i> Doctor Verification</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Enter a BMDC registration number to verify a doctor's credentials.
                    </div>

                    <form id="verificationForm">
                        <div class="mb-3">
                            <label for="bmdc_number" class="form-label fw-bold">BMDC Registration Number</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="bmdc_number" name="bmdc_number" placeholder="Enter BMDC registration number" required>
                                <button type="submit" class="btn btn-primary" id="verifyBtn">
                                    <i class="fas fa-check-circle me-2"></i> Verify
                                </button>
                            </div>
                            <div class="form-text">
                                E.g. A-12345, 54321, etc.
                            </div>
                        </div>
                    </form>

                    <div class="mt-4">
                        <h5>Verification Status</h5>
                        <ul class="verification-steps">
                            <li id="step-verify" class="step-pending">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <div class="d-flex align-items-center">
                                        <span class="step-icon"><i class="fas fa-check-circle"></i></span>
                                        <span class="step-text">Ready to verify doctor</span>
                                    </div>
                                    <div class="step-actions" style="display:none;">
                                        <button type="button" class="btn btn-sm btn-outline-info view-response" data-step="verify">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-warning retry-step">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary bg-gradient text-white">
                    <h5 class="mb-0"><i class="fas fa-user-md me-2"></i> Doctor Information</h5>
                </div>
                <div class="card-body">
                    <div class="verification-result" id="verification-result">
                        <div class="text-center p-4">
                            <p class="text-muted">Doctor information will appear here after verification</p>
                        </div>
                    </div>
                </div>
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
                <pre id="apiResponseData" class="p-3 bg-light rounded" style="max-height: 400px; overflow-y: auto;"></pre>
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
<script>
    $(document).ready(function() {
        // Initialize modal
        const apiResponseModal = new bootstrap.Modal(document.getElementById('apiResponseModal'));
        
        // Store API response
        let apiResponse = null;
        
        // Handle form submission
        $('#verificationForm').submit(function(e) {
            e.preventDefault();
            verifyDoctor();
        });
        
        // Handle retry button
        $(document).on('click', '.retry-step', function() {
            verifyDoctor();
        });
        
        // Handle view response button
        $(document).on('click', '.view-response', function() {
            $('#apiResponseData').text(JSON.stringify(apiResponse, null, 2));
            apiResponseModal.show();
        });
        
        function verifyDoctor() {
            const bmdcNumber = $('#bmdc_number').val().trim();
            
            if (!bmdcNumber) {
                alert('Please enter a BMDC registration number');
                return;
            }
            
            // Update step status
            updateStep('step-verify', 'loading', 'Verifying with BMDC database...');
            $('.step-actions').hide();
            
            // Clear previous results
            $('#verification-result').html('<div class="text-center p-4"><p class="text-muted">Verifying doctor...</p></div>');
            
            // Make API request
            $.ajax({
                url: '{{ route("bmdc.verify") }}',
                type: 'POST',
                data: {
                    bmdc_number: bmdcNumber
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Store response
                    apiResponse = response;
                    
                    if (!response.success) {
                        updateStep('step-verify', 'error', 'Doctor verification failed');
                        $('#verification-result').html(`
                            <div class="alert alert-danger">
                                <h5><i class="fas fa-exclamation-triangle me-2"></i> Verification Failed</h5>
                                <p>${response.message}</p>
                            </div>
                        `);
                        $('.step-actions').show();
                        return;
                    }
                    
                    // Show success result
                    updateStep('step-verify', 'success', 'Doctor verified successfully');
                    $('.step-actions').show();
                    
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
                },
                error: function(xhr) {
                    updateStep('step-verify', 'error', 'BMDC verification failed');
                    $('#verification-result').html(`<div class="alert alert-danger">Error verifying doctor: ${xhr.statusText}</div>`);
                    $('.step-actions').show();
                    apiResponse = xhr.responseJSON;
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
    });
</script>
@endsection
