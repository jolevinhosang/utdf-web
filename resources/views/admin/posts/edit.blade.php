@extends('layouts.admin')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post - Admin - UTDF</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo_utdf.jpg') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #eaf4ea 0%, #ffffff 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .admin-sidebar {
            background: white;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
            min-height: 100vh;
        }
        .admin-header {
            background: linear-gradient(to right, #198754, #20c997);
            color: white;
            padding: 1rem;
        }
        .nav-link {
            color: #495057;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            background: #e9ecef;
            color: #198754;
        }
        .nav-link i {
            width: 20px;
        }
        .main-content {
            padding: 2rem;
        }
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
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 admin-sidebar">
            <div class="admin-header text-center">
                <img src="{{ asset('assets/logo_utdf.jpg') }}" alt="UTDF Logo" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                <h6 class="mb-0 mt-2">Admin Panel</h6>
            </div>
            <nav class="nav flex-column p-3">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
                <a class="nav-link" href="{{ route('posts.create') }}">
                    <i class="bi bi-plus-circle me-2"></i>Create Post
                </a>
                <a class="nav-link active" href="{{ route('admin.posts') }}">
                    <i class="bi bi-file-text me-2"></i>Manage Posts
                </a>
                <a class="nav-link" href="{{ route('admin.users') }}">
                    <i class="bi bi-people me-2"></i>Users
                </a>
                <hr>
                <a class="nav-link" href="{{ route('welcome') }}">
                    <i class="bi bi-house me-2"></i>View Website
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </button>
                </form>
            </nav>
        </div>
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-success">Edit Post</h2>
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
                <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="date" class="form-label fw-bold text-success">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $post->date) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold text-success">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="subtitle" class="form-label fw-bold text-success">Sub Title</label>
                        <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ old('subtitle', $post->subtitle) }}">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold text-success">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $post->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label fw-bold text-success">Upload Images</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                        <div class="form-text">You can select multiple images. Uploading new images will replace all existing images.</div>
                    </div>
                    @if ($post->images && is_array($post->images))
                        <div class="mb-3">
                            <label class="form-label fw-bold text-success">Current Images</label>
                            <div class="image-preview-container">
                                @foreach ($post->images as $img)
                                    <img src="{{ asset('storage/' . $img) }}" class="image-preview" alt="Current Image">
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.posts') }}" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-success">Update Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@include('layouts.footer')
</body>
</html>
@endsection 