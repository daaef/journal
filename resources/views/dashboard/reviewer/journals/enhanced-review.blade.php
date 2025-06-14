<x-layouts.reviewer_layout>    <div class="breadcrumb mb-24">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('reviewer.dashboard') }}" class="text-gray-600 fw-normal text-15 hover-text-gray-800">Home</a></li>
            <li><span class="text-gray-400 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
            <li><span class="text-gray-800 fw-normal text-15">Review: {{ Str::limit($journal->title, 50) }}</span></li>
        </ul>
    </div>

    <!-- Manuscript Overview Section -->
    <div class="card mb-24 border">
        <div class="card-header bg-gray-50 border-bottom">
            <h4 class="mb-0 text-gray-800">
                <i class="ph ph-file-text me-12"></i>Manuscript Overview
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="mb-16 text-gray-800">{{ $journal->title }}</h3>                    <div class="flex-wrap gap-20 mb-20">
                        <div class="bg-white p-12 rounded border border-gray-200 d-inline-block">
                            <strong class="text-gray-700">Author:</strong> 
                            <span class="text-gray-600">{{ $journal->author->fullname ?? $journal->author }}</span>
                        </div>
                        <div class="bg-white p-12 rounded border border-gray-200 d-inline-block ml-8">
                            <strong class="text-gray-700">Category:</strong> 
                            <span class="text-gray-600">{{ $journal->category->name ?? 'N/A' }}</span>
                        </div>                        <div class="bg-white p-12 rounded border border-gray-200 d-inline-block ml-8">
                            <strong class="text-gray-700">Status:</strong> 
                            <span class="text-gray-600">{{ ucfirst($journal->approval_status) }}</span>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-16 rounded border-l-4 border-gray-400">
                        <h6 class="mb-12 text-gray-800">
                            <i class="ph ph-note me-8"></i>Abstract
                        </h6>
                        <p class="text-gray-700 text-15 line-height-relaxed">{{ $journal->abstract }}</p>
                    </div>
                    
    <!-- Document Preview Section (Visible by Default) -->
    @if($journal->journal_url)
    <div id="documentPreview" class="card mb-24 border-2 border-blue-200">        <div class="card-header bg-blue-50 border-bottom border-blue-200">
            <div class="flex-between">
                <div>
                    <h5 class="mb-0 text-blue-800 fw-bold">
                        <i class="ph ph-file-pdf me-12"></i>Manuscript Document Reader
                    </h5>
                    <small class="text-blue-600">Read the manuscript directly in your browser while reviewing</small>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" onclick="openFullscreen()" 
                            class="btn btn-sm btn-outline-primary rounded"
                            title="Open in fullscreen">
                        <i class="ph ph-corners-out"></i>
                    </button>
                    <button type="button" onclick="resizeDocumentViewer('expand')" 
                            class="btn btn-sm btn-outline-primary rounded"
                            title="Expand viewer">
                        <i class="ph ph-arrows-out"></i>
                    </button>
                    <button type="button" onclick="resizeDocumentViewer('shrink')" 
                            class="btn btn-sm btn-outline-primary rounded"
                            title="Shrink viewer">
                        <i class="ph ph-arrows-in"></i>
                    </button>
                    <a href="{{ asset('storage/' . $journal->journal_url) }}" target="_blank"
                       class="btn btn-sm btn-outline-success rounded"
                       title="Open in new tab">
                        <i class="ph ph-arrow-square-out"></i>
                    </a>
                    <a href="{{ asset('storage/' . $journal->journal_url) }}" download
                       class="btn btn-sm btn-outline-info rounded"
                       title="Download PDF">
                        <i class="ph ph-download-simple"></i>
                    </a>
                    <button type="button" onclick="toggleDocumentPreview()" 
                            class="btn btn-sm btn-outline-secondary rounded"
                            title="Hide document reader">
                        <i class="ph ph-eye-slash me-8"></i>Hide
                    </button>
                </div>
            </div>
        </div>        <div class="card-body p-0">            <div class="bg-gray-100 px-16 py-8 border-bottom d-flex justify-content-between align-items-center">
                <small class="text-gray-600">
                    <i class="ph ph-lightbulb me-4"></i>
                    <strong>Tip:</strong> Use Ctrl+F to search within the document, or right-click for additional PDF options.
                </small>
                <small class="text-gray-500">
                    <i class="ph ph-info me-4"></i>
                    File: {{ basename($journal->journal_url) }}
                </small>
            </div>
            
            <!-- Loading Indicator -->
            <div id="pdfLoading" class="text-center py-5" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading PDF...</span>
                </div>
                <p class="mt-2 text-gray-600">Loading manuscript...</p>
            </div>
            
            <!-- PDF Viewer -->
            <iframe id="pdfViewer" 
                    src="{{ asset('storage/' . $journal->journal_url) }}#toolbar=1&navpanes=1&scrollbar=1" 
                    style="width: 100%; height: 700px; border: none; background: #f8f9fa;"
                    loading="lazy"
                    title="Manuscript PDF Viewer"
                    onload="hidePdfLoading()"
                    onerror="showPdfError()">
            </iframe>
            
            <!-- Error Fallback -->
            <div id="pdfError" class="p-24 text-center" style="display: none;">
                <div class="alert alert-warning">
                    <i class="ph ph-warning-circle me-8"></i>
                    <strong>PDF Preview Not Available</strong>
                    <p class="mb-16">Your browser does not support embedded PDFs or the document could not be loaded.</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ asset('storage/' . $journal->journal_url) }}" target="_blank" 
                           class="btn btn-primary">
                            <i class="ph ph-arrow-square-out me-8"></i>Open in New Tab
                        </a>
                        <a href="{{ asset('storage/' . $journal->journal_url) }}" download
                           class="btn btn-success">
                            <i class="ph ph-download-simple me-8"></i>Download PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
                </div>
                <div class="col-lg-4">
                    <div class="bg-white p-20 rounded border border-gray-200">
                        <h6 class="mb-16 text-gray-800 fw-bold">
                            <i class="ph ph-info me-8"></i>Manuscript Details
                        </h6>
                        <ul class="list-unstyled space-y-3">
                            <li class="flex-between py-8 border-bottom border-gray-200">
                                <strong class="text-gray-700">Submitted:</strong> 
                                <span class="text-gray-600">{{ $journal->created_at->format('M j, Y') }}</span>
                            </li>
                            <li class="flex-between py-8 border-bottom border-gray-200">
                                <strong class="text-gray-700">Version:</strong> 
                                <span class="text-gray-600">{{ $journal->versions->count() > 0 ? $journal->versions->first()->version_number : '1.0' }}</span>
                            </li>
                            <li class="flex-between py-8 border-bottom border-gray-200">
                                <strong class="text-gray-700">Institution:</strong> 
                                <span class="text-gray-600">{{ Str::limit($journal->institution ?? 'N/A', 20) }}</span>
                            </li>
                            <li class="flex-between py-8">
                                <strong class="text-gray-700">Language:</strong> 
                                <span class="text-gray-600">{{ $journal->journal_language ?? 'N/A' }}</span>
                            </li>
                        </ul>                        @if($journal->journal_url)
                            <div class="mt-16 space-y-2">
                                <div class="p-12 bg-blue-50 rounded border border-blue-200 mb-12">
                                    <div class="text-center mb-8">
                                        <i class="ph ph-file-pdf text-blue-600" style="font-size: 24px;"></i>
                                    </div>                                    <h6 class="text-blue-800 mb-8 text-center fw-bold">Document Reader Active</h6>
                                    <p class="text-blue-700 text-sm mb-12 text-center">
                                        The manuscript is displayed below for convenient side-by-side reading while reviewing. You can hide it if needed.
                                    </p><button type="button" onclick="toggleDocumentPreview()" 
                                            class="btn btn-secondary btn-sm rounded w-100 fw-bold">
                                        <i class="ph ph-eye-slash me-8"></i>Hide Document Reader
                                    </button>
                                </div>
                                
                                <div class="border-top pt-12">
                                    <a href="{{ asset('storage/' . $journal->journal_url) }}" target="_blank" 
                                       class="btn btn-outline-secondary btn-sm rounded w-100">
                                        <i class="ph ph-download-simple me-8"></i>Download PDF Instead
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                         <!-- Academic Review Information -->
            <div class="sticky-sidebar mt-16">                <!-- Review Status -->
                <div class="bg-gray-50 p-20 rounded border-l-4 border-gray-400 mb-20">
                    <h6 class="mb-16 text-gray-800 fw-bold">
                        Review Status
                    </h6>
                        @php
                            $totalReviewers = $journal->reviewerAssignments ? $journal->reviewerAssignments->count() : 0;
                            $reviewersRatings = $journal->reviewers_ratings ?? [];
                            $completedReviews = count(array_filter($reviewersRatings, function($review) {
                                return !empty($review['comment']);
                            }));
                        @endphp
                        
                        <div class="text-center mb-16">
                            <div class="h2 text-gray-800 mb-0">{{ $completedReviews }}/{{ $totalReviewers }}</div>
                            <small class="text-muted">Reviews Completed</small>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-gray-200 rounded" style="height: 8px;">
                                <div class="bg-gray-600 rounded" style="height: 8px; width: {{ $totalReviewers > 0 ? ($completedReviews / $totalReviewers) * 100 : 0 }}%"></div>
                            </div>                            <small class="text-muted mt-8 d-block">
                                {{ $totalReviewers > 0 ? round(($completedReviews / $totalReviewers) * 100) : 0 }}% Complete
                            </small>
                        </div>
                </div>

                <!-- Other Reviewers (Simplified) -->
                @if($otherReviews && $otherReviews->count() > 0)
                <div class="card border border-gray-300">
                    <div class="card-header bg-gray-100 border-bottom border-gray-300">
                        <h6 class="mb-0 text-gray-800 fw-bold">
                            Other Reviewers
                        </h6>
                    </div>
                    <div class="card-body">
                        @foreach($otherReviews as $review)
                        <div class="border-bottom border-gray-200 pb-12 mb-12 last:border-0 last:pb-0 last:mb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold text-gray-800 text-14">{{ $review->user->fullname }}</div>
                                    <small class="text-muted">{{ $review->updated_at->diffForHumans() ?? 'Recently' }}</small>
                                </div>
                                @if($review->recommendation)
                                <span class="badge bg-gray-100 text-gray-700 text-12">
                                    {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>                </div>
                @endif
            </div>
                </div>
            </div>
        </div>
    </div>    

    <div class="row gy-4">        <!-- Review Form Section -->
        <div class="col-lg-8">
            <div class="card border">                <div class="card-header bg-gray-50 border-bottom">
                    <h5 class="mb-0 text-gray-800">
                        @if($existingReview)
                            <i class="ph ph-check-circle text-success me-12"></i>Your Review 
                            @if($existingReview->review_submitted_at)
                                (Submitted {{ $existingReview->review_submitted_at->format('M j, Y \a\t g:i A') }})
                            @else
                                (Content Available)
                            @endif
                        @else
                            <i class="ph ph-pencil me-12"></i>Submit Your Review
                        @endif
                    </h5>
                    @if($existingReview)                        <div class="alert alert-info mt-16 mb-0">
                            <div class="d-flex align-items-center">
                                <i class="ph ph-info text-info me-8"></i>
                                <div>
                                    @if($existingReview->review_submitted_at)
                                        <strong>Review Completed:</strong> Your review has been submitted and is now read-only. 
                                        Reviews can only be submitted once and cannot be modified.
                                    @else
                                        <strong>Review Content:</strong> You have existing review content for this manuscript.
                                        All fields are read-only to preserve your work.
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{ route('reviewer.journals.submitReview') }}" method="POST" id="enhancedReviewForm">
                        @csrf
                        <input type="hidden" name="journal_uuid" value="{{ $journal->uuid }}">
                        <input type="hidden" name="reviewer_id" value="{{ auth()->id() }}">                        <!-- Academic Review Assessment -->
                        <div class="mb-32">
                            <div class="bg-gray-50 p-20 rounded border-l-4 border-gray-400">
                                <h6 class="mb-16 text-gray-800 fw-bold">
                                    Academic Review Assessment
                                </h6>
                                <p class="text-gray-700 mb-16 text-15">
                                    Please evaluate this manuscript based on the following core academic criteria:
                                </p>
                                
                                <!-- Simplified 3-Criteria Assessment -->
                                <div class="row g-4 mb-20">
                                        <div class="col-md-4">
                                            <div class="border border-gray-200 rounded p-16 text-center">
                                                <label class="fw-bold text-gray-800 mb-8 d-block">Scholarly Merit</label>                                                <select name="criteria_ratings[scholarly_merit]" class="form-select form-select-sm" {{ $existingReview ? 'disabled' : '' }}>
                                                    <option value="">Select Rating</option>
                                                    <option value="1" {{ ($existingReview && isset($existingReview->criteria_ratings['scholarly_merit']) && $existingReview->criteria_ratings['scholarly_merit'] == 1) ? 'selected' : '' }}>1 - Poor</option>
                                                    <option value="2" {{ ($existingReview && isset($existingReview->criteria_ratings['scholarly_merit']) && $existingReview->criteria_ratings['scholarly_merit'] == 2) ? 'selected' : '' }}>2 - Fair</option>
                                                    <option value="3" {{ ($existingReview && isset($existingReview->criteria_ratings['scholarly_merit']) && $existingReview->criteria_ratings['scholarly_merit'] == 3) ? 'selected' : '' }}>3 - Good</option>
                                                    <option value="4" {{ ($existingReview && isset($existingReview->criteria_ratings['scholarly_merit']) && $existingReview->criteria_ratings['scholarly_merit'] == 4) ? 'selected' : '' }}>4 - Very Good</option>
                                                    <option value="5" {{ ($existingReview && isset($existingReview->criteria_ratings['scholarly_merit']) && $existingReview->criteria_ratings['scholarly_merit'] == 5) ? 'selected' : '' }}>5 - Excellent</option>
                                                </select>
                                                <small class="text-muted mt-8 d-block">Originality, significance, contribution to field</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="border border-gray-200 rounded p-16 text-center">
                                                <label class="fw-bold text-gray-800 mb-8 d-block">Methodology</label>
                                                <select name="criteria_ratings[methodology]" class="form-select form-select-sm" {{ $existingReview ? 'disabled' : '' }}>
                                                    <option value="">Select Rating</option>
                                                    <option value="1" {{ ($existingReview && isset($existingReview->criteria_ratings['methodology']) && $existingReview->criteria_ratings['methodology'] == 1) ? 'selected' : '' }}>1 - Poor</option>
                                                    <option value="2" {{ ($existingReview && isset($existingReview->criteria_ratings['methodology']) && $existingReview->criteria_ratings['methodology'] == 2) ? 'selected' : '' }}>2 - Fair</option>
                                                    <option value="3" {{ ($existingReview && isset($existingReview->criteria_ratings['methodology']) && $existingReview->criteria_ratings['methodology'] == 3) ? 'selected' : '' }}>3 - Good</option>
                                                    <option value="4" {{ ($existingReview && isset($existingReview->criteria_ratings['methodology']) && $existingReview->criteria_ratings['methodology'] == 4) ? 'selected' : '' }}>4 - Very Good</option>
                                                    <option value="5" {{ ($existingReview && isset($existingReview->criteria_ratings['methodology']) && $existingReview->criteria_ratings['methodology'] == 5) ? 'selected' : '' }}>5 - Excellent</option>
                                                </select>
                                                <small class="text-muted mt-8 d-block">Research design, analysis, rigor</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="border border-gray-200 rounded p-16 text-center">
                                                <label class="fw-bold text-gray-800 mb-8 d-block">Presentation</label>
                                                <select name="criteria_ratings[presentation]" class="form-select form-select-sm" {{ $existingReview ? 'disabled' : '' }}>
                                                    <option value="">Select Rating</option>
                                                    <option value="1" {{ ($existingReview && isset($existingReview->criteria_ratings['presentation']) && $existingReview->criteria_ratings['presentation'] == 1) ? 'selected' : '' }}>1 - Poor</option>
                                                    <option value="2" {{ ($existingReview && isset($existingReview->criteria_ratings['presentation']) && $existingReview->criteria_ratings['presentation'] == 2) ? 'selected' : '' }}>2 - Fair</option>
                                                    <option value="3" {{ ($existingReview && isset($existingReview->criteria_ratings['presentation']) && $existingReview->criteria_ratings['presentation'] == 3) ? 'selected' : '' }}>3 - Good</option>
                                                    <option value="4" {{ ($existingReview && isset($existingReview->criteria_ratings['presentation']) && $existingReview->criteria_ratings['presentation'] == 4) ? 'selected' : '' }}>4 - Very Good</option>
                                                    <option value="5" {{ ($existingReview && isset($existingReview->criteria_ratings['presentation']) && $existingReview->criteria_ratings['presentation'] == 5) ? 'selected' : '' }}>5 - Excellent</option>
                                                </select>
                                                <small class="text-muted mt-8 d-block">Clarity, organization, writing quality</small>                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>                        <!-- Overall Assessment -->
                        <div class="mb-32">
                            <div class="bg-gray-50 p-20 rounded border-l-4 border-gray-400">
                                <h6 class="mb-16 text-gray-800 fw-bold">
                                    Overall Assessment
                                </h6>
                                <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-gray-800 mb-12">
                                                Overall Quality Rating
                                            </label>
                                            <select name="rating" class="form-select" required {{ $existingReview ? 'disabled' : '' }}>
                                                <option value="">Select Overall Rating</option>
                                                <option value="1" {{ ($existingReview->rating ?? '') == 1 ? 'selected' : '' }}>1 - Poor (Reject)</option>
                                                <option value="2" {{ ($existingReview->rating ?? '') == 2 ? 'selected' : '' }}>2 - Fair (Major Concerns)</option>
                                                <option value="3" {{ ($existingReview->rating ?? '') == 3 ? 'selected' : '' }}>3 - Good (Minor Revisions)</option>
                                                <option value="4" {{ ($existingReview->rating ?? '') == 4 ? 'selected' : '' }}>4 - Very Good (Accept with Minor Changes)</option>
                                                <option value="5" {{ ($existingReview->rating ?? '') == 5 ? 'selected' : '' }}>5 - Excellent (Accept as is)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-gray-800 mb-12">
                                                Editorial Recommendation
                                            </label>                                            <select name="recommendation" class="form-select" required {{ $existingReview ? 'disabled' : '' }}>
                                                <option value="">Select Recommendation</option>
                                                <option value="accept" {{ ($existingReview->recommendation ?? '') === 'accept' ? 'selected' : '' }}>Accept for Publication</option>
                                                <option value="minor_revision" {{ ($existingReview->recommendation ?? '') === 'minor_revision' ? 'selected' : '' }}>Accept with Minor Revisions</option>
                                                <option value="major_revision" {{ ($existingReview->recommendation ?? '') === 'major_revision' ? 'selected' : '' }}>Major Revisions Required</option>
                                                <option value="reject" {{ ($existingReview->recommendation ?? '') === 'reject' ? 'selected' : '' }}>Reject</option>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                        </div>                        <!-- Review Comments -->
                        <div class="mb-32">
                            <div class="bg-gray-50 p-20 rounded border-l-4 border-gray-400">
                                <h6 class="mb-16 text-gray-800 fw-bold">
                                    Detailed Review Comments
                                </h6>
                                    <div class="mb-20">
                                        <label class="form-label fw-bold text-gray-800 mb-8">
                                            Comments for Author
                                        </label>                                        <textarea name="comment" class="form-control" rows="8" 
                                                  placeholder="Provide detailed, constructive feedback for the author. Include specific comments on strengths, weaknesses, and suggestions for improvement. Be professional and helpful in your critique."
                                                  required {{ $existingReview ? 'readonly' : '' }}>{{ $existingReview->comment ?? '' }}</textarea>
                                        <small class="text-muted mt-8 d-block">
                                            These comments will be shared with the author to help improve their manuscript.
                                        </small>
                                    </div>
                                    
                                    <div>
                                        <label class="form-label fw-bold text-gray-800 mb-8">
                                            Confidential Comments for Editor
                                        </label>                                        <textarea name="confidential_comments" class="form-control" rows="4" 
                                                  placeholder="Optional: Any confidential comments for the editor regarding manuscript handling, concerns about methodology, ethical issues, or recommendations for additional reviewers." {{ $existingReview ? 'readonly' : '' }}>{{ $existingReview->confidential_comments ?? '' }}</textarea><small class="text-muted mt-8 d-block">
                                            These comments are confidential and will only be visible to the editorial team.
                                        </small>
                                    </div>
                            </div>
                        </div>                        <!-- Submit Review -->
                        <div class="text-center py-20 border-top border-gray-200">
                            @if($existingReview)
                                <div class="alert alert-success">
                                    <i class="ph ph-check-circle me-8"></i>
                                    <strong>Review Content Available:</strong> 
                                    @if($existingReview->review_submitted_at)
                                        Your review was submitted on {{ $existingReview->review_submitted_at->format('M j, Y \a\t g:i A') }}
                                    @else
                                        You have existing review content for this manuscript
                                    @endif
                                </div>
                            @else
                                <button type="submit" class="btn btn-success px-32 py-12">
                                    <i class="ph ph-check-circle me-8"></i>Submit Review
                                </button>
                            @endif
                            <div class="mt-12">
                                <small class="text-muted">
                                    @if($existingReview)
                                        Your review content is displayed above and cannot be modified.
                                    @else
                                        <strong>Note:</strong> Once submitted, your review cannot be changed or updated.
                                    @endif
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>   
    </div>

