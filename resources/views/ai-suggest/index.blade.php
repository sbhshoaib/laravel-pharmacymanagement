@extends('layouts.app')

@section('title', 'AI Suggest')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">AI Suggest</h1>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary bg-gradient text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-pills me-2"></i> Medicine Information</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="flex-grow-1">Get detailed information about specific medicines including side effects, dosage, and indications using AI.</p>
                    <div class="text-center mt-4">
                        <a href="{{ route('ai-suggest.medicine-info') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-info-circle me-2"></i> Get Medicine Info
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary bg-gradient text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-stethoscope me-2"></i> Medicine Suggestion</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="flex-grow-1">Enter symptoms and get AI-powered medicine suggestions based on your pharmacy's inventory.</p>
                    <div class="text-center mt-4">
                        <a href="{{ route('ai-suggest.medicine-suggest') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-lightbulb me-2"></i> Get Medicine Suggestions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
