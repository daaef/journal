@extends('dashboard.user.layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Version Comparison</h6>
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
            <li class="fw-medium">Version Comparison</li>
        </ul>
    </div>

    <div class="row gy-4">
        <!-- Comparison Overview -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center mb-20">
                        <div class="col-md-8">
                            <h5 class="mb-8">{{ $journal->title }}</h5>
                            <p class="text-gray-600 mb-12">
                                Comparing <strong>Version {{ $comparison['metadata']['older_version']['version_number'] }}</strong> 
                                ({{ \Carbon\Carbon::parse($comparison['metadata']['older_version']['created_at'])->format('M d, Y \a\t g:i A') }})
                                with <strong>Version {{ $comparison['metadata']['newer_version']['version_number'] }}</strong>
                                ({{ \Carbon\Carbon::parse($comparison['metadata']['newer_version']['created_at'])->format('M d, Y \a\t g:i A') }})
                            </p>
                            <div class="d-flex flex-wrap gap-2 mb-12">
                                <span class="badge bg-primary-100 text-primary-600 px-12 py-6">
                                    <i class="ph ph-plus-circle me-8"></i>{{ $comparison['statistics']['additions'] }} additions
                                </span>
                                <span class="badge bg-danger-100 text-danger-600 px-12 py-6">
                                    <i class="ph ph-minus-circle me-8"></i>{{ $comparison['statistics']['deletions'] }} deletions
                                </span>
                                <span class="badge bg-warning-100 text-warning-600 px-12 py-6">
                                    <i class="ph ph-arrow-clockwise me-8"></i>{{ $comparison['statistics']['modifications'] }} changes
                                </span>
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
                                        <a class="dropdown-item" href="{{ route('manuscript.version.show', [$journal->uuid, $comparison['metadata']['older_version']['id']]) }}">
                                            <i class="ph ph-eye me-8"></i>View Version {{ $comparison['metadata']['older_version']['version_number'] }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('manuscript.version.show', [$journal->uuid, $comparison['metadata']['newer_version']['id']]) }}">
                                            <i class="ph ph-eye me-8"></i>View Version {{ $comparison['metadata']['newer_version']['version_number'] }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Title Changes -->
        @if(isset($comparison['title_diff']) && $comparison['title_diff'])
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-16 d-flex align-items-center">
                        <i class="ph ph-text-aa text-primary me-8"></i>Title Changes
                    </h6>
                    <div class="diff-container">
                        {!! $comparison['title_diff'] !!}
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Abstract Changes -->
        @if(isset($comparison['abstract_diff']) && $comparison['abstract_diff'])
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-16 d-flex align-items-center">
                        <i class="ph ph-file-text text-primary me-8"></i>Abstract Changes
                    </h6>
                    <div class="diff-container">
                        {!! $comparison['abstract_diff'] !!}
                    </div>
                </div>
            </div>
        </div>
        @endif        <!-- Content Changes -->
        @if(isset($comparison['content_diff']) && $comparison['content_diff'])
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-16 d-flex align-items-center">
                        <i class="ph ph-article text-primary me-8"></i>Content Changes
                    </h6>
                    <div class="diff-container">
                        {!! $comparison['content_diff'] !!}
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- File Comparison -->
        @if(isset($comparison['file_comparison']) && $comparison['file_comparison']['has_files'])
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-16 d-flex align-items-center">
                        <i class="ph ph-file-pdf text-primary me-8"></i>File Comparison
                    </h6>
                    
                    @if($comparison['file_comparison']['files_identical'])
                        <div class="alert alert-success">
                            <i class="ph ph-check-circle me-8"></i>
                            The PDF files are identical between these versions.
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="ph ph-info me-8"></i>
                            The PDF files are different between these versions.
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="border rounded-8 p-16">
                                <h6 class="text-14 mb-12 text-muted">Version {{ $comparison['file_comparison']['other_file']['version'] }} File</h6>
                                <div class="d-flex align-items-center gap-12 mb-12">
                                    <i class="ph ph-file-pdf text-danger text-24"></i>
                                    <div>
                                        <p class="mb-4 fw-medium">{{ basename($comparison['file_comparison']['other_file']['path']) }}</p>
                                        <p class="text-12 text-gray-600 mb-0">{{ $comparison['file_comparison']['other_file']['size_human'] }}</p>
                                    </div>
                                </div>
                                <a href="{{ $comparison['file_comparison']['other_file']['url'] }}" 
                                   target="_blank" class="action-btn action-btn-outline-primary action-btn-sm w-100">
                                    <i class="ph ph-eye me-8"></i>View File
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded-8 p-16">
                                <h6 class="text-14 mb-12 text-muted">Version {{ $comparison['file_comparison']['current_file']['version'] }} File</h6>
                                <div class="d-flex align-items-center gap-12 mb-12">
                                    <i class="ph ph-file-pdf text-danger text-24"></i>
                                    <div>
                                        <p class="mb-4 fw-medium">{{ basename($comparison['file_comparison']['current_file']['path']) }}</p>
                                        <p class="text-12 text-gray-600 mb-0">{{ $comparison['file_comparison']['current_file']['size_human'] }}</p>
                                    </div>
                                </div>
                                <a href="{{ $comparison['file_comparison']['current_file']['url'] }}" 
                                   target="_blank" class="action-btn action-btn-outline-primary action-btn-sm w-100">
                                    <i class="ph ph-eye me-8"></i>View File
                                </a>
                            </div>
                        </div>
                    </div>

                    @if($comparison['file_comparison']['size_difference'] != 0)
                        <div class="mt-16">
                            <small class="text-muted">
                                <i class="ph ph-info me-8"></i>
                                Size difference: 
                                @if($comparison['file_comparison']['size_difference'] > 0)
                                    <span class="text-success">+{{ $comparison['file_comparison']['size_difference_human'] }}</span>
                                @else
                                    <span class="text-danger">-{{ $comparison['file_comparison']['size_difference_human'] }}</span>
                                @endif
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @elseif(isset($comparison['file_comparison']) && !$comparison['file_comparison']['has_files'])
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-16 d-flex align-items-center">
                        <i class="ph ph-file-pdf text-primary me-8"></i>File Comparison
                    </h6>
                    <div class="alert alert-warning">
                        <i class="ph ph-warning me-8"></i>
                        {{ $comparison['file_comparison']['message'] }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Side by Side Comparison -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-16">
                        <h6 class="mb-0 d-flex align-items-center">
                            <i class="ph ph-columns text-primary me-8"></i>Side-by-Side Comparison
                        </h6>
                        <div class="btn-group btn-group-sm" role="group">
                            <input type="radio" class="btn-check" name="compareMode" id="titleMode" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="titleMode">Title</label>

                            <input type="radio" class="btn-check" name="compareMode" id="abstractMode" autocomplete="off">
                            <label class="btn btn-outline-primary" for="abstractMode">Abstract</label>

                            <input type="radio" class="btn-check" name="compareMode" id="contentMode" autocomplete="off">
                            <label class="btn btn-outline-primary" for="contentMode">Content</label>
                        </div>
                    </div>
                    
                    <!-- Title Side-by-Side -->
                    <div class="compare-section" id="titleCompare">
                        @if(isset($comparison['title_side_by_side']))
                            {!! $comparison['title_side_by_side'] !!}
                        @else
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="bg-light p-16 rounded-8">
                                        <h6 class="text-14 mb-8 text-muted">Version {{ $comparison['metadata']['older_version']['version_number'] }}</h6>
                                        <p class="mb-0">{{ $comparison['metadata']['older_version']['title'] ?? 'No title' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light p-16 rounded-8">
                                        <h6 class="text-14 mb-8 text-muted">Version {{ $comparison['metadata']['newer_version']['version_number'] }}</h6>
                                        <p class="mb-0">{{ $comparison['metadata']['newer_version']['title'] ?? 'No title' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Abstract Side-by-Side -->
                    <div class="compare-section d-none" id="abstractCompare">
                        @if(isset($comparison['abstract_side_by_side']))
                            {!! $comparison['abstract_side_by_side'] !!}
                        @else
                            <div class="row">                                <div class="col-md-6">
                                    <div class="bg-light p-16 rounded-8">
                                        <h6 class="text-14 mb-8 text-muted">Version {{ $comparison['metadata']['older_version']['version_number'] }}</h6>
                                        <div class="content-preview">{!! Str::limit($comparison['metadata']['older_version']['abstract'] ?? 'No abstract', 500) !!}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light p-16 rounded-8">
                                        <h6 class="text-14 mb-8 text-muted">Version {{ $comparison['metadata']['newer_version']['version_number'] }}</h6>
                                        <div class="content-preview">{!! Str::limit($comparison['metadata']['newer_version']['abstract'] ?? 'No abstract', 500) !!}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Content Side-by-Side -->
                    <div class="compare-section d-none" id="contentCompare">
                        @if(isset($comparison['content_side_by_side']))
                            {!! $comparison['content_side_by_side'] !!}
                        @else
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="bg-light p-16 rounded-8" style="max-height: 500px; overflow-y: auto;">
                                        <h6 class="text-14 mb-8 text-muted">Version {{ $comparison['metadata']['older_version']['version_number'] }}</h6>
                                        <div class="content-preview">{!! Str::limit($comparison['metadata']['older_version']['content'] ?? 'No content', 2000) !!}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light p-16 rounded-8" style="max-height: 500px; overflow-y: auto;">
                                        <h6 class="text-14 mb-8 text-muted">Version {{ $comparison['metadata']['newer_version']['version_number'] }}</h6>
                                        <div class="content-preview">{!! Str::limit($comparison['metadata']['newer_version']['content'] ?? 'No content', 2000) !!}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Diff Styling */
.diff-container {
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
    font-size: 13px;
    line-height: 1.6;
    background: #f8f9fa;
    border-radius: 8px;
    padding: 16px;
    overflow-x: auto;
}

.diff-container ins {
    background-color: #d4edda;
    color: #155724;
    text-decoration: none;
    padding: 2px 4px;
    border-radius: 3px;
}

.diff-container del {
    background-color: #f8d7da;
    color: #721c24;
    text-decoration: line-through;
    padding: 2px 4px;
    border-radius: 3px;
}

.diff-container .context {
    color: #6c757d;
}

/* Side-by-side diff styling */
.diff-container table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.diff-container td {
    padding: 4px 8px;
    vertical-align: top;
    border: 1px solid #dee2e6;
}

.diff-container .diff-deletedline {
    background-color: #ffecec;
}

.diff-container .diff-addedline {
    background-color: #eaffea;
}

.diff-container .diff-context {
    background-color: #f8f9fa;
}

.content-preview {
    white-space: pre-wrap;
    word-wrap: break-word;
    font-size: 14px;
    line-height: 1.6;
}

.compare-section {
    transition: all 0.3s ease;
}

/* Statistics badges */
.badge {
    font-size: 12px;
    font-weight: 500;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .diff-container {
        font-size: 12px;
        padding: 12px;
    }
    
    .content-preview {
        font-size: 13px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle comparison mode switching
    const modeButtons = document.querySelectorAll('input[name="compareMode"]');
    const compareSections = document.querySelectorAll('.compare-section');
    
    modeButtons.forEach(button => {
        button.addEventListener('change', function() {
            // Hide all sections
            compareSections.forEach(section => {
                section.classList.add('d-none');
            });
            
            // Show selected section
            const targetId = this.id.replace('Mode', 'Compare');
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                targetSection.classList.remove('d-none');
            }
        });
    });
});
</script>
@endsection
