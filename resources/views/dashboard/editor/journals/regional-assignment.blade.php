<x-layouts.editor_layout>
    <x-slot:title>
        Regional Reviewer Assignment
    </x-slot:title>

    <!-- Success Notification -->
    <div id="success-notification" class="fixed top-4 right-4 z-50 hidden">
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p id="success-message" class="text-sm font-medium text-green-800"></p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="hideNotification('success-notification')" class="text-green-400 hover:text-green-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Notification -->
    <div id="error-notification" class="fixed top-4 right-4 z-50 hidden">
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p id="error-message" class="text-sm font-medium text-red-800"></p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="hideNotification('error-notification')" class="text-red-400 hover:text-red-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm hidden z-50" onclick="closeConfirmationModal()">
        <div class="flex items-center justify-center min-h-screen p-4" onclick="event.stopPropagation()">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all duration-200 scale-95 opacity-0" id="confirmation-dialog">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-gray-900" id="confirmation-title">Confirm Action</h3>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6" id="confirmation-message"></p>
                    <div class="flex justify-end space-x-3">
                        <button onclick="closeConfirmationModal()" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            Cancel
                        </button>
                        <button id="confirmation-confirm" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Regional Reviewer Assignment</h1>
            <p class="text-gray-600">Assign Associate Editors based on regional expertise and research interests</p>
        </div>

        <!-- Manuscript Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Manuscript Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Title</label>
                        <p class="text-gray-900 font-medium">{{ $journal->title }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Author Country</label>
                        <p class="text-gray-900 font-medium">{{ $journal->country }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Region</label>
                        <p class="text-gray-900 font-medium">{{ $journal->region ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Category</label>
                        <p class="text-gray-900 font-medium">{{ $journal->category->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Current Status</label>
                        <p class="text-gray-900 font-medium">{{ ucfirst(str_replace('_', ' ', $journal->approval_status)) }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Submission Date</label>
                        <p class="text-gray-900 font-medium">{{ $journal->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assignment Strategy Explanation -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">📋 Assignment Strategy</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800">
                <div>
                    <h4 class="font-medium mb-2">🌍 Regional Matching:</h4>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Priority given to reviewers from the same region as the manuscript</li>
                        <li>Secondary priority to reviewers with regional expertise</li>
                        <li>Ensures cultural and contextual understanding</li>
                        <li><strong>Minimum 2 reviewers required</strong></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-medium mb-2">🔬 Research Interest Matching:</h4>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Matches reviewers with relevant research interests</li>
                        <li>Considers category and subcategory expertise</li>
                        <li>Balances workload across available reviewers</li>
                        <li>Use when regional reviewers are insufficient</li>
                    </ul>
                </div>
            </div>
            <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <h4 class="font-medium text-yellow-800 mb-2">⚠️ Important Note:</h4>
                <p class="text-sm text-yellow-700">
                    If there aren't enough regional reviewers available, you can select reviewers from other regions. 
                    The system will show you a warning when regional reviewers are insufficient, and you can choose 
                    from the "Other Available Reviewers" or "All Available Reviewers" sections below.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Optimal Suggestions -->
            <div class="lg:col-span-2">
                <!-- Regional Reviewers Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">🌍 Regional Reviewers</h3>
                        <p class="text-sm text-gray-600 mt-1">Reviewers from {{ $journal->region ?? 'the same region' }} or with regional expertise</p>
                    </div>
                    <div class="p-6">
                        @php
                            $regionalReviewers = $optimalReviewers->filter(function($reviewer) use ($journal) {
                                return $reviewer->hasRegionalExpertise($journal->country) || 
                                       $reviewer->hasRegionalExpertise($journal->region);
                            });
                            $regionalCount = $regionalReviewers->count();
                            $minimumRequired = 2;
                            $hasEnoughRegional = $regionalCount >= $minimumRequired;
                        @endphp
                        
                        @if(!$hasEnoughRegional)
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-medium text-yellow-800">Insufficient Regional Reviewers</h4>
                                        <p class="text-sm text-yellow-700 mt-1">
                                            Only {{ $regionalCount }} regional reviewer(s) available. You need at least {{ $minimumRequired }} reviewers. 
                                            You can select additional reviewers from other regions below.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div id="regional-suggestions" class="space-y-4">
                            @forelse($regionalReviewers as $reviewer)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($reviewer->fullname, 0, 2)) }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $reviewer->fullname }}</h4>
                                            <p class="text-sm text-gray-600">{{ $reviewer->email }}</p>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Regional Expert
                                                </span>
                                                @if($reviewer->hasResearchInterest($journal->category->name))
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        Research Expert
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if($assignedReviewers->where('user.uuid', $reviewer->uuid)->count() > 0)
                                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-md font-medium">
                                                Assigned
                                            </span>
                                        @else
                                            <button onclick="addReviewer('{{ $reviewer->uuid }}', '{{ $reviewer->fullname }}')" 
                                                    class="px-3 py-1 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition-colors">
                                                Add
                                            </button>
                                        @endif
                                        <button onclick="showReviewerDetails('{{ $reviewer->uuid }}')" 
                                                class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-md hover:bg-gray-200 transition-colors">
                                            Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-gray-500">No regional reviewers available for this manuscript.</p>
                                <p class="text-sm text-gray-400 mt-1">Please select reviewers from other regions below.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Other Reviewers Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">🔬 Other Available Reviewers</h3>
                        <p class="text-sm text-gray-600 mt-1">Reviewers from other regions with relevant research interests</p>
                    </div>
                    <div class="p-6">
                        @php
                            $otherReviewers = $optimalReviewers->filter(function($reviewer) use ($journal) {
                                return !$reviewer->hasRegionalExpertise($journal->country) && 
                                       !$reviewer->hasRegionalExpertise($journal->region);
                            });
                        @endphp
                        
                        <div id="other-suggestions" class="space-y-4">
                            @forelse($otherReviewers as $reviewer)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-orange-300 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($reviewer->fullname, 0, 2)) }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $reviewer->fullname }}</h4>
                                            <p class="text-sm text-gray-600">{{ $reviewer->email }}</p>
                                            <div class="flex items-center space-x-2 mt-1">
                                                @if($reviewer->hasResearchInterest($journal->category->name))
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        Research Expert
                                                    </span>
                                                @endif
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                    Other Region
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if($assignedReviewers->where('user.uuid', $reviewer->uuid)->count() > 0)
                                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-md font-medium">
                                                Assigned
                                            </span>
                                        @else
                                            <button onclick="addReviewer('{{ $reviewer->uuid }}', '{{ $reviewer->fullname }}')" 
                                                    class="px-3 py-1 bg-orange-600 text-white text-sm rounded-md hover:bg-orange-700 transition-colors">
                                                Add
                                            </button>
                                        @endif
                                        <button onclick="showReviewerDetails('{{ $reviewer->uuid }}')" 
                                                class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-md hover:bg-gray-200 transition-colors">
                                            Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-gray-500">No other reviewers available.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- All Available Reviewers Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">👥 All Available Reviewers</h3>
                        <p class="text-sm text-gray-600 mt-1">Complete list of all available Associate Editors</p>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <input type="text" id="reviewer-search" placeholder="Search reviewers by name or expertise..." 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div id="all-reviewers" class="space-y-4 max-h-96 overflow-y-auto">
                            @foreach($allReviewers as $reviewer)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-gray-300 transition-colors reviewer-item" 
                                 data-name="{{ strtolower($reviewer->fullname) }}" 
                                 data-expertise="{{ strtolower(implode(' ', $reviewer->regional_expertise ?? [])) }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-gray-500 to-gray-700 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($reviewer->fullname, 0, 2)) }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $reviewer->fullname }}</h4>
                                            <p class="text-sm text-gray-600">{{ $reviewer->email }}</p>
                                            <div class="flex items-center space-x-2 mt-1">
                                                @if($reviewer->regional_expertise)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        {{ implode(', ', array_slice($reviewer->regional_expertise, 0, 2)) }}
                                                    </span>
                                                @endif
                                                @if($reviewer->research_interests)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                        {{ implode(', ', array_slice($reviewer->research_interests, 0, 2)) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if($assignedReviewers->where('user.uuid', $reviewer->uuid)->count() > 0)
                                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-md font-medium">
                                                Assigned
                                            </span>
                                        @else
                                            <button onclick="addReviewer('{{ $reviewer->uuid }}', '{{ $reviewer->fullname }}')" 
                                                    class="px-3 py-1 bg-gray-600 text-white text-sm rounded-md hover:bg-gray-700 transition-colors">
                                                Add
                                            </button>
                                        @endif
                                        <button onclick="showReviewerDetails('{{ $reviewer->uuid }}')" 
                                                class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-md hover:bg-gray-200 transition-colors">
                                            Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignment Panel -->
            <div class="space-y-6">
                <!-- Selected Reviewers -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Selected Reviewers</h3>
                        <p class="text-sm text-gray-600 mt-1">Selected: <span id="selected-count">0</span>/4</p>
                    </div>
                    <div class="p-6">
                        <div id="selected-reviewers" class="space-y-3">
                            <!-- Selected reviewers will be added here -->
                        </div>
                        <button id="assign-btn" onclick="confirmAssignReviewers()" 
                                class="w-full mt-4 py-3 px-4 bg-gray-100 text-gray-400 rounded-lg font-medium cursor-not-allowed" disabled>
                            Need 2 more reviewers
                        </button>
                    </div>
                </div>

                <!-- Regional Statistics -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Regional Statistics</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($regionalStats as $region => $stats)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                                <span class="text-sm font-medium text-gray-700">{{ $region }}</span>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-gray-900">{{ $stats['available_reviewers'] }}</div>
                                    <div class="text-xs text-gray-500">available</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

                <!-- Already Assigned Reviewers -->
                @if($assignedReviewers->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mt-8">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">✅ Already Assigned Reviewers</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $assignedReviewers->count() }} reviewer(s) currently assigned</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($assignedReviewers as $assignedReviewer)
                            <div class="border border-green-200 bg-green-50 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($assignedReviewer->user->fullname, 0, 2)) }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $assignedReviewer->user->fullname }}</h4>
                                            <p class="text-sm text-gray-600">{{ $assignedReviewer->user->email }}</p>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Assigned {{ $assignedReviewer->assigned_at ? $assignedReviewer->assigned_at->diffForHumans() : '' }}
                                                </span>
                                                @if($assignedReviewer->status)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ ucfirst($assignedReviewer->status) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button onclick="showReviewerDetails('{{ $assignedReviewer->user->uuid }}')" 
                                                class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-md hover:bg-gray-200 transition-colors">
                                            Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Reviewer Details Sidebar -->
    <div id="reviewer-sidebar" class="fixed inset-y-0 left-0 w-96 bg-white shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out z-50">
        <div class="h-full flex flex-col">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Reviewer Details</h3>
                    <button onclick="closeReviewerSidebar()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div id="reviewer-sidebar-content" class="flex-1 overflow-y-auto p-6">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 hidden z-40" onclick="closeReviewerSidebar()"></div>

<script>
let selectedReviewers = [];
const MIN_REVIEWERS = 2;
const MAX_REVIEWERS = 4;

function showNotification(type, message) {
    const notification = document.getElementById(`${type}-notification`);
    const messageElement = document.getElementById(`${type}-message`);
    
    messageElement.textContent = message;
    notification.classList.remove('hidden');
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        hideNotification(`${type}-notification`);
    }, 5000);
}

