@extends('layouts.app')

@section('title', 'Staff Management')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Staff Management</h1>
        <a href="{{ route('staff.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Staff
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
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staff as $member)
                            <tr>
                                <td>{{ $member->Staff_ID }}</td>
                                <td>{{ $member->Name }}</td>
                                <td>{{ $member->Email }}</td>
                                <td>{{ $member->Phone }}</td>
                                <td>
                                    @php
                                        $role = DB::selectOne("SELECT Role_Name FROM roles WHERE Role_ID = ?", [$member->Role_ID]);
                                    @endphp
                                    @if($role)
                                        {{ $role->Role_Name }}
                                    @else
                                        Unknown Role
                                    @endif
                                </td>
                                <td>
                                    @if($member->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('staff.edit', $member->Staff_ID) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($member->Staff_ID != session('staff_id'))
                                            <form action="{{ route('staff.destroy', $member->Staff_ID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this staff member?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if(count($staff) == 0)
                            <tr>
                                <td colspan="7" class="text-center py-4">No staff members found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
