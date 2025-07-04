@extends('layouts.admin')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold text-success mb-1">Dashboard</h2>
        <span class="text-muted">Welcome back, {{ auth()->user()->name }}</span>
    </div>
    <div class="card shadow-sm border-0 bg-success bg-opacity-10 px-4 py-3 mb-2 mb-md-0" style="min-width: 250px;">
        <div class="d-flex align-items-center">
            <i class="bi bi-person-circle text-success fs-2 me-3"></i>
            <div>
                <div class="fw-semibold">Role:</div>
                <div class="text-success text-uppercase small">{{ auth()->user()->role }}</div>
            </div>
        </div>
    </div>
</div>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stats-card text-center py-4 h-100">
            <div class="mb-3">
                <span class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-block">
                    <i class="bi bi-file-text text-success fs-2"></i>
                </span>
            </div>
            <h3 class="fw-bold mb-1">{{ $totalPosts }}</h3>
            <div class="text-muted">Total Posts</div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stats-card text-center py-4 h-100">
            <div class="mb-3">
                <span class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block">
                    <i class="bi bi-eye text-primary fs-2"></i>
                </span>
            </div>
            <h3 class="fw-bold mb-1">{{ $totalViews }}</h3>
            <div class="text-muted">Total Views</div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stats-card text-center py-4 h-100">
            <div class="mb-3">
                <span class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block">
                    <i class="bi bi-people text-warning fs-2"></i>
                </span>
            </div>
            <h3 class="fw-bold mb-1">{{ $totalUsers }}</h3>
            <div class="text-muted">Total Users</div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stats-card text-center py-4 h-100">
            <div class="mb-3">
                <span class="bg-info bg-opacity-10 p-3 rounded-circle d-inline-block">
                    <i class="bi bi-calendar-event text-info fs-2"></i>
                </span>
            </div>
            <h3 class="fw-bold mb-1">{{ $thisMonthPosts }}</h3>
            <div class="text-muted">Posts This Month</div>
        </div>
    </div>
</div>
<!-- Recent Posts -->
<div class="table-container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Recent Posts</h5>
        <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle me-1"></i>Create New Post
        </a>
    </div>
    @if($recentPosts->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Images</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPosts as $post)
                        <tr>
                            <td>
                                <strong>{{ $post->title }}</strong>
                                @if($post->subtitle)
                                    <br><small class="text-muted">{{ $post->subtitle }}</small>
                                @endif
                            </td>
                            <td>{{ $post->date->format('M j, Y') }}</td>
                            <td>
                                <span class="badge bg-success">{{ count($post->images) }} images</span>
                            </td>
                            <td>
                                <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this post?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-4">
            <i class="bi bi-file-text text-muted fs-1"></i>
            <p class="text-muted mt-2">No posts yet. Create your first post!</p>
            <a href="{{ route('posts.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i>Create Post
            </a>
        </div>
    @endif
</div>
@push('styles')
<style>
    .stats-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        margin-bottom: 0.5rem;
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
    .table-container {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,0.1);
    }
    .table thead th {
        background: #f8f9fa;
        font-weight: 600;
    }
    .table-hover tbody tr:hover {
        background: #f1fdf6;
    }
</style>
@endpush
@endsection 