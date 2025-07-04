@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success">Create New Post</h2>
</div>
<div class="form-container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="date" class="form-label fw-bold text-success">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label fw-bold text-success">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Enter post title" required>
        </div>
        <div class="mb-3">
            <label for="subtitle" class="form-label fw-bold text-success">Sub Title</label>
            <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ old('subtitle') }}" placeholder="Enter subtitle">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label fw-bold text-success">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter post description" required>{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="images" class="form-label fw-bold text-success">Upload Images</label>
            <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" required>
            <div class="form-text">You can select multiple images. First image will be used as the feature image.</div>
        </div>
        <div id="imagePreviewContainer" class="image-preview-container"></div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary me-md-2">Cancel</a>
            <button type="submit" class="btn btn-success">Create Post</button>
        </div>
    </form>
</div>
@push('styles')
<style>
    .form-container {
        background: #ffffff;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.05);
    }
    .image-preview {
        max-width: 200px;
        max-height: 200px;
        object-fit: cover;
        border-radius: 0.5rem;
        margin: 0.5rem;
    }
    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
    }
</style>
@endpush
@push('scripts')
<script>
    // Image preview functionality
    document.getElementById('images').addEventListener('change', function(e) {
        const container = document.getElementById('imagePreviewContainer');
        container.innerHTML = '';
        for (let i = 0; i < e.target.files.length; i++) {
            const file = e.target.files[i];
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'image-preview';
                    img.alt = 'Preview ' + (i + 1);
                    container.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }
    });
</script>
@endpush
@endsection 