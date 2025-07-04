@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success mb-0">
        <i class="bi bi-geo-alt-fill me-2"></i>Edit Section: LOCATIONS
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

@php $locationData = json_decode($section->content, true) ?? []; @endphp

<!-- Location Description Section -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Location Description</h5>
        <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea id="description" name="description" class="form-control" rows="6" placeholder="Enter location description...">{{ $locationData['description'] ?? '' }}</textarea>
                <div class="form-text">
                    <i class="bi bi-info-circle me-1"></i>
                    Use the rich text editor to format your description with bold, italic, links, and other formatting options.
                </div>
            </div>
            <button type="submit" class="btn btn-success px-4">Save Description</button>
        </form>
    </div>
</div>

<!-- Map Image Section -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3">
            <i class="bi bi-map me-2"></i>Map Image
        </h5>
        
        <!-- Current Map Image -->
        @if(isset($locationData['map_image']) && !empty($locationData['map_image']))
            <div class="mb-4">
                <label class="form-label fw-semibold">Current Map Image</label>
                <div class="border rounded-3 p-3 bg-light">
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $locationData['map_image']) }}" 
                             alt="Current Map" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 300px; max-width: 100%;">
                    </div>
                    <div class="mt-3 text-center">
                        <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="remove_map_image" value="1">
                            <button type="submit" 
                                    class="btn btn-outline-danger btn-sm" 
                                    onclick="return confirm('Are you sure you want to remove the current map image?')">
                                <i class="bi bi-trash me-1"></i>Remove Current Map
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle me-2"></i>
                <strong>No map image currently set.</strong> Upload a map image to display on the locations section.
            </div>
        @endif
        
        <!-- Upload New Map Image -->
        <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="map_image" class="form-label fw-semibold">
                    @if(isset($locationData['map_image']) && !empty($locationData['map_image']))
                        Replace Map Image
                    @else
                        Upload Map Image
                    @endif
                </label>
                <input type="file" id="map_image" name="map_image" class="form-control" accept="image/*">
                <div class="form-text">
                    <i class="bi bi-info-circle me-1"></i>
                    Upload a map image (JPEG, PNG, JPG, GIF, max 2MB). Recommended size: 800x600px or larger.
                </div>
            </div>
            <button type="submit" class="btn btn-success px-4">
                <i class="bi bi-upload me-1"></i>
                @if(isset($locationData['map_image']) && !empty($locationData['map_image']))
                    Replace Map Image
                @else
                    Upload Map Image
                @endif
            </button>
        </form>
    </div>
</div>

<!-- Timor Indonesia Locations Section -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-flag-fill me-2 text-primary"></i>Timor Indonesia Locations
            </h5>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addIndonesiaLocationModal">
                <i class="bi bi-plus-circle me-1"></i>Add Location
            </button>
        </div>
        
        @php $timorIndonesia = $locationData['timor_indonesia'] ?? []; @endphp
        @if(count($timorIndonesia) > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timorIndonesia as $idx => $location)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">{{ $location['title'] ?? '' }}</span>
                                </td>
                                <td>
                                    <div class="text-muted small">
                                        {{ Str::limit(strip_tags($location['description'] ?? ''), 100) }}
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-outline-warning btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editIndonesiaLocationModal{{ $idx }}"
                                                title="Edit Location">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="remove_location" value="1">
                                            <input type="hidden" name="region" value="indonesia">
                                            <input type="hidden" name="idx" value="{{ $idx }}">
                                            <button type="submit" 
                                                    class="btn btn-outline-danger btn-sm" 
                                                    onclick="return confirm('Are you sure you want to remove this location?')"
                                                    title="Remove Location">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle me-2"></i>No Timor Indonesia locations available. Click "Add Location" to get started.
            </div>
        @endif
    </div>
</div>

<!-- Timor Leste Locations Section -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-flag-fill me-2 text-success"></i>Timor Leste Locations
            </h5>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addLesteLocationModal">
                <i class="bi bi-plus-circle me-1"></i>Add Location
            </button>
        </div>
        
        @php $timorLeste = $locationData['timor_leste'] ?? []; @endphp
        @if(count($timorLeste) > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timorLeste as $idx => $location)
                            <tr>
                                <td>
                                    <span class="fw-bold text-success">{{ $location['title'] ?? '' }}</span>
                                </td>
                                <td>
                                    <div class="text-muted small">
                                        {{ Str::limit(strip_tags($location['description'] ?? ''), 100) }}
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-outline-warning btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editLesteLocationModal{{ $idx }}"
                                                title="Edit Location">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="remove_location" value="1">
                                            <input type="hidden" name="region" value="leste">
                                            <input type="hidden" name="idx" value="{{ $idx }}">
                                            <button type="submit" 
                                                    class="btn btn-outline-danger btn-sm" 
                                                    onclick="return confirm('Are you sure you want to remove this location?')"
                                                    title="Remove Location">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle me-2"></i>No Timor Leste locations available. Click "Add Location" to get started.
            </div>
        @endif
    </div>
</div>

<!-- Add Timor Indonesia Location Modal -->
<div class="modal fade" id="addIndonesiaLocationModal" tabindex="-1" aria-labelledby="addIndonesiaLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="add_location" value="1">
                <input type="hidden" name="region" value="indonesia">
                <div class="modal-header">
                    <h5 class="modal-title" id="addIndonesiaLocationModalLabel">Add Timor Indonesia Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Location Title</label>
                        <input type="text" class="form-control" name="title" placeholder="e.g., Belu District" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea class="form-control tinymce-editor" name="description" rows="4" placeholder="Enter location description..." required></textarea>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Use the rich text editor to format your description with bold, italic, links, and other formatting options.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Add Location</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Timor Leste Location Modal -->
<div class="modal fade" id="addLesteLocationModal" tabindex="-1" aria-labelledby="addLesteLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="add_location" value="1">
                <input type="hidden" name="region" value="leste">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLesteLocationModalLabel">Add Timor Leste Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Location Title</label>
                        <input type="text" class="form-control" name="title" placeholder="e.g., Maliana" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea class="form-control tinymce-editor" name="description" rows="4" placeholder="Enter location description..." required></textarea>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Use the rich text editor to format your description with bold, italic, links, and other formatting options.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Add Location</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Timor Indonesia Location Modals -->
@foreach($timorIndonesia as $idx => $location)
    <div class="modal fade" id="editIndonesiaLocationModal{{ $idx }}" tabindex="-1" aria-labelledby="editIndonesiaLocationModalLabel{{ $idx }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="edit_location" value="1">
                    <input type="hidden" name="region" value="indonesia">
                    <input type="hidden" name="idx" value="{{ $idx }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editIndonesiaLocationModalLabel{{ $idx }}">Edit Timor Indonesia Location</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Location Title</label>
                            <input type="text" class="form-control" name="title" value="{{ $location['title'] ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea class="form-control tinymce-editor" name="description" rows="4" required>{{ $location['description'] ?? '' }}</textarea>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Use the rich text editor to format your description with bold, italic, links, and other formatting options.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!-- Edit Timor Leste Location Modals -->
@foreach($timorLeste as $idx => $location)
    <div class="modal fade" id="editLesteLocationModal{{ $idx }}" tabindex="-1" aria-labelledby="editLesteLocationModalLabel{{ $idx }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="edit_location" value="1">
                    <input type="hidden" name="region" value="leste">
                    <input type="hidden" name="idx" value="{{ $idx }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLesteLocationModalLabel{{ $idx }}">Edit Timor Leste Location</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Location Title</label>
                            <input type="text" class="form-control" name="title" value="{{ $location['title'] ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea class="form-control tinymce-editor" name="description" rows="4" required>{{ $location['description'] ?? '' }}</textarea>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Use the rich text editor to format your description with bold, italic, links, and other formatting options.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@push('scripts')
<script>
    // Initialize TinyMCE for the main description field
    tinymce.init({
        selector: '#description',
        height: 300,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; }',
        menubar: false,
        branding: false,
        promotion: false,
        elementpath: false,
        statusbar: false,
        resize: false,
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        }
    });

    // Initialize TinyMCE for modal textareas
    function initModalTinyMCE() {
        tinymce.init({
            selector: '.tinymce-editor',
            height: 200,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; }',
            menubar: false,
            branding: false,
            promotion: false,
            elementpath: false,
            statusbar: false,
            resize: false,
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
        });
    }

    // Initialize TinyMCE when modals are shown
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize for existing modals
        initModalTinyMCE();
        
        // Initialize for dynamically created modals
        document.addEventListener('shown.bs.modal', function(event) {
            setTimeout(function() {
                initModalTinyMCE();
            }, 100);
        });
    });
</script>
@endpush
@endsection 