<x-layouts.layout>
    <x-slot:title>
        My Manuscript Submissions
    </x-slot>
    <x-slot:breadcrumb>
        <div class="border-b border-gray-200 pb-5 sm:flex w-full sm:items-center sm:justify-between">
            <h3 class="text-lg font-bold leading-6 text-gray-900">My Submissions</h3>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">{{ auth()->user()->fullname }}</span>
                <a href="{{ route('submit-manuscript') }}" class="bg-primary-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary-700">
                    Submit New Manuscript
                </a>
            </div>
        </div>
    </x-slot:breadcrumb>
    
    <div class="py-6">
        @if (count($journals) > 0)
            <div class="space-y-6">
                @foreach($journals as $journal)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <!-- Manuscript Header -->
                        <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $journal->title }}</h3>
                                    <p class="text-gray-600 mb-3">{!! Str::limit($journal->description, 200) !!}</p>
                                    
                                    <div class="flex flex-wrap gap-3 text-sm">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $journal->status_class }}">
                                            {{ $journal->status_label }}
                                        </span>
                                        
                                        @if($journal->category)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-gray-100 text-gray-700">
                                                {{ $journal->category->name }}
                                            </span>
                                        @endif
                                        
                                        @if($journal->version_count > 0)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-indigo-100 text-indigo-700">
                                                v{{ $journal->latest_version->version_number ?? '1.0' }} ({{ $journal->version_count }} versions)
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="text-right text-sm text-gray-500">
                                    <p>Submitted: {{ $journal->created_at->format('M j, Y') }}</p>
                                    <p>Updated: {{ $journal->updated_at->format('M j, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Review Progress -->
                        @if($journal->review_summary['total_reviews'] > 0)
                            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Review Progress</h4>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                                    <div class="text-center">
                                        <div class="text-lg font-semibold text-blue-600">{{ $journal->review_summary['total_reviews'] }}</div>
                                        <div class="text-gray-600">Total Reviews</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-lg font-semibold text-green-600">{{ $journal->review_summary['completed_reviews'] }}</div>
                                        <div class="text-gray-600">Completed</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-lg font-semibold text-yellow-600">
                                            @if($journal->review_summary['average_rating'])
                                                {{ number_format($journal->review_summary['average_rating'], 1) }}/5
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                        <div class="text-gray-600">Avg Rating</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-lg font-semibold text-purple-600">
                                            @if($journal->review_summary['recommendations'] && $journal->review_summary['recommendations']->get('accept', 0) > 0)
                                                {{ $journal->review_summary['recommendations']->get('accept', 0) }} Accepts
                                            @else
                                                Pending
                                            @endif
                                        </div>
                                        <div class="text-gray-600">Recommendations</div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Review Comments for Author -->
                        @if($journal->submitted_reviews && $journal->submitted_reviews->count() > 0)
                            <div class="px-6 py-4 bg-blue-50 border-b border-blue-200">
                                <h4 class="text-sm font-medium text-blue-900 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    Reviewer Feedback
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $journal->submitted_reviews->count() }} {{ Str::plural('Review', $journal->submitted_reviews->count()) }}
                                    </span>
                                </h4>
                                
                                <div class="space-y-3">
                                    @foreach($journal->submitted_reviews as $index => $review)
                                        <div class="bg-white p-4 rounded-lg border border-blue-200 shadow-sm">
                                            <div class="flex justify-between items-start mb-3">
                                                <div class="flex items-center space-x-3">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Reviewer {{ $index + 1 }}
                                                    </span>
                                                    @if($review->recommendation)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                            {{ $review->recommendation === 'accept' ? 'bg-green-100 text-green-800' : 
                                                               ($review->recommendation === 'reject' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                            {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                                                        </span>
                                                    @endif
                                                    @if($review->rating)
                                                        <div class="flex items-center">
                                                            <span class="text-sm font-medium text-gray-700 mr-1">Rating:</span>
                                                            <div class="flex items-center">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                    </svg>
                                                                @endfor
                                                                <span class="ml-1 text-sm text-gray-600">({{ $review->rating }}/5)</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <span class="text-xs text-gray-500">
                                                    {{ $review->review_submitted_at ? $review->review_submitted_at->format('M j, Y') : 'Recently submitted' }}
                                                </span>
                                            </div>
                                                             @if($review->comment)
                                <div class="border-l-4 border-blue-400 pl-4">
                                    <h6 class="text-sm font-medium text-gray-900 mb-2">
                                        <i class="ph ph-message-circle mr-1 text-blue-600"></i>Comments for You (Author)
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            Review Feedback
                                        </span>
                                    </h6>
                                    <div class="prose prose-sm max-w-none text-gray-700 bg-blue-50 p-3 rounded">
                                        {{ $review->comment }}
                                    </div>
                                    <small class="text-xs text-blue-600 mt-2 block">
                                        <i class="ph ph-info mr-1"></i>This feedback is specifically for you to help improve your manuscript
                                    </small>
                                </div>
                            @endif
                                            
                                            <!-- Criteria Ratings (if available) -->
                                            @if($review->criteria_ratings)
                                                <div class="mt-4 pt-3 border-t border-gray-200">
                                                    <h6 class="text-sm font-medium text-gray-900 mb-2">Detailed Ratings</h6>
                                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-sm">
                                                        @foreach($review->criteria_ratings as $criterion => $rating)
                                                            <div class="flex justify-between items-center">
                                                                <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $criterion) }}:</span>
                                                                <span class="font-medium text-gray-900">{{ $rating }}/5</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Change Requests / Feedback -->
                        @if($journal->approval_status === 'revision_requested' && $journal->formatted_change_requests)
                            <div class="px-6 py-4 bg-orange-50 border-b border-orange-200">
                                <h4 class="text-sm font-medium text-orange-900 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    Revision Requests
                                </h4>
                                <div class="space-y-2">
                                    @foreach($journal->formatted_change_requests as $request)
                                        <div class="p-3 bg-white rounded-md border border-orange-200">
                                            <div class="flex justify-between items-start mb-1">
                                                <span class="text-xs font-medium text-orange-700 bg-orange-100 px-2 py-1 rounded">
                                                    {{ $request['category'] }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ \Carbon\Carbon::parse($request['requested_at'])->format('M j, Y') }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-700 mt-2">{{ $request['description'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Editor Decision -->
                        @if($journal->editor_decision_comment)
                            <div class="px-6 py-4 bg-blue-50 border-b border-blue-200">
                                <h4 class="text-sm font-medium text-blue-900 mb-2">Editor Decision</h4>
                                <div class="bg-white p-3 rounded-md border border-blue-200">
                                    <p class="text-sm text-gray-700">{{ $journal->editor_decision_comment }}</p>
                                    @if($journal->editor_decision_date)
                                        <p class="text-xs text-gray-500 mt-2">
                                            Decision made on {{ $journal->editor_decision_date->format('M j, Y g:i A') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="px-6 py-4 bg-gray-50 flex flex-wrap gap-3">
                            <a href="{{ route('journals.view', $journal->slug) }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View Details
                            </a>
                            
                            @if($journal->approval_status === 'revision_requested')
                                <button onclick="openRevisionModal('{{ $journal->uuid }}')" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    Upload Revision
                                </button>
                            @endif
                            
                            @if($journal->version_count > 1)
                                <button onclick="viewVersionHistory('{{ $journal->uuid }}')" 
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Version History
                                </button>
                            @endif
                            
                            @if(in_array($journal->approval_status, ['pending', 'in_progress']) && $journal->is_draft)
                                <a href="{{ route('journals.edit', $journal->uuid) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit Draft
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No manuscripts submitted</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by submitting your first manuscript.</p>
                <div class="mt-6">
                    <a href="{{ route('submit-manuscript') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Submit Manuscript
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Revision Upload Modal -->
    <div id="revisionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Upload Revision</h3>
                    <button onclick="closeRevisionModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <form id="revisionForm" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" id="revisionJournalUuid" name="journal_uuid" value="">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Revised Manuscript File</label>
                        <input type="file" name="revision_file" required 
                               accept=".pdf,.doc,.docx" 
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">Accepted formats: PDF, DOC, DOCX (Max 10MB)</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Revision Notes</label>
                        <textarea name="revision_notes" rows="4" required
                                  placeholder="Please describe the changes you made in response to the reviewer feedback..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeRevisionModal()" 
                                class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700">
                            Upload Revision
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRevisionModal(journalUuid) {
            document.getElementById('revisionJournalUuid').value = journalUuid;
            document.getElementById('revisionModal').classList.remove('hidden');
        }

        function closeRevisionModal() {
            document.getElementById('revisionModal').classList.add('hidden');
            document.getElementById('revisionForm').reset();
        }

        function viewVersionHistory(journalUuid) {
            // Redirect to version history page
            window.location.href = '/dashboard/manuscript/' + journalUuid + '/versions';
        }

        // Handle revision form submission
        document.getElementById('revisionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Uploading...';
            
            fetch('/dashboard/upload-revision', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeRevisionModal();
                    location.reload(); // Refresh the page to show updated status
                } else {
                    alert('Error uploading revision: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while uploading the revision.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Upload Revision';
            });
        });

        // Close modal when clicking outside
        document.getElementById('revisionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRevisionModal();
            }
        });
    </script>
</x-layouts.layout>