function hideNotification(notificationId) {
    document.getElementById(notificationId).classList.add('hidden');
}

function showConfirmationModal(title, message, onConfirm) {
    document.getElementById('confirmation-title').textContent = title;
    document.getElementById('confirmation-message').textContent = message;
    
    const confirmBtn = document.getElementById('confirmation-confirm');
    confirmBtn.onclick = onConfirm;
    
    const modal = document.getElementById('confirmation-modal');
    const dialog = document.getElementById('confirmation-dialog');
    
    modal.classList.remove('hidden');
    
    // Trigger animation
    setTimeout(() => {
        dialog.classList.remove('scale-95', 'opacity-0');
        dialog.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeConfirmationModal() {
    const modal = document.getElementById('confirmation-modal');
    const dialog = document.getElementById('confirmation-dialog');
    
    // Trigger close animation
    dialog.classList.remove('scale-100', 'opacity-100');
    dialog.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

function addReviewer(uuid, name) {
    if (selectedReviewers.length >= MAX_REVIEWERS) {
        showNotification('error', 'Maximum 4 reviewers allowed');
        return;
    }
    
    if (selectedReviewers.find(r => r.uuid === uuid)) {
        showNotification('error', 'Reviewer already selected');
        return;
    }
    
    selectedReviewers.push({ uuid, name });
    updateSelectedReviewers();
    showNotification('success', `${name} added to selected reviewers`);
}

function removeReviewer(uuid) {
    const reviewer = selectedReviewers.find(r => r.uuid === uuid);
    selectedReviewers = selectedReviewers.filter(r => r.uuid !== uuid);
    updateSelectedReviewers();
    if (reviewer) {
        showNotification('success', `${reviewer.name} removed from selected reviewers`);
    }
}

function updateSelectedReviewers() {
    const container = document.getElementById('selected-reviewers');
    const countSpan = document.getElementById('selected-count');
    const assignBtn = document.getElementById('assign-btn');
    
    countSpan.textContent = selectedReviewers.length;
    
    container.innerHTML = selectedReviewers.map(reviewer => `
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
            <span class="font-medium text-gray-900">${reviewer.name}</span>
            <button onclick="removeReviewer('${reviewer.uuid}')" class="text-red-600 hover:text-red-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `).join('');
    
    // Update assign button
    if (selectedReviewers.length >= MIN_REVIEWERS) {
        assignBtn.disabled = false;
        assignBtn.className = 'w-full mt-4 py-3 px-4 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors';
        assignBtn.textContent = `Assign ${selectedReviewers.length} Reviewer${selectedReviewers.length > 1 ? 's' : ''}`;
    } else {
        assignBtn.disabled = true;
        assignBtn.className = 'w-full mt-4 py-3 px-4 bg-gray-100 text-gray-400 rounded-lg font-medium cursor-not-allowed';
        assignBtn.textContent = `Need ${MIN_REVIEWERS - selectedReviewers.length} more reviewer${MIN_REVIEWERS - selectedReviewers.length > 1 ? 's' : ''}`;
    }
}

function confirmAssignReviewers() {
    if (selectedReviewers.length < MIN_REVIEWERS) {
        showNotification('error', 'Please select at least 2 reviewers');
        return;
    }
    
    showConfirmationModal(
        'Confirm Assignment',
        `Are you sure you want to assign ${selectedReviewers.length} reviewer${selectedReviewers.length > 1 ? 's' : ''} to this manuscript?`,
        assignReviewers
    );
}

function assignReviewers() {
    closeConfirmationModal();
    
    const reviewerUuids = selectedReviewers.map(r => r.uuid);
    
    // Show loading state
    const assignBtn = document.getElementById('assign-btn');
    const originalText = assignBtn.textContent;
    assignBtn.disabled = true;
    assignBtn.textContent = 'Assigning...';
    
    fetch('{{ route("editor.regional-assignment.assign", $journal->uuid) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            reviewers: reviewerUuids
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('success', data.message);
            setTimeout(() => {
                window.location.href = '{{ route("editor.journals.preview", ["uuid" => $journal->uuid, "slug" => $journal->slug]) }}';
            }, 1500);
        } else {
            showNotification('error', data.message);
            // Reset button state
            assignBtn.disabled = false;
            assignBtn.textContent = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'An error occurred while assigning reviewers');
        // Reset button state
        assignBtn.disabled = false;
        assignBtn.textContent = originalText;
    });
}

function showReviewerDetails(uuid) {
    // Show loading state
    const sidebar = document.getElementById('reviewer-sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const content = document.getElementById('reviewer-sidebar-content');
    
    content.innerHTML = `
        <div class="flex items-center justify-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <span class="ml-3 text-gray-600">Loading reviewer details...</span>
        </div>
    `;
    
    // Show sidebar and overlay
    sidebar.classList.remove('-translate-x-full');
    overlay.classList.remove('hidden');
    
    fetch(`{{ route('editor.reviewer.details', ['reviewerUuid' => 'REPLACE_UUID']) }}`.replace('REPLACE_UUID', uuid))
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            content.innerHTML = `
                <div class="space-y-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-white font-bold text-lg">${data.reviewer.fullname.split(' ').map(n => n[0]).join('').toUpperCase()}</span>
                        </div>
                        <h4 class="font-semibold text-gray-900 text-lg">${data.reviewer.fullname}</h4>
                        <p class="text-gray-600">${data.reviewer.email}</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h5 class="font-medium text-gray-900 mb-3">Performance Metrics</h5>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <span class="text-sm text-gray-500">Total Reviews</span>
                                <p class="font-semibold text-lg text-gray-900">${data.performance.total_reviews}</p>
                            </div>
                            <div class="text-center">
                                <span class="text-sm text-gray-500">Average Rating</span>
                                <p class="font-semibold text-lg text-gray-900">${data.performance.average_rating || 'N/A'}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h5 class="font-medium text-gray-900 mb-3">Regional Expertise</h5>
                        <div class="flex flex-wrap gap-2">
                            ${data.regional_expertise && data.regional_expertise.length > 0 ? 
                                data.regional_expertise.map(region => 
                                    `<span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">${region}</span>`
                                ).join('') : 
                                '<span class="text-gray-500 text-sm">No regional expertise specified</span>'
                            }
                        </div>
                    </div>
                    
                    <div>
                        <h5 class="font-medium text-gray-900 mb-3">Research Interests</h5>
                        <div class="flex flex-wrap gap-2">
                            ${data.research_interests && data.research_interests.length > 0 ? 
                                data.research_interests.map(interest => 
                                    `<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">${interest}</span>`
                                ).join('') : 
                                '<span class="text-gray-500 text-sm">No research interests specified</span>'
                            }
                        </div>
                    </div>
                    
                    ${data.reviewer.biography ? `
                    <div>
                        <h5 class="font-medium text-gray-900 mb-3">Biography</h5>
                        <p class="text-gray-600 text-sm leading-relaxed">${data.reviewer.biography}</p>
                    </div>
                    ` : ''}
                </div>
            `;
        })
        .catch(error => {
            console.error('Error:', error);
            content.innerHTML = `
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Error Loading Details</h3>
                    <p class="mt-1 text-sm text-gray-500">Unable to load reviewer details. Please try again.</p>
                    <div class="mt-6">
                        <button onclick="closeReviewerSidebar()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            Close
                        </button>
                    </div>
                </div>
            `;
        });
}

function closeReviewerSidebar() {
    const sidebar = document.getElementById('reviewer-sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    
    // Hide sidebar and overlay
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
}

// Search functionality for all-reviewers list
const reviewerSearchInput = document.getElementById('reviewer-search');
const allReviewersList = document.getElementById('all-reviewers');

reviewerSearchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const reviewerItems = allReviewersList.querySelectorAll('.reviewer-item');

    reviewerItems.forEach(item => {
        const name = item.dataset.name;
        const expertise = item.dataset.expertise;

        if (name.includes(searchTerm) || expertise.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>
</x-layouts.editor_layout> 