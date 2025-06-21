@props([
    'journal',
    'title' => 'Document Reader',
    'subtitle' => 'Review the document directly in your browser',
    'showControls' => true,
    'height' => '75vh',
    'containerClass' => '',
    'role' => 'default'
])

@php
    $extension = pathinfo($journal->journal_url, PATHINFO_EXTENSION);
    $uniqueId = $role . '-' . uniqid();
@endphp

<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 {{ $containerClass }}">
    <!-- Enhanced Header with Modern Design -->
    <div class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-5 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="ph ph-file-text text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 leading-tight">{{ $title }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $subtitle }}</p>
                    <p class="text-xs text-gray-500 mt-1 font-medium bg-gray-100 px-2 py-1 rounded-md inline-block">
                        📄 {{ basename($journal->journal_url) }}
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                @if($extension === 'pdf')
                    <span class="px-4 py-2 text-sm font-semibold bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-700 rounded-full shadow-sm border border-emerald-200">
                        <i class="ph ph-file-pdf mr-1"></i>PDF
                    </span>
                @elseif(in_array($extension, ['doc', 'docx']))
                    <span class="px-4 py-2 text-sm font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 rounded-full shadow-sm border border-blue-200">
                        <i class="ph ph-file-doc mr-1"></i>{{ strtoupper($extension) }}
                    </span>
                @else
                    <span class="px-4 py-2 text-sm font-semibold bg-gradient-to-r from-gray-100 to-slate-100 text-gray-700 rounded-full shadow-sm border border-gray-200">
                        <i class="ph ph-file mr-1"></i>{{ strtoupper($extension) }}
                    </span>
                @endif
                
                <span class="px-4 py-2 text-sm font-semibold bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 rounded-full shadow-sm border border-purple-200">
                    <i class="ph ph-eye mr-2"></i>Preview Mode
                </span>

                @if($showControls)
                    <button type="button" onclick="toggleDocumentReader{{ $uniqueId }}()" 
                            class="px-4 py-2 text-sm font-medium bg-white hover:bg-gray-50 text-gray-700 rounded-full transition-all duration-200 shadow-md hover:shadow-lg border border-gray-200 hover:border-gray-300"
                            id="toggle-btn-{{ $uniqueId }}"
                            title="Hide/Show document reader">
                        <i class="ph ph-eye-slash mr-2" id="toggle-icon-{{ $uniqueId }}"></i>
                        <span id="toggle-text-{{ $uniqueId }}">Hide Reader</span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Document Preview Content -->
    <div class="relative bg-gray-50" id="document-reader-{{ $uniqueId }}">
        <!-- Enhanced Loading State -->
        <div id="manuscript-loading-{{ $uniqueId }}" class="flex flex-col items-center justify-center py-20 bg-gradient-to-br from-blue-50 to-indigo-50">
            <div class="relative">
                <div class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                <div class="absolute inset-0 w-16 h-16 border-4 border-transparent border-r-indigo-400 rounded-full animate-spin animation-delay-150"></div>
            </div>
            <div class="mt-6 text-center">
                <p class="text-lg font-semibold text-gray-800">Loading Document Preview</p>
                <p class="text-sm text-gray-600 mt-2">Processing with Pandoc technology...</p>
                <div class="flex items-center justify-center mt-4 space-x-2">
                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce animation-delay-100"></div>
                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce animation-delay-200"></div>
                </div>
            </div>
        </div>
        
        <!-- Enhanced PDF Container -->
        <div id="document-preview-{{ $uniqueId }}" class="hidden bg-white border-2 border-gray-100 rounded-lg overflow-hidden shadow-inner" style="height: {{ $height }};">
            <!-- PDF iframe will be inserted here -->
        </div>
        
        <!-- Enhanced HTML Document Container -->
        <div id="html-document-container-{{ $uniqueId }}" class="hidden bg-white border-2 border-gray-100 rounded-lg shadow-inner" style="height: {{ $height }};">
            <div class="h-full overflow-auto p-8 prose prose-lg max-w-none" id="html-document-content-{{ $uniqueId }}">
                <!-- Converted HTML content will be inserted here -->
            </div>
        </div>
        
        <!-- Enhanced Error State -->
        <div id="manuscript-error-{{ $uniqueId }}" class="hidden flex flex-col items-center justify-center py-20 bg-gradient-to-br from-red-50 to-pink-50">
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-red-100 to-pink-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                    <i class="ph ph-warning-circle text-4xl text-red-500"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 mb-3">Document Preview Unavailable</h4>
                <p class="text-gray-600 max-w-md mx-auto mb-6" id="error-message-{{ $uniqueId }}">
                    We're having trouble loading the document preview. This might be due to file format or connectivity issues.
                </p>
                <button onclick="retryPreview{{ $uniqueId }}()" 
                   class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 inline-flex items-center group">
                    <i class="ph ph-arrow-clockwise mr-3 group-hover:animate-spin"></i>
                    Retry Preview
                </button>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Footer -->
    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-slate-50 border-t border-gray-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4 text-sm text-gray-600">
                <span class="flex items-center bg-green-100 text-green-700 px-3 py-1 rounded-full font-medium">
                    <i class="ph ph-shield-check mr-2"></i>
                    Secure Preview
                </span>
                <span class="flex items-center">
                    <i class="ph ph-lock mr-2"></i>
                    Content Protection Active
                </span>
            </div>
            <div class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                <i class="ph ph-gear mr-1"></i>
                Powered by Pandoc Engine
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Document Preview Implementation using Pandoc for {{ $uniqueId }}
    const manuscriptLoading = document.getElementById('manuscript-loading-{{ $uniqueId }}');
    const documentPreview = document.getElementById('document-preview-{{ $uniqueId }}');
    const htmlDocumentContainer = document.getElementById('html-document-container-{{ $uniqueId }}');
    const htmlDocumentContent = document.getElementById('html-document-content-{{ $uniqueId }}');
    const manuscriptError = document.getElementById('manuscript-error-{{ $uniqueId }}');
    const errorMessage = document.getElementById('error-message-{{ $uniqueId }}');

    // Document information
    const journalUuid = '{{ $journal->uuid }}';
    const documentName = '{{ basename($journal->journal_url) }}';
    const fileExtension = '{{ pathinfo($journal->journal_url, PATHINFO_EXTENSION) }}';
    const previewUrl = '{{ route("journals.preview", $journal->uuid) }}';

    console.log('{{ $uniqueId }} - Initializing document preview for:', documentName);
    console.log('{{ $uniqueId }} - File type:', fileExtension);
    console.log('{{ $uniqueId }} - Preview URL:', previewUrl);

    function showError(message) {
        console.error('{{ $uniqueId }} - Error:', message);
        manuscriptLoading?.classList.add('hidden');
        documentPreview?.classList.add('hidden');
        htmlDocumentContainer?.classList.add('hidden');
        if (errorMessage) errorMessage.textContent = message;
        manuscriptError?.classList.remove('hidden');
    }

    function showSuccess(isPdf = false) {
        console.log('{{ $uniqueId }} - Success, isPdf:', isPdf);
        manuscriptLoading?.classList.add('hidden');
        manuscriptError?.classList.add('hidden');
        
        if (isPdf) {
            documentPreview?.classList.remove('hidden');
            htmlDocumentContainer?.classList.add('hidden');
        } else {
            documentPreview?.classList.add('hidden');
            htmlDocumentContainer?.classList.remove('hidden');
        }
    }

    function initDocumentPreview() {
        try {
            console.log('{{ $uniqueId }} - Starting initialization...');
            
            if (fileExtension.toLowerCase() === 'pdf') {
                // Handle PDF files directly
                const pdfUrl = '{{ asset("storage/" . $journal->journal_url) }}';
                console.log('{{ $uniqueId }} - Loading PDF directly:', pdfUrl);
                
                const iframe = document.createElement('iframe');
                iframe.src = pdfUrl + '#toolbar=0&navpanes=0&scrollbar=0';
                iframe.style.width = '100%';
                iframe.style.height = '100%';
                iframe.style.border = 'none';
                iframe.title = 'PDF Document Viewer';
                iframe.allowFullscreen = true;
                iframe.setAttribute('type', 'application/pdf');
                
                iframe.onload = function() {
                    console.log('{{ $uniqueId }} - PDF loaded successfully');
                    showSuccess(true);
                };
                
                iframe.onerror = function() {
                    console.error('{{ $uniqueId }} - PDF failed to load');
                    showError('Failed to load PDF document. The file may be corrupted or not accessible.');
                };
                
                documentPreview.innerHTML = '';
                documentPreview.appendChild(iframe);
                
                // Show success immediately for PDF as iframe load event might not fire reliably
                setTimeout(() => {
                    if (manuscriptLoading && !manuscriptLoading.classList.contains('hidden')) {
                        console.log('{{ $uniqueId }} - PDF timeout, showing success anyway');
                        showSuccess(true);
                    }
                }, 2000);
                
            } else if (fileExtension.toLowerCase() === 'docx' || fileExtension.toLowerCase() === 'doc') {
                // Handle DOC/DOCX files with Pandoc conversion
                console.log('{{ $uniqueId }} - Loading DOC/DOCX with Pandoc conversion');
                
                fetch(previewUrl, {
                    method: 'GET',
                    headers: {
                        'Accept': 'text/html,application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    console.log('{{ $uniqueId }} - Response status:', response.status);
                    
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Failed to load document preview');
                        });
                    }
                    
                    const contentType = response.headers.get('content-type');
                    
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Failed to convert document');
                        });
                    } else {
                        return response.text().then(html => {
                            console.log('{{ $uniqueId }} - HTML content received');
                            htmlDocumentContent.innerHTML = html;
                            showSuccess(false);
                            applyDocumentProtection();
                        });
                    }
                })
                .catch(error => {
                    console.error('{{ $uniqueId }} - Fetch error:', error);
                    showError(error.message || 'Failed to load document preview. Please try again.');
                });
                
            } else {
                console.error('{{ $uniqueId }} - Unsupported file type:', fileExtension);
                showError('File type "' + fileExtension.toUpperCase() + '" is not supported for preview. Supported formats: PDF, DOC, DOCX.');
            }

        } catch (error) {
            console.error('{{ $uniqueId }} - Initialization error:', error);
            showError('Failed to initialize document viewer. Please try refreshing the page.');
        }
    }

    function applyDocumentProtection() {
        const previewContent = htmlDocumentContent;
        
        if (previewContent) {
            previewContent.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                return false;
            });
            
            previewContent.addEventListener('selectstart', function(e) {
                e.preventDefault();
                return false;
            });
            
            previewContent.addEventListener('dragstart', function(e) {
                e.preventDefault();
                return false;
            });
            
            const style = document.createElement('style');
            style.textContent = `
                #html-document-content-{{ $uniqueId }} * {
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
                #html-document-container-{{ $uniqueId }} {
                    background: white;
                    box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.1);
                }
                #html-document-content-{{ $uniqueId }} {
                    background: white;
                    border-radius: 8px;
                    min-height: calc(100% - 24px);
                }
                #document-preview-{{ $uniqueId }} {
                    border: 1px solid #e5e7eb;
                    background: white;
                    box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
                }
                #document-preview-{{ $uniqueId }} iframe {
                    background: white;
                    border-radius: 4px;
                }
            `;
            document.head.appendChild(style);
        }
    }

    // Toggle function for hiding/showing document reader
    window['toggleDocumentReader{{ $uniqueId }}'] = function() {
        const readerContainer = document.getElementById('document-reader-{{ $uniqueId }}');
        const toggleBtn = document.getElementById('toggle-btn-{{ $uniqueId }}');
        const toggleIcon = document.getElementById('toggle-icon-{{ $uniqueId }}');
        const toggleText = document.getElementById('toggle-text-{{ $uniqueId }}');
          if (readerContainer && toggleIcon && toggleText) {
            if (readerContainer.style.display === 'none') {
                // Show the reader
                readerContainer.style.display = 'block';
                toggleIcon.className = 'ph ph-eye-slash mr-2';
                toggleText.textContent = 'Hide Reader';
            } else {
                // Hide the reader
                readerContainer.style.display = 'none';
                toggleIcon.className = 'ph ph-eye mr-2';
                toggleText.textContent = 'Show Reader';
            }
        }
    };

    // Retry function
    window['retryPreview{{ $uniqueId }}'] = function() {
        console.log('{{ $uniqueId }} - Retrying preview...');
        manuscriptError?.classList.add('hidden');
        manuscriptLoading?.classList.remove('hidden');
        documentPreview.innerHTML = '';
        htmlDocumentContent.innerHTML = '';
        
        setTimeout(() => {
            initDocumentPreview();
        }, 1000);
    };

    // Initialize preview immediately since we're already in DOMContentLoaded
    console.log('{{ $uniqueId }} - DOM ready, initializing preview...');
    setTimeout(() => {
        initDocumentPreview();
    }, 500);

    // Global document protection for this instance
    document.addEventListener('contextmenu', function(e) {
        if (e.target.closest('#document-preview-{{ $uniqueId }}') || e.target.closest('#html-document-container-{{ $uniqueId }}')) {
            e.preventDefault();
            return false;
        }
    });

    document.addEventListener('selectstart', function(e) {
        if (e.target.closest('#document-preview-{{ $uniqueId }}') || e.target.closest('#html-document-container-{{ $uniqueId }}')) {
            e.preventDefault();
            return false;
        }
    });

    // Disable common keyboard shortcuts in preview area
    document.addEventListener('keydown', function(e) {
        if (e.target.closest('#document-preview-{{ $uniqueId }}') || e.target.closest('#html-document-container-{{ $uniqueId }}')) {
            if (e.ctrlKey && (e.keyCode === 65 || e.keyCode === 67 || e.keyCode === 83 || e.keyCode === 80)) {
                e.preventDefault();
                return false;
            }
        }
    });
});
</script>
