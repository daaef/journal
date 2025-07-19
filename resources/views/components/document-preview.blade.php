@props(['documentUrl' => null, 'documentType' => 'pdf', 'height' => '600px', 'showControls' => true])

@php
    $componentId = 'doc-preview-' . uniqid('', true);
@endphp

<div class="document-preview-wrapper" data-document-url="{{ $documentUrl }}" data-document-type="{{ $documentType }}"
     data-component-id="{{ $componentId }}">
    <!-- Preview Container -->
    <div id="{{ $componentId }}-content"
         style="width: 100%; height: {{ $height }}; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #f5f5f5;">
        <!-- Loading State -->
        <div id="{{ $componentId }}-loading" class="flex items-center justify-center h-full">
            <div class="text-center p-8">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                <p class="text-gray-600 text-lg">Loading document...</p>
                <p class="text-gray-500 text-sm">Please wait while we prepare the preview</p>
            </div>
        </div>

        <!-- Preview Content (Initially Hidden) -->
        <div id="{{ $componentId }}-display" class="hidden w-full h-full"></div>

        <!-- Error State -->
        <div id="{{ $componentId }}-error" class="hidden flex items-center justify-center h-full">
            <div class="text-center p-8">
                <svg class="mx-auto h-16 w-16 text-red-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.502 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Preview Error</h3>
                <p id="{{ $componentId }}-error-message" class="text-sm text-gray-600 mb-4"></p>
                <div id="{{ $componentId }}-error-actions">
                    @if($showControls)
                        <button onclick="retryDocumentPreview('{{ $componentId }}')"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Retry Preview
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($showControls)
        <!-- Control Buttons -->
        <div class="mt-4 text-center">
            <div class="flex justify-center space-x-3">
                <a id="{{ $componentId }}-open-tab" href="{{ $documentUrl }}" target="_blank"
                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 hover:text-blue-800">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Open in New Tab
                </a>
                <a id="{{ $componentId }}-download" href="{{ $documentUrl }}?download=1"
                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-green-600 hover:text-green-800">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download
                </a>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const wrappers = document.querySelectorAll('.document-preview-wrapper');
        wrappers.forEach(wrapper => {
            loadDocumentPreview(wrapper);
        });
    });

    function loadDocumentPreview(wrapper) {
        const documentUrl = wrapper.dataset.documentUrl;
        const documentType = wrapper.dataset.documentType;
        const componentId = wrapper.dataset.componentId;

        if (!documentUrl) {
            showDocumentPreviewError('No document URL provided', componentId);
            return;
        }

        const loadingEl = document.getElementById(componentId + '-loading');
        const displayEl = document.getElementById(componentId + '-display');
        const errorEl = document.getElementById(componentId + '-error');

        // Show loading state
        loadingEl.classList.remove('hidden');
        displayEl.classList.add('hidden');
        errorEl.classList.add('hidden');

        // Clear previous content
        displayEl.innerHTML = '';

        // Add debugging info
        console.log('Loading document preview:', {
            documentUrl,
            documentType,
            componentId
        });

        // Always try to determine type dynamically first by making a request
        fetch(documentUrl, {
            method: 'HEAD',
            headers: {
                'Accept': 'application/json, text/html, application/pdf',
            }
        })
            .then(response => {
                console.log('HEAD response:', response.status, response.headers.get('content-type'));
                const contentType = response.headers.get('content-type');

                // Check if the URL might return JSON (like journals.preview)
                if (documentUrl.includes('/journals/') && documentUrl.includes('/preview')) {
                    // This is likely a journals.preview route, make a GET request to see what we get
                    return fetch(documentUrl, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json, text/html',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(getResponse => {
                        console.log('GET response:', getResponse.status, getResponse.headers.get('content-type'));
                        const getContentType = getResponse.headers.get('content-type');

                        if (getContentType && getContentType.includes('application/json')) {
                            return getResponse.json().then(data => {
                                console.log('JSON response data:', data);
                                
                                // Handle login requirement
                                if (!data.success && data.requires_login) {
                                    showLoginRequiredError(data.message, data.login_url, componentId);
                                    return;
                                }
                                
                                if (data.success && data.type === 'pdf' && data.url) {
                                    loadPdfPreview(data.url, displayEl, loadingEl, errorEl, componentId);
                                } else if (data.success && data.html) {
                                    // Direct HTML content from Pandoc conversion
                                    displayEl.innerHTML = `
                                <div style="padding: 20px; height: 100%; overflow-y: auto; font-family: Arial, sans-serif; line-height: 1.6;">
                                    ${data.html}
                                </div>
                            `;
                                    updateControlLinks(documentUrl, componentId);
                                    loadingEl.classList.add('hidden');
                                    displayEl.classList.remove('hidden');
                                } else {
                                    throw new Error(data.message || 'Failed to load document');
                                }
                            });
                        } else if (getContentType && getContentType.includes('text/html')) {
                            // HTML response from Pandoc conversion
                            return getResponse.text().then(html => {
                                displayEl.innerHTML = `
                            <div style="padding: 20px; height: 100%; overflow-y: auto; font-family: Arial, sans-serif; line-height: 1.6;">
                                ${html}
                            </div>
                        `;
                                updateControlLinks(documentUrl, componentId);
                                loadingEl.classList.add('hidden');
                                displayEl.classList.remove('hidden');
                            });
                        } else {
                            throw new Error('Unexpected response type: ' + getContentType);
                        }
                    });
                }

                // For direct file URLs, use content-type to determine handling
                if (contentType && contentType.includes('application/pdf')) {
                    loadPdfPreview(documentUrl, displayEl, loadingEl, errorEl, componentId);
                } else {
                    // Default to pandoc preview for other types (including .docx files)
                    loadPandocPreview(documentUrl, displayEl, loadingEl, errorEl, componentId);
                }
            })
            .catch(error => {
                console.error('Preview error:', error);
                // Fallback: try to determine by documentType parameter or URL
                if (documentType === 'pdf' || documentUrl.includes('.pdf')) {
                    loadPdfPreview(documentUrl, displayEl, loadingEl, errorEl, componentId);
                } else {
                    loadPandocPreview(documentUrl, displayEl, loadingEl, errorEl, componentId);
                }
            });
    }

    function loadPdfPreview(documentUrl, displayEl, loadingEl, errorEl, componentId) {
        // Add inline parameter to ensure PDF displays inline
        const pdfUrl = documentUrl + (documentUrl.includes('?') ? '&' : '?') + 'inline=1';

        displayEl.innerHTML = `
        <object
            data="${pdfUrl}"
            type="application/pdf"
            width="100%"
            height="100%"
            style="border: none;">
            <embed
                src="${pdfUrl}"
                type="application/pdf"
                width="100%"
                height="100%"
                style="border: none;">
                <div class="flex items-center justify-center h-full">
                    <div class="text-center p-8">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">PDF Preview Not Supported</h3>
                        <p class="text-sm text-gray-600 mb-4">Your browser doesn't support inline PDF viewing.</p>
                        <a href="${documentUrl}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            Open PDF in New Tab
                        </a>
                    </div>
                </div>
            </embed>
        </object>
    `;

        // Update control links
        updateControlLinks(documentUrl, componentId);

        // Hide loading and show preview
        loadingEl.classList.add('hidden');
        displayEl.classList.remove('hidden');
    }

    function loadPandocPreview(documentUrl, displayEl, loadingEl, errorEl, componentId) {
        // For Pandoc previews, we need to make a request to get the content
        fetch(documentUrl, {
            method: 'GET',
            headers: {
                'Accept': 'application/json, text/html',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {
                const contentType = response.headers.get('content-type');

                if (contentType && contentType.includes('application/json')) {
                    // Handle JSON response (for PDF files)
                    return response.json().then(data => {
                        if (data.success && data.type === 'pdf') {
                            // Switch to PDF preview mode
                            loadPdfPreview(data.url, displayEl, loadingEl, errorEl, componentId);
                            return;
                        } else {
                            throw new Error(data.message || 'Failed to load document');
                        }
                    });
                } else {
                    // Handle HTML response
                    return response.text().then(html => {
                        if (!response.ok) {
                            throw new Error('Failed to load document');
                        }

                        // Sanitize and display HTML content
                        displayEl.innerHTML = `
                    <div style="padding: 20px; height: 100%; overflow-y: auto; font-family: Arial, sans-serif; line-height: 1.6;">
                        ${html}
                    </div>
                `;

                        // Update control links
                        updateControlLinks(documentUrl, componentId);

                        // Hide loading and show preview
                        loadingEl.classList.add('hidden');
                        displayEl.classList.remove('hidden');
                    });
                }
            })
            .catch(error => {
                showDocumentPreviewError('Failed to load document: ' + error.message, componentId);
            });
    }

    function updateControlLinks(documentUrl, componentId) {
        const openTabLink = document.getElementById(componentId + '-open-tab');
        const downloadLink = document.getElementById(componentId + '-download');

        if (openTabLink) {
            openTabLink.href = documentUrl;
        }
        if (downloadLink) {
            downloadLink.href = documentUrl + (documentUrl.includes('?') ? '&' : '?') + 'download=1';
        }
    }

    function showDocumentPreviewError(message, componentId) {
        const loadingEl = document.getElementById(componentId + '-loading');
        const displayEl = document.getElementById(componentId + '-display');
        const errorEl = document.getElementById(componentId + '-error');
        const errorMessageEl = document.getElementById(componentId + '-error-message');

        if (errorMessageEl) {
            errorMessageEl.textContent = message;
        }

        loadingEl.classList.add('hidden');
        displayEl.classList.add('hidden');
        errorEl.classList.remove('hidden');
    }

    function retryDocumentPreview(componentId) {
        const wrapper = document.querySelector(`[data-component-id="${componentId}"]`);
        if (wrapper) {
            loadDocumentPreview(wrapper);
        }
    }

    function showLoginRequiredError(message, loginUrl, componentId) {
        const loadingEl = document.getElementById(componentId + '-loading');
        const displayEl = document.getElementById(componentId + '-display');
        const errorEl = document.getElementById(componentId + '-error');
        const errorMessageEl = document.getElementById(componentId + '-error-message');
        const errorActionsEl = document.getElementById(componentId + '-error-actions');

        if (errorMessageEl) {
            errorMessageEl.textContent = message;
        }

        if (errorActionsEl) {
            errorActionsEl.innerHTML = `
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="${loginUrl}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Log In to View Document
                    </a>
                    <button onclick="retryDocumentPreview('${componentId}')"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Retry Preview
                    </button>
                </div>
            `;
        }

        loadingEl.classList.add('hidden');
        displayEl.classList.add('hidden');
        errorEl.classList.remove('hidden');
    }
</script>
