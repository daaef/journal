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
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-blue-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="ph ph-file-text text-blue-600 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Your Manuscript</h3>
                                    <p class="text-sm text-gray-600">{{ basename($journal->journal_url) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @php
                                    $extension = pathinfo($journal->journal_url, PATHINFO_EXTENSION);
                                @endphp
                                
                                @if($extension === 'pdf')
                                    <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">
                                        PDF
                                    </span>
                                @elseif(in_array($extension, ['doc', 'docx']))
                                    <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">
                                        {{ strtoupper($extension) }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">
                                        {{ strtoupper($extension) }}
                                    </span>
                                @endif
                                
                                <span class="px-3 py-1 text-xs font-medium bg-purple-100 text-purple-700 rounded-full">
                                    <i class="ph ph-eye mr-1"></i>Preview Only
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Document Preview Content -->
                    <div class="relative">
                        <!-- Loading State -->
                        <div id="manuscript-loading" class="text-center py-16 bg-gray-50">
                            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                            <p class="mt-4 text-gray-600">Loading document preview...</p>
                            <p class="mt-1 text-sm text-gray-500">Powered by Pandoc</p>
                        </div>
                        
                        <!-- Document Preview Container (for PDF) -->
                        <div id="document-preview" class="hidden bg-white rounded-lg overflow-hidden shadow-inner" style="height: 75vh;">
                            <!-- PDF iframe will be inserted here -->
                        </div>
                        
                        <!-- HTML Document Container (for DOC/DOCX) -->
                        <div id="html-document-container" class="hidden bg-white rounded-lg shadow-inner" style="height: 75vh;">
                            <div class="h-full overflow-auto p-6" id="html-document-content">
                                <!-- Converted HTML content will be inserted here -->
                            </div>
                        </div>
                        
                        <!-- Error State -->
                        <div id="manuscript-error" class="hidden text-center py-16 bg-gray-50">
                            <div class="text-red-500">
                                <i class="ph ph-warning-circle text-5xl mb-4"></i>
                                <h4 class="font-semibold text-lg text-gray-900">Document Preview Not Available</h4>
                                <p class="mt-2 text-gray-600" id="error-message">
                                    Unable to load document preview. Please try refreshing the page.
                                </p>
                                <button onclick="retryPreview()" 
                                   class="mt-6 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center">
                                    <i class="ph ph-arrow-clockwise mr-2"></i>Retry Preview
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-6 py-3 bg-gray-50 border-t border-gray-100">
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span class="flex items-center">
                                <i class="ph ph-shield-check mr-2"></i>
                                Document protected - Preview only
                            </span>
                            <span class="text-xs">
                                Secure viewing mode enabled
                            </span>
                        </div>
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Document Preview Implementation using Pandoc
        const manuscriptLoading = document.getElementById('manuscript-loading');
        const documentPreview = document.getElementById('document-preview');
        const htmlDocumentContainer = document.getElementById('html-document-container');
        const htmlDocumentContent = document.getElementById('html-document-content');
        const manuscriptError = document.getElementById('manuscript-error');
        const errorMessage = document.getElementById('error-message');

        // Document information
        const journalUuid = '{{ $journal->uuid }}';
        const documentName = '{{ basename($journal->journal_url) }}';
        const fileExtension = '{{ pathinfo($journal->journal_url, PATHINFO_EXTENSION) }}';
        const previewUrl = '{{ route("journals.preview", $journal->uuid) }}';

        console.log('Initializing document preview for:', documentName);
        console.log('File type:', fileExtension);
        console.log('Preview URL:', previewUrl);

        function showError(message) {
            manuscriptLoading.classList.add('hidden');
            documentPreview.classList.add('hidden');
            htmlDocumentContainer.classList.add('hidden');
            errorMessage.textContent = message;
            manuscriptError.classList.remove('hidden');
        }

        function showSuccess(isPdf = false) {
            manuscriptLoading.classList.add('hidden');
            manuscriptError.classList.add('hidden');
            
            if (isPdf) {
                documentPreview.classList.remove('hidden');
                htmlDocumentContainer.classList.add('hidden');
            } else {
                documentPreview.classList.add('hidden');
                htmlDocumentContainer.classList.remove('hidden');
            }
        }

        function initDocumentPreview() {
            try {
                console.log('Fetching document preview...');
                console.log('File extension detected:', fileExtension);
                
                // Check file type first and handle accordingly
                if (fileExtension.toLowerCase() === 'pdf') {
                    // Handle PDF files directly with simple viewer
                    const pdfUrl = '{{ asset("storage/" . $journal->journal_url) }}';
                    console.log('Loading PDF directly:', pdfUrl);
                    
                    const iframe = document.createElement('iframe');
                    iframe.src = pdfUrl + '#toolbar=0&navpanes=0&scrollbar=0';
                    iframe.style.width = '100%';
                    iframe.style.height = '100%';
                    iframe.style.border = 'none';
                    iframe.title = 'PDF Document Viewer';
                    iframe.allowFullscreen = true;
                    
                    // Add PDF-specific attributes for better compatibility
                    iframe.setAttribute('type', 'application/pdf');
                    
                    iframe.onload = function() {
                        console.log('PDF loaded successfully');
                        showSuccess(true);
                    };
                    
                    iframe.onerror = function() {
                        console.error('PDF failed to load');
                        showError('Failed to load PDF document. The file may be corrupted or not accessible.');
                    };
                    
                    documentPreview.innerHTML = '';
                    documentPreview.appendChild(iframe);
                    
                    // Show success immediately for PDF as iframe load event might not fire reliably
                    setTimeout(() => {
                        if (manuscriptLoading.classList.contains('hidden') === false) {
                            showSuccess(true);
                        }
                    }, 2000);
                    
                } else if (fileExtension.toLowerCase() === 'docx' || fileExtension.toLowerCase() === 'doc') {
                    // Handle DOC/DOCX files with Pandoc conversion
                    console.log('Loading DOC/DOCX with Pandoc conversion');
                    
                    fetch(previewUrl, {
                        method: 'GET',
                        headers: {
                            'Accept': 'text/html,application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        console.log('Preview response status:', response.status);
                        
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.message || 'Failed to load document preview');
                            });
                        }
                        
                        const contentType = response.headers.get('content-type');
                        
                        if (contentType && contentType.includes('application/json')) {
                            // Handle JSON error responses
                            return response.json().then(data => {
                                throw new Error(data.message || 'Failed to convert document');
                            });
                        } else {
                            // Handle HTML response (for DOCX converted content)
                            return response.text().then(html => {
                                // Insert HTML content into the container
                                htmlDocumentContent.innerHTML = html;
                                showSuccess(false); // Pass false for HTML
                                
                                // Apply additional protection to the HTML content
                                applyDocumentProtection();
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Preview fetch error:', error);
                        showError(error.message || 'Failed to load document preview. Please try again.');
                    });
                    
                } else {
                    // Unsupported file type
                    console.error('Unsupported file type:', fileExtension);
                    showError('File type "' + fileExtension.toUpperCase() + '" is not supported for preview. Supported formats: PDF, DOC, DOCX.');
                }

            } catch (error) {
                console.error('Error initializing document preview:', error);
                showError('Failed to initialize document viewer. Please try refreshing the page.');
            }
        }

        function applyDocumentProtection() {
            // Additional protection for HTML content
            const previewContent = htmlDocumentContent;
            
            if (previewContent) {
                // Disable context menu
                previewContent.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                    return false;
                });
                
                // Disable text selection
                previewContent.addEventListener('selectstart', function(e) {
                    e.preventDefault();
                    return false;
                });
                
                // Disable drag and drop
                previewContent.addEventListener('dragstart', function(e) {
                    e.preventDefault();
                    return false;
                });
                
                // Add CSS protection
                const style = document.createElement('style');
                style.textContent = `
                    #html-document-content * {
                        -webkit-user-select: none !important;
                        -moz-user-select: none !important;
                        -ms-user-select: none !important;
                        user-select: none !important;
                        -webkit-user-drag: none !important;
                        -khtml-user-drag: none !important;
                        -moz-user-drag: none !important;
                        -o-user-drag: none !important;
                        user-drag: none !important;
                    }
                    #html-document-container {
                        background: white;
                        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.1);
                    }
                    #html-document-content {
                        background: white;
                        border-radius: 8px;
                        min-height: calc(100% - 24px);
                    }
                    #document-preview {
                        border: 1px solid #e5e7eb;
                        background: white;
                        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
                    }
                    #document-preview iframe {
                        background: white;
                        border-radius: 4px;
                    }
                `;
                document.head.appendChild(style);
            }
        }

        // Retry function
        window.retryPreview = function() {
            manuscriptError.classList.add('hidden');
            manuscriptLoading.classList.remove('hidden');
            documentPreview.innerHTML = ''; // Clear previous content
            htmlDocumentContent.innerHTML = ''; // Clear HTML content
            
            setTimeout(() => {
                initDocumentPreview();
            }, 1000);
        };

        // Initialize preview on page load
        setTimeout(() => {
            initDocumentPreview();
        }, 500); // Small delay to ensure DOM is ready

        // Global document protection
        document.addEventListener('contextmenu', function(e) {
            if (e.target.closest('#document-preview') || e.target.closest('#html-document-container')) {
                e.preventDefault();
                return false;
            }
        });

        document.addEventListener('selectstart', function(e) {
            if (e.target.closest('#document-preview') || e.target.closest('#html-document-container')) {
                e.preventDefault();
                return false;
            }
        });

        // Disable common keyboard shortcuts in preview area
        document.addEventListener('keydown', function(e) {
            if (e.target.closest('#document-preview') || e.target.closest('#html-document-container')) {
                if (e.ctrlKey && (e.keyCode === 65 || e.keyCode === 67 || e.keyCode === 83 || e.keyCode === 80)) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    });
    </script>

</x-layouts.layout>
