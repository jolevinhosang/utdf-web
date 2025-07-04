@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success">Manage Posts</h2>
    <a href="{{ route('posts.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle me-1"></i>Create New Post
    </a>
</div>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
<div class="table-container">
    @if($posts->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Images</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>
                                <strong>{{ $post->title }}</strong>
                                @if($post->is_hero)
                                    <span class="badge bg-success ms-2">Hero</span>
                                @endif
                                @if($post->subtitle)
                                    <br><small class="text-muted">{{ $post->subtitle }}</small>
                                @endif
                            </td>
                            <td>{{ $post->date->format('M j, Y') }}</td>
                            <td>
                                <span class="badge bg-success">{{ count($post->images) }} images</span>
                            </td>
                            <td>{{ $post->created_at->format('M j, Y') }}</td>
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
                                @if(!$post->is_hero)
                                <form method="POST" action="{{ route('admin.posts.setHero', $post->id) }}" class="d-inline ms-1">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success">Set as Hero</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
    @else
        <div class="text-center py-4">
            <i class="bi bi-file-text text-muted fs-1"></i>
            <p class="text-muted mt-2">No posts found.</p>
            <a href="{{ route('posts.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i>Create Your First Post
            </a>
        </div>
    @endif
</div>
@push('styles')
<style>
    .table-container {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,0.1);
    }
</style>
@endpush
@endsection 