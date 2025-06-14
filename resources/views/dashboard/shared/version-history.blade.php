@extends('dashboard.user.layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Version History</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-main">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">{{ $journal->title }}</li>
            <li>-</li>
            <li class="fw-medium">Version History</li>
        </ul>
    </div>

    <div class="row gy-4">
        <!-- Manuscript Overview -->
        <div class="col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="mb-8">{{ $journal->title }}</h5>
                            <div class="d-flex flex-wrap gap-3 mb-12">
                                <span class="badge bg-primary-100 text-primary-600 px-12 py-6">
                                    {{ $journal->category->name ?? 'Uncategorized' }}
                                </span>
                                @if($journal->sub_category)
                                    <span class="badge bg-secondary-100 text-secondary-600 px-12 py-6">
                                        {{ $journal->sub_category->name }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-gray-600 mb-12">
                                <strong>Current Status:</strong> 
                                <span class="badge 
                                    @if($journal->approval_status === 'approved') bg-success
                                    @elseif($journal->approval_status === 'reviewed') bg-info
                                    @elseif($journal->approval_status === 'in-progress') bg-warning
                                    @elseif($journal->approval_status === 'pending') bg-secondary
                                    @else bg-danger
                                    @endif
                                    text-white ms-8">
                                    {{ ucfirst(str_replace('-', ' ', $journal->approval_status)) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="mb-12">
                                <span class="text-gray-600">Total Versions:</span>
                                <span class="fw-bold text-main ms-8">{{ $versionHistory->count() }}</span>
                            </div>
                            <a href="{{ route('manuscript.feedback', $journal->uuid) }}" 
                               class="btn btn-outline-main btn-sm me-8">
                                <i class="ph ph-chat-circle me-8"></i>View Feedback
                            </a>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-main btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="ph ph-gear me-8"></i>Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#compareModal">
                                        <i class="ph ph-git-diff me-8"></i>Compare Versions
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Version Timeline -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-20">Version Timeline</h6>
                    
                    @if($versionHistory->count() > 0)
                        <div class="version-timeline">
                            @foreach($versionHistory as $index => $version)
                                <div class="timeline-item {{ $index === 0 ? 'current' : '' }}" data-version-id="{{ $version['id'] }}">
                                    <div class="timeline-marker">
                                        @if($index === 0)
                                            <i class="ph ph-check-circle text-success"></i>
                                        @elseif($version['status'] === 'reverted')
                                            <i class="ph ph-arrow-counter-clockwise text-warning"></i>
                                        @else
                                            <i class="ph ph-circle text-gray-400"></i>
                                        @endif
                                    </div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start mb-8">
                                            <div>
                                                <h6 class="mb-4">
                                                    Version {{ $version['version_number'] }}
                                                    @if($index === 0)
                                                        <span class="badge bg-success text-white ms-8">Current</span>
                                                    @endif
                                                    @if($version['status'] === 'reverted')
                                                        <span class="badge bg-warning text-white ms-8">Reverted</span>
                                                    @endif
                                                </h6>
                                                <p class="text-gray-600 text-13 mb-8">
                                                    By {{ $version['author'] }} • {{ \Carbon\Carbon::parse($version['created_at'])->format('M d, Y \a\t g:i A') }}
                                                </p>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-gray-400 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="ph ph-dots-three"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('manuscript.version.show', [$journal->uuid, $version['id']]) }}">
                                                            <i class="ph ph-eye me-8"></i>View Details
                                                        </a>
                                                    </li>
                                                    @if($index !== 0)
                                                        <li>
                                                            <a class="dropdown-item compare-version" href="#" 
                                                               data-version-id="{{ $version['id'] }}" 
                                                               data-version-number="{{ $version['version_number'] }}">
                                                                <i class="ph ph-git-diff me-8"></i>Compare with Current
                                                            </a>
                                                        </li>
                                                        @if(auth()->user()->hasAnyRole(['Editor in Chief', 'Managing Editor']) || $journal->user_id === auth()->id())
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item text-warning revert-version" href="#" 
                                                                   data-version-id="{{ $version['id'] }}" 
                                                                   data-version-number="{{ $version['version_number'] }}">
                                                                    <i class="ph ph-arrow-counter-clockwise me-8"></i>Revert to This Version
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        @if($version['changes_summary'])
                                            <div class="bg-gray-50 p-12 rounded-8 mb-12">
                                                <h6 class="text-14 mb-8">Changes Summary</h6>
                                                <p class="mb-0 text-14">{{ $version['changes_summary'] }}</p>
                                            </div>
                                        @endif
                                        
                                        @if($version['revision_notes'])
                                            <div class="bg-blue-50 p-12 rounded-8">
                                                <h6 class="text-14 mb-8 text-blue-600">Revision Notes</h6>
                                                <p class="mb-0 text-14">{{ $version['revision_notes'] }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-40">
                            <i class="ph ph-file-text text-gray-400 text-64 mb-16"></i>
                            <h6 class="text-gray-600 mb-8">No Version History</h6>
                            <p class="text-gray-500">Version history will appear here as you make revisions to your manuscript.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Compare Versions Modal -->
<div class="modal fade" id="compareModal" tabindex="-1" aria-labelledby="compareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="compareModalLabel">Compare Versions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('manuscript.version.compare', $journal->uuid) }}" method="GET">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="version1" class="form-label">From Version</label>
                            <select name="version1" id="version1" class="form-select" required>
                                <option value="">Select version...</option>
                                @foreach($versionHistory as $version)
                                    <option value="{{ $version['id'] }}">Version {{ $version['version_number'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="version2" class="form-label">To Version</label>
                            <select name="version2" id="version2" class="form-select" required>
                                <option value="">Select version...</option>
                                @foreach($versionHistory as $version)
                                    <option value="{{ $version['id'] }}">Version {{ $version['version_number'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-main">Compare Versions</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Revert Confirmation Modal -->
<div class="modal fade" id="revertModal" tabindex="-1" aria-labelledby="revertModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-warning" id="revertModalLabel">
                    <i class="ph ph-warning me-8"></i>Confirm Revert
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('manuscript.version.revert', $journal->uuid) }}" method="POST" id="revertForm">
                @csrf
                <input type="hidden" name="version_id" id="revertVersionId">
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h6 class="alert-heading">Warning!</h6>
                        <p class="mb-0">You are about to revert the manuscript to <strong id="revertVersionNumber"></strong>. This will create a new version based on the selected version and cannot be undone.</p>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="confirm" value="1" id="confirmRevert" required>
                        <label class="form-check-label" for="confirmRevert">
                            I understand that this action will create a new version and cannot be undone
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning" id="confirmRevertBtn" disabled>
                        <i class="ph ph-arrow-counter-clockwise me-8"></i>Revert to Version
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .version-timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .version-timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }
    
    .timeline-item.current .timeline-content {
        border-left: 3px solid #28a745;
        background: #f8fff9;
    }
    
    .timeline-marker {
        position: absolute;
        left: -22px;
        top: 0;
        width: 16px;
        height: 16px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
    
    .timeline-content {
        background: #f8f9fa;
        padding: 16px;
        border-radius: 8px;
        border-left: 3px solid #dee2e6;
    }
    
    .bg-blue-50 {
        background-color: #e7f3ff;
    }
    
    .text-blue-600 {
        color: #0066cc;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Compare version functionality
    document.querySelectorAll('.compare-version').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const versionId = this.getAttribute('data-version-id');
            const currentVersionId = document.querySelector('.timeline-item.current').getAttribute('data-version-id');
            
            // Set up comparison with current version
            document.getElementById('version1').value = versionId;
            document.getElementById('version2').value = currentVersionId;
            
            // Show comparison modal
            const compareModal = new bootstrap.Modal(document.getElementById('compareModal'));
            compareModal.show();
        });
    });
    
    // Revert version functionality
    document.querySelectorAll('.revert-version').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const versionId = this.getAttribute('data-version-id');
            const versionNumber = this.getAttribute('data-version-number');
            
            document.getElementById('revertVersionId').value = versionId;
            document.getElementById('revertVersionNumber').textContent = 'Version ' + versionNumber;
            
            const revertModal = new bootstrap.Modal(document.getElementById('revertModal'));
            revertModal.show();
        });
    });
    
    // Enable/disable revert button based on confirmation
    document.getElementById('confirmRevert').addEventListener('change', function() {
        document.getElementById('confirmRevertBtn').disabled = !this.checked;
    });
});
</script>
@endsection
