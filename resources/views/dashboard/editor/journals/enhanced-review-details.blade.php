<x-layouts.editor_layout>
    <!-- Enhanced Breadcrumb integrated with layout navbar -->
    <div class="bg-white z-40 backdrop-blur-sm bg-white/95 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('editor.dashboard') }}" class="inline-flex items-center px-3 py-2 text-gray-600 hover:text-slate-600 hover:bg-slate-50 rounded-lg transition-all duration-200 text-sm font-medium group">
                        Dashboard
                    </a>
                    <span class="text-gray-300">/</span>
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-900 font-semibold text-sm">{{ Str::limit($journal->title, 45) }}</span>
                    </div>
                </div>
                
                <!-- Action Bar -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-800 rounded-full text-xs font-medium">
                            Enhanced Review Details
                        </span>
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-800',
                                'under_peer_review' => 'bg-blue-100 text-blue-800',
                                'reviewed' => 'bg-purple-100 text-purple-800',
                                'approved' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                                'revision_requested' => 'bg-orange-100 text-orange-800'
                            ];
                            $statusColor = $statusColors[$journal->approval_status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-flex items-center px-3 py-1.5 {{ $statusColor }} rounded-full text-xs font-medium">
                            <span class="w-2 h-2 rounded-full mr-2 {{ str_replace('text-', 'bg-', str_replace('100', '500', explode(' ', $statusColor)[1])) }}"></span>
                            {{ $journal->status_label }}
                        </span>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('editor.journals.preview', [$journal->uuid, $journal->slug]) }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
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

    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 pt-0 pb-8">            <!-- Enhanced Hero Section -->
            <div class="bg-white rounded-2xl shadow-sm shadow-gray-900/10 mb-8 overflow-hidden border border-gray-100">
                <!-- Header with Gradient -->
                <div class="relative bg-gradient-to-br from-slate-600 via-slate-700 to-slate-800 p-16 text-white overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.5) 1px, transparent 0); background-size: 20px 20px;"></div>
                    </div>
                    
                    <!-- Content -->
                    <div class="relative">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                            <!-- Title -->
                            <div class="lg:col-span-8">
                                <div class="space-y-4">
                                    <h1 class="text-3xl md:text-4xl font-bold leading-tight text-white drop-shadow-sm">
                                        {{ $journal->title }}
                                    </h1>
                                    
                                    <!-- Meta Information -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-[15px] text-sm">
                                        <div class="py-2 rounded-lg">
                                            <p class="text-white/80 text-xs my-0">Author</p>
                                            <p class="font-semibold text-white my-0">{{ $journal->author->fullname ?? 'Unknown' }}</p>
                                        </div>
                                        
                                        <div class="px-3 py-2 rounded-lg">
                                            <p class="text-white/80 text-xs my-0">Category</p>
                                            <p class="font-semibold text-white my-0">{{ $journal->category->name ?? 'Uncategorized' }}</p>
                                        </div>
                                        
                                        @if($journal->sub_category)
                                        <div class="px-3 py-2 rounded-lg">
                                            <p class="text-white/80 text-xs my-0">Subcategory</p>
                                            <p class="font-semibold text-white my-0">{{ $journal->sub_category->name }}</p>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Additional Tags -->
                                    <div class="flex flex-wrap gap-2 pt-2">
                                        @if($journal->status === 'published')
                                            <span class="px-3 py-1 bg-green-500/20 text-green-100 rounded-full text-sm font-medium border border-green-400/30">
                                                Published
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Status Card -->
                            <div class="lg:col-span-4 flex justify-end">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-40">
                                    <p class="text-white/80 text-sm mb-1 my-0 text-center">Review Status</p>
                                    <p class="text-white font-bold text-lg my-0 text-center">{{ $journal->status_label }}</p>
                                    <p class="text-white/80 text-xs my-0 text-center mt-1">Enhanced Review Analysis</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            <!-- Document Reader Section -->
            @if($journal->journal_url)
            <div class="bg-white rounded-xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-slate-50 to-green-50 border-b border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-md">
                            <i class="ph ph-file-magnifying-glass text-white text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 leading-tight">Enhanced Review Analysis</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ basename($journal->journal_url) }}</p>
                            @php
                                $extension = strtolower(pathinfo($journal->journal_url, PATHINFO_EXTENSION));
                                $documentType = ($extension === 'pdf') ? 'pdf' : 'pandoc';
                                // For existing journal documents, we'll use the journals.preview route
                                $documentUrl = route('journals.preview', $journal->uuid);
                            @endphp
                            <span class="text-xs text-gray-500 mt-1 font-medium bg-gray-100 px-2 py-1 rounded-md inline-block">
                                📄 {{ strtoupper($extension) }} Document
                            </span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="ph ph-magnifying-glass mr-1"></i>
                                Detailed Review
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <!-- Document Preview Component -->
                    <x-document-preview 
                        :document-url="$documentUrl" 
                        :document-type="$documentType"
                        title="Manuscript Document Reader"
                        subtitle="Review the manuscript directly in your browser"
                        height="600px"
                        :show-controls="true"
                        container-class=""
                    />
                </div>
            </div>

            <!-- Review Statistics & Analysis -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Review Statistics -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden h-full">
                        <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="ph ph-chart-bar text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Review Statistics</h3>
                                    <p class="text-sm text-gray-600">Overall assessment metrics</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="text-center mb-6">
                                <div class="text-4xl font-bold text-blue-600 mb-2">{{ number_format($averageRating, 1) }}</div>
                                <div class="star-display mb-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= round($averageRating) ? 'filled' : '' }}">★</span>
                                    @endfor
                                </div>
                                <p class="text-gray-600 text-sm">Average Rating from {{ $totalReviews }} review{{ $totalReviews !== 1 ? 's' : '' }}</p>
                            </div>
                            
                            <div class="space-y-3">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3">Recommendations</h4>
                                @foreach($recommendationCounts as $rec => $count)
                                    @if($count > 0)
                                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                                @if($rec === 'accept') bg-green-100 text-green-800
                                                @elseif($rec === 'minor_revisions') bg-yellow-100 text-yellow-800
                                                @elseif($rec === 'major_revisions') bg-orange-100 text-orange-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $rec)) }}
                                            </span>
                                            <span class="font-semibold text-gray-900">{{ $count }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Criteria Average Ratings -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden h-full">
                        <div class="px-6 py-5 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="ph ph-target text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Criteria Average Ratings</h3>
                                    <p class="text-sm text-gray-600">Detailed assessment breakdown</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($reviewCriteria as $key => $label)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex justify-between items-center mb-3">
                                            <span class="text-sm font-semibold text-gray-900">{{ $label }}</span>
                                            <span class="text-purple-600 font-bold text-lg">{{ number_format($criteriaAverages[$key], 1) }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 shadow-inner">
                                            <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2.5 rounded-full shadow-sm transition-all duration-300" style="width: {{ ($criteriaAverages[$key] / 5) * 100 }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif            <!-- Individual Reviews -->
            <div class="bg-white rounded-xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-sm">
                            <i class="ph ph-users text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Individual Review Details</h3>
                            <p class="text-sm text-gray-600">Comprehensive reviewer feedback</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @if($reviewsData->count() > 0)
                        <div class="space-y-6">
                            @foreach($reviewsData as $index => $review)
                                <div class="bg-gradient-to-r from-slate-50 to-gray-50 rounded-xl p-6 border border-gray-200 shadow-sm">
                                    
                                    <!-- Reviewer Info -->
                                    <div class="flex justify-between items-start mb-6">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-semibold shadow-md">
                                                {{ substr($review->reviewer->fullname, 0, 1) }}
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-900">{{ $review->reviewer->fullname }}</h4>
                                                <p class="text-sm text-gray-600">
                                                    Submitted on {{ \Carbon\Carbon::parse($review->submitted_at)->format('M d, Y \a\t g:i A') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <!-- Overall Rating -->
                                            <div class="star-display mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">★</span>
                                                @endfor
                                            </div>
                                            <!-- Recommendation Badge -->
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                @if($review->recommendation === 'accept') bg-green-100 text-green-800
                                                @elseif($review->recommendation === 'minor_revisions') bg-yellow-100 text-yellow-800
                                                @elseif($review->recommendation === 'major_revisions') bg-orange-100 text-orange-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Criteria Ratings -->
                                    @if(!empty($review->criteria_ratings))
                                        <div class="mb-6">
                                            <h5 class="text-sm font-semibold text-gray-900 mb-4">Criteria Ratings</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                @foreach($reviewCriteria as $key => $label)
                                                    @if(isset($review->criteria_ratings[$key]) && $review->criteria_ratings[$key] > 0)
                                                        <div class="bg-white rounded-lg p-3 shadow-sm">
                                                            <div class="flex justify-between items-center">
                                                                <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
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
                                    <div class="mb-6">
                                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                            <h5 class="text-sm font-semibold text-blue-900 mb-3 flex items-center">
                                                <i class="ph ph-user mr-2"></i>Comments for the Author
                                                <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs ml-2">For User/Author</span>
                                            </h5>
                                            @if(!empty($review->comment))
                                                <p class="text-sm text-blue-800 mb-2">{{ $review->comment }}</p>
                                                <small class="text-blue-600 flex items-center">
                                                    <i class="ph ph-info mr-1"></i>This feedback is visible to the author of the manuscript
                                                </small>
                                            @else
                                                <p class="text-sm text-blue-600 italic">No comments provided for the author</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Confidential Comments (only for senior editors) -->
                                    @if($canViewConfidential)
                                        <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                                            <h5 class="text-sm font-semibold text-orange-900 mb-3 flex items-center">
                                                <i class="ph ph-lock mr-2"></i>Confidential Comments for Editorial Team
                                                <span class="inline-flex items-center px-2 py-1 bg-orange-100 text-orange-800 rounded-full text-xs ml-2">For Editors Only</span>
                                            </h5>
                                            @if(!empty($review->confidential_comments))
                                                <p class="text-sm text-orange-800 mb-2">{{ $review->confidential_comments }}</p>
                                                <small class="text-orange-600 flex items-center">
                                                    <i class="ph ph-shield-check mr-1"></i>This content is only visible to Managing Editors and Editor-in-Chief
                                                </small>
                                            @else
                                                <p class="text-sm text-orange-600 italic">No confidential comments provided</p>
                                                <small class="text-orange-600 flex items-center">
                                                    <i class="ph ph-shield-check mr-1"></i>Confidential comments are only visible to Managing Editors and Editor-in-Chief
                                                </small>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="ph ph-clipboard-text text-gray-400 text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-600 mb-2">No Reviews Submitted</h4>
                            <p class="text-gray-500">Reviews will appear here once reviewers submit their feedback.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

<style>
    /* Modern Star Display */
    .star-display .star {
        font-size: 16px;
        color: #e5e7eb;
        margin-right: 2px;
        transition: color 0.2s ease-in-out;
    }
    .star-display .star.filled {
        color: #fbbf24;
        text-shadow: 0 0 4px rgba(251, 191, 36, 0.3);
    }
    .star-display.small .star {
        font-size: 12px;
    }
    
    /* Enhanced shadows */
    .shadow-modern {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .shadow-modern-lg {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    /* Card hover effects */
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Orange variants for major revisions */
    .bg-orange-100 {
        background-color: #fed7aa;
    }
    .text-orange-800 {
        color: #9a3412;
    }
    
    /* Warning variants */
    .bg-warning-50 {
        background-color: #fffbeb;
    }
    
    /* Smooth transitions */
    .transition-smooth {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Modern scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
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
</x-layouts.editor_layout>