<!-- Enhanced Styles -->
    <style>
        /* Document Preview */
        #documentPreview {
            animation: slideDown 0.3s ease-out;
        }
          @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }        /* Subtle Form Input Styling */
        .form-select, .form-control, textarea.form-control {
            border: 1px solid #e2e8f0 !important;
            border-radius: 6px !important;
            padding: 12px 16px !important;
            font-size: 14px !important;
            background-color: #ffffff !important;
            transition: all 0.2s ease !important;
        }
        
        .form-select:focus, .form-control:focus, textarea.form-control:focus {
            border-color: #6b7280 !important;
            box-shadow: 0 0 0 2px rgba(107, 114, 128, 0.1) !important;
            outline: none !important;
            background-color: #ffffff !important;
        }
        
        .form-select:hover, .form-control:hover, textarea.form-control:hover {
            border-color: #9ca3af !important;
        }
          .form-select-sm {
            padding: 8px 12px !important;
            font-size: 13px !important;
        }

        /* Section Background Colors for Differentiation */
        .border.border-gray-300.rounded {
            background-color: #f8fafc !important;
            border-color: #e2e8f0 !important;
        }
        
        .bg-gray-100 {
            background-color: #f1f5f9 !important;
        }
        
        .card {
            background-color: #ffffff !important;
        }
        
        .card-body {
            background-color: #ffffff !important;
        }

        /* Criteria Grid */
        .criteria-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .criteria-card {
            background: linear-gradient(135deg, #f8faff 0%, #f1f5ff 100%);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .criteria-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-color: #6366f1;
        }        .criteria-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: #6b7280;
        }

        .criteria-header {
            margin-bottom: 12px;
        }

        .criteria-body {
            text-align: center;
        }        /* Enhanced Star Rating */
        .star-rating .star-enhanced, .overall-star-rating .star-enhanced {
            font-size: 28px;
            color: #d1d5db;
            cursor: pointer;
            transition: all 0.2s ease;
            margin: 0 2px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .star-rating .star-enhanced.large, .overall-star-rating .star-enhanced.large {
            font-size: 36px;
            margin: 0 4px;
        }

        .star-rating .star-enhanced.active, .overall-star-rating .star-enhanced.active {
            color: #fbbf24;
            transform: scale(1.1);
        }

        .star-rating .star-enhanced:hover, .overall-star-rating .star-enhanced:hover {
            color: #fbbf24;
            transform: scale(1.15);
        }

        .rating-text, .overall-rating-text {
            height: 20px;
            transition: all 0.3s ease;
        }        .rating-label-enhanced, .overall-rating-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Recommendation Grid */
        .recommendation-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 16px;
        }

        .recommendation-option {
            position: relative;
        }

        .recommendation-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            margin: 0;
            cursor: pointer;
        }

        .recommendation-label {
            display: flex;
            align-items: center;
            padding: 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .recommendation-label:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }        .recommendation-label.accept {
            border-color: #d1d5db;
        }
        .recommendation-label.minor {
            border-color: #d1d5db;
        }
        .recommendation-label.major {
            border-color: #d1d5db;
        }
        .recommendation-label.reject {
            border-color: #d1d5db;
        }.recommendation-option input:checked + .recommendation-label.accept {
            background: #f3f4f6;
            border-color: #6b7280;
            color: #374151;
        }
        .recommendation-option input:checked + .recommendation-label.minor {
            background: #f3f4f6;
            border-color: #6b7280;
            color: #374151;
        }
        .recommendation-option input:checked + .recommendation-label.major {
            background: #f3f4f6;
            border-color: #6b7280;
            color: #374151;
        }
        .recommendation-option input:checked + .recommendation-label.reject {
            background: #f3f4f6;
            border-color: #6b7280;
            color: #374151;
        }

        .recommendation-icon {
            font-size: 24px;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .recommendation-text {
            flex-grow: 1;
        }

        .recommendation-text strong {
            display: block;
            font-size: 14px;
            margin-bottom: 2px;
        }

        .recommendation-text small {
            font-size: 12px;
            opacity: 0.8;
        }

        /* Enhanced Textareas */
        .enhanced-textarea {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            font-size: 14px;
            line-height: 1.6;
            transition: all 0.3s ease;
            resize: vertical;
            min-height: 120px;
        }        .enhanced-textarea:focus {
            border-color: #6b7280;
            box-shadow: 0 0 0 3px rgba(107, 114, 128, 0.1);
            outline: none;
        }

        /* Sidebar Enhancements */
        .sticky-sidebar {
            position: sticky;
            top: 20px;
        }

        .sidebar-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
            border: 1px solid #e5e7eb;
        }

        .sidebar-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-card-body {
            padding: 20px;
        }

        /* Progress Circle */
        .progress-circle-container {
            position: relative;
            display: inline-block;
        }        .progress-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: conic-gradient(#6b7280 0deg, #6b7280 var(--percentage, 0deg), #e5e7eb var(--percentage, 0deg));
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .progress-circle::before {
            content: '';
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: white;
            position: absolute;
        }

        .progress-value {
            font-size: 14px;
            font-weight: bold;
            color: #374151;
            z-index: 1;
        }

        .progress-stats {
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            display: block;
            font-size: 18px;
            font-weight: bold;
            color: #374151;
        }

        .stat-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-divider {
            width: 1px;
            height: 30px;
            background: #e5e7eb;
        }

        .progress-bar-custom {
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }        .progress-fill {
            height: 100%;
            background: #6b7280;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        /* Review Items */
        .review-item {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .reviewer-info {
            display: flex;
            align-items: center;
        }        .reviewer-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #6b7280;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            margin-right: 8px;
        }

        .reviewer-details {
            display: flex;
            flex-direction: column;
        }

        .reviewer-name {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
        }

        .review-date {
            font-size: 11px;
            color: #6b7280;
        }

        .review-rating {
            display: flex;
        }

        .star.mini {
            font-size: 12px;
            margin: 0 1px;
        }

        .star.mini.filled {
            color: #fbbf24;
        }

        .star.mini:not(.filled) {
            color: #d1d5db;
        }

        .recommendation-badge {
            display: inline-flex;
            align-items: center;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 6px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .recommendation-badge.accept {
            background: #d1fae5;
            color: #065f46;
        }
        .recommendation-badge.minor_revisions {
            background: #fef3c7;
            color: #92400e;
        }
        .recommendation-badge.major_revisions {
            background: #fed7aa;
            color: #9a3412;
        }
        .recommendation-badge.reject {
            background: #fecaca;
            color: #991b1b;
        }

        .review-comment p {
            font-size: 12px;
            color: #6b7280;
            line-height: 1.4;
            margin: 0;
        }

        /* Empty State */
        .empty-state {
            padding: 20px;
        }

        .empty-state i {
            font-size: 48px;
        }

        /* Quick Actions */
        .quick-actions-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 16px 12px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            background: white;
            color: #374151;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            color: #6366f1;
            border-color: #6366f1;
        }

        .action-btn i {
            font-size: 20px;
            margin-bottom: 8px;
        }

        .action-btn span {
            font-size: 12px;
            font-weight: 600;
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .criteria-grid {
                grid-template-columns: 1fr;
            }
            
            .recommendation-grid {
                grid-template-columns: 1fr;
            }
            
            .quick-actions-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Enhanced review form loaded');            // Document preview toggle and controls
            window.toggleDocumentPreview = function() {
                const preview = document.getElementById('documentPreview');
                const toggleBtn = document.querySelector('button[onclick="toggleDocumentPreview()"]');
                const headerBtn = preview?.querySelector('button[onclick="toggleDocumentPreview()"]');
                
                if (preview.style.display === 'none') {
                    preview.style.display = 'block';
                    preview.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    // Update button text in the sidebar
                    if (toggleBtn && toggleBtn.innerHTML.includes('Show Document Reader')) {
                        toggleBtn.innerHTML = '<i class="ph ph-eye-slash me-8"></i>Hide Document Reader';
                        toggleBtn.classList.remove('btn-primary');
                        toggleBtn.classList.add('btn-secondary');
                    }
                    // Update header button
                    if (headerBtn) {
                        headerBtn.innerHTML = '<i class="ph ph-eye-slash me-8"></i>Hide';
                        headerBtn.title = 'Hide document reader';
                    }
                } else {
                    preview.style.display = 'none';
                    // Update button text in the sidebar
                    if (toggleBtn && toggleBtn.innerHTML.includes('Hide Document Reader')) {
                        toggleBtn.innerHTML = '<i class="ph ph-eye me-8"></i>Show Document Reader';
                        toggleBtn.classList.remove('btn-secondary');
                        toggleBtn.classList.add('btn-primary');
                    }
                    // Update header button (won't be visible when hidden, but for consistency)
                    if (headerBtn) {
                        headerBtn.innerHTML = '<i class="ph ph-eye me-8"></i>Show';
                        headerBtn.title = 'Show document reader';
                    }
                }
            };            // Document viewer resize functionality
            window.resizeDocumentViewer = function(action) {
                const viewer = document.getElementById('pdfViewer');
                if (!viewer) return;
                
                const currentHeight = parseInt(viewer.style.height) || 700;
                
                if (action === 'expand' && currentHeight < 1000) {
                    viewer.style.height = (currentHeight + 100) + 'px';
                } else if (action === 'shrink' && currentHeight > 400) {
                    viewer.style.height = (currentHeight - 100) + 'px';
                }
            };            // Fullscreen document viewer
            window.openFullscreen = function() {
                const viewer = document.getElementById('pdfViewer');
                if (!viewer) return;
                
                if (viewer.requestFullscreen) {
                    viewer.requestFullscreen();
                } else if (viewer.webkitRequestFullscreen) { /* Safari */
                    viewer.webkitRequestFullscreen();
                } else if (viewer.msRequestFullscreen) { /* IE11 */
                    viewer.msRequestFullscreen();
                }
            };

            // PDF Loading and Error Handling
            window.hidePdfLoading = function() {
                const loading = document.getElementById('pdfLoading');
                if (loading) loading.style.display = 'none';
            };

            window.showPdfError = function() {
                const loading = document.getElementById('pdfLoading');
                const viewer = document.getElementById('pdfViewer');
                const error = document.getElementById('pdfError');
                
                if (loading) loading.style.display = 'none';
                if (viewer) viewer.style.display = 'none';
                if (error) error.style.display = 'block';
            };

            // Show loading initially
            const pdfLoading = document.getElementById('pdfLoading');
            if (pdfLoading) pdfLoading.style.display = 'block';

            // Progress circle animation
            function updateProgressCircle() {
                const circles = document.querySelectorAll('.progress-circle');
                circles.forEach(circle => {
                    const percentage = circle.getAttribute('data-percentage');
                    const degrees = (percentage / 100) * 360;
                    circle.style.setProperty('--percentage', degrees + 'deg');
                });
            }
            updateProgressCircle();

            // Enhanced star rating with labels
            const ratingLabels = {
                0: 'Not Rated',
                1: 'Poor',
                2: 'Fair', 
                3: 'Good',
                4: 'Very Good',
                5: 'Excellent'
            };            // Initialize criteria star ratings
            document.querySelectorAll('.star-rating').forEach(function(container) {
                console.log('Found star rating container:', container);
                const stars = container.querySelectorAll('.star-enhanced');
                console.log('Found stars:', stars.length);
                const hiddenInput = container.parentNode.querySelector('input[type="hidden"]');
                const ratingText = container.parentNode.querySelector('.rating-label-enhanced');
                const currentRating = parseInt(container.getAttribute('data-rating')) || 0;
                
                // Set initial rating
                updateStars(stars, currentRating);
                if (ratingText) {
                    ratingText.textContent = ratingLabels[currentRating];
                    ratingText.style.color = getRatingColor(currentRating);
                }
                
                stars.forEach(function(star, index) {
                    star.addEventListener('click', function() {
                        const rating = index + 1;
                        hiddenInput.value = rating;
                        updateStars(stars, rating);
                        if (ratingText) {
                            ratingText.textContent = ratingLabels[rating];
                            ratingText.style.color = getRatingColor(rating);
                        }
                        
                        // Add visual feedback
                        container.style.transform = 'scale(1.05)';
                        setTimeout(() => {
                            container.style.transform = 'scale(1)';
                        }, 150);
                    });
                    
                    star.addEventListener('mouseover', function() {
                        updateStars(stars, index + 1);
                        if (ratingText) {
                            ratingText.textContent = ratingLabels[index + 1];
                            ratingText.style.color = getRatingColor(index + 1);
                        }
                    });
                });
                
                container.addEventListener('mouseleave', function() {
                    const currentValue = parseInt(hiddenInput.value) || 0;
                    updateStars(stars, currentValue);
                    if (ratingText) {
                        ratingText.textContent = ratingLabels[currentValue];
                        ratingText.style.color = getRatingColor(currentValue);
                    }
                });
            });            // Overall rating
            document.querySelectorAll('.overall-star-rating').forEach(function(container) {
                const stars = container.querySelectorAll('.star-enhanced');
                const hiddenInput = container.parentNode.querySelector('input[name="rating"]');
                const ratingText = container.parentNode.querySelector('.overall-rating-label');
                const currentRating = parseInt(container.getAttribute('data-rating')) || 0;
                
                updateStars(stars, currentRating);
                if (ratingText) {
                    ratingText.textContent = ratingLabels[currentRating];
                    ratingText.style.color = getRatingColor(currentRating);
                }
                
                stars.forEach(function(star, index) {
                    star.addEventListener('click', function() {
                        const rating = index + 1;
                        hiddenInput.value = rating;
                        updateStars(stars, rating);
                        if (ratingText) {
                            ratingText.textContent = ratingLabels[rating];
                            ratingText.style.color = getRatingColor(rating);
                        }
                        
                        // Add visual feedback
                        container.style.transform = 'scale(1.05)';
                        setTimeout(() => {
                            container.style.transform = 'scale(1)';
                        }, 150);
                    });
                    
                    star.addEventListener('mouseover', function() {
                        updateStars(stars, index + 1);
                        if (ratingText) {
                            ratingText.textContent = ratingLabels[index + 1];
                            ratingText.style.color = getRatingColor(index + 1);
                        }
                    });
                });
                
                container.addEventListener('mouseleave', function() {
                    const currentValue = parseInt(hiddenInput.value) || 0;
                    updateStars(stars, currentValue);
                    if (ratingText) {
                        ratingText.textContent = ratingLabels[currentValue];
                        ratingText.style.color = getRatingColor(currentValue);
                    }
                });
            });

            function updateStars(stars, rating) {
                stars.forEach(function(star, index) {
                    if (index < rating) {
                        star.classList.add('active');
                    } else {
                        star.classList.remove('active');
                    }
                });
            }

            function getRatingColor(rating) {
                const colors = {
                    0: '#6b7280',
                    1: '#dc2626',
                    2: '#ea580c',
                    3: '#ca8a04',
                    4: '#16a34a',
                    5: '#059669'
                };
                return colors[rating] || '#6b7280';
            }

            // Recommendation selection visual feedback
            document.querySelectorAll('input[name="recommendation"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    // Add animation to selected option
                    const label = this.nextElementSibling;
                    label.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        label.style.transform = 'scale(1)';
                    }, 200);
                });
            });

            // Textarea character count and auto-resize
            document.querySelectorAll('.enhanced-textarea').forEach(function(textarea) {
                // Auto-resize
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = this.scrollHeight + 'px';
                });
                
                // Initial resize
                textarea.style.height = textarea.scrollHeight + 'px';
            });

            // Form validation with enhanced UX
            document.getElementById('enhancedReviewForm').addEventListener('submit', function(e) {
                const rating = document.querySelector('input[name="rating"]').value;
                const recommendation = document.querySelector('input[name="recommendation"]:checked');
                const comment = document.querySelector('textarea[name="comment"]').value.trim();
                
                let isValid = true;
                let errors = [];
                
                if (!rating || rating === '0') {
                    errors.push('Please provide an overall rating.');
                    isValid = false;
                    
                    // Highlight overall rating section
                    const ratingSection = document.querySelector('.overall-star-rating').closest('.mb-32');
                    ratingSection.style.border = '2px solid #ef4444';
                    ratingSection.style.borderRadius = '12px';
                    setTimeout(() => {
                        ratingSection.style.border = '';
                    }, 3000);
                }
                
                if (!recommendation) {
                    errors.push('Please select a recommendation.');
                    isValid = false;
                    
                    // Highlight recommendation section
                    const recSection = document.querySelector('.recommendation-grid').closest('.mb-32');
                    recSection.style.border = '2px solid #ef4444';
                    recSection.style.borderRadius = '12px';
                    setTimeout(() => {
                        recSection.style.border = '';
                    }, 3000);
                }
                
                if (!comment) {
                    errors.push('Please provide detailed comments.');
                    isValid = false;
                    
                    // Highlight comment section
                    const commentSection = document.querySelector('textarea[name="comment"]').closest('.mb-32');
                    commentSection.style.border = '2px solid #ef4444';
                    commentSection.style.borderRadius = '12px';
                    setTimeout(() => {
                        commentSection.style.border = '';
                    }, 3000);
                }
                
                if (!isValid) {
                    e.preventDefault();
                    
                    // Show errors in a better way
                    const errorHtml = `
                        <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 16px; margin-bottom: 20px; color: #991b1b;">
                            <h6 style="margin: 0 0 8px 0; color: #991b1b;"><i class="ph ph-warning-circle"></i> Please complete the following:</h6>
                            <ul style="margin: 0; padding-left: 20px;">
                                ${errors.map(error => `<li>${error}</li>`).join('')}
                            </ul>
                        </div>
                    `;
                    
                    // Remove existing error message
                    const existingError = document.querySelector('.validation-errors');
                    if (existingError) {
                        existingError.remove();
                    }
                    
                    // Add new error message
                    const form = document.getElementById('enhancedReviewForm');
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'validation-errors';
                    errorDiv.innerHTML = errorHtml;
                    form.insertBefore(errorDiv, form.firstChild);
                    
                    // Scroll to top of form
                    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    
                    return false;
                }
                
                // Add loading state to submit button
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="ph ph-circle-notch ph-spin me-8"></i>Submitting...';
                submitBtn.disabled = true;
                
                // Re-enable button after 5 seconds (fallback)
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 5000);
            });

            // Auto-save draft functionality (optional)
            let saveTimeout;
            function autoSaveDraft() {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(() => {
                    const formData = new FormData(document.getElementById('enhancedReviewForm'));
                    // Here you could implement auto-save to localStorage or server
                    console.log('Auto-saving draft...');
                }, 2000);
            }
            
            document.querySelectorAll('#enhancedReviewForm input, #enhancedReviewForm textarea').forEach(function(input) {
                input.addEventListener('input', autoSaveDraft);
            });
        });
    </script>
</x-layouts.reviewer_layout>
