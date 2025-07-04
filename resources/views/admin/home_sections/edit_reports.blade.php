@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success mb-0">
        <i class="bi bi-file-earmark-bar-graph-fill me-2"></i>Edit Section: YEARLY REPORTS
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Yearly Reports</h5>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addReportModal">
                <i class="bi bi-plus-circle me-1"></i>Add Report
            </button>
        </div>
        
        @php $reports = json_decode($section->content, true) ?? []; @endphp
        @if(count($reports) > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>Year</th>
                            <th>Description</th>
                            <th>File</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $idx => $report)
                            <tr>
                                <td>
                                    <span class="fw-bold text-success">{{ $report['year'] }}</span>
                                </td>
                                <td>
                                    <div class="text-muted">{{ Str::limit($report['description'], 100) }}</div>
                                </td>
                                <td>
                                    @if(!empty($report['file']))
                                        <a href="{{ route('download.report', basename($report['file'])) }}" 
                                           class="btn btn-outline-primary btn-sm" 
                                           title="Download {{ basename($report['file']) }}">
                                            <i class="bi bi-download me-1"></i>Download
                                        </a>
                                    @else
                                        <span class="text-muted">No file</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-outline-warning btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editReportModal{{ $idx }}"
                                                title="Edit Report">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="remove_report" value="{{ $idx }}">
                                            <button type="submit" 
                                                    class="btn btn-outline-danger btn-sm" 
                                                    onclick="return confirm('Are you sure you want to remove this report?')"
                                                    title="Remove Report">
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
                <i class="bi bi-info-circle me-2"></i>No yearly reports available. Click "Add Report" to get started.
            </div>
        @endif
    </div>
</div>

<!-- Add Report Modal -->
<div class="modal fade" id="addReportModal" tabindex="-1" aria-labelledby="addReportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="add_report" value="1">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReportModalLabel">Add Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Year</label>
                        <select class="form-select" name="year" required>
                            <option value="">Select Year</option>
                            @for($year = date('Y'); $year >= 2010; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Enter report description..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">File (PDF, DOC, DOCX)</label>
                        <input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx" required>
                        <div class="form-text">Maximum file size: 10MB</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Add Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Report Modals -->
@foreach($reports as $idx => $report)
    <div class="modal fade" id="editReportModal{{ $idx }}" tabindex="-1" aria-labelledby="editReportModalLabel{{ $idx }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="edit_report" value="{{ $idx }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editReportModalLabel{{ $idx }}">Edit Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Year</label>
                            <select class="form-select" name="year" required>
                                <option value="">Select Year</option>
                                @for($year = date('Y'); $year >= 2010; $year--)
                                    <option value="{{ $year }}" {{ $report['year'] == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Enter report description..." required>{{ $report['description'] }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">File (PDF, DOC, DOCX)</label>
                            @if(!empty($report['file']))
                                <div class="mb-2">
                                    <small class="text-muted">Current file: {{ basename($report['file']) }}</small>
                                </div>
                            @endif
                            <input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx">
                            <div class="form-text">Leave empty to keep current file. Maximum file size: 10MB</div>
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