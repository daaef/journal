<x-layouts.reviewer_layout>
    @php
        // Ensure variables are defined to prevent errors
        $existingReview = $existingReview ?? null;
        $otherReviews = $otherReviews ?? collect();
    @endphp

    <!-- Modern Header with Gradient -->
    <div class="bg-gradient-to-r from-slate-50 to-blue-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <!-- Breadcrumb -->
            <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-6">
                <a href="{{ route('reviewer.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                <span class="text-gray-900 font-medium">Enhanced Review</span>
            </nav>

            <!-- Title Section -->
            <div class="flex items-start justify-between mb-6">
                <div class="flex-1 pr-6">
                    <h1 class="text-3xl font-light text-gray-900 leading-tight mb-4">{{ $journal->title }}</h1>
                    <div class="flex flex-wrap items-center gap-4 text-sm">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $journal->author->fullname ?? $journal->author }}
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $journal->created_at->format('F j, Y') }}
                        </div>
                        <span class="px-3 py-1 bg-white text-gray-700 text-xs font-medium rounded-full border">
                            {{ $journal->category->name ?? 'N/A' }}
                        </span>
                    </div>
                </div>
                
                <!-- Status Badge -->
                <div class="flex-shrink-0">
                    @if($existingReview && $existingReview->review_submitted_at)
                        <div class="px-4 py-2 bg-green-100 text-green-800 rounded-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Review Submitted
                        </div>
                    @else
                        <div class="px-4 py-2 bg-amber-100 text-amber-800 rounded-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            Review Pending
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
            
            <!-- Document & Abstract Column -->
            <div class="xl:col-span-8 space-y-6">
                
                <!-- Abstract Card -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-900">Abstract</h2>
                    </div>
                    <div class="p-6">
                        <div class="text-gray-700 leading-relaxed">{!! $journal->abstract !!}</div>
                    </div>
                </div>

                <!-- Document Reader Card -->
                @if($journal->journal_url)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Manuscript Document</h2>
                            <a href="{{ asset('storage/' . $journal->journal_url) }}" target="_blank" 
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download PDF
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        <x-document-reader 
                            :journal="$journal" 
                            title="Manuscript for Review"
                            subtitle="Review the complete manuscript document"
                            height="700px"
                            role="reviewer"
                            :showControls="true"
                        />
                    </div>
                </div>
                @endif

            </div>

            <!-- Sidebar -->
            <div class="xl:col-span-4 space-y-6">
                <!-- Manuscript Details Card -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Manuscript Information</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Submitted</span>
                                <p class="font-medium text-gray-900">{{ $journal->created_at->format('M j, Y') }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Version</span>
                                <p class="font-medium text-gray-900">{{ $journal->versions->count() > 0 ? $journal->versions->first()->version_number : '1.0' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Institution</span>
                                <p class="font-medium text-gray-900 text-xs">{{ Str::limit($journal->institution ?? 'N/A', 15) }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Language</span>
                                <p class="font-medium text-gray-900">{{ $journal->journal_language ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-100">
                            <span class="text-sm text-gray-500">Review Due</span>
                            <div class="flex items-center mt-1">
                                <svg class="w-4 h-4 text-amber-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                <p class="text-amber-600 font-medium">{{ now()->addWeeks(3)->format('M j, Y') }}</p>
                            </div>
                        </div>

                        @if($journal->keywords)
                        <div class="pt-4 border-t border-gray-100">
                            <span class="text-sm text-gray-500 mb-3 block">Keywords</span>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $journal->keywords) as $keyword)
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-full border border-blue-200">{{ trim($keyword) }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Progress Card -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Review Progress</h3>
                        @if($existingReview && $existingReview->review_submitted_at)
                            <div class="text-center py-6">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-900 mb-1">Review Completed</p>
                                <p class="text-xs text-gray-500">{{ $existingReview->review_submitted_at->format('M j, Y') }}</p>
                            </div>
                        @else
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Review Status</span>
                                    <span class="text-sm font-medium text-amber-600">In Progress</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-amber-500 h-2 rounded-full" style="width: 45%"></div>
                                </div>
                                <p class="text-xs text-gray-500">Complete the form below to submit your review</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <!-- Review Form Section -->
        @if(!($existingReview && $existingReview->review_submitted_at))
        <div class="mt-8">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Submit Your Review
                    </h2>
                    <p class="text-gray-600 mt-2">Please provide a comprehensive evaluation of this manuscript based on academic standards.</p>
                </div>
                
                <div class="p-8">
                    <form action="{{ route('reviewer.journals.submitReview') }}" method="POST" id="enhancedReviewForm" class="space-y-8">
                        @csrf
                        <input type="hidden" name="journal_uuid" value="{{ $journal->uuid }}">
                        <input type="hidden" name="reviewer_id" value="{{ auth()->id() }}">

                        <!-- Rating Section -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Academic Assessment</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Scholarly Merit -->
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <label class="block text-sm font-semibold text-gray-900 mb-3">Scholarly Merit</label>
                                    <select name="criteria_ratings[scholarly_merit]" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                        <option value="">Select Rating</option>
                                        <option value="1">1 - Poor</option>
                                        <option value="2">2 - Fair</option>
                                        <option value="3">3 - Good</option>
                                        <option value="4">4 - Very Good</option>
                                        <option value="5">5 - Excellent</option>
                                    </select>
                                </div>

                                <!-- Methodology -->
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <label class="block text-sm font-semibold text-gray-900 mb-3">Methodology</label>
                                    <select name="criteria_ratings[methodology]" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                        <option value="">Select Rating</option>
                                        <option value="1">1 - Poor</option>
                                        <option value="2">2 - Fair</option>
                                        <option value="3">3 - Good</option>
                                        <option value="4">4 - Very Good</option>
                                        <option value="5">5 - Excellent</option>
                                    </select>
                                </div>

                                <!-- Presentation -->
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <label class="block text-sm font-semibold text-gray-900 mb-3">Presentation</label>
                                    <select name="criteria_ratings[presentation]" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                        <option value="">Select Rating</option>
                                        <option value="1">1 - Poor</option>
                                        <option value="2">2 - Fair</option>
                                        <option value="3">3 - Good</option>
                                        <option value="4">4 - Very Good</option>
                                        <option value="5">5 - Excellent</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Overall Rating & Recommendation -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Overall Rating -->
                            <div class="bg-white rounded-lg border border-gray-200 p-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-4">Overall Rating</label>
                                <div class="space-y-3">
                                    @for($i = 1; $i <= 5; $i++)
                                    <label class="flex items-center cursor-pointer hover:bg-gray-50 p-2 rounded-lg transition-colors">
                                        <input type="radio" name="overall_rating" value="{{ $i }}" class="mr-3 text-blue-600 focus:ring-blue-500">
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

                            <!-- Recommendation -->
                            <div class="bg-white rounded-lg border border-gray-200 p-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-4">Editorial Recommendation</label>
                                <div class="space-y-3">
                                    <label class="flex items-center cursor-pointer hover:bg-green-50 p-3 rounded-lg border border-transparent hover:border-green-200 transition-all">
                                        <input type="radio" name="recommendation" value="accept" class="mr-3 text-green-600 focus:ring-green-500">
                                        <div>
                                            <div class="text-sm font-medium text-green-800">Accept</div>
                                            <div class="text-xs text-green-600">Ready for publication</div>
                                        </div>
                                    </label>
                                    <label class="flex items-center cursor-pointer hover:bg-blue-50 p-3 rounded-lg border border-transparent hover:border-blue-200 transition-all">
                                        <input type="radio" name="recommendation" value="minor_revisions" class="mr-3 text-blue-600 focus:ring-blue-500">
                                        <div>
                                            <div class="text-sm font-medium text-blue-800">Minor Revisions</div>
                                            <div class="text-xs text-blue-600">Small changes needed</div>
                                        </div>
                                    </label>
                                    <label class="flex items-center cursor-pointer hover:bg-yellow-50 p-3 rounded-lg border border-transparent hover:border-yellow-200 transition-all">
                                        <input type="radio" name="recommendation" value="major_revisions" class="mr-3 text-yellow-600 focus:ring-yellow-500">
                                        <div>
                                            <div class="text-sm font-medium text-yellow-800">Major Revisions</div>
                                            <div class="text-xs text-yellow-600">Significant changes required</div>
                                        </div>
                                    </label>
                                    <label class="flex items-center cursor-pointer hover:bg-red-50 p-3 rounded-lg border border-transparent hover:border-red-200 transition-all">
                                        <input type="radio" name="recommendation" value="reject" class="mr-3 text-red-600 focus:ring-red-500">
                                        <div>
                                            <div class="text-sm font-medium text-red-800">Reject</div>
                                            <div class="text-xs text-red-600">Not suitable for publication</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Comments Section -->
                        <div class="space-y-6">
                            <!-- Author Comments -->
                            <div class="bg-white rounded-lg border border-gray-200 p-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-4">Comments for Author</label>
                                <p class="text-sm text-gray-600 mb-4">These comments will be shared with the author to help improve their manuscript.</p>
                                <textarea name="comment" 
                                          rows="6"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-vertical"
                                          placeholder="Provide detailed feedback on the manuscript's strengths, weaknesses, and suggestions for improvement..."
                                          id="authorCommentsTextarea"></textarea>
                                <div class="mt-2 text-right text-sm text-gray-500">
                                    <span id="authorCommentsCount">0</span> / 2000 characters
                                </div>
                            </div>

                            <!-- Confidential Comments -->
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-4">Confidential Comments for Editor</label>
                                <p class="text-sm text-gray-600 mb-4">These comments are private and will only be seen by the editorial team.</p>
                                <textarea name="confidential_comments" 
                                          rows="4"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-vertical bg-white"
                                          placeholder="Share any concerns or additional context that should remain confidential..."
                                          id="editorCommentsTextarea"></textarea>
                                <div class="mt-2 text-right text-sm text-gray-500">
                                    <span id="editorCommentsCount">0</span> / 1000 characters
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-6 border-t border-gray-200">
                            <button type="submit" 
                                    class="px-8 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors shadow-lg">
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
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Your Submitted Review
                    </h2>
                    <p class="text-gray-600 mt-2">Review submitted on {{ $existingReview->review_submitted_at->format('F j, Y \a\t g:i A') }}</p>
                </div>
                
                <div class="p-8 space-y-6">
                    <!-- Display existing review data here if needed -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-blue-800 font-medium">Review Complete</p>
                        <p class="text-blue-700 text-sm">Your review has been successfully submitted and is now with the editorial team for processing.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
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

            // Form validation
            const form = document.getElementById('enhancedReviewForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const errors = [];
                    let isValid = true;

                    // Check criteria ratings
                    const criteriaSelects = form.querySelectorAll('select[name^="criteria_ratings"]');
                    criteriaSelects.forEach(select => {
                        if (!select.value) {
                            errors.push(`Please rate ${select.name.replace('criteria_ratings[', '').replace(']', '').replace('_', ' ')}.`);
                            isValid = false;
                        }
                    });

                    // Check overall rating
                    const rating = form.querySelector('input[name="overall_rating"]:checked');
                    if (!rating) {
                        errors.push('Please provide an overall rating.');
                        isValid = false;
                    }

                    // Check recommendation
                    const recommendation = form.querySelector('input[name="recommendation"]:checked');
                    if (!recommendation) {
                        errors.push('Please select an editorial recommendation.');
                        isValid = false;
                    }

                    // Check comments
                    const comment = form.querySelector('textarea[name="comment"]').value.trim();
                    if (!comment) {
                        errors.push('Please provide comments for the author.');
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
                        
                        // Auto-remove after 5 seconds
                        setTimeout(() => {
                            if (errorDiv.parentElement) {
                                errorDiv.remove();
                            }
                        }, 5000);

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
    </script>

    <style>
        /* Modern Academic Styling */
        .academic-gradient {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        
        /* Enhanced focus states */
        .form-input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* Smooth transitions */
        .transition-smooth {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Modern shadows */
        .shadow-modern {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        /* Rating hover effects */
        input[type="radio"]:hover + div {
            background-color: rgba(59, 130, 246, 0.05);
        }
        
        /* Card hover effects */
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</x-layouts.reviewer_layout>
