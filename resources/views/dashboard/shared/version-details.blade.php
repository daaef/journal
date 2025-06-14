@extends('dashboard.user.layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Version Details</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-main">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('manuscript.versions', $journal->uuid) }}" class="hover-text-main">
                    {{ $journal->title }}
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Version {{ $versionDetails['version_number'] }}</li>
        </ul>
    </div>

    <div class="row gy-4">
        <!-- Version Information -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center gap-12 mb-12">
                                <h5 class="mb-0">Version {{ $versionDetails['version_number'] }}</h5>
                                @if($versionDetails['status'] === 'reverted')
                                    <span class="badge bg-warning text-white">Reverted</span>
                                @elseif($versionDetails['status'] === 'current')
                                    <span class="badge bg-success text-white">Current</span>
                                @else
                                    <span class="badge bg-secondary text-white">{{ ucfirst($versionDetails['status']) }}</span>
                                @endif
                            </div>
                            <div class="mb-16">
                                <p class="text-gray-600 mb-8">
                                    <i class="ph ph-user me-8"></i>
                                    <strong>Author:</strong> {{ $versionDetails['author'] }}
                                </p>
                                <p class="text-gray-600 mb-8">
                                    <i class="ph ph-calendar me-8"></i>
                                    <strong>Created:</strong> {{ \Carbon\Carbon::parse($versionDetails['created_at'])->format('M d, Y \a\t g:i A') }}
                                </p>
                                @if($versionDetails['file_path'])
                                    <p class="text-gray-600 mb-0">
                                        <i class="ph ph-file-pdf me-8"></i>
                                        <strong>File:</strong> 
                                        <a href="{{ asset('storage/' . $versionDetails['file_path']) }}" 
                                           target="_blank" class="text-primary hover-text-primary-600">
                                            View PDF Document
                                        </a>
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('manuscript.versions', $journal->uuid) }}" 
                               class="btn btn-outline-main btn-sm me-8">
                                <i class="ph ph-arrow-left me-8"></i>Back to History
                            </a>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-main btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="ph ph-gear me-8"></i>Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="compareWithCurrent({{ $versionDetails['id'] }}, {{ $versionDetails['version_number'] }})">
                                            <i class="ph ph-git-diff me-8"></i>Compare with Current
                                        </a>
                                    </li>
                                    @if(auth()->user()->hasAnyRole(['Editor in Chief', 'Managing Editor']) || $journal->user_id === auth()->id())
                                        @if($versionDetails['status'] !== 'current')
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item text-warning" href="#" onclick="revertToVersion({{ $versionDetails['id'] }}, {{ $versionDetails['version_number'] }})">
                                                    <i class="ph ph-arrow-counter-clockwise me-8"></i>Revert to This Version
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Changes Summary -->
        @if($versionDetails['changes_summary'])
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-16 d-flex align-items-center">
                        <i class="ph ph-list-bullets text-primary me-8"></i>Changes Summary
                    </h6>
                    <div class="bg-gray-50 p-16 rounded-8">
                        <p class="mb-0 text-14 lh-lg">{{ $versionDetails['changes_summary'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Revision Notes -->
        @if($versionDetails['revision_notes'])
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-16 d-flex align-items-center text-blue-600">
                        <i class="ph ph-note text-blue-600 me-8"></i>Revision Notes
                    </h6>
                    <div class="bg-blue-50 p-16 rounded-8">
                        <p class="mb-0 text-14 lh-lg">{{ $versionDetails['revision_notes'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Manuscript Content -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-16">
                        <h6 class="mb-0 d-flex align-items-center">
                            <i class="ph ph-article text-primary me-8"></i>Manuscript Content
                        </h6>
                        <div class="btn-group btn-group-sm" role="group">
                            <input type="radio" class="btn-check" name="contentView" id="titleView" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="titleView">Title</label>

                            <input type="radio" class="btn-check" name="contentView" id="abstractView" autocomplete="off">
                            <label class="btn btn-outline-primary" for="abstractView">Abstract</label>

                            <input type="radio" class="btn-check" name="contentView" id="fullContentView" autocomplete="off">
                            <label class="btn btn-outline-primary" for="fullContentView">Full Content</label>
                        </div>
                    </div>

                    <!-- Title Section -->
                    <div class="content-section" id="titleSection">
                        <div class="border-bottom pb-16 mb-16">
                            <h6 class="text-14 mb-8 text-muted">Title</h6>
                            <h4 class="mb-0 fw-semibold lh-base">{{ $versionDetails['title'] ?? 'No title provided' }}</h4>
                        </div>
                    </div>

                    <!-- Abstract Section -->
                    <div class="content-section d-none" id="abstractSection">
                        <div class="border-bottom pb-16 mb-16">
                            <h6 class="text-14 mb-12 text-muted">Abstract</h6>
                            <div class="abstract-content">
                                @if($versionDetails['abstract'])
                                    <div class="text-14 lh-lg">{!! nl2br(e($versionDetails['abstract'])) !!}</div>
                                @else
                                    <p class="text-gray-500 fst-italic">No abstract provided</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Full Content Section -->
                    <div class="content-section d-none" id="fullContentSection">
                        <div class="manuscript-content">
                            @if($versionDetails['content'])
                                <div class="content-viewer">
                                    {!! $versionDetails['content'] !!}
                                </div>
                            @else
                                <div class="text-center py-40">
                                    <i class="ph ph-file-text text-gray-400 text-64 mb-16"></i>
                                    <h6 class="text-gray-600 mb-8">No Content Available</h6>
                                    <p class="text-gray-500">The manuscript content is not available for this version.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Version Tree -->
        @if(isset($versionDetails['version_tree']) && count($versionDetails['version_tree']) > 0)
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-16 d-flex align-items-center">
                        <i class="ph ph-tree-structure text-primary me-8"></i>Version Relationships
                    </h6>
                    <div class="version-tree">
                        @foreach($versionDetails['version_tree'] as $treeVersion)
                            <div class="tree-item {{ $treeVersion['id'] == $versionDetails['id'] ? 'current-version' : '' }}">
                                <div class="d-flex align-items-center gap-12">
                                    <div class="tree-icon">
                                        @if($treeVersion['id'] == $versionDetails['id'])
                                            <i class="ph ph-check-circle text-success"></i>
                                        @else
                                            <i class="ph ph-circle text-gray-400"></i>
                                        @endif
                                    </div>
                                    <div class="tree-content">
                                        <span class="fw-medium">Version {{ $treeVersion['version_number'] }}</span>
                                        <span class="text-gray-600 ms-8">
                                            {{ \Carbon\Carbon::parse($treeVersion['created_at'])->format('M d, Y') }}
                                        </span>
                                    </div>
                                    @if($treeVersion['id'] != $versionDetails['id'])
                                        <div class="tree-actions ms-auto">
                                            <a href="{{ route('manuscript.version.show', [$journal->uuid, $treeVersion['id']]) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Compare with Current Modal -->
<div class="modal fade" id="compareModal" tabindex="-1" aria-labelledby="compareModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="compareModalLabel">Compare Versions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>You are about to compare <strong>Version <span id="compareVersionNumber"></span></strong> with the current version.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-main" id="confirmCompareBtn">Compare Versions</button>
            </div>
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
.content-viewer {
    font-size: 14px;
    line-height: 1.8;
    color: #333;
    max-height: 600px;
    overflow-y: auto;
    padding: 16px;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    background: #fff;
}

.content-viewer h1, .content-viewer h2, .content-viewer h3, 
.content-viewer h4, .content-viewer h5, .content-viewer h6 {
    margin-top: 24px;
    margin-bottom: 12px;
    font-weight: 600;
}

.content-viewer p {
    margin-bottom: 16px;
    text-align: justify;
}

.content-viewer ul, .content-viewer ol {
    margin-bottom: 16px;
    padding-left: 24px;
}

.content-viewer blockquote {
    margin: 16px 0;
    padding: 12px 16px;
    border-left: 4px solid #e9ecef;
    background: #f8f9fa;
    font-style: italic;
}

.abstract-content {
    font-size: 15px;
    line-height: 1.7;
    text-align: justify;
    color: #495057;
}

.content-section {
    transition: all 0.3s ease;
}

.version-tree {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 16px;
}

.tree-item {
    padding: 12px 0;
    border-bottom: 1px solid #e9ecef;
    transition: background-color 0.2s ease;
}

.tree-item:last-child {
    border-bottom: none;
}

.tree-item.current-version {
    background: #e7f3ff;
    border-radius: 6px;
    padding: 12px;
    margin-bottom: 8px;
}

.tree-item:hover:not(.current-version) {
    background: #f1f3f4;
    border-radius: 6px;
    padding: 12px;
}

.tree-icon {
    width: 20px;
    text-align: center;
}

.bg-blue-50 {
    background-color: #e7f3ff;
}

.text-blue-600 {
    color: #0066cc;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .content-viewer {
        font-size: 13px;
        padding: 12px;
        max-height: 400px;
    }
    
    .abstract-content {
        font-size: 14px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle content view switching
    const viewButtons = document.querySelectorAll('input[name="contentView"]');
    const contentSections = document.querySelectorAll('.content-section');
    
    viewButtons.forEach(button => {
        button.addEventListener('change', function() {
            // Hide all sections
            contentSections.forEach(section => {
                section.classList.add('d-none');
            });
            
            // Show selected section
            const targetId = this.id.replace('View', 'Section');
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                targetSection.classList.remove('d-none');
            }
        });
    });
    
    // Enable/disable revert button based on confirmation
    const confirmRevertCheckbox = document.getElementById('confirmRevert');
    const confirmRevertBtn = document.getElementById('confirmRevertBtn');
    
    if (confirmRevertCheckbox && confirmRevertBtn) {
        confirmRevertCheckbox.addEventListener('change', function() {
            confirmRevertBtn.disabled = !this.checked;
        });
    }
});

function compareWithCurrent(versionId, versionNumber) {
    // Find current version ID from the history
    const currentVersionId = {{ $versionDetails['journal']['current_version_id'] ?? 'null' }};
    
    if (currentVersionId) {
        const url = new URL('{{ route("manuscript.version.compare", $journal->uuid) }}');
        url.searchParams.set('version1', versionId);
        url.searchParams.set('version2', currentVersionId);
        window.location.href = url.toString();
    } else {
        // Fallback: show modal and let user confirm
        document.getElementById('compareVersionNumber').textContent = versionNumber;
        const compareModal = new bootstrap.Modal(document.getElementById('compareModal'));
        compareModal.show();
        
        document.getElementById('confirmCompareBtn').onclick = function() {
            window.location.href = '{{ route("manuscript.versions", $journal->uuid) }}';
        };
    }
}

function revertToVersion(versionId, versionNumber) {
    document.getElementById('revertVersionId').value = versionId;
    document.getElementById('revertVersionNumber').textContent = 'Version ' + versionNumber;
    
    const revertModal = new bootstrap.Modal(document.getElementById('revertModal'));
    revertModal.show();
}
</script>
@endsection
