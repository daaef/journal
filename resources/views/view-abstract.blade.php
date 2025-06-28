<x-layouts.layout>
    <x-slot:title>
        Welcome to JAPR Homepage
    </x-slot>
    <x-slot:breadcrumb>
        <div class="flex items-center justify-between pb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $journal->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">Journal Article Preview</p>
            </div>
            <a class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors"
               href="{{ route('journals') }}">
                <i class="ph ph-arrow-left mr-2"></i>
                Back to Journals
            </a>
        </div>
    </x-slot:breadcrumb>
    <div class="max-w-7xl mx-auto">
        <!-- Main Content Area -->
        <div class="grid lg:grid-cols-[1fr_350px] gap-8">
            <!-- Primary Content -->
            <div class="space-y-6">
                <!-- Manuscript Preview Section (For Authors Only) -->
                @if(Auth::check() && Auth::user()->id === $journal->user_id && $journal->journal_url)
                <!-- New Document Preview Component -->
                @php
                    $extension = strtolower(pathinfo($journal->journal_url, PATHINFO_EXTENSION));
                    $documentType = ($extension === 'pdf') ? 'pdf' : 'pandoc';
                    // For existing journal documents, we'll use the journals.preview route
                    $documentUrl = route('journals.preview', $journal->uuid);
                @endphp
                
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                                <i class="ph ph-file-text text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 leading-tight">Your Manuscript</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ basename($journal->journal_url) }}</p>
                                <span class="text-xs text-gray-500 mt-1 font-medium bg-gray-100 px-2 py-1 rounded-md inline-block">
                                    📄 {{ strtoupper($extension) }} Document
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <x-document-preview 
                            :document-url="$documentUrl" 
                            :document-type="$documentType" 
                            height="75vh" 
                            :show-controls="true" 
                        />
                    </div>
                </div>
                @endif

                <!-- Abstract Content -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-8">
                        <div class="prose prose-lg max-w-none">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Abstract</h2>
                            <div class="text-gray-700 leading-relaxed">
                                {!! $journal->abstract !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                @if($journal->approval_status === 'approved')
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Actions</h3>
                    <div class="space-y-3">
                        <a class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors"
                           href="{{ route('download-journal', $journal->uuid) }}">
                            <i class="ph ph-download mr-2"></i>
                            Download
                        </a>
                        
                        @if (auth()->user() && checkJournalInMyCollection($journal->id, auth()->user()->id))
                            <form action="{{ route('journals.remove-from-collection') }}" method="post">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->user() ? auth()->user()->id : null }}">
                                <input type="hidden" name="journal_id" value="{{ $journal->id }}"/>
                                <button name="remove_from_collection" value="remove_from_collection"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                                    <i class="ph ph-heart-break mr-2"></i>
                                    Remove from Collection
                                </button>
                            </form>
                        @else
                            <form action="{{ route('journals.add-to-collection') }}" method="post">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->user() ? auth()->user()->id : null }}">
                                <input type="hidden" name="journal_id" value="{{ $journal->id }}"/>
                                <button name="add_to_collection" value="add_to_collection"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                                    <i class="ph ph-heart mr-2"></i>
                                    Add to Collection
                                </button>
                            </form>
                        @endif
                        
                        <div class="flex space-x-2">
                            <form action="{{ route('journals.like') }}" method="post" class="flex-1">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->user() ? auth()->user()->id : null }}">
                                <input type="hidden" name="journal_id" value="{{ $journal->id }}"/>
                                <button name="like" value="like"
                                        class="w-full inline-flex items-center justify-center px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                                    <i class="ph ph-thumbs-up"></i>
                                </button>
                            </form>
                            <form action="{{ route('journals.dislike') }}" method="post" class="flex-1">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->user() ? auth()->user()->id : null }}">
                                <input type="hidden" name="journal_id" value="{{ $journal->id }}"/>
                                <button name="dislike" value="dislike"
                                        class="w-full inline-flex items-center justify-center px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                                    <i class="ph ph-thumbs-down"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Journal Information -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Journal Information</h3>
                        <div class="space-y-4">
                            @if($journal->approval_status !== 'approved')
                            <div class="flex items-start space-x-3">
                                <i class="ph ph-clock text-amber-500 text-lg mt-0.5"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Status</p>
                                    <p class="text-sm text-gray-600 capitalize">{{ $journal->status_label }}</p>
                                </div>
                            </div>
                            @endif
                            
                            <div class="flex items-start space-x-3">
                                <i class="ph ph-tag text-blue-500 text-lg mt-0.5"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Category</p>
                                    <p class="text-sm text-gray-600">{{ $journal->category->name }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <i class="ph ph-globe text-green-500 text-lg mt-0.5"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Language</p>
                                    <p class="text-sm text-gray-600">{{ $journal->journal_language }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <i class="ph ph-copyright text-purple-500 text-lg mt-0.5"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Copyright</p>
                                    <p class="text-sm text-gray-600">Retained by author</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Author Review Comments Section -->
                @if(Auth::check() && Auth::user()->id === $journal->user_id && $authorReviewComments->isNotEmpty())
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-6">
                        <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="ph ph-chat-circle text-green-500 mr-2"></i>
                            Review Comments
                        </h3>
                        <div class="space-y-4">
                            @foreach ($authorReviewComments as $review)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <h6 class="font-medium text-gray-900 text-sm">
                                                {{ $review->reviewer->fullname ?? 'Anonymous Reviewer' }}
                                            </h6>
                                            <p class="text-xs text-gray-500">
                                                {{ $review->review_submitted_at ? $review->review_submitted_at->format('M j, Y') : 'Recently' }}
                                            </p>
                                        </div>
                                        @if($review->rating)
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="ph {{ $i <= $review->rating ? 'ph-star-fill text-yellow-400' : 'ph-star text-gray-300' }} text-sm"></i>
                                            @endfor
                                            <span class="ml-1 text-sm text-gray-600">({{ $review->rating }})</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="text-gray-700 text-sm leading-relaxed">
                                        {!! nl2br(e($review->comment)) !!}
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
    <!-- All document preview functionality is now handled by the document-reader component -->

</x-layouts.layout>
