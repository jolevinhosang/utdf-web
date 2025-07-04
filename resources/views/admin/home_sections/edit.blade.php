@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success mb-0">
        <i class="bi bi-pencil-square me-2"></i>Edit Section: <span class="text-uppercase">{{ ucfirst(str_replace('_', ' ', $section->section_key)) }}</span>
    </h2>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
    </a>
</div>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="content" class="form-label fw-semibold">Content</label>
                <textarea id="content" name="content" class="form-control" rows="12">{{ old('content', $section->content) }}</textarea>
                @error('content')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success px-4">Save Changes</button>
        </form>
    </div>
</div>
@endsection