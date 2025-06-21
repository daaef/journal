<x-layouts.editor_layout>
    <!-- Clean Navigation Breadcrumb -->
    <nav class="bg-white border-b border-gray-200 mb-8">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <a href="{{ route('editor.dashboard') }}" class="hover:text-gray-900 transition-colors">Dashboard</a>
                    <span class="text-gray-400">→</span>
                    <span class="text-gray-900 font-medium">Enhanced Review Details</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="space-y-8">
            <!-- Manuscript Overview -->
            <div class="bg-white border border-gray-200">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900 mb-3">{{ $journal->title }}</h1>
                            <div class="flex flex-wrap gap-3 mb-4">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    {{ $journal->category->name ?? 'Uncategorized' }}
                                </span>                                @if($journal->sub_category)
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
                                        {{ $journal->sub_category->name }}
                                    </span>
                                @endif
                                @if($journal->status === 'published')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                        Published
                                    </span>
                                @endif
                            </div>
                            <p class="text-gray-600 mb-4">
                                <strong>Author:</strong> {{ $journal->author->fullname ?? 'Unknown' }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-right">
                                <div class="mb-2">
                                    <span class="text-gray-600">Status:</span>
                                    <span class="ml-2 px-3 py-1 rounded-full text-sm font-medium
                                        @if($journal->approval_status === 'approved') bg-green-100 text-green-800
                                        @elseif($journal->approval_status === 'reviewed') bg-blue-100 text-blue-800
                                        @elseif($journal->approval_status === 'in-progress' || $journal->approval_status === 'under_peer_review') bg-yellow-100 text-yellow-800
                                        @elseif($journal->approval_status === 'pending') bg-gray-100 text-gray-800
                                        @elseif($journal->approval_status === 'ready_for_managing_editor_notice') bg-blue-100 text-blue-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $journal->status_label }}
                                    </span>
                                </div>
                                <a href="{{ route('editor.journals.preview', [$journal->uuid, $journal->slug]) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View Manuscript
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Document Reader Section -->
            @if($journal->journal_url)
            <div class="bg-white border border-gray-200">
                               class="btn btn-outline-main btn-sm">
                                <i class="ph ph-eye me-8"></i>View Manuscript
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>        <!-- Document Reader Section -->
        @if($journal->journal_url)
        <div class="col-12">
            <!-- Document Reader Component -->
            <x-document-reader 
                :journal="$journal" 
                title="Manuscript Document Reader"
                subtitle="Review the manuscript directly in your browser"
                height="600px"
                role="details"
                :showControls="true"
                container-class=""
            />
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
                                @endif                                <!-- Public Comments -->
                                <div class="mb-16">
                                    <h6 class="text-14 mb-8">
                                        <i class="ph ph-user me-8 text-primary"></i>Comments for the Author
                                        <span class="badge bg-primary-50 text-primary text-12 ms-8">For User/Author</span>
                                    </h6>
                                    <div class="bg-primary-50 p-12 rounded-8 border border-primary-200">
                                        @if(!empty($review->comment))
                                            <p class="mb-0 text-14">{{ $review->comment }}</p>
                                            <small class="text-muted d-block mt-8">
                                                <i class="ph ph-info me-4"></i>This feedback is visible to the author of the manuscript
                                            </small>
                                        @else
                                            <p class="mb-0 text-14 text-muted fst-italic">No comments provided for the author</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Confidential Comments (only for senior editors) -->
                                @if($canViewConfidential)
                                    <div class="mb-16">
                                        <div class="bg-warning-50 p-12 rounded-8 border border-warning">
                                            <h6 class="text-14 mb-8 text-warning">
                                                <i class="ph ph-lock me-8"></i>Confidential Comments for Editorial Team
                                                <span class="badge bg-warning text-white text-12 ms-8">For Editors Only</span>
                                            </h6>
                                            @if(!empty($review->confidential_comments))
                                                <p class="mb-0 text-14">{{ $review->confidential_comments }}</p>
                                                <small class="text-muted d-block mt-8">
                                                    <i class="ph ph-shield-check me-4"></i>This content is only visible to Managing Editors and Editor-in-Chief
                                                </small>
                                            @else
                                                <p class="mb-0 text-14 text-muted fst-italic">No confidential comments provided</p>
                                                <small class="text-muted d-block mt-8">
                                                    <i class="ph ph-shield-check me-4"></i>Confidential comments are only visible to Managing Editors and Editor-in-Chief
                                                </small>
                                            @endif
                                        </div>
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
    // Legacy controls (now handled by component)
    window.openDetailsFullscreen = function() {
        console.log('Fullscreen functionality moved to component');
    };

    window.resizeDetailsViewer = function(action) {
        console.log('Resize functionality moved to component');
    };
</script>
@endsection
