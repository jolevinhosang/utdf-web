@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success">Admin Users</h2>
</div>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<!-- Create User Form -->
<div class="create-user-form mb-4">
    <h5 class="fw-bold mb-3">Create New User</h5>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="row g-3 align-items-center">
            <div class="col-md-2">
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="col-md-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="col-md-2">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="col-md-2">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
            </div>
            <div class="col-md-2">
                <select name="role" class="form-select" required>
                    <option value="admin">Admin</option>
                    <option value="superadmin">Superadmin</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-success w-100">Create</button>
            </div>
        </div>
    </form>
</div>
<!-- Users Table -->
<div class="table-container">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@push('styles')
<style>
    .table-container {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,0.1);
    }
    .create-user-form {
        background: #f8f9fa;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,0.05);
        margin-bottom: 2rem;
    }
</style>
@endpush
@endsection 