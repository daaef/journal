<script src="https://unpkg.com/htmx.org@2.0.2"
    integrity="sha384-Y7hw+L/jvKeWIRRkqWYfPcvVxHzVzn5REgzbawhxAuQGwX1XWe70vji+VSeHOThJ" crossorigin="anonymous">
</script>

<x-layouts.layout>
    <x-slot:title>
        Custom Title
    </x-slot>

    <x-slot:title>
        Welcome to your JAPR Submissions Page
    </x-slot>
    <x-slot:breadcrumb>
        <div class="w-full pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <h3 class="text-lg font-bold leading-6 text-gray-900">Submissions</h3>
            <div>
                <h4>{{ Str::words(auth()->user()->fullname, 1, '') }}'s Dashboard</h4>
            </div>
        </div>
        <hr class="">
    </x-slot:breadcrumb>
    <form action="{{ route('submit-manuscript.post') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="space-y-12">
            <div class="">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Submit a Manuscript</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Submit a manuscript for reviews by our editors</p>

                <div class="grid grid-cols-1 mt-10 gap-x-6 gap-y-8 sm:grid-cols-2">

                    <div>
                        <label for="author" class="block text-sm font-medium leading-6 text-gray-900">Authors (separate with commas)</label>
                        <div class="mt-2">
                            <input id="author" name="author" type="text"
                                   value="{{ old('author') ?: auth()->user()->fullname }}" required
                                   placeholder="John Smith, Jane Doe, Robert Johnson"
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div>
                        <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Manuscript title</label>
                        <div class="mt-2">
                            <input id="title" name="title" type="text" value="{{ old('title') }}" required
                                placeholder="Enter your manuscript title"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div class="col-span-full">
                        <label for="abstract" class="block text-sm font-medium leading-6 text-gray-900">Abstract</label>
                        <div class="mt-2">
                            <textarea id="abstract" name="abstract" rows="3" value="{{ old('abstract') }}"
                                      placeholder="Brief summary of your research (150-300 words)"
                                      class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">{{ old('abstract') }}</textarea>
                        </div>
                    </div>

                    <div>
                        <label for="institution"
                            class="block text-sm font-medium leading-6 text-gray-900">Institution/Affiliation</label>
                        <div class="mt-2">
                            <input id="institution" name="institution" type="text" value="{{ old('institution') }}"
                                required
                                placeholder="Your institution or organization"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <label for="keywords" class="block text-sm font-medium leading-6 text-gray-900">Keywords (3-6 keywords, comma separated)</label>
                        <div class="mt-2">
                            <input id="keywords" name="meta_keywords" type="text" value="{{ old('keywords') }}"
                                required
                                placeholder="renewable energy, sustainability, climate change"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div class="col-span-full">
                        <label for="cover-photo"
                               class="block text-sm font-medium leading-6 text-gray-900">Manuscript (Word docs auto-converted to PDF)</label>
                        <div
                            class="flex justify-center px-6 py-10 mt-2 border border-dashed rounded-lg border-gray-900/25">
                            <div class="text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                     width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path
                                        d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
                                </svg>
                                <div class="flex mt-4 text-sm justify-center leading-6 text-gray-600">
                                    <label for="file-upload"
                                           class="relative font-semibold text-indigo-600 bg-white rounded-md cursor-pointer focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload Manuscript</span>
                                        <input id="file-upload" name="manuscripts" type="file" class="sr-only" accept=".pdf,.doc,.docx">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <span id="file-name"
                                      class="px-4 py-2 text-sm font-medium text-gray-100 rounded-md bg-primary-600"
                                      style="display: none;"></span>
                                <p class="text-xs leading-5 text-gray-600">PDF, DOC, or DOCX files up to 10MB</p>
                                
                                <!-- Preview button -->
                                <button type="button" id="preview-btn" 
                                        class="hidden mt-3 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Preview Document
                                </button>
                            </div>
                        </div>
                        
                        <!-- Document Preview Modal -->
                        <div id="preview-modal" class="fixed inset-0 z-[2000] hidden bg-gray-600 bg-opacity-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-center justify-center w-full h-screen p-4">
                                <div class="bg-white rounded-lg shadow-xl max-w-6xl w-full mx-auto my-8 flex flex-col max-h-[70vh] overflow-y-auto">
                                    <!-- Modal Header -->
                                    <div class="flex items-center justify-between flex-shrink-0 p-6 border-b">
                                        <h3 class="text-xl font-semibold text-gray-900" id="modal-title">
                                            <svg class="w-6 h-6 inline-block mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Document Preview
                                        </h3>
                                        <button type="button" id="close-preview" class="flex-shrink-0 text-2xl text-gray-400 hover:text-gray-600 transition-colors">
                                            <span class="sr-only">Close</span>
                                            ×
                                        </button>
                                    </div>
                                                     <!-- Modal Content (Scrollable) -->
                    <div id="preview-content" class="flex-1 p-6 overflow-y-auto border rounded-lg m-4 bg-gray-50" style="isolation: isolate;">
                        <div id="preview-loading" class="hidden text-center py-12">
                            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                            <p class="mt-4 text-gray-600 text-lg">Generating preview...</p>
                            <p class="mt-2 text-gray-500 text-sm">This may take a moment depending on document size</p>
                        </div>
                        
                        <!-- Document Preview Component Container -->
                        <div id="preview-html" class="prose max-w-none"></div>
                        
                        <div id="preview-error" class="hidden text-center py-12">
                                            <div class="text-red-600 text-lg">
                                                <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <p class="font-medium">Preview Generation Failed</p>
                                                <p class="mt-2 text-sm text-gray-600">Please check your document format and try again</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Modal Footer -->
                                    <div class="flex items-center justify-end flex-shrink-0 p-6 border-t bg-gray-50">
                                        <button type="button" id="close-preview-footer" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                            Close Preview
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full">
                        <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Country</label>
                        <div class="mt-2">
                            <select name="country" id="country"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                                <option value="" disabled selected>Select country</option>
                                @foreach ($regions as $region => $countries)
                                    <optgroup label="{{ $region }}">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country }}">{{ $country }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="w-full">
                        <label for="journal_language"
                            class="block text-sm font-medium leading-6 text-gray-900">Language</label>
                        <div class="mt-2">
                            <select id="journal_language" name="journal_language" autocomplete="language-name"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                                <option value="" disabled selected>Select language</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language }}">{{ $language }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-span-full">
                        <label for="category_id"
                            class="block text-sm font-medium leading-6 text-gray-900">Category</label>
                        <div class="mt-2">
                            <select id="category_id" name="category_id" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6"
                                hx-get="/load-subcategories" hx-target="#subcategories"
                                hx-params="category_id=${select.value}" hx-trigger="change">
                                <option value="" disabled selected>Select category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div id="subcategories">
                        <label for="subcategory_id" class="block text-sm font-medium leading-6 text-gray-900">Sub
                            Category</label>
                        <div class="mt-2">
                            <select id="subcategory_id" name="subcategory_id" required
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                                <option value="" disabled selected>Select a Sub-Category</option>
                            </select>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="pb-12 border-b border-gray-900/10">
                <div class="mt-10 space-y-10">
                    <fieldset>
                        <div class="mt-6 space-y-6">
                            <div class="relative flex gap-x-3">
                                <div class="flex items-center h-6">
                                    <input id="agree" name="agree_japr_policy" type="checkbox"
                                        class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-600"
                                        required>
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="agree" class="text-gray-500">
                                        I agree that I haven't published this article anywhere else
                                    </label>
                                </div>
                            </div>

                            <!-- Review Policy Acceptance -->
                            <div class="relative flex gap-x-3">
                                <div class="flex items-center h-6">
                                    <input id="review_policy_accepted" name="review_policy_accepted" type="checkbox"
                                        class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-600"
                                        value="1"
                                        @if(auth()->user()->review_policy_accepted) checked disabled @else disabled @endif>
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="review_policy_accepted" class="text-gray-500">
                                        I accept the
                                        @if(!auth()->user()->review_policy_accepted)
                                            <button type="button" onclick="showReviewPolicyModal()" class="p-0 text-blue-600 font-bold underline bg-transparent border-none cursor-pointer hover:text-blue-800">JAPR Review Policy</button>
                                        @else
                                            <a href="{{ route('review-policy.show') }}" target="_blank" class="text-blue-600 underline font-bold hover:text-blue-800">JAPR Review Policy</a>
                                        @endif
                                        and agree to comply with all review standards and procedures
                                        @if(!auth()->user()->review_policy_accepted)
                                            <br><small class="text-gray-400 italic">(Click policy link to accept before submitting)</small>
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-6 gap-x-6">
            <a href="{{ url()->previous() }}"
                class="px-3 py-2 text-sm font-semibold leading-6 text-gray-200 bg-red-600 rounded-md hover:bg-red-500">Cancel</a>
            <button type="submit" name="submit" value="submit" id="submitBtn"
                class="px-3 py-2 text-sm font-semibold text-white bg-green-800 rounded-md shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                Submit
            </button>
        </div>
    </form>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 z-50 bg-gray-600 bg-opacity-50 flex items-center justify-center h-full" style="display: none;">
        <div class="">
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-6 h-6 border-b-2 border-green-600 rounded-full animate-spin"></div>
                    <span class="text-gray-700">Processing and converting your document...</span>
                </div>
                <p class="mt-2 text-sm text-gray-500">This may take a moment for Word documents.</p>
            </div>
        </div>
    </div>

    <!-- Review Policy Modal -->
    <div id="reviewPolicyModal" class="fixed inset-0 z-[50000] bg-gray-600 bg-opacity-50" style="display: none;">
        <div class="flex items-center justify-center w-full min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-auto my-8 flex flex-col max-h-[calc(100vh-10rem)]">
                <!-- Modal Header -->
                <div class="flex items-center justify-between flex-shrink-0 p-6 border-b">
                    <h3 class="text-xl font-semibold text-gray-900">JAPR Review Policy</h3>
                    <button type="button" onclick="closeReviewPolicyModal()" class="flex-shrink-0 text-2xl text-gray-400 hover:text-gray-600">
                        ×
                    </button>
                </div>

                <!-- Modal Content (Scrollable) -->
                <div class="flex-1 p-6 overflow-y-auto">
                    <div id="reviewPolicyContent" class="prose max-w-none">
                        <p class="text-center text-gray-500">Loading policy content...</p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end flex-shrink-0 p-6 border-t gap-x-4 bg-gray-50">
                    <button type="button" onclick="declineReviewPolicy()"
                            class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-md shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                        Decline
                    </button>
                    <button type="button" onclick="acceptReviewPolicy()"
                            class="px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-md shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                        Accept
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Container -->
    <div id="notificationContainer" class="fixed z-50 space-y-2 top-4 right-4"></div>

    <script>
        // Notification System
        function showNotification(message, type = 'info') {
            const container = document.getElementById('notificationContainer');
            const notification = document.createElement('div');

            // Set styles based on notification type
            let bgColor = 'bg-blue-500';
            let icon = 'ℹ️';

            switch(type) {
                case 'success':
                    bgColor = 'bg-green-500';
                    icon = '✅';
                    break;
                case 'error':
                    bgColor = 'bg-red-500';
                    icon = '❌';
                    break;
                case 'warning':
                    bgColor = 'bg-yellow-500';
                    icon = '⚠️';
                    break;
            }

            notification.className = `${bgColor} text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 transform translate-x-full transition-transform duration-300 ease-out`;
            notification.innerHTML = `
                <span class="text-lg">${icon}</span>
                <span class="flex-1">${message}</span>
                <button onclick="removeNotification(this.parentElement)" class="ml-2 text-xl text-white hover:text-gray-200">&times;</button>
            `;

            container.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Auto remove after 5 seconds
            setTimeout(() => {
                removeNotification(notification);
            }, 5000);
        }

        function removeNotification(notification) {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.parentElement.removeChild(notification);
                }
            }, 300);
        }

        // File upload functionality
        const fileInput = document.getElementById('file-upload');
        const fileNameSpan = document.getElementById('file-name');

        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];
            if (file) {
                const extension = file.name.split('.').pop().toLowerCase();
                let message = `Selected: ${file.name}`;
                
                // Add conversion notice for Word documents
                if (extension === 'doc' || extension === 'docx') {
                    message += ' (will be converted to PDF)';
                    fileNameSpan.className = 'px-4 py-2 text-sm font-medium text-gray-100 rounded-md bg-blue-600';
                } else if (extension === 'pdf') {
                    fileNameSpan.className = 'px-4 py-2 text-sm font-medium text-gray-100 rounded-md bg-green-600';
                } else {
                    fileNameSpan.className = 'px-4 py-2 text-sm font-medium text-gray-100 rounded-md bg-red-600';
                    message = `Unsupported file type: ${file.name}`;
                }
                
                fileNameSpan.textContent = message;
                fileNameSpan.style.display = 'inline-block';
                
                // Show/hide preview button
                const previewBtn = document.getElementById('preview-btn');
                if (extension === 'doc' || extension === 'docx' || extension === 'pdf' || extension === 'txt') {
                    previewBtn.classList.remove('hidden');
                } else {
                    previewBtn.classList.add('hidden');
                }
            } else {
                fileNameSpan.textContent = '';
                fileNameSpan.style.display = 'none';
                document.getElementById('preview-btn').classList.add('hidden');
            }
        });

        // Document Preview Functionality
        const previewBtn = document.getElementById('preview-btn');
        const previewModal = document.getElementById('preview-modal');
        const closePreviewBtn = document.getElementById('close-preview');
        const closePreviewFooterBtn = document.getElementById('close-preview-footer');
        const previewLoading = document.getElementById('preview-loading');
        const previewHtml = document.getElementById('preview-html');
        const previewError = document.getElementById('preview-error');

        function closePreviewModal() {
            previewModal.classList.add('hidden');
            // Reset body to normal state
            document.body.style.overflow = '';
            document.body.style.padding = '0';
            document.body.style.maxWidth = '100%';
        }

        previewBtn.addEventListener('click', function() {
            const file = fileInput.files[0];
            if (!file) {
                showNotification('Please select a file first', 'error');
                return;
            }

            // Show modal and prevent body scrolling
            previewModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Show loading state
            previewLoading.classList.remove('hidden');
            previewHtml.innerHTML = '';
            previewError.classList.add('hidden');

            // Create FormData for the preview request
            const formData = new FormData();
            formData.append('document', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            // Make the preview request
            fetch('/dashboard/document/preview', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                previewLoading.classList.add('hidden');
                
                if (data.success) {
                    // Clear any existing content
                    previewHtml.innerHTML = '';
                    
                    // Create document preview component dynamically
                    const documentUrl = data.url || '#';
                    const documentType = data.type || 'html';
                    
                    if (data.type === 'pdf') {
                        // Use the document preview component for PDF
                        previewHtml.innerHTML = `
                            <x-document-preview 
                                :document-url="'${documentUrl}'" 
                                document-type="pdf" 
                                height="600px" 
                                :show-controls="true" 
                            />
                        `;
                        
                        // Since we can't use Blade components in JavaScript, we'll create the preview manually
                        createDocumentPreview(previewHtml, documentUrl, 'pdf');
                    } else {
                        // For HTML content from Pandoc, display directly
                        previewHtml.innerHTML = `
                            <div style="padding: 20px; font-family: Arial, sans-serif; line-height: 1.6;">
                                ${data.html}
                            </div>
                        `;
                    }
                    
                    showNotification('Preview generated successfully', 'success');
                } else {
                    previewError.innerHTML = data.message || 'Failed to generate preview';
                    previewError.classList.remove('hidden');
                    showNotification('Preview generation failed: ' + (data.message || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                previewLoading.classList.add('hidden');
                previewError.innerHTML = 'Error: ' + error.message;
                previewError.classList.remove('hidden');
                showNotification('Preview generation failed: ' + error.message, 'error');
            });
        });

        closePreviewBtn.addEventListener('click', closePreviewModal);
        closePreviewFooterBtn.addEventListener('click', closePreviewModal);

        // Close modal when clicking outside
        previewModal.addEventListener('click', function(e) {
            if (e.target === previewModal) {
                closePreviewModal();
            }
        });

        // Review Policy Modal Functions
        function showReviewPolicyModal() {
            const modal = document.getElementById('reviewPolicyModal');
            const content = document.getElementById('reviewPolicyContent');

            // Show modal and prevent body scrolling
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';

            // Load policy content via AJAX
            fetch('{{ route("review-policy.show") }}')
                .then(response => response.text())
                .then(html => {
                    // Extract the main content from the response
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const policyContent = doc.querySelector('main, .content, body');
                    content.innerHTML = policyContent ? policyContent.innerHTML : html;

                    // Scroll content area to top after loading
                    const contentContainer = content.parentElement;
                    contentContainer.scrollTop = 0;
                })
                .catch(error => {
                    content.innerHTML = '<p class="text-red-500">Error loading policy content. Please try again.</p>';
                    console.error('Error loading policy:', error);
                });
        }

        function closeReviewPolicyModal() {
            const modal = document.getElementById('reviewPolicyModal');
            modal.style.display = 'none';

            // Restore body scrolling
            document.body.style.overflow = '';
        }

        function acceptReviewPolicy() {
            // Enable and check the checkbox locally (no server call needed)
            const checkbox = document.getElementById('review_policy_accepted');
            checkbox.checked = true;
            checkbox.disabled = true; // Keep it disabled but checked
            checkbox.value = '1';

            // Add a hidden input to ensure the value gets submitted since disabled inputs don't submit
            let hiddenInput = document.querySelector('input[name="review_policy_accepted"][type="hidden"]');
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'review_policy_accepted';
                hiddenInput.value = '1';
                checkbox.parentElement.appendChild(hiddenInput);
            }

            // Update the UI to show policy link instead of button and remove hint
            const label = checkbox.parentElement.nextElementSibling.querySelector('label');
            const policyLink = label.querySelector('button, a');
            if (policyLink && policyLink.tagName === 'BUTTON') {
                // Replace button with link
                const newLink = document.createElement('a');
                newLink.href = '{{ route("review-policy.show") }}';
                newLink.target = '_blank';
                newLink.className = 'text-blue-600 hover:text-blue-800 underline font-bold';
                newLink.textContent = 'JAPR Review Policy';
                policyLink.parentNode.replaceChild(newLink, policyLink);
                
                // Remove the hint text
                const hintText = label.querySelector('small');
                if (hintText) {
                    hintText.remove();
                }
            }

            // Close modal
            closeReviewPolicyModal();

            // Show success feedback with a temporary notification
            showNotification('Review policy accepted! You can now submit your manuscript.', 'success');
        }

        function declineReviewPolicy() {
            // Close modal
            closeReviewPolicyModal();

            // Show warning notification
            showNotification('You must accept the review policy to submit manuscripts.', 'warning');
        }

        // Form submission with review policy validation and conversion notice
        const form = document.querySelector('form');
        const reviewPolicyCheckbox = document.getElementById('review_policy_accepted');
        const loadingOverlay = document.getElementById('loadingOverlay');

        form.addEventListener('submit', function(e) {
            const submitValue = e.submitter.value;

            // Only check policy for actual submission, not drafts
            if (submitValue === 'submit') {
                // Check if policy is accepted in multiple ways
                const hiddenInput = document.querySelector('input[name="review_policy_accepted"][type="hidden"]');
                const userAlreadyAccepted = {{ auth()->user()->review_policy_accepted ? 'true' : 'false' }};
                const checkboxChecked = reviewPolicyCheckbox.checked;
                const hiddenInputExists = hiddenInput && hiddenInput.value === '1';
                
                const policyAccepted = userAlreadyAccepted || checkboxChecked || hiddenInputExists;

                if (!policyAccepted) {
                    e.preventDefault();
                    showNotification('Please accept the JAPR Review Policy before submitting your manuscript.', 'warning');
                    showReviewPolicyModal();
                    return false;
                }
                
                // Check if we have a Word document that will need conversion
                const fileInput = document.getElementById('file-upload');
                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    const extension = file.name.split('.').pop().toLowerCase();
                    
                    if (extension === 'doc' || extension === 'docx') {
                        // Show loading overlay for Word document conversion
                        loadingOverlay.style.display = 'flex';
                        showNotification('Processing your Word document... This may take a moment.', 'info');
                    }
                }
            }
        });

        // Close modal when clicking outside
        document.getElementById('reviewPolicyModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReviewPolicyModal();
            }
        });

        // Close modal when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('reviewPolicyModal');
                if (modal.style.display === 'flex') {
                    closeReviewPolicyModal();
                }
            }
        });

        // Category/Subcategory functionality
        const categorySelect = document.getElementById('category_id');
        const subcategorySelect = document.getElementById('subcategory_id');

        if (categorySelect && subcategorySelect) {
            categorySelect.addEventListener('change', () => {
                const categoryId = categorySelect.value;
                fetch(`/load-subcategories?category_id=${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        subcategorySelect.innerHTML = '<option value="" disabled selected>Select a Sub-Category</option>';
                        data.forEach(subcategory => {
                            console.log('sub-cat is', subcategory)
                            const option = document.createElement('option');
                            option.value = subcategory.id;
                            option.textContent = subcategory.name;
                            subcategorySelect.appendChild(option);
                            console.log('option is', subcategorySelect)
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        }

        // Function to create document preview manually (since we can't use Blade components in JS)
        function createDocumentPreview(container, documentUrl, documentType, height = '600px') {
            const previewHtml = `
                <div class="document-preview-wrapper" data-document-url="${documentUrl}" data-document-type="${documentType}">
                    <!-- Preview Container -->
                    <div id="document-preview-content" style="width: 100%; height: ${height}; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #f5f5f5;">
                        <!-- Loading State -->
                        <div id="document-preview-loading" class="flex items-center justify-center h-full">
                            <div class="text-center p-8">
                                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                                <p class="text-gray-600 text-lg">Loading document...</p>
                                <p class="text-gray-500 text-sm">Please wait while we prepare the preview</p>
                            </div>
                        </div>
                        
                        <!-- Preview Content (Initially Hidden) -->
                        <div id="document-preview-display" class="hidden w-full h-full"></div>
                        
                        <!-- Error State -->
                        <div id="document-preview-error" class="hidden flex items-center justify-center h-full">
                            <div class="text-center p-8">
                                <svg class="mx-auto h-16 w-16 text-red-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.502 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Preview Error</h3>
                                <p id="document-preview-error-message" class="text-sm text-gray-600 mb-4"></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Control Buttons -->
                    <div class="mt-4 text-center">
                        <div class="flex justify-center space-x-3">
                            <a id="document-open-tab" href="${documentUrl}" target="_blank" class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Open in New Tab
                            </a>
                            <a id="document-download" href="${documentUrl}?download=1" class="inline-flex items-center px-3 py-2 text-sm font-medium text-green-600 hover:text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
            `;
            
            container.innerHTML = previewHtml;
            
            // Initialize the preview
            setTimeout(() => {
                const wrapper = container.querySelector('.document-preview-wrapper');
                if (wrapper) {
                    loadDocumentPreviewJS(wrapper);
                }
            }, 100);
        }

        // JavaScript version of the document preview loader
        function loadDocumentPreviewJS(wrapper) {
            const documentUrl = wrapper.dataset.documentUrl;
            const documentType = wrapper.dataset.documentType;
            
            if (!documentUrl) {
                showDocumentPreviewErrorJS('No document URL provided');
                return;
            }
            
            const loadingEl = wrapper.querySelector('#document-preview-loading');
            const displayEl = wrapper.querySelector('#document-preview-display');
            const errorEl = wrapper.querySelector('#document-preview-error');
            
            // Show loading state
            loadingEl.classList.remove('hidden');
            displayEl.classList.add('hidden');
            errorEl.classList.add('hidden');
            
            // Handle different document types
            if (documentType === 'pdf') {
                loadPdfPreviewJS(documentUrl, displayEl, loadingEl, errorEl, wrapper);
            } else {
                loadPandocPreviewJS(documentUrl, displayEl, loadingEl, errorEl, wrapper);
            }
        }

        function loadPdfPreviewJS(documentUrl, displayEl, loadingEl, errorEl, wrapper) {
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
            updateControlLinksJS(wrapper, documentUrl);
            
            // Hide loading and show preview
            loadingEl.classList.add('hidden');
            displayEl.classList.remove('hidden');
        }

        function updateControlLinksJS(wrapper, documentUrl) {
            const openTabLink = wrapper.querySelector('#document-open-tab');
            const downloadLink = wrapper.querySelector('#document-download');
            
            if (openTabLink) {
                openTabLink.href = documentUrl;
            }
            if (downloadLink) {
                downloadLink.href = documentUrl + (documentUrl.includes('?') ? '&' : '?') + 'download=1';
            }
        }

        // ...existing code...
    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#abstract'))
            .catch(error => {
                console.error(error);
            });
    </script>
</x-layouts.layout>
