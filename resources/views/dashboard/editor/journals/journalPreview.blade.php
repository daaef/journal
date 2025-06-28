<x-layouts.editor_layout>
    <!-- Enhanced Breadcrumb with Action Bar -->
    <div class="bg-white z-40 backdrop-blur-sm bg-white/95">
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
                            Editorial Review
                        </span>
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-800',
                                'under_review' => 'bg-blue-100 text-blue-800',
                                'accepted' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                                'revision_required' => 'bg-orange-100 text-orange-800'
                            ];
                            $statusColor = $statusColors[$journal->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-flex items-center px-3 py-1.5 {{ $statusColor }} rounded-full text-xs font-medium">
                            <span class="w-2 h-2 rounded-full mr-2 {{ str_replace('text-', 'bg-', str_replace('100', '500', explode(' ', $statusColor)[1])) }}"></span>
                            {{ ucwords(str_replace('_', ' ', $journal->status)) }}
                        </span>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="flex items-center space-x-2">
                        <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" title="Print">
                            Print
                        </button>
                        <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" title="Download">
                            Download
                        </button>
                        <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" title="Share">
                            Share
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 pt-0 pb-8">
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
                                            <p class="font-semibold text-white my-0">{{ $journal->author }}</p>
                                        </div>
                                        
                                        <div class="px-3 py-2 rounded-lg">
                                            <p class="text-white/80 text-xs my-0">Submitted</p>
                                            <p class="font-semibold text-white my-0">{{ $journal->created_at->format('M j, Y') }}</p>
                                        </div>
                                        
                                        <div class="px-3 py-2 rounded-lg">
                                            <p class="text-xs my-0">Category</p>
                                            <p class="font-bold my-0">{{ $journal->category->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Status Card -->
                            <div class="lg:col-span-4 flex justify-end">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-40">
                                    <p class="text-white/80 text-sm mb-1 my-0 text-center">Review Status</p>
                                    <p class="text-white font-bold text-lg my-0 text-center">{{ ucwords(str_replace('_', ' ', $journal->status)) }}</p>
                                    <div class="mt-2 pt-2 border-t border-white/30">
                                        <p class="text-white/70 text-xs my-0 text-center">{{ $journal->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stats Bar -->
                <div class="bg-gray-50 px-8 py-4 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ str_word_count(strip_tags($journal->abstract)) }}</div>
                            <div class="text-xs text-gray-600 uppercase tracking-wide font-medium">Abstract Words</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $assignedReviewers->count() }}/4</div>
                            <div class="text-xs text-gray-600 uppercase tracking-wide font-medium">Reviewers Assigned</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $comments->count() }}</div>
                            <div class="text-xs text-gray-600 uppercase tracking-wide font-medium">Review Comments</div>
                        </div>
                        <div class="text-center">
                            @php
                                $extension = strtoupper(pathinfo($journal->journal_url, PATHINFO_EXTENSION));
                            @endphp
                            <div class="text-2xl font-bold text-gray-900">{{ $extension }}</div>
                            <div class="text-xs text-gray-600 uppercase tracking-wide font-medium">Document Type</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Main Content Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
                <!-- Document Viewer - Main Content -->
                <div class="xl:col-span-3 space-y-8">
                    <!-- Abstract Card with Enhanced Design -->
                    <div class="bg-white rounded-2xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-slate-50 to-slate-100 px-6 py-4 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">Abstract</h3>
                                        <p class="text-sm text-gray-600">Research summary and key findings</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-3 py-1 bg-slate-100 text-slate-800 rounded-full text-xs font-medium">
                                        {{ str_word_count(strip_tags($journal->abstract)) }} words
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="prose prose-lg prose-gray max-w-none leading-relaxed">
                                <div class="text-gray-700 text-lg leading-8 font-light">
                                    {!! $journal->abstract !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Document Preview Card -->
                    <div class="bg-white rounded-2xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-slate-50 to-slate-100 px-6 py-4 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">Manuscript Document</h3>
                                        <p class="text-sm text-gray-600">{{ basename($journal->journal_url) }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    @php
                                        $extension = strtolower(pathinfo($journal->journal_url, PATHINFO_EXTENSION));
                                        $documentType = ($extension === 'pdf') ? 'pdf' : 'pandoc';
                                        $documentUrl = route('journals.preview', $journal->uuid);
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-800 rounded-full text-xs font-bold tracking-wide">
                                        {{ strtoupper($extension) }}
                                    </span>
                                    <button class="p-2 text-gray-500 hover:text-slate-600 hover:bg-slate-50 rounded-lg transition-colors" title="Fullscreen">
                                        Fullscreen
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-50">
                            <div class="bg-white rounded-xl overflow-hidden">
                                <x-document-preview 
                                    :document-url="$documentUrl" 
                                    :document-type="$documentType"
                                    title="Document Preview"
                                    subtitle="Manuscript document for review"
                                    height="900px"
                                    :show-controls="true"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Sidebar -->
                <div class="xl:col-span-1 space-y-6">
                    @if (auth()->user()->hasRole('Editor in Chief') || auth()->user()->hasRole('Managing Editor'))
                    <!-- Redesigned Reviewer Assignment -->
                    <div class="bg-white rounded-2xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-50 to-amber-50 px-6 py-5 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div>
                                        <h3 class="font-bold text-gray-900 text-lg">Reviewers</h3>
                                        <p class="text-xs text-gray-600 my-0">Associate Editors</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-gray-900">{{ $assignedReviewers->count() }}</div>
                                    <div class="text-xs text-gray-600 my-0">of 4 max</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <!-- Enhanced Status Indicator -->
                            <div class="mb-6">
                                @if($assignedReviewers->count() >= 4)
                                    <div class="bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 rounded-xl p-4">
                                        <div class="flex items-center">
                                            <div>
                                                <p class="text-amber-900 font-bold text-sm">Maximum Reached</p>
                                                <p class="text-amber-700 text-xs">{{ $assignedReviewers->count() }}/4 reviewers assigned</p>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($assignedReviewers->count() < 2)
                                    <div class="bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-xl p-4">
                                        <div class="flex items-center">
                                            <div>
                                                <p class="text-red-900 font-bold text-sm">More Needed</p>
                                                <p class="text-red-700 text-xs">{{ $assignedReviewers->count() }}/2 minimum required</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4">
                                        <div class="flex items-center">
                                            <div>
                                                <p class="text-green-900 font-bold text-sm">Ready to Proceed</p>
                                                <p class="text-green-700 text-xs">{{ $assignedReviewers->count() }} reviewers assigned</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <form action="{{ route('editor.journals.reviewers.save', $journal->uuid) }}" method="post" id="reviewer-assignment-form" class="space-y-6">
                                @csrf
                                
                                <!-- Enhanced Reviewer Selection -->
                                <div>
                                    <label for="reviewerSelect" class="block text-sm font-bold text-gray-900 mb-3">
                                        Add Associate Editor
                                    </label>                                        <div class="relative">
                                        <select id="reviewerSelect" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:bg-white transition-all {{ $assignedReviewers->count() >= 4 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $assignedReviewers->count() >= 4 ? 'disabled' : '' }}>
                                            <option value="" disabled selected>
                                                {{ $assignedReviewers->count() >= 4 ? 'Maximum reviewers reached' : 'Choose an editor...' }}
                                            </option>
                                            @foreach ($reviewers as $reviewer)
                                                @if(!$assignedReviewers->contains('user_id', $reviewer->id))
                                                    <option value="{{ $reviewer->uuid }}">{{ $reviewer->fullname }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Enhanced Selected Reviewers -->
                                <div id="selectedReviewers" class="space-y-3">
                                    @foreach($assignedReviewers as $reviewer)
                                        <div class="group bg-gradient-to-r from-gray-50 to-orange-50 hover:from-orange-50 hover:to-amber-50 border border-gray-200 hover:border-orange-300 p-4 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md" id="reviewer-{{ $reviewer->user->uuid }}">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-600 rounded-full flex items-center justify-center shadow-sm">
                                                        <span class="text-sm font-bold text-white">
                                                            {{ strtoupper(substr($reviewer->user->fullname, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-gray-900 text-sm my-0">{{ $reviewer->user->fullname }}</p>
                                                        <p class="text-xs text-gray-600 my-0">Associate Editor</p>
                                                    </div>
                                                </div>
                                                <button type="button" onclick="removeReviewer('{{ $reviewer->user->uuid }}', '{{ $reviewer->user->fullname }}')" 
                                                        class="opacity-0 group-hover:opacity-100 w-16 h-16 bg-red-100 hover:bg-red-200 text-red-600 hover:text-red-700 rounded-full flex items-center justify-center transition-all duration-200" title="Remove reviewer">
                                                    ×
                                                </button>
                                                <input type="hidden" name="reviewers[]" value="{{ $reviewer->user->uuid }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Enhanced Submit Button -->
                                <button type="submit" id="assign-btn" 
                                        class="w-full py-3 px-4 text-sm font-bold rounded-xl transition-all duration-200 flex items-center justify-center space-x-2 {{ $assignedReviewers->count() < 2 ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white shadow-sm hover:shadow-sm transform hover:-translate-y-0.5' }}"
                                        {{ $assignedReviewers->count() < 2 ? 'disabled' : '' }}>
                                    @if($assignedReviewers->count() < 2)
                                        <span>Need {{ 2 - $assignedReviewers->count() }} more reviewer(s)</span>
                                    @else
                                        <span>Save {{ $assignedReviewers->count() }} Reviewer{{ $assignedReviewers->count() > 1 ? 's' : '' }}</span>
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    <!-- Enhanced Manuscript Details -->
                    <div class="bg-white rounded-2xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-slate-50 to-slate-100 px-6 py-4 border-b border-gray-100">
                            <div class="flex items-center">
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg">Details</h3>
                                    <p class="text-xs text-gray-600 my-0">Manuscript information</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 space-y-3">
                            <div class="flex justify-between items-center py-2 px-3 bg-gradient-to-r from-gray-50 to-slate-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">Status</span>
                                <span class="inline-flex items-center px-3 py-1.5 {{ $statusColor }} rounded-full text-xs font-bold">
                                    <span class="w-2 h-2 rounded-full mr-2 {{ str_replace('text-', 'bg-', str_replace('100', '500', explode(' ', $statusColor)[1])) }}"></span>
                                    {{ ucwords(str_replace('_', ' ', $journal->status)) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2 px-3 bg-gradient-to-r from-gray-50 to-slate-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">Submitted</span>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-gray-900">{{ $journal->created_at->format('M j, Y') }}</div>
                                    <div class="text-xs text-gray-600 my-0">{{ $journal->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <div class="flex justify-between items-center py-2 px-3 bg-gradient-to-r from-gray-50 to-slate-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">Category</span>
                                <span class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-800 rounded-full text-xs font-bold">
                                    {{ $journal->category->name }}
                                </span>
                            </div>
                            @if($journal->file_path)
                            <div class="flex justify-between items-center py-2 px-3 bg-gradient-to-r from-gray-50 to-slate-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">File Type</span>
                                <span class="inline-flex items-center px-3 py-1.5 bg-gray-200 text-gray-800 rounded-full text-xs font-bold uppercase tracking-wide">
                                    {{ pathinfo($journal->file_path, PATHINFO_EXTENSION) }}
                                </span>
                            </div>
                            @endif
                            <div class="flex justify-between items-center py-2 px-3 bg-gradient-to-r from-gray-50 to-slate-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">Author</span>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-gray-900">{{ $journal->author }}</div>
                                    <div class="text-xs text-gray-600 my-0">Primary Author</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Review Comments -->
                    <div class="bg-white rounded-2xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-5 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div>
                                        <h3 class="font-bold text-gray-900 text-lg">Comments</h3>
                                        <p class="text-xs text-gray-600 my-0">Review feedback</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-gray-900">{{ $comments->count() }}</div>
                                    <div class="text-xs text-gray-600 my-0">total</div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 max-h-96 overflow-y-auto">
                            @forelse ($comments as $comment)
                                <div class="bg-gradient-to-r from-gray-50 to-green-50 border border-gray-200 rounded-xl p-4 mb-4 last:mb-0 hover:shadow-md transition-all duration-200">
                                    <div class="flex items-start space-x-4">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-sm">
                                            <span class="text-white text-sm font-bold">C</span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-gray-800 text-sm leading-relaxed font-medium mb-3">{{ $comment->comment }}</p>
                                            <div class="flex items-center justify-between">
                                                <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">
                                                    Review Feedback
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ $comment->created_at->diffForHumans() ?? 'Recently' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-green-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                                        <span class="text-gray-400 text-2xl font-bold">💬</span>
                                    </div>
                                    <h4 class="text-gray-900 font-bold text-lg mb-2">No Comments Yet</h4>
                                    <p class="text-gray-600 text-sm max-w-xs mx-auto leading-relaxed">
                                        Comments will appear here once reviewers provide their feedback on the manuscript.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Enhanced Progress Tracker -->
                    <div class="bg-white rounded-2xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-slate-50 to-slate-100 px-6 py-4 border-b border-gray-100">
                            <div class="flex items-center">
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg">Progress</h3>
                                    <p class="text-xs text-gray-600 my-0">Review timeline</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <!-- Progress Steps -->
                            <div class="space-y-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-16 h-16 bg-green-500 rounded-full flex justify-center shadow">
                                        <span class="text-white text-xs font-bold">✓</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900">Manuscript Submitted</p>
                                        <p class="text-xs text-gray-600 my-0">{{ $journal->created_at->format('M j, Y g:i A') }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    @if($assignedReviewers->count() >= 2)
                                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center shadow">
                                            <span class="text-white text-xs font-bold">✓</span>
                                        </div>
                                    @else
                                        <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center">
                                            <span class="text-gray-600 text-xs">○</span>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900">Reviewers Assigned</p>
                                        <p class="text-xs text-gray-600 my-0">{{ $assignedReviewers->count() }}/2 minimum assigned</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    @if($comments->count() > 0)
                                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center shadow">
                                            <span class="text-white text-xs font-bold">✓</span>
                                        </div>
                                    @else
                                        <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center">
                                            <span class="text-gray-600 text-xs">○</span>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900">Review Comments</p>
                                        <p class="text-xs text-gray-600 my-0">{{ $comments->count() }} comments received</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center">
                                        <span class="text-gray-600 text-xs">○</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900">Final Decision</p>
                                        <p class="text-xs text-gray-600 my-0">Pending review completion</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Managing Editor Actions for Ready for Notice Status -->
    @if($journal->approval_status === 'ready_for_managing_editor_notice' && auth()->user()->hasAnyRole(['Managing Editor', 'Editor in Chief']))
    <div class="mt-8">
        <div class="bg-white rounded-xl shadow-sm shadow-gray-900/10 border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="ph ph-clipboard-text text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Managing Editor Decision</h2>
                        <p class="text-gray-600 text-sm">Final approval or decline notice</p>
                    </div>
                </div>
            </div>
            
            <div class="p-8">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200 shadow-sm mb-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-sm">
                            <i class="ph ph-info text-white text-sm"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Peer Review Completed</h3>
                    </div>
                    <p class="text-blue-800 text-sm leading-relaxed">
                        This manuscript has completed the peer review process and is ready for your final approval or decline notice. 
                        Please review the feedback from Associate Editors and make your decision.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Approval Option -->
                    <div class="bg-green-50 rounded-xl p-6 border border-green-200 shadow-sm">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center shadow-sm">
                                <i class="ph ph-check-circle text-white text-lg"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-green-900">Send Approval Notice</h4>
                        </div>
                        <p class="text-green-800 text-sm mb-4">
                            Approve this manuscript for publication and notify the author of the positive decision.
                        </p>
                        <button type="button" 
                                class="w-full px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                onclick="showApprovalForm('{{ $journal->uuid }}', '{{ $journal->title }}')">
                            <i class="ph ph-paper-plane mr-2"></i>
                            Send Approval Notice
                        </button>
                    </div>

                    <!-- Decline Option -->
                    <div class="bg-red-50 rounded-xl p-6 border border-red-200 shadow-sm">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center shadow-sm">
                                <i class="ph ph-x-circle text-white text-lg"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-red-900">Send Decline Notice</h4>
                        </div>
                        <p class="text-red-800 text-sm mb-4">
                            Decline this manuscript for publication and provide feedback to the author.
                        </p>
                        <button type="button" 
                                class="w-full px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold rounded-lg hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                onclick="showDeclineForm('{{ $journal->uuid }}', '{{ $journal->title }}')">
                            <i class="ph ph-x-circle mr-2"></i>
                            Send Decline Notice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Enhanced JavaScript with Better UX -->
    <script>
        // Enhanced reviewer management with better UX
        let currentReviewerCount = {{ $assignedReviewers->count() }};
        const MIN_REVIEWERS = 2;
        const MAX_REVIEWERS = 4;
        let availableReviewers = @json($reviewers->whereNotIn('id', $assignedReviewers->pluck('user_id'))->values());

        // Enhanced toast notification system
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-sm transform transition-all duration-300 translate-x-full ${
                type === 'success' ? 'bg-green-500 text-white' : 
                type === 'error' ? 'bg-red-500 text-white' : 
                'bg-slate-500 text-white'
            }`;
            toast.innerHTML = `
                <div class="flex items-center space-x-3">
                    <span class="font-medium">${message}</span>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Animate in
            setTimeout(() => toast.classList.remove('translate-x-full'), 100);
            
            // Animate out and remove
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => document.body.removeChild(toast), 300);
            }, 3000);
        }

        function addReviewer() {
            const reviewerSelect = document.getElementById('reviewerSelect');
            const selectedUuid = reviewerSelect.value;
            
            if (!selectedUuid || currentReviewerCount >= MAX_REVIEWERS) return;

            const selectedReviewer = availableReviewers.find(reviewer => reviewer.uuid === selectedUuid);
            if (!selectedReviewer) return;

            // Add reviewer to interface with enhanced styling
            const selectedReviewersDiv = document.getElementById('selectedReviewers');
            const reviewerDiv = document.createElement('div');
            reviewerDiv.className = 'group bg-gradient-to-r from-gray-50 to-orange-50 hover:from-orange-50 hover:to-amber-50 border border-gray-200 hover:border-orange-300 p-4 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5';
            reviewerDiv.id = `reviewer-${selectedReviewer.uuid}`;
            reviewerDiv.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-600 rounded-full flex items-center justify-center shadow-sm">
                            <span class="text-sm font-bold text-white">
                                ${selectedReviewer.fullname.substring(0, 2).toUpperCase()}
                            </span>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm my-0">${selectedReviewer.fullname}</p>
                            <p class="text-xs text-gray-600 my-0">Associate Editor</p>
                        </div>
                    </div>
                    <button type="button" onclick="removeReviewer('${selectedReviewer.uuid}', '${selectedReviewer.fullname}')" 
                            class="opacity-0 group-hover:opacity-100 w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 hover:text-red-700 rounded-full flex items-center justify-center transition-all duration-200" title="Remove reviewer">
                        ×
                    </button>
                    <input type="hidden" name="reviewers[]" value="${selectedReviewer.uuid}">
                </div>
            `;
            
            selectedReviewersDiv.appendChild(reviewerDiv);
            
            // Update state
            currentReviewerCount++;
            availableReviewers = availableReviewers.filter(reviewer => reviewer.uuid !== selectedUuid);
            
            updateReviewerInterface();
            reviewerSelect.value = '';
            
            // Show success toast
            showToast(`${selectedReviewer.fullname} added as reviewer`, 'success');
        }

        function removeReviewer(reviewerId, reviewerName) {
            const reviewerDiv = document.getElementById(`reviewer-${reviewerId}`);
            if (reviewerDiv) {
                const allReviewers = @json($reviewers);
                const removedReviewer = allReviewers.find(reviewer => reviewer.uuid === reviewerId);
                
                if (removedReviewer) {
                    availableReviewers.push(removedReviewer);
                }
                
                // Animate out
                reviewerDiv.style.transform = 'translateX(100%)';
                reviewerDiv.style.opacity = '0';
                
                setTimeout(() => {
                    reviewerDiv.remove();
                    currentReviewerCount--;
                    updateReviewerInterface();
                    showToast(`${reviewerName} removed from reviewers`, 'info');
                }, 300);
            }
        }

        function updateReviewerInterface() {
            const reviewerSelect = document.getElementById('reviewerSelect');
            const assignButton = document.getElementById('assign-btn');
            
            // Update dropdown with enhanced styling
            reviewerSelect.innerHTML = `
                <option value="" disabled selected>
                    ${currentReviewerCount >= MAX_REVIEWERS ? 'Maximum reviewers reached' : 'Choose an editor...'}
                </option>
            `;
            
            if (currentReviewerCount < MAX_REVIEWERS) {
                availableReviewers.forEach(reviewer => {
                    const option = document.createElement('option');
                    option.value = reviewer.uuid;
                    option.textContent = reviewer.fullname;
                    reviewerSelect.appendChild(option);
                });
            }
            
            reviewerSelect.disabled = currentReviewerCount >= MAX_REVIEWERS;
            
            // Update button with enhanced styling and animations
            if (currentReviewerCount < MIN_REVIEWERS) {
                assignButton.disabled = true;
                assignButton.className = "w-full py-3 px-4 text-sm font-bold rounded-xl transition-all duration-200 flex items-center justify-center space-x-2 bg-gray-100 text-gray-400 cursor-not-allowed";
                assignButton.innerHTML = `<span>Need ${MIN_REVIEWERS - currentReviewerCount} more reviewer(s)</span>`;
            } else {
                assignButton.disabled = false;
                assignButton.className = "w-full py-3 px-4 text-sm font-bold rounded-xl transition-all duration-200 flex items-center justify-center space-x-2 bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white shadow-sm hover:shadow-sm transform hover:-translate-y-0.5";
                assignButton.innerHTML = `<span>Save ${currentReviewerCount} Reviewer${currentReviewerCount > 1 ? 's' : ''}</span>`;
            }
        }

        // Enhanced form submission with loading state
        function handleFormSubmit(event) {
            const form = event.target;
            const submitButton = form.querySelector('button[type="submit"]');
            
            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <div class="flex items-center justify-center space-x-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Saving...</span>
                </div>
            `;
        }

        // Enhanced smooth scrolling for better UX
        function smoothScrollToElement(element) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        // Enhanced initialization
        document.addEventListener('DOMContentLoaded', function() {
            const reviewerSelect = document.getElementById('reviewerSelect');
            const form = document.getElementById('reviewer-assignment-form');
            
            if (reviewerSelect) {
                reviewerSelect.addEventListener('change', function() {
                    if (this.value) addReviewer();
                });
            }
            
            if (form) {
                form.addEventListener('submit', handleFormSubmit);
            }
            
            updateReviewerInterface();
            
            // Add entrance animations
            const cards = document.querySelectorAll('.xl\\:col-span-1 > div, .xl\\:col-span-3 > div');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Make functions global for onclick handlers
        window.removeReviewer = removeReviewer;
        window.addReviewer = addReviewer;
        window.showToast = showToast;
    </script>

    <!-- Approval Notice Modal -->
    <div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approvalModalLabel">
                        <i class="ph ph-check-circle text-success me-2"></i>Send Approval Notice
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="approvalForm" method="POST" action="{{ route('editor.journals.sendApprovalNotice') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="approval-journal-uuid" name="journal_uuid" value="">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Manuscript</label>
                            <p id="approval-manuscript-title" class="text-muted"></p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="approval-comment" class="form-label fw-semibold">Comments (Optional)</label>
                            <textarea name="comment" id="approval-comment" class="form-control" rows="4" 
                                      placeholder="Add any comments for the author regarding the approval..."></textarea>
                            <div class="form-text">This message will be sent to the author along with the approval notice.</div>
                        </div>
                        
                        <div class="alert alert-success">
                            <i class="ph ph-info me-2"></i>
                            <strong>This action will:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Approve the manuscript for publication</li>
                                <li>Send notification to the author</li>
                                <li>Notify Editor-in-Chief and other editors</li>
                                <li>Change manuscript status to "Approved"</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="ph ph-paper-plane me-2"></i>Send Approval Notice
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Decline Notice Modal -->
    <div class="modal fade" id="declineModal" tabindex="-1" aria-labelledby="declineModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="declineModalLabel">
                        <i class="ph ph-x-circle text-danger me-2"></i>Send Decline Notice
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="declineForm" method="POST" action="{{ route('editor.journals.sendDeclineNotice') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="decline-journal-uuid" name="journal_uuid" value="">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Manuscript</label>
                            <p id="decline-manuscript-title" class="text-muted"></p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="decline-reason" class="form-label fw-semibold">Reason for Decline <span class="text-danger">*</span></label>
                            <textarea name="reason" id="decline-reason" class="form-control" rows="4" 
                                      placeholder="Provide a clear reason for declining this manuscript..." required></textarea>
                            <div class="form-text">This message will be sent to the author explaining the decline decision.</div>
                        </div>
                        
                        <div class="alert alert-warning">
                            <i class="ph ph-warning me-2"></i>
                            <strong>This action will:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Decline the manuscript for publication</li>
                                <li>Send notification to the author with reason</li>
                                <li>Notify Editor-in-Chief and other editors</li>
                                <li>Change manuscript status to "Declined"</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="ph ph-paper-plane me-2"></i>Send Decline Notice
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal functions for Managing Editor actions
        function showApprovalForm(journalUuid, journalTitle) {
            document.getElementById('approval-journal-uuid').value = journalUuid;
            document.getElementById('approval-manuscript-title').textContent = journalTitle;
            document.getElementById('approval-comment').value = '';
            
            const modal = new bootstrap.Modal(document.getElementById('approvalModal'));
            modal.show();
        }

        function showDeclineForm(journalUuid, journalTitle) {
            document.getElementById('decline-journal-uuid').value = journalUuid;
            document.getElementById('decline-manuscript-title').textContent = journalTitle;
            document.getElementById('decline-reason').value = '';
            
            const modal = new bootstrap.Modal(document.getElementById('declineModal'));
            modal.show();
        }

        // Make functions global for onclick handlers
        window.showApprovalForm = showApprovalForm;
        window.showDeclineForm = showDeclineForm;
    </script>
</x-layouts.editor_layout>

