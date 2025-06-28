<x-layouts.reviewer_layout>
    @php
        // Ensure variables are defined to prevent errors
        $existingReview = $existingReview ?? null;
        $otherReviews = $otherReviews ?? collect();
    @endphp    <!-- Enhanced Breadcrumb with Action Bar -->
    <div class="bg-white z-40 backdrop-blur-sm bg-white/95">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('reviewer.dashboard') }}" class="inline-flex items-center px-3 py-2 text-gray-600 hover:text-slate-600 hover:bg-slate-50 rounded-lg transition-all duration-200 text-sm font-medium group">
                        Dashboard
                    </a>
                    <span class="text-gray-300">/</span>
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-900 font-semibold text-sm">{{ Str::limit($journal->title, 45) }}</span>
                    </div>
                </div>
                
                <!-- Status Badge -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-800 rounded-full text-xs font-medium">
                            Peer Review
                        </span>
                        @if($existingReview && $existingReview->review_submitted_at)
                            <span class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                <span class="w-2 h-2 rounded-full mr-2 bg-green-500"></span>
                                Review Submitted
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">
                                <span class="w-2 h-2 rounded-full mr-2 bg-amber-500"></span>
                                Review Pending
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 pt-0 pb-8">
            
            <!-- Display validation errors -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-500 mt-1 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="text-red-800 font-medium text-sm">Please correct the following errors:</h3>
                            <ul class="text-red-700 text-sm mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Display success message -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mt-1 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="text-green-800 font-medium text-sm">{{ session('success') }}</h3>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Enhanced Hero Section -->
            <div class="bg-white rounded-2xl shadow-sm shadow-gray-900/10 mb-8 overflow-hidden border border-gray-100">
                <!-- Header with Gradient -->
                <div class="relative bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 p-16 text-white overflow-hidden">
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
                                            <p class="font-semibold text-white my-0">{{ $journal->author->fullname ?? $journal->author }}</p>
                                        </div>
                                        
                                        <div class="px-3 py-2 rounded-lg">
                                            <p class="text-white/80 text-xs my-0">Submitted</p>
                                            <p class="font-semibold text-white my-0">{{ $journal->created_at->format('M j, Y') }}</p>
                                        </div>
                                        
                                        <div class="px-3 py-2 rounded-lg">
                                            <p class="text-white/80 text-xs my-0">Category</p>
                                            <p class="font-semibold text-white my-0">{{ $journal->category->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Status Card -->
                            <div class="lg:col-span-4 flex justify-end">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-40">
                                    <p class="text-white/80 text-sm mb-1 my-0 text-center">Review Status</p>
                                    @if($existingReview && $existingReview->review_submitted_at)
                                        <p class="text-white font-bold text-lg my-0 text-center">Completed</p>
                                        <p class="text-white/80 text-xs my-0 text-center mt-1">{{ $existingReview->review_submitted_at->format('M j, Y') }}</p>
                                    @else
                                        <p class="text-white font-bold text-lg my-0 text-center">In Progress</p>
                                        <p class="text-white/80 text-xs my-0 text-center mt-1">Due: {{ now()->addWeeks(3)->format('M j, Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
            
            <!-- Document & Abstract Column -->
            <div class="xl:col-span-8 space-y-8">
                
                <!-- Abstract Card -->
                <div class="bg-white rounded-xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 bg-gradient-to-r from-slate-50 to-blue-50 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-sm">
                                <i class="ph ph-article text-white text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Abstract</h2>
                                <p class="text-sm text-gray-600">Research overview and methodology</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="prose prose-gray max-w-none text-gray-700 leading-relaxed">{!! $journal->abstract !!}</div>
                    </div>
                </div>

                <!-- Document Reader Card -->
                @if($journal->journal_url)
                <div class="bg-white rounded-xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 bg-gradient-to-r from-purple-50 to-violet-50 border-b border-gray-100">
                        <div class="flex items-center space-x-4">
                            <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-violet-600 rounded-xl flex items-center justify-center shadow-md">
                                <i class="ph ph-file-search text-white text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 leading-tight">Manuscript for Review</h3>
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <i class="ph ph-user-check mr-1"></i>
                                    Reviewer Analysis
                                </span>
                                <a href="{{ asset('storage/' . $journal->journal_url) }}" target="_blank" 
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <x-document-preview 
                            :document-url="$documentUrl" 
                            :document-type="$documentType"
                            title="Manuscript for Review"
                            subtitle="Review the complete manuscript document"
                            height="700px"
                            :show-controls="true"
                        />
                    </div>
                </div>
                @endif

            </div>            <!-- Sidebar -->
            <div class="xl:col-span-4 space-y-8">
                <!-- Manuscript Details Card -->
                <div class="bg-white rounded-xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 bg-gradient-to-r from-slate-50 to-gray-50 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-20 h-20 bg-gradient-to-br from-gray-500 to-gray-600 rounded-xl flex items-center justify-center shadow-sm">
                                <i class="ph ph-info text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Manuscript Details</h3>
                                <p class="text-sm text-gray-600">Publication information</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-gray-500 text-xs font-medium">Submitted</span>
                                <p class="font-semibold text-gray-900 mt-1">{{ $journal->created_at->format('M j, Y') }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-gray-500 text-xs font-medium">Version</span>
                                <p class="font-semibold text-gray-900 mt-1">{{ $journal->versions->count() > 0 ? $journal->versions->first()->version_number : '1.0' }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-gray-500 text-xs font-medium">Institution</span>
                                <p class="font-semibold text-gray-900 text-xs mt-1" title="{{ $journal->institution ?? 'N/A' }}">{{ Str::limit($journal->institution ?? 'N/A', 15) }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-gray-500 text-xs font-medium">Language</span>
                                <p class="font-semibold text-gray-900 mt-1">{{ $journal->journal_language ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="bg-amber-50 rounded-lg p-4 border border-amber-200">
                            <div class="flex items-center space-x-2 mb-2">
                                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-medium text-amber-800">Review Due</span>
                            </div>
                            <p class="text-amber-700 font-semibold">{{ now()->addWeeks(3)->format('M j, Y') }}</p>
                        </div>

                        @if($journal->keywords)
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <span class="text-sm font-medium text-blue-800 mb-3 block">Keywords</span>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $journal->keywords) as $keyword)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full border border-blue-300 font-medium">{{ trim($keyword) }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Progress Card -->
                <div class="bg-white rounded-xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-sm">
                                <i class="ph ph-chart-line text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Review Progress</h3>
                                <p class="text-sm text-gray-600">Current status overview</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($existingReview && $existingReview->review_submitted_at)
                            <div class="text-center py-6">
                                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                    <svg class="w-20 h-20 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-900 mb-1">Review Completed</p>
                                <p class="text-xs text-gray-500">{{ $existingReview->review_submitted_at->format('M j, Y') }}</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600 font-medium">Review Status</span>
                                    <span class="text-sm font-semibold text-amber-600">In Progress</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3 shadow-inner">
                                    <div class="bg-gradient-to-r from-amber-400 to-amber-500 h-3 rounded-full shadow-sm" style="width: 45%"></div>
                                </div>
                                <p class="text-xs text-gray-500">Complete the form below to submit your review</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>        <!-- Review Form Section -->
        @if(!($existingReview && $existingReview->review_submitted_at))
        <div class="mt-8">
            <div class="bg-white rounded-xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Submit Your Review</h2>
                            <p class="text-gray-600 text-sm">Comprehensive evaluation based on academic standards</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-8">
                    <form action="{{ route('reviewer.journals.submitReview') }}" method="POST" id="enhancedReviewForm" class="space-y-8">
                        @csrf
                        <input type="hidden" name="journal_uuid" value="{{ $journal->uuid }}">
                        <input type="hidden" name="reviewer_id" value="{{ auth()->id() }}">

                        <!-- Rating Section -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200 shadow-sm">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="ph ph-star text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Academic Assessment</h3>
                                    <p class="text-sm text-gray-600">Rate the manuscript across key criteria</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">                                <!-- Scholarly Merit -->
                                <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                                    <label class="block text-sm font-semibold text-gray-900 mb-3">Scholarly Merit</label>
                                    <select name="criteria_ratings[scholarly_merit]" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors">
                                        <option value="">Select Rating</option>
                                        <option value="1" {{ old('criteria_ratings.scholarly_merit') == '1' ? 'selected' : '' }}>1 - Poor</option>
                                        <option value="2" {{ old('criteria_ratings.scholarly_merit') == '2' ? 'selected' : '' }}>2 - Fair</option>
                                        <option value="3" {{ old('criteria_ratings.scholarly_merit') == '3' ? 'selected' : '' }}>3 - Good</option>
                                        <option value="4" {{ old('criteria_ratings.scholarly_merit') == '4' ? 'selected' : '' }}>4 - Very Good</option>
                                        <option value="5" {{ old('criteria_ratings.scholarly_merit') == '5' ? 'selected' : '' }}>5 - Excellent</option>
                                    </select>
                                </div>

                                <!-- Methodology -->
                                <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                                    <label class="block text-sm font-semibold text-gray-900 mb-3">Methodology</label>
                                    <select name="criteria_ratings[methodology]" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors">
                                        <option value="">Select Rating</option>
                                        <option value="1" {{ old('criteria_ratings.methodology') == '1' ? 'selected' : '' }}>1 - Poor</option>
                                        <option value="2" {{ old('criteria_ratings.methodology') == '2' ? 'selected' : '' }}>2 - Fair</option>
                                        <option value="3" {{ old('criteria_ratings.methodology') == '3' ? 'selected' : '' }}>3 - Good</option>
                                        <option value="4" {{ old('criteria_ratings.methodology') == '4' ? 'selected' : '' }}>4 - Very Good</option>
                                        <option value="5" {{ old('criteria_ratings.methodology') == '5' ? 'selected' : '' }}>5 - Excellent</option>
                                    </select>
                                </div>

                                <!-- Presentation -->
                                <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                                    <label class="block text-sm font-semibold text-gray-900 mb-3">Presentation</label>
                                    <select name="criteria_ratings[presentation]" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors">
                                        <option value="">Select Rating</option>
                                        <option value="1" {{ old('criteria_ratings.presentation') == '1' ? 'selected' : '' }}>1 - Poor</option>
                                        <option value="2" {{ old('criteria_ratings.presentation') == '2' ? 'selected' : '' }}>2 - Fair</option>
                                        <option value="3" {{ old('criteria_ratings.presentation') == '3' ? 'selected' : '' }}>3 - Good</option>
                                        <option value="4" {{ old('criteria_ratings.presentation') == '4' ? 'selected' : '' }}>4 - Very Good</option>
                                        <option value="5" {{ old('criteria_ratings.presentation') == '5' ? 'selected' : '' }}>5 - Excellent</option>
                                    </select>
                                </div>
                            </div>
                        </div>                        <!-- Overall Rating & Recommendation -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Overall Rating -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                                <div class="px-6 py-4 bg-gradient-to-r from-yellow-50 to-orange-50 border-b border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-lg flex items-center justify-center shadow-sm">
                                            <i class="ph ph-star text-white text-sm"></i>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-900">Overall Rating</h4>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="space-y-3">                                        @for($i = 1; $i <= 5; $i++)
                                        <label class="flex items-center cursor-pointer hover:bg-gray-50 p-3 rounded-lg transition-all duration-200 border border-transparent hover:border-gray-200 hover:shadow-sm">
                                            <input type="radio" name="rating" value="{{ $i }}" class="mr-3 text-blue-600 focus:ring-blue-500 focus:ring-2" {{ old('rating') == $i ? 'checked' : '' }}>
                                            <div class="flex items-center">
                                                <div class="flex mr-3">
                                                    @for($j = 1; $j <= 5; $j++)
                                                        <svg class="w-4 h-4 {{ $j <= $i ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <span class="text-sm font-medium text-gray-700">
                                                    @if($i == 1) Poor
                                                    @elseif($i == 2) Fair
                                                    @elseif($i == 3) Good
                                                    @elseif($i == 4) Very Good
                                                    @else Excellent
                                                    @endif
                                                </span>
                                            </div>
                                        </label>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            <!-- Recommendation -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-indigo-50 border-b border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-sm">
                                            <i class="ph ph-clipboard-text text-white text-sm"></i>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-900">Editorial Recommendation</h4>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="space-y-3">                                        <label class="flex items-center cursor-pointer hover:bg-green-50 p-3 rounded-lg border border-transparent hover:border-green-200 transition-all duration-200 hover:shadow-sm">
                                            <input type="radio" name="recommendation" value="accept" class="mr-3 text-green-600 focus:ring-green-500 focus:ring-2" {{ old('recommendation') == 'accept' ? 'checked' : '' }}>
                                            <div>
                                                <div class="text-sm font-semibold text-green-800">Accept</div>
                                                <div class="text-xs text-green-600">Ready for publication</div>
                                            </div>
                                        </label>
                                        <label class="flex items-center cursor-pointer hover:bg-blue-50 p-3 rounded-lg border border-transparent hover:border-blue-200 transition-all duration-200 hover:shadow-sm">
                                            <input type="radio" name="recommendation" value="minor_revision" class="mr-3 text-blue-600 focus:ring-blue-500 focus:ring-2" {{ old('recommendation') == 'minor_revision' ? 'checked' : '' }}>
                                            <div>
                                                <div class="text-sm font-semibold text-blue-800">Minor Revisions</div>
                                                <div class="text-xs text-blue-600">Small changes needed</div>
                                            </div>
                                        </label>
                                        <label class="flex items-center cursor-pointer hover:bg-yellow-50 p-3 rounded-lg border border-transparent hover:border-yellow-200 transition-all duration-200 hover:shadow-sm">
                                            <input type="radio" name="recommendation" value="major_revision" class="mr-3 text-yellow-600 focus:ring-yellow-500 focus:ring-2" {{ old('recommendation') == 'major_revision' ? 'checked' : '' }}>
                                            <div>
                                                <div class="text-sm font-semibold text-yellow-800">Major Revisions</div>
                                                <div class="text-xs text-yellow-600">Significant changes required</div>
                                            </div>
                                        </label>
                                        <label class="flex items-center cursor-pointer hover:bg-red-50 p-3 rounded-lg border border-transparent hover:border-red-200 transition-all duration-200 hover:shadow-sm">
                                            <input type="radio" name="recommendation" value="reject" class="mr-3 text-red-600 focus:ring-red-500 focus:ring-2" {{ old('recommendation') == 'reject' ? 'checked' : '' }}>
                                            <div>
                                                <div class="text-sm font-semibold text-red-800">Reject</div>
                                                <div class="text-xs text-red-600">Not suitable for publication</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>                        <!-- Comments Section -->
                        <div class="space-y-8">
                            <!-- Author Comments -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                                <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center shadow-sm">
                                            <i class="ph ph-chat-text text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900">Comments for Author</h4>
                                            <p class="text-sm text-gray-600">Feedback to help improve the manuscript</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-6">                                    <textarea name="comment" 
                                              rows="6"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-vertical transition-colors shadow-sm"
                                              placeholder="Provide detailed feedback on the manuscript's strengths, weaknesses, and suggestions for improvement..."
                                              id="authorCommentsTextarea">{{ old('comment') }}</textarea>
                                    <div class="mt-3 flex justify-between items-center">
                                        <p class="text-xs text-gray-500">Share constructive feedback to help the author improve their work</p>
                                        <div class="text-sm text-gray-500">
                                            <span id="authorCommentsCount">0</span> / 2000 characters
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Confidential Comments -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-slate-50 border-b border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-20 h-20 bg-gradient-to-br from-gray-500 to-slate-600 rounded-lg flex items-center justify-center shadow-sm">
                                            <i class="ph ph-lock text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900">Confidential Comments for Editor</h4>
                                            <p class="text-sm text-gray-600">Private notes for editorial team only</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-6">                                    <textarea name="confidential_comments" 
                                              rows="4"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-vertical bg-white transition-colors shadow-sm"
                                              placeholder="Share any concerns or additional context that should remain confidential..."
                                              id="editorCommentsTextarea">{{ old('confidential_comments') }}</textarea>
                                    <div class="mt-3 flex justify-between items-center">
                                        <p class="text-xs text-gray-500">Additional context or concerns for the editorial team</p>
                                        <div class="text-sm text-gray-500">
                                            <span id="editorCommentsCount">0</span> / 1000 characters
                                        </div>
                                    </div>
                                </div>
                            </div>                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-8 border-t border-gray-200">
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @else
        <!-- Read-only Review Display -->
        <div class="mt-8">
            <div class="bg-white rounded-xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Your Submitted Review</h2>
                            <p class="text-gray-600 text-sm">Review submitted on {{ $existingReview->review_submitted_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-8 space-y-6">
                    <!-- Display existing review data here if needed -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6 shadow-sm">
                        <div class="flex items-center space-x-3">
                            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-sm">
                                <i class="ph ph-check-circle text-white text-lg"></i>
                            </div>
                            <div>
                                <p class="text-blue-900 font-semibold">Review Complete</p>
                                <p class="text-blue-800 text-sm">Your review has been successfully submitted and is now with the editorial team for processing.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Character counters
            const authorTextarea = document.getElementById('authorCommentsTextarea');
            const editorTextarea = document.getElementById('editorCommentsTextarea');
            const authorCounter = document.getElementById('authorCommentsCount');
            const editorCounter = document.getElementById('editorCommentsCount');

            if (authorTextarea && authorCounter) {
                authorTextarea.addEventListener('input', function() {
                    const count = this.value.length;
                    authorCounter.textContent = count;
                    if (count > 1800) {
                        authorCounter.parentElement.classList.add('text-red-500');
                    } else {
                        authorCounter.parentElement.classList.remove('text-red-500');
                    }
                });
            }

            if (editorTextarea && editorCounter) {
                editorTextarea.addEventListener('input', function() {
                    const count = this.value.length;
                    editorCounter.textContent = count;
                    if (count > 900) {
                        editorCounter.parentElement.classList.add('text-red-500');
                    } else {
                        editorCounter.parentElement.classList.remove('text-red-500');
                    }
                });
            }

            // Real-time validation feedback
            const addValidationFeedback = () => {
                // Add feedback to criteria selects
                const criteriaSelects = form.querySelectorAll('select[name^="criteria_ratings"]');
                criteriaSelects.forEach(select => {
                    select.addEventListener('change', function() {
                        if (this.value) {
                            this.classList.remove('border-red-500');
                            this.classList.add('border-green-300', 'border-gray-300');
                        }
                    });
                });

                // Add feedback to radio buttons
                const radioGroups = ['rating', 'recommendation'];
                radioGroups.forEach(groupName => {
                    const radios = form.querySelectorAll(`input[name="${groupName}"]`);
                    radios.forEach(radio => {
                        radio.addEventListener('change', function() {
                            const container = this.closest('.space-y-3') || this.closest('.p-6');
                            if (container) {
                                container.style.border = '';
                                container.style.borderRadius = '';
                            }
                        });
                    });
                });

                // Add feedback to textareas
                const comment = form.querySelector('textarea[name="comment"]');
                if (comment) {
                    comment.addEventListener('input', function() {
                        const length = this.value.trim().length;
                        if (length >= 50) {
                            this.classList.remove('border-red-500');
                            this.classList.add('border-green-300');
                        } else if (length > 0) {
                            this.classList.remove('border-green-300', 'border-red-500');
                            this.classList.add('border-yellow-300');
                        } else {
                            this.classList.remove('border-green-300', 'border-yellow-300');
                            this.classList.add('border-gray-300');
                        }
                    });
                }

                const confidentialComment = form.querySelector('textarea[name="confidential_comments"]');
                if (confidentialComment) {
                    confidentialComment.addEventListener('input', function() {
                        const length = this.value.trim().length;
                        if (length > 1000) {
                            this.classList.remove('border-green-300');
                            this.classList.add('border-red-500');
                        } else {
                            this.classList.remove('border-red-500');
                            this.classList.add('border-gray-300');
                        }
                    });
                }
            };

            // Ensure form is defined before adding validation feedback
            const form = document.getElementById('enhancedReviewForm');
            if (form) {
                addValidationFeedback();
            }

            // Form validation
            if (form) {
                form.addEventListener('submit', function(e) {
                    const errors = [];
                    let isValid = true;                    // Check criteria ratings
                    const criteriaSelects = form.querySelectorAll('select[name^="criteria_ratings"]');
                    let emptyCriteria = [];
                    criteriaSelects.forEach(select => {
                        if (!select.value) {
                            const criteriaName = select.name.replace('criteria_ratings[', '').replace(']', '').replace('_', ' ');
                            emptyCriteria.push(criteriaName.charAt(0).toUpperCase() + criteriaName.slice(1));
                            isValid = false;
                        }
                    });
                    
                    if (emptyCriteria.length > 0) {
                        errors.push(`Please rate: ${emptyCriteria.join(', ')}`);
                    }// Check overall rating
                    const rating = form.querySelector('input[name="rating"]:checked');
                    if (!rating) {
                        errors.push('Please provide an overall rating.');
                        isValid = false;
                    }

                    // Check recommendation
                    const recommendation = form.querySelector('input[name="recommendation"]:checked');
                    if (!recommendation) {
                        errors.push('Please select an editorial recommendation.');
                        isValid = false;
                    }                    // Check comments
                    const comment = form.querySelector('textarea[name="comment"]').value.trim();
                    if (!comment) {
                        errors.push('Please provide comments for the author.');
                        isValid = false;
                    } else if (comment.length < 50) {
                        errors.push('Comments for author must be at least 50 characters long.');
                        isValid = false;
                    }

                    // Check character limits
                    if (comment.length > 2000) {
                        errors.push('Comments for author exceed 2000 character limit.');
                        isValid = false;
                    }
                    
                    const confidentialComment = form.querySelector('textarea[name="confidential_comments"]').value.trim();
                    if (confidentialComment.length > 1000) {
                        errors.push('Confidential comments exceed 1000 character limit.');
                        isValid = false;
                    }

                    if (!isValid) {
                        e.preventDefault();
                        
                        // Remove existing error
                        const existingError = document.querySelector('.validation-errors');
                        if (existingError) {
                            existingError.remove();
                        }

                        // Create error message
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'validation-errors fixed top-4 right-4 z-50 max-w-md bg-red-50 border border-red-200 rounded-lg p-4 shadow-lg';
                        errorDiv.innerHTML = `
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mt-1 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <h3 class="text-red-800 font-medium text-sm">Please complete the following:</h3>
                                    <ul class="text-red-700 text-sm mt-2 list-disc list-inside">
                                        ${errors.map(error => `<li>${error}</li>`).join('')}
                                    </ul>
                                </div>
                                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-500 hover:text-red-700">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        `;
                          document.body.appendChild(errorDiv);
                        
                        // Scroll to first error field and highlight it
                        let firstErrorField = null;
                        
                        // Remove previous error highlights
                        form.querySelectorAll('.border-red-300, .border-red-500').forEach(el => {
                            el.classList.remove('border-red-300', 'border-red-500');
                            el.classList.add('border-gray-300');
                        });
                        
                        // Find and highlight first error field
                        if (emptyCriteria.length > 0) {
                            firstErrorField = form.querySelector('select[name^="criteria_ratings"]:not([value])') || 
                                            form.querySelector('select[name^="criteria_ratings"]');
                        } else if (!rating) {
                            firstErrorField = form.querySelector('input[name="rating"]');
                        } else if (!recommendation) {
                            firstErrorField = form.querySelector('input[name="recommendation"]');
                        } else if (!comment || comment.length < 50) {
                            firstErrorField = form.querySelector('textarea[name="comment"]');
                        }
                        
                        if (firstErrorField) {
                            // Highlight the error field
                            if (firstErrorField.tagName === 'SELECT' || firstErrorField.tagName === 'TEXTAREA') {
                                firstErrorField.classList.remove('border-gray-300');
                                firstErrorField.classList.add('border-red-500');
                            } else if (firstErrorField.type === 'radio') {
                                // Highlight the parent container for radio buttons
                                const radioContainer = firstErrorField.closest('.space-y-3') || firstErrorField.closest('.p-6');
                                if (radioContainer) {
                                    radioContainer.style.border = '2px solid #ef4444';
                                    radioContainer.style.borderRadius = '8px';
                                    setTimeout(() => {
                                        radioContainer.style.border = '';
                                        radioContainer.style.borderRadius = '';
                                    }, 3000);
                                }
                            }
                            
                            // Scroll to the field
                            firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            
                            // Focus if possible
                            if (firstErrorField.focus && (firstErrorField.tagName === 'SELECT' || firstErrorField.tagName === 'TEXTAREA')) {
                                setTimeout(() => firstErrorField.focus(), 300);
                            }
                        }
                        
                        // Auto-remove after 8 seconds                        setTimeout(() => {
                            if (errorDiv.parentElement) {
                                errorDiv.remove();
                            }
                        }, 8000);

                        return false;
                    }

                    // Show loading state
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalHTML = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <svg class="w-5 h-5 inline-block mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Submitting Review...
                    `;

                    // Reset after delay if something goes wrong
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalHTML;
                    }, 10000);
                });
            }
        });
    </script>    <style>
        /* Modern Academic Styling */
        .academic-gradient {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
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
        
        /* Enhanced focus states */
        .form-input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            transform: scale(1.01);
            transition: all 0.2s ease-in-out;
        }
        
        /* Smooth transitions */
        .transition-smooth {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Rating hover effects */
        input[type="radio"]:hover + div {
            background-color: rgba(59, 130, 246, 0.05);
            transform: scale(1.02);
        }
        
        /* Gradient text */
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        /* Enhanced button effects */
        button:hover {
            transform: translateY(-1px);
        }
        
        button:active {
            transform: translateY(0);
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
</x-layouts.reviewer_layout>
