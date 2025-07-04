<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $post->title }} - UTDF</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
    }

    .header-gradient {
      background: linear-gradient(to right, #eaf4ea, #ffffff);
      color: white;
      padding: 30px 0;
    }

    .header-gradient h1 {
      font-size: 2.5rem;
    }

    .gallery img {
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      object-fit: cover;
      height: 180px;
      width: 100%;
    }

    .gallery img:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }

    .content-box {
      background: #ffffff;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.05);
    }

    .feature-image {
      max-height: 450px;
      object-fit: cover;
    }

    @media (max-width: 768px) {
      .gallery img {
        height: auto;
      }
    }
  </style>
</head>
<body>
  @include('layouts.navigation')

  <!-- Header -->
  <section class="header-gradient text-success text-center">
    <div class="container">
      <p class="mb-2 small opacity-75">{{ $post->date->format('F j, Y') }}</p>
      <h1 class="fw-bold">{{ $post->title }}</h1>
      @if($post->subtitle)
        <p class="lead mt-2">{{ $post->subtitle }}</p>
      @endif
    </div>
  </section>

  <!-- Main Content -->
  <section class="container py-5">
    <!-- Feature Image -->
    @if(count($post->images) > 0)
      <div class="mb-5 text-center">
        <img src="{{ asset('storage/' . $post->images[0]) }}" alt="Feature" class="img-fluid rounded shadow feature-image" />
      </div>
    @endif

    <!-- Content Box -->
    <div class="content-box mb-5">
      <h2 class="mb-3 text-success">{{ $post->title }}</h2>
      <p class="lead mb-3">
        {!! nl2br(e($post->description)) !!}
      </p>
    </div>

    <!-- Gallery -->
    @if(count($post->images) > 1)
      <div class="row gallery g-4">
        @foreach(array_slice($post->images, 1) as $index => $image)
          <div class="col-6 col-sm-4 col-md-3">
            <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded shadow-sm" alt="Gallery Image {{ $index + 2 }}">
          </div>
        @endforeach
      </div>
    @endif
  </section>

  <!-- Image Preview Modal -->
  <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content bg-transparent border-0">
        <div class="modal-body p-0 text-center">
          <img id="modalImage" src="" class="img-fluid rounded shadow" alt="Preview">
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="px-5 py-2 bg-white w-100">
    <p class="m-0 text-center text-dark">&copy; {{ date('Y') }} UNITED TIMOR DEVELOPMENT FOUNDATION. All rights reserved.</p>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const galleryImages = document.querySelectorAll('.gallery img');
      const modalImage = document.getElementById('modalImage');
      const imagePreviewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));

      galleryImages.forEach(img => {
        img.addEventListener('click', function () {
          modalImage.src = this.src;
          modalImage.alt = this.alt;
          imagePreviewModal.show();
        });
      });
    });
  </script>
  @include('layouts.footer')
</body>
</html> 