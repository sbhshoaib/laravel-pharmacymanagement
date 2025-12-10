@extends('layouts.app')

@section('title', 'Pharmaceuticals')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Pharmaceuticals</h1>
        <a href="{{ route('pharmaceuticals.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Add New Pharmaceutical
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
                            <th scope="col">Name</th>
                            <th scope="col" class="text-center">Medicines</th>
                            <th scope="col" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($pharmaceuticals) > 0)
                            @foreach($pharmaceuticals as $pharmaceutical)
                                <tr>
                                    <td class="ps-4">{{ $pharmaceutical->id }}</td>
                                    <td>{{ $pharmaceutical->name }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-info text-dark">{{ $pharmaceutical->medicine_count }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('pharmaceuticals.edit', $pharmaceutical->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('pharmaceuticals.destroy', $pharmaceutical->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this pharmaceutical?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center py-4">No pharmaceuticals found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
