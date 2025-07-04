<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>All Posts - UTDF</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo_utdf.jpg') }}" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
@include('layouts.navigation')
<div class="py-5" style="background: linear-gradient(135deg, #eaf4ea 0%, #ffffff 100%); min-height: 100vh;">
    <div class="container px-4 px-lg-5">
        <h2 class="fw-bold text-success text-uppercase mb-4 text-center">
            <i class="bi bi-newspaper me-2"></i>All Posts
        </h2>
        <form method="GET" action="{{ route('posts.all') }}" class="mb-5">
            <div class="input-group input-group-lg justify-content-center">
                <input type="text" name="search" class="form-control w-50 rounded-pill border-success" placeholder="Search posts..." value="{{ request('search') }}" style="max-width: 400px;">
                <button class="btn btn-success rounded-pill ms-2 px-4" type="submit"><i class="bi bi-search"></i> Search</button>
            </div>
        </form>
        <div class="row gx-4 gy-4">
            @forelse($posts as $post)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        @if($post->images && is_array($post->images) && count($post->images) > 0)
                            <img src="{{ asset('storage/' . $post->images[0]) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover; border-radius: 1.25rem 1.25rem 0 0;">
                        @else
                            <img src="{{ asset('assets/logo_utdf.jpg') }}" class="card-img-top" alt="UTDF" style="height: 200px; object-fit: cover; border-radius: 1.25rem 1.25rem 0 0;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $post->title }}</h5>
                            <div class="mb-2 text-muted small">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ $post->date ? $post->date->format('F j, Y') : '' }}
                            </div>
                            <p class="card-text text-muted">{{ $post->subtitle ?? Str::limit($post->description, 80) }}</p>
                            <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-outline-success btn-sm">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-file-text text-muted fs-1"></i>
                    <p class="text-muted mt-2">No posts found.</p>
                </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-5">
            {{ $posts->withQueryString()->links() }}
        </div>
    </div>
</div>
@include('layouts.footer')
</body>
</html> 