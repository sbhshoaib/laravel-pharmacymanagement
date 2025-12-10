@extends('layouts.app')

@section('title', 'AI Medicine Suggestions')

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
    
    .symptoms-box {
        min-height: 150px;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">AI Medicine Suggestions</h1>
        <a href="{{ route('ai-suggest.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to AI Suggest
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary bg-gradient text-white py-3">
            <h5 class="mb-0"><i class="fas fa-stethoscope me-2"></i> Get Medicine Suggestions</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> Describe the symptoms in detail below and our AI will suggest appropriate medicines from your inventory.
            </div>

            <form id="suggestForm">
                <div class="mb-3">
                    <label for="symptoms" class="form-label fw-bold">Describe Symptoms</label>
                    <textarea class="form-control symptoms-box" id="symptoms" name="symptoms" rows="5" placeholder="Enter patient symptoms in detail..." required></textarea>
                    <div class="form-text">The more detailed the description, the better the suggestions will be.</div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary" id="getSuggestionsBtn">
                        <i class="fas fa-lightbulb me-2"></i> Get Suggestions
                    </button>
                </div>
            </form>

            <div class="loading-container mt-4 text-center py-5">
                <div class="loader"></div>
                <p class="mt-3 text-muted">Analyzing symptoms and generating medicine suggestions...</p>
            </div>

            <div class="result-container mt-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Medicine Suggestions</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>For symptoms:</strong>
                            <p id="symptoms-text" class="fst-italic"></p>
                        </div>
                        <hr>
                        <div id="suggestions" class="ai-response"></div>
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
        $('#suggestForm').on('submit', function(e) {
            e.preventDefault();
            
            const symptoms = $('#symptoms').val();
            
            if (!symptoms || symptoms.trim().length < 5) {
                alert('Please enter detailed symptoms');
                return;
            }
            
            // Show loading
            $('.loading-container').show();
            $('.result-container').hide();
            $('#getSuggestionsBtn').prop('disabled', true);
            
            $.ajax({
                url: '{{ route("ai-suggest.get-suggestion") }}',
                type: 'POST',
                data: {
                    symptoms: symptoms
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#symptoms-text').text(response.symptoms);
                        $('#suggestions').html(response.suggestions);
                        $('.result-container').show();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'An error occurred while generating suggestions';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    alert('Error: ' + errorMessage);
                },
                complete: function() {
                    $('.loading-container').hide();
                    $('#getSuggestionsBtn').prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection
