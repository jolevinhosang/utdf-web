@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success mb-0">
        <i class="bi bi-heart-fill me-2"></i>Edit Section: SUPPORT
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

<!-- Support Description Section -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Support Description</h5>
        @php $supportData = json_decode($section->content, true) ?? []; @endphp
        <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4" placeholder="Enter support description...">{{ $supportData['description'] ?? '' }}</textarea>
            </div>
            <button type="submit" class="btn btn-success px-4">Save Description</button>
        </form>
    </div>
</div>

<!-- Bank Cards Section -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Bank Account Information</h5>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSupportModal">
                <i class="bi bi-plus-circle me-1"></i>Add Bank Account
            </button>
        </div>
        
        @php $cards = $supportData['cards'] ?? []; @endphp
        @if(count($cards) > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>Bank Name</th>
                            <th>Account Name</th>
                            <th>Account Number</th>
                            <th>Branch Code</th>
                            <th>SWIFT Code</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cards as $idx => $card)
                            <tr>
                                <td>
                                    <span class="fw-bold text-success">{{ $card['bank_name'] ?? '' }}</span>
                                </td>
                                <td>{{ $card['account_name'] ?? '' }}</td>
                                <td>
                                    <code class="bg-light px-2 py-1 rounded">{{ $card['account_number'] ?? '' }}</code>
                                </td>
                                <td>{{ $card['branch_code'] ?? '' }}</td>
                                <td>
                                    <code class="bg-light px-2 py-1 rounded">{{ $card['swift_code'] ?? '' }}</code>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-outline-warning btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editSupportModal{{ $idx }}"
                                                title="Edit Bank Account">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="remove_card" value="{{ $idx }}">
                                            <button type="submit" 
                                                    class="btn btn-outline-danger btn-sm" 
                                                    onclick="return confirm('Are you sure you want to remove this bank account?')"
                                                    title="Remove Bank Account">
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
                <i class="bi bi-info-circle me-2"></i>No bank accounts available. Click "Add Bank Account" to get started.
            </div>
        @endif
    </div>
</div>

<!-- Add Bank Account Modal -->
<div class="modal fade" id="addSupportModal" tabindex="-1" aria-labelledby="addSupportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="add_card" value="1">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSupportModalLabel">Add Bank Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Bank Name</label>
                        <input type="text" class="form-control" name="bank_name" placeholder="e.g., Bank Mandiri" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Account Name</label>
                        <input type="text" class="form-control" name="account_name" placeholder="e.g., Yayasan Colin Barlow Ria" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Account Number</label>
                        <input type="text" class="form-control" name="account_number" placeholder="e.g., 181-00-0220381-9" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Branch Code</label>
                        <input type="text" class="form-control" name="branch_code" placeholder="e.g., KC ATAMBUA 18102" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">SWIFT Code</label>
                        <input type="text" class="form-control" name="swift_code" placeholder="e.g., BMRIIDJA" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Add Bank Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Bank Account Modals -->
@foreach($cards as $idx => $card)
    <div class="modal fade" id="editSupportModal{{ $idx }}" tabindex="-1" aria-labelledby="editSupportModalLabel{{ $idx }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.home_sections.update', $section->section_key) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="edit_card" value="{{ $idx }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSupportModalLabel{{ $idx }}">Edit Bank Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Bank Name</label>
                            <input type="text" class="form-control" name="bank_name" value="{{ $card['bank_name'] ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Account Name</label>
                            <input type="text" class="form-control" name="account_name" value="{{ $card['account_name'] ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Account Number</label>
                            <input type="text" class="form-control" name="account_number" value="{{ $card['account_number'] ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Branch Code</label>
                            <input type="text" class="form-control" name="branch_code" value="{{ $card['branch_code'] ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">SWIFT Code</label>
                            <input type="text" class="form-control" name="swift_code" value="{{ $card['swift_code'] ?? '' }}" required>
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