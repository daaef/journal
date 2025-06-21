<x-layouts.editor_layout>
    <!-- Clean Academic Breadcrumb -->
    <nav class="bg-white border-b border-gray-200 px-6 py-4 mb-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center space-x-3 text-sm text-gray-600">
                <a href="{{ route('editor.dashboard') }}" class="hover:text-blue-600 transition-colors font-medium">
                    Dashboard
                </a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-900 font-medium">{{ Str::limit($journal->title, 60) }}</span>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-8">

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content Area -->
            <div class="lg:col-span-3">
                <!-- Academic Paper Header -->
                <div class="bg-white border border-gray-200 mb-8">
                    <!-- Title and Metadata -->
                    <div class="p-8 border-b border-gray-100">
                        <h1 class="text-3xl font-light text-gray-900 leading-tight mb-6">{{ $journal->title }}</h1>
                        
                        <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600 mb-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">{{ $journal->author }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $journal->created_at->format('F j, Y') }}</span>
                            </div>
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 text-xs uppercase tracking-wide font-medium rounded">
                                {{ $journal->category->name }}
                            </span>
                        </div>
                    </div>

                    <!-- Abstract Section -->
                    <div class="p-8 border-b border-gray-100">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Abstract</h2>
                        <div class="text-gray-700 leading-relaxed text-justify prose prose-sm max-w-none">
                            {!! $journal->abstract !!}
                        </div>
                    </div>

                    <!-- Document Viewer Section -->
                    <div class="p-8">
                        <h2 class="text-lg font-medium text-gray-900 mb-6">Manuscript</h2>
                        <x-document-reader 
                            :journal="$journal" 
                            title="Document Preview"
                            subtitle="Manuscript document for review"
                            height="800px"
                            role="editor"
                            :showControls="true"
                        />
                    </div>
                </div>
            </div>

            <!-- Academic Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                @if (auth()->user()->hasRole('Editor in Chief') || auth()->user()->hasRole('Managing Editor'))
                <!-- Reviewer Assignment -->
                <div class="bg-white border border-gray-200">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="font-medium text-gray-900 mb-4">Associate Editors</h3>
                        @if($assignedReviewers->count() >= 4)
                            <div class="bg-amber-50 border border-amber-200 p-3 mb-4 text-sm">
                                <p class="text-amber-800 font-medium">Maximum reviewers assigned</p>
                                <p class="text-amber-700">Remove some to add new ones.</p>
                            </div>
                        @elseif($assignedReviewers->count() < 2)
                            <div class="bg-blue-50 border border-blue-200 p-3 mb-4 text-sm">
                                <p class="text-blue-800 font-medium">More reviewers needed</p>
                                <p class="text-blue-700">{{ 2 - $assignedReviewers->count() }} more required.</p>
                            </div>
                        @endif

                        <form action="{{ route('editor.journals.reviewers.save', $journal->uuid) }}" method="post" id="reviewer-assignment-form" class="space-y-4">
                            @csrf
                            <select id="reviewerSelect" class="w-full px-3 py-2 border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" {{ $assignedReviewers->count() >= 4 ? 'disabled' : '' }}>
                                <option value="" disabled selected>
                                    {{ $assignedReviewers->count() >= 4 ? 'Maximum reviewers reached' : 'Select an Associate Editor' }}
                                </option>
                                @foreach ($reviewers as $reviewer)
                                    @if(!$assignedReviewers->contains('user_id', $reviewer->id))
                                        <option value="{{ $reviewer->uuid }}">{{ $reviewer->fullname }}</option>
                                    @endif
                                @endforeach
                            </select>

                            <div id="selectedReviewers" class="space-y-2">
                                @foreach($assignedReviewers as $reviewer)
                                    <div class="flex items-center justify-between bg-gray-50 border border-gray-200 p-3 text-sm" id="reviewer-{{ $reviewer->user->uuid }}">
                                        <span class="font-medium text-gray-900">{{ $reviewer->user->fullname }}</span>
                                        <button type="button" onclick="removeReviewer('{{ $reviewer->user->uuid }}', '{{ $reviewer->user->fullname }}')" 
                                                class="text-red-500 hover:text-red-700 p-1" title="Remove reviewer">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                        <input type="hidden" name="reviewers[]" value="{{ $reviewer->user->uuid }}">
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" id="assign-btn" 
                                    class="w-full py-2 px-4 text-sm font-medium transition-colors {{ $assignedReviewers->count() < 2 ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700 text-white' }}"
                                    {{ $assignedReviewers->count() < 2 ? 'disabled' : '' }}>
                                @if($assignedReviewers->count() < 2)
                                    Need {{ 2 - $assignedReviewers->count() }} more reviewer(s)
                                @else
                                    Save Associate Editors
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                <!-- Manuscript Details -->
                <div class="bg-white border border-gray-200">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="font-medium text-gray-900 mb-4">Manuscript Details</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="text-gray-900 font-medium">{{ ucfirst($journal->status) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Submitted:</span>
                                <span class="text-gray-900">{{ $journal->created_at->format('M j, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Category:</span>
                                <span class="text-gray-900">{{ $journal->category->name }}</span>
                            </div>
                            @if($journal->file_path)
                            <div class="flex justify-between">
                                <span class="text-gray-600">File Type:</span>
                                <span class="text-gray-900 uppercase">{{ pathinfo($journal->file_path, PATHINFO_EXTENSION) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Review Comments -->
                <div class="bg-white border border-gray-200">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="font-medium text-gray-900 mb-4">Review Comments</h3>
                    </div>
                    <div class="p-6">
                        @forelse ($comments as $comment)
                            <div class="mb-4 last:mb-0 p-4 bg-gray-50 border border-gray-200">
                                <p class="text-gray-700 text-sm leading-relaxed">{{ $comment->comment }}</p>
                                <p class="text-xs text-gray-500 mt-2">Review Feedback</p>
                            </div>
                        @empty
                            <div class="text-center py-6">
                                <p class="text-gray-500 text-sm">No comments yet</p>
                                <p class="text-xs text-gray-400">Comments will appear here once reviewers provide feedback</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white border border-gray-200">
                    <div class="p-6">
                        <h3 class="font-medium text-gray-900 mb-4">Quick Stats</h3>
                        <div class="space-y-4">
                            <div class="text-center py-3 border border-gray-100">
                                <div class="text-2xl font-light text-gray-900">{{ str_word_count(strip_tags($journal->abstract)) }}</div>
                                <div class="text-xs text-gray-600 uppercase tracking-wide">Abstract Words</div>
                            </div>
                            <div class="text-center py-3 border border-gray-100">
                                <div class="text-xl font-light text-gray-900">{{ $journal->created_at->diffForHumans() }}</div>
                                <div class="text-xs text-gray-600 uppercase tracking-wide">Submitted</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simplified reviewer management
        let currentReviewerCount = {{ $assignedReviewers->count() }};
        const MIN_REVIEWERS = 2;
        const MAX_REVIEWERS = 4;

        function removeReviewer(reviewerId, reviewerName) {
            const reviewerDiv = document.getElementById(`reviewer-${reviewerId}`);
            if (reviewerDiv) {
                reviewerDiv.remove();
                currentReviewerCount--;
                updateReviewerInterface();
            }
        }

        function updateReviewerInterface() {
            const assignButton = document.getElementById('assign-btn');
            const reviewerSelect = document.getElementById('reviewerSelect');
            
            if (currentReviewerCount < MIN_REVIEWERS) {
                assignButton.disabled = true;
                assignButton.textContent = `Need ${MIN_REVIEWERS - currentReviewerCount} more reviewer(s)`;
                assignButton.className = "w-full py-2 px-4 text-sm font-medium bg-gray-300 text-gray-500 cursor-not-allowed transition-colors";
            } else {
                assignButton.disabled = false;
                assignButton.textContent = 'Save Associate Editors';
                assignButton.className = "w-full py-2 px-4 text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white transition-colors";
            }

            if (currentReviewerCount >= MAX_REVIEWERS) {
                reviewerSelect.disabled = true;
                reviewerSelect.innerHTML = '<option value="" disabled selected>Maximum reviewers reached</option>';
            } else {
                reviewerSelect.disabled = false;
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateReviewerInterface();
        });

        // Make function globally accessible
        window.removeReviewer = removeReviewer;
    </script>

    <style>
        /* Clean Academic Styling */
        .academic-layout {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
        }
        
        .academic-title {
            font-weight: 300;
            letter-spacing: -0.025em;
            color: #1f2937;
        }
        
        .academic-text {
            line-height: 1.7;
            color: #374151;
        }
        
        /* Clean transitions */
        .transition-smooth {
            transition: all 0.2s ease-in-out;
        }
        
        /* Focus states */
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* Hover effects */
        .sidebar-card:hover {
            border-color: #d1d5db;
        }
        
        /* Button states */
        .btn-disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        /* Clean shadows */
        .subtle-shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
    </style>
</x-layouts.editor_layout>
