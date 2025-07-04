@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success mb-0">
        <i class="bi bi-pencil-square me-2"></i>Edit Section: MISSION & VISION
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
                <label for="content" class="form-label fw-semibold">Mission & Vision Content</label>
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

@push('scripts')
<script src="https://cdn.tiny.cloud/1/j73mk6mnqhc1xplmcestnwbx6lwiunb4ib4bwuf13z36qjfg/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
        height: 400,
        menubar: false,
        plugins: [
            'advlist autolink lists link charmap preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | bold italic backcolor | \
            alignleft aligncenter alignright alignjustify | \
            bullist numlist outdent indent | removeformat | help',
        content_css: '//www.tiny.cloud/css/codepen.min.css'
    });
</script>
@endpush 