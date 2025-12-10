@extends('layouts.app')

@section('title', 'AI Medicine Information')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .result-container {
        display: none;
        transition: all 0.3s ease;
    }
    
    .loading-container {
        display: none;
        transition: all 0.3s ease;
    }
    
    .ai-response {
        white-space: pre-line;
        border-left: 4px solid #4361ee;
        padding-left: 15px;
    }

    .loader {
        width: 48px;
        height: 48px;
        border: 5px solid #FFF;
        border-bottom-color: #4361ee;
        border-radius: 50%;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
        margin: 0 auto;
    }

    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">AI Medicine Information</h1>
        <a href="{{ route('ai-suggest.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to AI Suggest
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary bg-gradient text-white py-3">
            <h5 class="mb-0"><i class="fas fa-pills me-2"></i> Get Medicine Information</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> Select a medicine from the list below to get detailed information about it, including side effects, dosage, and indications.
            </div>

            <form id="medicineInfoForm">
                <div class="mb-3">
                    <label for="medicine_id" class="form-label fw-bold">Select Medicine</label>
                    <select class="form-select" id="medicine_id" name="medicine_id" required>
                        <option value="">-- Select a Medicine --</option>
                        @foreach($medicines as $medicine)
                            <option value="{{ $medicine->id }}">{{ $medicine->name }} - {{ $medicine->generic_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary" id="getInfoBtn">
                        <i class="fas fa-search me-2"></i> Get Information
                    </button>
                </div>
            </form>

            <div class="loading-container mt-4 text-center py-5">
                <div class="loader"></div>
                <p class="mt-3 text-muted">Generating detailed medicine information using AI...</p>
            </div>

            <div class="result-container mt-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0" id="medicine-name">Medicine Information</h5>
                    </div>
                    <div class="card-body">
                        <div id="medicine-info" class="ai-response"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#medicineInfoForm').on('submit', function(e) {
            e.preventDefault();
            
            const medicineId = $('#medicine_id').val();
            const medicineName = $('#medicine_id option:selected').text();
            
            if (!medicineId) {
                alert('Please select a medicine');
                return;
            }
            
            // Show loading
            $('.loading-container').show();
            $('.result-container').hide();
            $('#getInfoBtn').prop('disabled', true);
            
            $.ajax({
                url: '{{ route("ai-suggest.get-medicine-info") }}',
                type: 'POST',
                data: {
                    medicine_id: medicineId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#medicine-name').html(
                            `${response.medicine_name} <small class="text-muted">${response.generic_name}</small>`
                        );
                        $('#medicine-info').html(response.information);
                        $('.result-container').show();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'An error occurred while generating information';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    alert('Error: ' + errorMessage);
                },
                complete: function() {
                    $('.loading-container').hide();
                    $('#getInfoBtn').prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection
