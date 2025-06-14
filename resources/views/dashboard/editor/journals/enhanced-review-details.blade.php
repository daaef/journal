@extends('dashboard.editor.layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Enhanced Review Details</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('editor.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-main">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Enhanced Review Details</li>
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
                                <strong>Author:</strong> {{ $journal->author->fullname ?? 'Unknown' }}
                            </p>                        </div>
                        <div class="col-md-4 text-end">
                            <div class="mb-12">
                                <span class="text-gray-600">Status:</span>
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
                            </div>
                            <a href="{{ route('editor.journals.preview', [$journal->uuid, $journal->slug]) }}" 
                               class="btn btn-outline-main btn-sm">
                                <i class="ph ph-eye me-8"></i>View Manuscript
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Reader Section -->
        @if($journal->journal_url)
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">
                                <i class="ph ph-file-pdf me-8"></i>Manuscript Document Reader
                            </h6>
                            <small class="text-gray-600">Review the manuscript directly in your browser</small>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" onclick="openDetailsFullscreen()" 
                                    class="btn btn-sm btn-outline-primary"
                                    title="Open in fullscreen">
                                <i class="ph ph-corners-out"></i>
                            </button>
                            <button type="button" onclick="resizeDetailsViewer('expand')" 
                                    class="btn btn-sm btn-outline-primary"
                                    title="Expand viewer">
                                <i class="ph ph-arrows-out"></i>
                            </button>
                            <button type="button" onclick="resizeDetailsViewer('shrink')" 
                                    class="btn btn-sm btn-outline-primary"
                                    title="Shrink viewer">
                                <i class="ph ph-arrows-in"></i>
                            </button>
                            <a href="{{ asset('storage/' . $journal->journal_url) }}" target="_blank"
                               class="btn btn-sm btn-outline-success"
                               title="Open in new tab">
                                <i class="ph ph-arrow-square-out"></i>
                            </a>
                            <a href="{{ asset('storage/' . $journal->journal_url) }}" download
                               class="btn btn-sm btn-outline-info"
                               title="Download PDF">
                                <i class="ph ph-download-simple"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="bg-light px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="ph ph-lightbulb me-1"></i>
                            <strong>Tip:</strong> Use Ctrl+F to search within the document
                        </small>
                        <small class="text-muted">
                            <i class="ph ph-info me-1"></i>
                            File: {{ basename($journal->journal_url) }}
                        </small>
                    </div>
                    
                    <!-- PDF Viewer -->
                    <iframe id="detailsPdfViewer" 
                            src="{{ asset('storage/' . $journal->journal_url) }}#toolbar=1&navpanes=1&scrollbar=1" 
                            style="width: 100%; height: 600px; border: none; background: #f8f9fa;"
                            loading="lazy"
                            title="Manuscript PDF Viewer">
                        <div class="p-4 text-center">
                            <div class="alert alert-warning">
                                <i class="ph ph-warning-circle me-2"></i>
                                <strong>PDF Preview Not Available</strong>
                                <p class="mb-3">Your browser does not support embedded PDFs.</p>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ asset('storage/' . $journal->journal_url) }}" target="_blank" 
                                       class="btn btn-primary">
                                        <i class="ph ph-arrow-square-out me-2"></i>Open in New Tab
                                    </a>
                                    <a href="{{ asset('storage/' . $journal->journal_url) }}" download
                                       class="btn btn-success">
                                        <i class="ph ph-download-simple me-2"></i>Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </iframe>
                </div>
            </div>
        </div>
        @endif

        <!-- Review Statistics -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="mb-16">Review Statistics</h6>
                    <div class="text-center mb-20">
                        <div class="text-48 fw-bold text-main mb-8">{{ number_format($averageRating, 1) }}</div>
                        <div class="star-display mb-8">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= round($averageRating) ? 'filled' : '' }}">★</span>
                            @endfor
                        </div>
                        <p class="text-gray-600 mb-0">Average Rating from {{ $totalReviews }} review{{ $totalReviews !== 1 ? 's' : '' }}</p>
                    </div>
                    
                    <div class="recommendation-summary">
                        <h6 class="text-14 mb-12">Recommendations</h6>
                        @foreach($recommendationCounts as $rec => $count)
                            @if($count > 0)
                                <div class="d-flex justify-content-between align-items-center mb-8">
                                    <span class="badge 
                                        @if($rec === 'accept') bg-success
                                        @elseif($rec === 'minor_revisions') bg-warning
                                        @elseif($rec === 'major_revisions') bg-orange
                                        @else bg-danger
                                        @endif
                                        text-white">
                                        {{ ucfirst(str_replace('_', ' ', $rec)) }}
                                    </span>
                                    <span class="fw-medium">{{ $count }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Criteria Average Ratings -->
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="mb-16">Criteria Average Ratings</h6>
                    <div class="row gy-3">
                        @foreach($reviewCriteria as $key => $label)
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-8">
                                    <span class="text-14 fw-medium">{{ $label }}</span>
                                    <span class="text-main fw-semibold">{{ number_format($criteriaAverages[$key], 1) }}</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-main" style="width: {{ ($criteriaAverages[$key] / 5) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Individual Reviews -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-20">Individual Review Details</h6>
                    
                    @if($reviewsData->count() > 0)
                        @foreach($reviewsData as $index => $review)
                            <div class="review-item p-20 rounded-12 {{ $index < $reviewsData->count() - 1 ? 'mb-20' : '' }}" 
                                 style="background: #f8f9fa; border-left: 4px solid #007bff;">
                                
                                <!-- Reviewer Info -->
                                <div class="d-flex justify-content-between align-items-start mb-16">
                                    <div>
                                        <h6 class="mb-4">{{ $review->reviewer->fullname }}</h6>
                                        <p class="text-gray-600 text-13 mb-0">
                                            Submitted on {{ \Carbon\Carbon::parse($review->submitted_at)->format('M d, Y \a\t g:i A') }}
                                        </p>
                                    </div>
                                    <div class="text-end">
                                        <!-- Overall Rating -->
                                        <div class="star-display mb-8">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">★</span>
                                            @endfor
                                        </div>
                                        <!-- Recommendation Badge -->
                                        <span class="badge 
                                            @if($review->recommendation === 'accept') bg-success
                                            @elseif($review->recommendation === 'minor_revisions') bg-warning
                                            @elseif($review->recommendation === 'major_revisions') bg-orange
                                            @else bg-danger
                                            @endif
                                            text-white">
                                            {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Criteria Ratings -->
                                @if(!empty($review->criteria_ratings))
                                    <div class="mb-16">
                                        <h6 class="text-14 mb-12">Criteria Ratings</h6>
                                        <div class="row gy-2">
                                            @foreach($reviewCriteria as $key => $label)
                                                @if(isset($review->criteria_ratings[$key]) && $review->criteria_ratings[$key] > 0)
                                                    <div class="col-md-6">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="text-13">{{ $label }}</span>
                                                            <div class="star-display small">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <span class="star {{ $i <= $review->criteria_ratings[$key] ? 'filled' : '' }}">★</span>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Public Comments -->
                                <div class="mb-16">
                                    <h6 class="text-14 mb-8">Public Comments</h6>
                                    <div class="bg-white p-12 rounded-8 border">
                                        <p class="mb-0 text-14">{{ $review->comment }}</p>
                                    </div>
                                </div>

                                <!-- Confidential Comments (only for senior editors) -->
                                @if($canViewConfidential && !empty($review->confidential_comments))
                                    <div class="bg-warning-50 p-12 rounded-8 border border-warning">
                                        <h6 class="text-14 mb-8 text-warning">
                                            <i class="ph ph-lock me-8"></i>Confidential Comments (Editor Only)
                                        </h6>
                                        <p class="mb-0 text-14">{{ $review->confidential_comments }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-40">
                            <i class="ph ph-clipboard-text text-gray-400 text-64 mb-16"></i>
                            <h6 class="text-gray-600 mb-8">No Reviews Submitted</h6>
                            <p class="text-gray-500">Reviews will appear here once reviewers submit their feedback.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .star-display .star {
        font-size: 16px;
        color: #ddd;
        margin-right: 2px;
    }
    .star-display .star.filled {
        color: #ffd700;
    }
    .star-display.small .star {
        font-size: 12px;
    }
    .bg-orange {
        background-color: #fd7e14 !important;
    }
    .text-orange {
        color: #fd7e14 !important;
    }    .bg-warning-50 {
        background-color: #fff3cd;
    }
</style>

<script>
    // Document viewer controls for enhanced review details
    window.openDetailsFullscreen = function() {
        const viewer = document.getElementById('detailsPdfViewer');
        if (!viewer) return;
        
        if (viewer.requestFullscreen) {
            viewer.requestFullscreen();
        } else if (viewer.webkitRequestFullscreen) { /* Safari */
            viewer.webkitRequestFullscreen();
        } else if (viewer.msRequestFullscreen) { /* IE11 */
            viewer.msRequestFullscreen();
        }
    };

    window.resizeDetailsViewer = function(action) {
        const viewer = document.getElementById('detailsPdfViewer');
        if (!viewer) return;
        
        const currentHeight = parseInt(viewer.style.height) || 600;
        
        if (action === 'expand' && currentHeight < 1000) {
            viewer.style.height = (currentHeight + 100) + 'px';
        } else if (action === 'shrink' && currentHeight > 400) {
            viewer.style.height = (currentHeight - 100) + 'px';
        }
    };
</script>
@endsection
