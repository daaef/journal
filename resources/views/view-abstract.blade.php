<x-layouts.layout>
    <x-slot:title>
        Welcome to JAPR Homepage
    </x-slot>
    <x-slot:breadcrumb>
        <div class="border-b border-gray-200 pb-5 sm:flex w-full sm:items-center sm:justify-between">
            <h3 class="text-lg font-bold leading-6 text-gray-900">Abstract</h3>
            <div>
                <a class="font-bold text-gray-100 rounded-[8px] inline-block py-2 px-6 bg-primary-500"
                   href="{{ route('journals') }}">Back to Journals</a>
            </div>
        </div>
        <hr class="">
    </x-slot:breadcrumb>
    <div class="grid lg:grid-cols-[400px_1fr] gap-4 w-full">
        <div class="flex flex-col justify-start gap-4">
            @if($journal->approval_status === 'approved')
                <a class="font-bold text-gray-100 flex gap-4 justify-center items-center rounded-[8px] py-1 px-6 bg-primary-500"
                   href="{{ route('download-journal', $journal->uuid) }}">
                    <svg width="15" height="15" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.5469 0H14.4531C15.1025 0 15.625 0.522461 15.625 1.17188V9.375H19.9072C20.7764 9.375 21.2109 10.4248 20.5957 11.04L13.1689 18.4717C12.8027 18.8379 12.2021 18.8379 11.8359 18.4717L4.39941 11.04C3.78418 10.4248 4.21875 9.375 5.08789 9.375H9.375V1.17188C9.375 0.522461 9.89746 0 10.5469 0ZM25 18.3594V23.8281C25 24.4775 24.4775 25 23.8281 25H1.17188C0.522461 25 0 24.4775 0 23.8281V18.3594C0 17.71 0.522461 17.1875 1.17188 17.1875H8.33496L10.7275 19.5801C11.709 20.5615 13.291 20.5615 14.2725 19.5801L16.665 17.1875H23.8281C24.4775 17.1875 25 17.71 25 18.3594ZM18.9453 22.6562C18.9453 22.1191 18.5059 21.6797 17.9688 21.6797C17.4316 21.6797 16.9922 22.1191 16.9922 22.6562C16.9922 23.1934 17.4316 23.6328 17.9688 23.6328C18.5059 23.6328 18.9453 23.1934 18.9453 22.6562ZM22.0703 22.6562C22.0703 22.1191 21.6309 21.6797 21.0938 21.6797C20.5566 21.6797 20.1172 22.1191 20.1172 22.6562C20.1172 23.1934 20.5566 23.6328 21.0938 23.6328C21.6309 23.6328 22.0703 23.1934 22.0703 22.6562Z"
                            class="fill-gray-100"/>
                    </svg>
                    Download Journal
                </a>
                @if (auth()->user() && checkJournalInMyCollection($journal->id, auth()->user()->id))
                    <form action="{{ route('journals.remove-from-collection') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user() ? auth()->user()->id : null }}">
                        <input type="hidden" name="journal_id" value="{{ $journal->id }}"/>
                        <button name="remove_from_collection" value="remove_from_collection"
                                class="text-gray-100 w-full flex justify-center bg-primary-500 rounded-[8px] px-4 py-1 font-bold hover:bg-primary-600">
                            Remove
                            from my Collection
                        </button>
                    </form>
                @else
                    <form action="{{ route('journals.add-to-collection') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user() ? auth()->user()->id : null }}">
                        <input type="hidden" name="journal_id" value="{{ $journal->id }}"/>
                        <button name="add_to_collection" value="add_to_collection"
                                class="text-gray-100 w-full flex justify-center bg-primary-500 rounded-[8px] px-4 py-1 font-bold hover:bg-primary-600">
                            Add
                            to my Collection
                        </button>
                    </form>
                @endif
                <div class="grid grid-cols-2 gap-4">
                    <form action="{{ route('journals.dislike') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user() ? auth()->user()->id : null }}">
                        <input type="hidden" name="journal_id" value="{{ $journal->id }}"/>
                        <button
                            class="text-gray-100 w-full py-2 h-full bg-primary-500 rounded-[8px] px-4 justify-center flex font-bold hover:bg-primary-600"
                            name="dislike" value="dislike">
                            <svg width="15" height="15" viewBox="0 0 25 25" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.3027 24.9476C16.5723 24.6574 17.3975 23.2457 17.1436 21.7949L17.0312 21.1588C16.7725 19.669 16.2939 18.2517 15.625 16.9628H22.6562C23.9502 16.9628 25 15.7631 25 14.2844C25 13.2522 24.4873 12.3538 23.7354 11.9074C24.2676 11.4164 24.6094 10.6631 24.6094 9.82055C24.6094 8.51486 23.7891 7.42679 22.71 7.19244C22.9248 6.78511 23.0469 6.31082 23.0469 5.80305C23.0469 4.61454 22.3682 3.60459 21.4307 3.25864C21.4648 3.0745 21.4844 2.87921 21.4844 2.67833C21.4844 1.19967 20.4346 0 19.1406 0H14.3799C13.4521 0 12.5488 0.312472 11.7773 0.898357L9.89746 2.33238C8.59375 3.3256 7.8125 4.99955 7.8125 6.79069V12.9955C7.8125 14.6248 8.46191 16.1593 9.57031 17.1804L9.93164 17.5096C11.2256 18.6925 12.1094 20.3553 12.4316 22.2078L12.5439 22.8439C12.7979 24.2947 14.0332 25.2377 15.3027 24.9476ZM1.5625 19.6411H4.6875C5.55176 19.6411 6.25 18.8432 6.25 17.8555V5.35666C6.25 4.36903 5.55176 3.57111 4.6875 3.57111H1.5625C0.698242 3.57111 0 4.36903 0 5.35666V17.8555C0 18.8432 0.698242 19.6411 1.5625 19.6411Z"
                                    class="fill-gray-100"/>
                            </svg>
                        </button>
                    </form>
                    <form action="{{ route('journals.like') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user() ? auth()->user()->id : null }}">
                        <input type="hidden" name="journal_id" value="{{ $journal->id }}"/>
                        <button
                            class="text-gray-100 w-full py-2 bg-primary-500 h-full rounded-[8px] px-4 justify-center flex font-bold hover:bg-primary-600"
                            name="like" value="like">
                            <svg width="15" height="15" viewBox="0 0 25 25" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.07812 10.9375H1.17187C0.524658 10.9375 0 11.4622 0 12.1094V23.8281C0 24.4753 0.524658 25 1.17187 25H5.07812C5.72534 25 6.25 24.4753 6.25 23.8281V12.1094C6.25 11.4622 5.72534 10.9375 5.07812 10.9375ZM3.125 23.0469C2.47778 23.0469 1.95312 22.5222 1.95312 21.875C1.95312 21.2278 2.47778 20.7031 3.125 20.7031C3.77222 20.7031 4.29687 21.2278 4.29687 21.875C4.29687 22.5222 3.77222 23.0469 3.125 23.0469ZM18.75 3.97715C18.75 6.04824 17.4819 7.20996 17.1251 8.59375H22.0921C23.7228 8.59375 24.9923 9.94854 24.9999 11.4306C25.0041 12.3064 24.6315 13.2494 24.0508 13.8328L24.0454 13.8381C24.5257 14.9776 24.4476 16.5743 23.5909 17.7185C24.0148 18.9829 23.5875 20.536 22.791 21.3687C23.0009 22.228 22.9006 22.9593 22.4908 23.548C21.4942 24.9798 19.0242 25 16.9355 25L16.7966 25C14.4388 24.9991 12.5092 24.1407 10.9587 23.4509C10.1795 23.1042 9.16079 22.6751 8.38784 22.6609C8.06851 22.6551 7.8125 22.3945 7.8125 22.0751V11.6371C7.8125 11.4809 7.8751 11.3309 7.98623 11.221C9.92051 9.30972 10.7522 7.28613 12.3376 5.69805C13.0605 4.97383 13.3234 3.87988 13.5775 2.82197C13.7947 1.9186 14.2489 0 15.2344 0C16.4062 0 18.75 0.390625 18.75 3.97715Z"
                                    class="fill-gray-100"/>
                            </svg>
                        </button>
                    </form>
                </div>
            @endif
            @if($journal->approval_status !== 'approved')
                <div class="flex flex-col border border-gray-200 rounded-xl overflow-hidden">
                    <div class="px-4 py-2 md:px-5 bg-secondary-900 text-gray-100">
                        Status
                    </div>
                    <div class="p-4 md:p-5 capitalize">
                        {{ $journal->status_label }}
                    </div>
                </div>
            @endif
            <div class="flex flex-col border border-gray-200 rounded-xl overflow-hidden">
                <div class="px-4 py-2 md:px-5 bg-secondary-900 text-gray-100">
                    Category
                </div>
                <div class="p-4 md:p-5">
                    {{ $journal->category->name }}
                </div>
            </div>
            <div class="flex flex-col border border-gray-200 rounded-xl overflow-hidden">
                <div class="px-4 py-2 md:px-5 bg-secondary-900 text-gray-100">
                    Language
                </div>
                <div class="p-4 md:p-5">
                    {{ $journal->journal_language }}
                </div>
            </div>
            <div class="flex flex-col border border-gray-200 rounded-xl overflow-hidden">
                <div class="px-4 py-2 md:px-5 bg-secondary-900 text-gray-100">
                    Copyright
                </div>
                <div class="p-4 md:p-5">
                    Copyright for articles published in this journal is retained by the author.
                </div>
            </div>

            <!-- Author Review Comments Section (For Authors Only) - In Sidebar -->
            @if(Auth::check() && Auth::user()->id === $journal->user_id && $authorReviewComments->isNotEmpty())
            <div class="flex flex-col border border-gray-200 rounded-xl overflow-hidden">
                <div class="px-4 py-2 md:px-5 bg-green-600 text-gray-100">
                    <div class="flex items-center gap-2">
                        Review Comments
                    </div>
                </div>
                <div class="p-4 md:p-5">
                    <div class="space-y-4">
                        @foreach ($authorReviewComments as $review)
                            <div class="bg-gray-50 border border-gray-200 rounded-lg">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <div>
                                            <h6 class="font-medium text-gray-800 text-sm">
                                                {{ $review->reviewer->fullname ?? 'Anonymous Reviewer' }}
                                            </h6>
                                            <p class="text-xs text-gray-500">
                                                {{ $review->review_submitted_at ? $review->review_submitted_at->format('M j, Y') : 'Recently' }}
                                            </p>
                                        </div>
                                    </div>
                                    @if($review->rating)
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="ph {{ $i <= $review->rating ? 'ph-star-fill text-yellow-400' : 'ph-star text-gray-300' }} text-xs"></i>
                                        @endfor
                                        <span class="ml-1 text-xs text-gray-600">({{ $review->rating }})</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="bg-white rounded p-3">
                                    <div class="text-gray-700 text-sm leading-relaxed">
                                        {!! nl2br(e($review->comment)) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="grid gap-y-2">
            <!-- Manuscript Preview Section (For Authors Only) -->
            @if(Auth::check() && Auth::user()->id === $journal->user_id && $journal->journal_url)
            <div id="manuscriptPreview" class="border rounded-lg overflow-hidden mb-6">
                <div class="bg-blue-50 border-b border-blue-200 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-bold text-blue-800 mb-1">
                                <i class="ph ph-file-pdf mr-2"></i>Your Manuscript Preview
                            </h4>
                            <p class="text-sm text-blue-600">Preview your submitted manuscript</p>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" onclick="resizeManuscriptViewer('expand')" 
                                    class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200"
                                    title="Expand viewer">
                                <i class="ph ph-arrows-out"></i>
                            </button>
                            <button type="button" onclick="resizeManuscriptViewer('shrink')" 
                                    class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200"
                                    title="Shrink viewer">
                                <i class="ph ph-arrows-in"></i>
                            </button>
                            <a href="{{ asset('storage/' . $journal->journal_url) }}" target="_blank"
                               class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded hover:bg-green-200"
                               title="Open in new tab">
                                <i class="ph ph-arrow-square-out"></i>
                            </a>
                            <a href="{{ asset('storage/' . $journal->journal_url) }}" download
                               class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200"
                               title="Download PDF">
                                <i class="ph ph-download-simple"></i>
                            </a>
                            <button type="button" onclick="toggleManuscriptPreview()" 
                                    class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200"
                                    title="Hide preview">
                                <i class="ph ph-eye-slash mr-1"></i>Hide
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-0">
                    <div class="bg-gray-100 px-4 py-2 border-b flex justify-between items-center text-sm">
                        <span class="text-gray-600">
                            <i class="ph ph-lightbulb mr-1"></i>
                            <strong>Tip:</strong> Use Ctrl+F to search within the document
                        </span>
                        <span class="text-gray-500">
                            <i class="ph ph-info mr-1"></i>
                            File: {{ basename($journal->journal_url) }}
                        </span>
                    </div>
                    
                    <!-- Loading Indicator -->
                    <div id="manuscriptLoading" class="text-center py-8" style="display: none;">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                        <p class="mt-2 text-gray-600">Loading manuscript...</p>
                    </div>
                    
                    <!-- PDF Viewer -->
                    <iframe id="manuscriptViewer" 
                            src="{{ asset('storage/' . $journal->journal_url) }}#toolbar=1&navpanes=1&scrollbar=1" 
                            style="width: 100%; height: 600px; border: none; background: #f8f9fa;"
                            loading="lazy"
                            title="Manuscript PDF Viewer"
                            onload="hideManuscriptLoading()"
                            onerror="showManuscriptError()">
                    </iframe>
                    
                    <!-- Error Fallback -->
                    <div id="manuscriptError" class="p-6 text-center" style="display: none;">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <i class="ph ph-warning-circle text-yellow-600 text-xl"></i>
                            <div class="mt-2">
                                <strong class="text-yellow-800">PDF Preview Not Available</strong>
                                <p class="text-yellow-700 mt-2">Your browser does not support embedded PDFs or the document could not be loaded.</p>
                                <div class="flex gap-2 justify-center mt-4">
                                    <a href="{{ asset('storage/' . $journal->journal_url) }}" target="_blank" 
                                       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        <i class="ph ph-arrow-square-out mr-1"></i>Open in New Tab
                                    </a>
                                    <a href="{{ asset('storage/' . $journal->journal_url) }}" download
                                       class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                        <i class="ph ph-download-simple mr-1"></i>Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="border p-8 rounded-[8px]">
                <h4 class="text-3xl text-primary-500 font-bold mb-4">
                    {{ $journal->title }}
                </h4>
                <hr class="mb-5">
                {!! $journal->abstract !!}
            </div>
        </div>
    </div>

    <script>
    // Manuscript Preview Functions
    document.addEventListener('DOMContentLoaded', function() {
        // Show loading initially for manuscript
        const manuscriptLoading = document.getElementById('manuscriptLoading');
        if (manuscriptLoading) manuscriptLoading.style.display = 'block';
    });

    // Manuscript preview toggle
    window.toggleManuscriptPreview = function() {
        const preview = document.getElementById('manuscriptPreview');
        const toggleBtn = document.querySelector('button[onclick="toggleManuscriptPreview()"]');
        
        if (preview.style.display === 'none') {
            preview.style.display = 'block';
            preview.scrollIntoView({ behavior: 'smooth', block: 'start' });
            if (toggleBtn) {
                toggleBtn.innerHTML = '<i class="ph ph-eye-slash mr-1"></i>Hide';
                toggleBtn.title = 'Hide preview';
            }
        } else {
            preview.style.display = 'none';
            if (toggleBtn) {
                toggleBtn.innerHTML = '<i class="ph ph-eye mr-1"></i>Show';
                toggleBtn.title = 'Show preview';
            }
        }
    };

    // Manuscript viewer resize functionality
    window.resizeManuscriptViewer = function(action) {
        const viewer = document.getElementById('manuscriptViewer');
        if (!viewer) return;
        
        const currentHeight = parseInt(viewer.style.height) || 600;
        
        if (action === 'expand' && currentHeight < 1000) {
            viewer.style.height = (currentHeight + 100) + 'px';
        } else if (action === 'shrink' && currentHeight > 400) {
            viewer.style.height = (currentHeight - 100) + 'px';
        }
    };

    // Manuscript Loading and Error Handling
    window.hideManuscriptLoading = function() {
        const loading = document.getElementById('manuscriptLoading');
        if (loading) loading.style.display = 'none';
    };

    window.showManuscriptError = function() {
        const loading = document.getElementById('manuscriptLoading');
        const viewer = document.getElementById('manuscriptViewer');
        const error = document.getElementById('manuscriptError');
        
        if (loading) loading.style.display = 'none';
        if (viewer) viewer.style.display = 'none';
        if (error) error.style.display = 'block';
    };
    </script>

</x-layouts.layout>
