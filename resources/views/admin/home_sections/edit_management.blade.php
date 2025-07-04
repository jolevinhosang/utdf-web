@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success mb-0">
        <i class="bi bi-people-fill me-2"></i>Edit Section: FOUNDATION MANAGEMENT
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
        <h5 class="fw-bold mb-3">Management Team</h5>
        <div class="row" id="managementCards">
            @php $members = json_decode($section->content, true) ?? []; @endphp
            @foreach($members as $idx => $member)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm text-center">
                        @if(!empty($member['photo']))
                            <img src="{{ asset('storage/' . $member['photo']) }}" class="card-img-top rounded-top mx-auto d-block" alt="{{ $member['name'] }}" style="width: 180px; height: 180px; object-fit: cover; margin-top: 20px;" />
                        @else
                            <div class="bg-light rounded-top mx-auto d-block" style="width: 180px; height: 180px; margin-top: 20px;"></div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $member['name'] }}</h5>
                            <div class="card-text text-muted">{{ $member['role'] }}</div>
                            <button type="button" class="btn btn-outline-warning btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#editMemberModal{{ $idx }}">Edit</button>
                            <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="remove_member" value="{{ $idx }}">
                                <button type="submit" class="btn btn-outline-danger btn-sm mt-2">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Edit Modal -->
                <div class="modal fade" id="editMemberModal{{ $idx }}" tabindex="-1" aria-labelledby="editMemberModalLabel{{ $idx }}" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="edit_member" value="{{ $idx }}">
                        <div class="modal-header">
                          <h5 class="modal-title" id="editMemberModalLabel{{ $idx }}">Edit Member</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $member['name'] }}" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" name="role" value="{{ $member['role'] }}" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Photo</label>
                            <input type="file" class="form-control" name="photo">
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
        </div>
        <!-- Add Member Button -->
        <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#addMemberModal">
            <i class="bi bi-plus-circle me-1"></i>Add Member
        </button>
        <!-- Add Modal -->
        <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="add_member" value="1">
                <div class="modal-header">
                  <h5 class="modal-title" id="addMemberModalLabel">Add Member</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Role</label>
                    <input type="text" class="form-control" name="role" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Photo</label>
                    <input type="file" class="form-control" name="photo">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success">Add Member</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection 