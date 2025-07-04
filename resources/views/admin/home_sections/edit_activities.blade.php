@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success mb-0">
        <i class="bi bi-calendar-event me-2"></i>Edit Section: UPCOMING ACTIVITIES
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
        <h5 class="fw-bold mb-3">Add New Activity</h5>
        <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="add_activity" value="1">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Add Activity</button>
        </form>

        <h5 class="fw-bold mt-5 mb-3">All Activities</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $activities = json_decode($section->content, true) ?? []; @endphp
                    @foreach($activities as $idx => $activity)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $activity['title'] }}</td>
                            <td>{{ $activity['description'] }}</td>
                            <td>
                                <!-- Edit Button triggers modal -->
                                <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editActivityModal{{ $idx }}">Edit</button>
                                <!-- Delete Form -->
                                <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="remove_activity" value="{{ $idx }}">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <!-- Edit Modal -->
                        <div class="modal fade" id="editActivityModal{{ $idx }}" tabindex="-1" aria-labelledby="editActivityModalLabel{{ $idx }}" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="edit_activity" value="{{ $idx }}">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editActivityModalLabel{{ $idx }}">Edit Activity</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ $activity['title'] }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3" required>{{ $activity['description'] }}</textarea>
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
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 