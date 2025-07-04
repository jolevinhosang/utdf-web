@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success mb-0">
        <i class="bi bi-envelope-fill me-2"></i>Edit Section: CONTACT US
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

<!-- Contact Description Section -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Contact Description</h5>
        @php $contactData = json_decode($section->content, true) ?? []; @endphp
        <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4" placeholder="Enter contact description...">{{ $contactData['description'] ?? '' }}</textarea>
            </div>
            <button type="submit" class="btn btn-success px-4">Save Description</button>
        </form>
    </div>
</div>

<!-- Contact Information Section -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Contact Information</h5>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addContactModal">
                <i class="bi bi-plus-circle me-1"></i>Add Contact
            </button>
        </div>
        
        @php $contacts = $contactData['contacts'] ?? []; @endphp
        @if(count($contacts) > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Phone Number</th>
                            <th>Email(s)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $idx => $contact)
                            <tr>
                                <td>
                                    <span class="fw-bold text-success">{{ $contact['name'] ?? '' }}</span>
                                </td>
                                <td>{{ $contact['role'] ?? '' }}</td>
                                <td>
                                    <a href="tel:{{ $contact['phone'] ?? '' }}" class="text-decoration-none">
                                        <i class="bi bi-telephone-fill me-1"></i>{{ $contact['phone'] ?? '' }}
                                    </a>
                                </td>
                                <td>
                                    @php
                                        $emails = explode(',', $contact['emails'] ?? '');
                                        $emails = array_map('trim', $emails);
                                    @endphp
                                    @foreach($emails as $email)
                                        @if(!empty($email))
                                            <a href="mailto:{{ $email }}" class="text-decoration-none d-block">
                                                <i class="bi bi-envelope-fill me-1"></i>{{ $email }}
                                            </a>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-outline-warning btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editContactModal{{ $idx }}"
                                                title="Edit Contact">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="remove_card" value="{{ $idx }}">
                                            <button type="submit" 
                                                    class="btn btn-outline-danger btn-sm" 
                                                    onclick="return confirm('Are you sure you want to remove this contact?')"
                                                    title="Remove Contact">
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
                <i class="bi bi-info-circle me-2"></i>No contacts available. Click "Add Contact" to get started.
            </div>
        @endif
    </div>
</div>

<!-- Add Contact Modal -->
<div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="add_card" value="1">
                <div class="modal-header">
                    <h5 class="modal-title" id="addContactModalLabel">Add Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="e.g., Dr. Ria Gondowarsito" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role</label>
                        <input type="text" class="form-control" name="role" placeholder="e.g., Founder – United Timor Development Foundation" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone Number</label>
                        <input type="tel" class="form-control" name="phone" placeholder="e.g., +61 431 371 669" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email(s)</label>
                        <input type="text" class="form-control" name="emails" placeholder="e.g., colinbarlowria@gmail.com, ria081954@gmail.com" required>
                        <div class="form-text">Separate multiple emails with commas</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Add Contact</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Contact Modals -->
@foreach($contacts as $idx => $contact)
    <div class="modal fade" id="editContactModal{{ $idx }}" tabindex="-1" aria-labelledby="editContactModalLabel{{ $idx }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="edit_card" value="{{ $idx }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editContactModalLabel{{ $idx }}">Edit Contact</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $contact['name'] ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Role</label>
                            <input type="text" class="form-control" name="role" value="{{ $contact['role'] ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" class="form-control" name="phone" value="{{ $contact['phone'] ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email(s)</label>
                            <input type="text" class="form-control" name="emails" value="{{ $contact['emails'] ?? '' }}" required>
                            <div class="form-text">Separate multiple emails with commas</div>
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
@endsection 