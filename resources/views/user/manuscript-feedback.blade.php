<x-layouts.layout>
    <x-slot:title>
        Manuscript Feedback - {{ $journal->title }}
    </x-slot>
    
    <x-slot:breadcrumb>
        <div class="border-b border-gray-200 pb-5">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('user.submissions') }}" class="text-gray-600 hover:text-primary-600">
                            My Submissions
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500">Feedback</span>
                        </div>
                    </li>
                </ol>
            </nav>
            
            <div class="sm:flex w-full sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-bold leading-6 text-gray-900">Manuscript Feedback</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $journal->title }}</p>
                </div>
                <div class="mt-3 sm:mt-0 flex items-center space-x-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($journal->approval_status === 'approved') bg-green-100 text-green-800
                        @elseif($journal->approval_status === 'rejected') bg-red-100 text-red-800
                        @elseif($journal->approval_status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($journal->approval_status === 'in_progress') bg-blue-100 text-blue-800
                        @elseif($journal->approval_status === 'reviewed') bg-purple-100 text-purple-800
                        @elseif($journal->approval_status === 'revision_requested') bg-orange-100 text-orange-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $journal->approval_status)) }}
                    </span>
                    
                    @if($journal->approval_status === 'revision_requested')
                        <button onclick="openRevisionModal('{{ $journal->uuid }}')" 
                                class="inline-flex items-center px-3 py-1 border border-transparent rounded-md text-sm font-medium text-white bg-orange-600 hover:bg-orange-700">
                            Upload Revision
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </x-slot:breadcrumb>

    <div class="py-6 space-y-6">
        <!-- Manuscript Overview -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                <h4 class="text-lg font-medium text-gray-900 mb-3">Manuscript Overview</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Title:</span>
                        <p class="text-gray-600 mt-1">{{ $journal->title }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Category:</span>
                        <p class="text-gray-600 mt-1">{{ $journal->category->name ?? 'Not specified' }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Submitted:</span>
                        <p class="text-gray-600 mt-1">{{ $journal->created_at->format('M j, Y g:i A') }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Last Updated:</span>
                        <p class="text-gray-600 mt-1">{{ $journal->updated_at->format('M j, Y g:i A') }}</p>
                    </div>
                </div>
                
                @if($journal->abstract)
                    <div class="mt-4">
                        <span class="font-medium text-gray-700">Abstract:</span>
                        <p class="text-gray-600 mt-1 text-sm leading-relaxed">{{ $journal->abstract }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Editor Decision -->
        @if($journal->editor_decision_comment || $journal->editor_decision_date)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <div class="p-6 bg-blue-50 border-b border-blue-200">
                    <h4 class="text-lg font-medium text-blue-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Editor Decision
                    </h4>
                    
                    @if($journal->editor_decision_comment)
                        <div class="bg-white p-4 rounded-md border border-blue-200 mb-3">
                            <p class="text-gray-700">{{ $journal->editor_decision_comment }}</p>
                        </div>
                    @endif
                    
                    @if($journal->editor_decision_date)
                        <p class="text-sm text-blue-700">
                            Decision made on {{ $journal->editor_decision_date->format('M j, Y g:i A') }}
                        </p>
                    @endif
                </div>
            </div>
        @endif

        <!-- Change Requests -->
        @if($journal->change_requests && count($journal->change_requests) > 0)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <div class="p-6 bg-orange-50 border-b border-orange-200">
                    <h4 class="text-lg font-medium text-orange-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Revision Requests
                    </h4>
                    
                    <div class="space-y-4">
                        @foreach($journal->change_requests as $index => $request)
                            <div class="bg-white p-4 rounded-md border border-orange-200">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-orange-100 text-orange-800">
                                        @if(is_array($request) && isset($request['category']))
                                            {{ $request['category'] }}
                                        @else
                                            Request #{{ $index + 1 }}
                                        @endif
                                    </span>
                                    
                                    @if(is_array($request) && isset($request['requested_at']))
                                        <span class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($request['requested_at'])->format('M j, Y') }}
                                        </span>
                                    @endif
                                </div>
                                
                                <p class="text-gray-700">
                                    @if(is_array($request))
                                        {{ $request['description'] ?? $request['request'] ?? 'No description provided' }}
                                    @else
                                        {{ $request }}
                                    @endif
                                </p>
                                
                                @if(is_array($request) && isset($request['status']))
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium 
                                            @if($request['status'] === 'addressed') bg-green-100 text-green-800
                                            @elseif($request['status'] === 'in_progress') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($request['status']) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Associate Editor Reviews -->
        @if($journal->reviewers->count() > 0)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <div class="p-6 bg-green-50 border-b border-green-200">
                    <h4 class="text-lg font-medium text-green-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z"/>
                        </svg>
                        Associate Editor Reviews
                    </h4>
                    
                    <div class="space-y-4">
                        @foreach($journal->reviewers as $review)
                            <div class="bg-white p-4 rounded-md border border-green-200">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-medium text-green-800">
                                                    @php
                                                        $names = explode(' ', $review->user->fullname);
                                                        $initials = '';
                                                        foreach (array_slice($names, 0, 2) as $name) {
                                                            $initials .= strtoupper(substr($name, 0, 1));
                                                        }
                                                    @endphp
                                                    {{ $initials }}
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $review->user->fullname }}
                                            </p>
                                            <p class="text-xs text-gray-500">Associate Editor</p>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right">
                                        @if($review->rating)
                                            <div class="flex items-center space-x-1 mb-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                                <span class="text-sm text-gray-600 ml-2">{{ $review->rating }}/5</span>
                                            </div>
                                        @endif
                                        
                                        @if($review->recommendation)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium
                                                @if($review->recommendation === 'accept') bg-green-100 text-green-800
                                                @elseif($review->recommendation === 'reject') bg-red-100 text-red-800
                                                @elseif($review->recommendation === 'minor_revision') bg-yellow-100 text-yellow-800
                                                @elseif($review->recommendation === 'major_revision') bg-orange-100 text-orange-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($review->comment)
                                    <div class="prose max-w-none">
                                        <p class="text-gray-700 text-sm leading-relaxed">{{ $review->comment }}</p>
                                    </div>
                                @endif
                                
                                <div class="mt-3 pt-3 border-t border-gray-200 text-xs text-gray-500">
                                    Review submitted on {{ $review->created_at->format('M j, Y g:i A') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Version History Summary -->
        @if($journal->versions->count() > 1)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <div class="p-6 bg-indigo-50 border-b border-indigo-200">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-medium text-indigo-900 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Version History Summary
                        </h4>
                        <a href="{{ route('manuscript.versions', $journal->uuid) }}" 
                           class="inline-flex items-center px-3 py-1 border border-indigo-300 rounded-md text-sm font-medium text-indigo-700 bg-white hover:bg-indigo-50">
                            View All Versions
                        </a>
                    </div>
                    
                    <div class="space-y-2">
                        @foreach($journal->versions->take(3) as $version)
                            <div class="flex items-center justify-between p-3 bg-white rounded border border-indigo-200">
                                <div class="flex items-center space-x-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                                        @if($loop->first) bg-blue-100 text-blue-800 @else bg-gray-100 text-gray-800 @endif">
                                        v{{ $version->version_number }}
                                    </span>
                                    
                                    @if($loop->first)
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                            Current
                                        </span>
                                    @endif
                                    
                                    <span class="text-sm text-gray-600">
                                        {{ $version->changes_summary ? Str::limit($version->changes_summary, 50) : 'No changes summary' }}
                                    </span>
                                </div>
                                
                                <span class="text-xs text-gray-500">
                                    {{ $version->created_at->format('M j, Y') }}
                                </span>
                            </div>
                        @endforeach
                        
                        @if($journal->versions->count() > 3)
                            <p class="text-sm text-indigo-600 text-center pt-2">
                                And {{ $journal->versions->count() - 3 }} more versions...
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Back to Submissions -->
        <div class="flex justify-center">
            <a href="{{ route('user.submissions') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Submissions
            </a>
        </div>
    </div>

    <!-- Revision Upload Modal -->
    <div id="revisionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 h-full w-full hidden z-50">
        <div class="flex items-center justify-center w-full min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto my-8 flex flex-col max-h-[calc(100vh-8rem)]">
                <!-- Modal Header -->
                <div class="flex items-center justify-between flex-shrink-0 p-6 border-b">
                    <h3 class="text-xl font-semibold text-gray-900">
                        <svg class="w-6 h-6 inline-block mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Upload Revision
                    </h3>
                    <button onclick="closeRevisionModal()" class="flex-shrink-0 text-2xl text-gray-400 hover:text-gray-600 transition-colors">
                        <span class="sr-only">Close</span>
                        ×
                    </button>
                </div>
                
                <!-- Modal Content (Scrollable) -->
                <div class="flex-1 p-6 overflow-y-auto">
                    <form id="revisionForm" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" id="revisionJournalUuid" name="journal_uuid" value="{{ $journal->uuid }}">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                </svg>
                                Revised Manuscript File
                            </label>
                            <input type="file" name="revision_file" required 
                                   accept=".pdf,.doc,.docx" 
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-2">Accepted formats: PDF, DOC, DOCX (Max 10MB)</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Revision Notes
                            </label>
                            <textarea name="revision_notes" rows="6" required
                                      placeholder="Please describe the changes you made in response to the reviewer feedback..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 resize-none"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Provide a clear summary of the changes made</p>
                        </div>
                    </form>
                </div>
                
                <!-- Modal Footer -->
                <div class="flex items-center justify-end flex-shrink-0 p-6 border-t bg-gray-50 space-x-3">
                    <button type="button" onclick="closeRevisionModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                        Cancel
                    </button>
                    <button type="submit" form="revisionForm"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Upload Revision
                    </button>
                </div>
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
