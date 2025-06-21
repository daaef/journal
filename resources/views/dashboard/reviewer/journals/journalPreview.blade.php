<x-layouts.reviewer_layout>
    <!-- Clean Navigation Breadcrumb -->
    <nav class="bg-white border-b border-gray-200 mb-8">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ route('reviewer.dashboard') }}" class="hover:text-gray-900 transition-colors">Home</a>
                <span class="text-gray-400">→</span>
                <span class="text-gray-900 font-medium">Preview: {{ Str::limit($journal->title, 50) }}</span>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Journal Details Section -->
            <div class="space-y-8">
                <!-- Academic Paper Header -->
                <div class="bg-white border border-gray-200">
                    <div class="p-8">
                    <div class="p-8">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 mb-3">{{ $journal->title }}</h1>
                                <p class="text-gray-600">Author: {{ $journal->author }}</p>
                            </div>
                            <div class="flex flex-col items-end space-y-3">
                                <span class="px-4 py-2 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium">
                                    Category: {{ $journal->category->name }}
                                </span>
                                <div class="relative group">
                                    <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                                        </svg>
                                    </button>
                                    <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                        <div class="p-3">
                                            <div class="flex space-x-2">
                                                <a href="https://www.facebook.com" class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                                                    <i class="ph ph-facebook-logo text-sm"></i>
                                                </a>
                                                <a href="https://www.twitter.com" class="w-8 h-8 bg-sky-500 text-white rounded-full flex items-center justify-center hover:bg-sky-600 transition-colors">
                                                    <i class="ph ph-twitter-logo text-sm"></i>
                                                </a>
                                                <a href="https://www.linkedin.com" class="w-8 h-8 bg-blue-700 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition-colors">
                                                    <i class="ph ph-linkedin-logo text-sm"></i>
                                                </a>
                                                <a href="https://www.instagram.com" class="w-8 h-8 bg-pink-600 text-white rounded-full flex items-center justify-center hover:bg-pink-700 transition-colors">
                                                    <i class="ph ph-instagram-logo text-sm"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                        <!-- Abstract Section -->
                        <div class="border-t border-gray-200 pt-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Abstract</h2>
                            <div class="text-gray-700 leading-relaxed">{!! $journal->abstract !!}</div>
                        </div>

                        <!-- Additional Details -->
                        <div class="border-t border-gray-200 pt-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Manuscript Details</h2>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Submitted:</span>
                                    <span class="text-gray-900 font-medium">{{ $journal->created_at->format('M d, Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Status:</span>
                                    <span class="text-gray-900 font-medium">{{ ucfirst($journal->status) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Document Reader Section -->
                <div class="bg-white border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Document Preview</h2>
                    </div>
                    <div class="p-6">
                        <x-document-reader :document="$journal" />
                    </div>
                </div>
            </div>

            <!-- Review and Actions Section -->
            <div class="space-y-8">
                <!-- Comments Section -->
                <div class="bg-white border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Review Comments</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @forelse ($comments as $comment)
                                <div class="flex items-start space-x-3 p-4 bg-gray-50 rounded-lg">
                                    <div class="flex-shrink-0 w-6 h-6 text-blue-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-gray-700">{{ $comment->comment }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    <span>No comments yet</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Review Form Section -->
                <div class="bg-white border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Submit Review</h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('reviewer.journals.approveJournalWithComment') }}" method="post" class="space-y-6">
                            @csrf
                            <div>
                                <label for="comment" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Add Comments <span class="text-sm text-gray-500 font-normal">(Required)</span>
                                </label>
                                <div class="relative">
                                    <textarea 
                                        name="comment"
                                        id="comment"
                                        rows="12"
                                        maxlength="1500"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                                        placeholder="Enter your review comments here..."
                                    ></textarea>
                                    <div class="absolute bottom-3 right-3 text-sm text-gray-400">
                                        <span id="current">0</span><span id="maximum">/1500</span>
                                    </div>
                                </div>
                            </div>
                            
                            <input type="hidden" name="journal_uuid" value="{{ $journal->uuid }}"/>
                            <input type="hidden" name="reviewer_uuid" value="{{ auth()->user()->uuid }}"/>

                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                <div class="grid grid-cols-2 gap-3">
                                    <button type="submit" name="action" value="approve" 
                                            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors font-medium">
                                        Approve
                                    </button>
                                    <button type="submit" name="action" value="decline" 
                                            class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors font-medium">
                                        Decline
                                    </button>
                                </div>
                                
                                <!-- Enhanced Review Link -->
                                <a href="{{ route('reviewer.journals.review', [$journal->uuid, $journal->slug]) }}" 
                                   class="w-full inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors font-medium">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    Enhanced Review
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Character counter for textarea
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('comment');
            const currentSpan = document.getElementById('current');
            const maximumSpan = document.getElementById('maximum');
            
            if (textarea && currentSpan) {
                textarea.addEventListener('input', function() {
                    const currentLength = this.value.length;
                    currentSpan.textContent = currentLength;
                    
                    // Change color based on character count
                    if (currentLength > 1200) {
                        currentSpan.parentElement.classList.add('text-red-500');
                        currentSpan.parentElement.classList.remove('text-gray-400');
                    } else if (currentLength > 900) {
                        currentSpan.parentElement.classList.add('text-yellow-500');
                        currentSpan.parentElement.classList.remove('text-gray-400', 'text-red-500');
                    } else {
                        currentSpan.parentElement.classList.add('text-gray-400');
                        currentSpan.parentElement.classList.remove('text-yellow-500', 'text-red-500');
                    }
                });
            }
        });
    </script>
</x-layouts.reviewer_layout>
