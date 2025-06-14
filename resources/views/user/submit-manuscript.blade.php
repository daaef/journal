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
                        <label for="author" class="block text-sm font-medium leading-6 text-gray-900">Name of authors
                            (Seperate with commas)</label>
                        <div class="mt-2">
                            <input id="author" name="author" type="text"
                                   value="{{ old('author') ?: auth()->user()->fullname }}" required
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div>
                        <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title of manuscript</label>
                        <div class="mt-2">
                            <input id="title" name="title" type="text" value="{{ old('title') }}" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div class="col-span-full">
                        <label for="abstract" class="block text-sm font-medium leading-6 text-gray-900">Abstract</label>
                        <div class="mt-2">
                            <textarea id="abstract" name="abstract" rows="3" value="{{ old('abstract') }}"
                                      class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                {{ old('abstract') }}
                            </textarea>
                        </div>
                    </div>

                    <div>
                        <label for="institution"
                            class="block text-sm font-medium leading-6 text-gray-900">Institution/Affiliation</label>
                        <div class="mt-2">
                            <input id="institution" name="institution" type="text" value="{{ old('institution') }}"
                                required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <label for="keywords" class="block text-sm font-medium leading-6 text-gray-900">Keywords</label>
                        <div class="mt-2">
                            <input id="keywords" name="meta_keywords" type="text" value="{{ old('keywords') }}"
                                required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div class="col-span-full">
                        <label for="cover-photo"
                               class="block text-sm font-medium leading-6 text-gray-900">Manuscript (Please attach manuscript: word doc and pdf)</label>
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
                                <div class="flex mt-4 text-sm leading-6 text-gray-600">
                                    <label for="file-upload"
                                           class="relative font-semibold text-indigo-600 bg-white rounded-md cursor-pointer focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload Manuscript</span>
                                        <input id="file-upload" name="manuscripts" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <span id="file-name"
                                      class="px-4 py-2 text-sm font-medium text-gray-100 rounded-md bg-primary-600"
                                      style="display: none;"></span>
                                <p class="text-xs leading-5 text-gray-600">PDF up to 10MB</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-full">
                        <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Country /
                            Region</label>
                        <div class="mt-2">
                            <select name="country" id="country"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                                <option value="" disabled selected>Select Country</option>
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
                                <option value="" disabled selected>Select Language</option>
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
                                <option value="" disabled selected>Select Category</option>
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
            <div>
                <label for="keywords" class="block text-sm font-medium leading-6 text-gray-900">Licensing</label>
                <div class="pb-2 border-b border-gray-900/10"></div>
                <div class="mt-2">
                    <div class="relative flex gap-x-3">
                        <div class="flex items-center h-6">
                            <input id="cc-by" name="license[]" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-600">
                        </div>
                        <div class="text-sm leading-6">
                            <label for="cc-by" class="text-gray-500">CC BY</label>
                        </div>
                    </div>
                    <div class="relative flex gap-x-3">
                        <div class="flex items-center h-6">
                            <input id="cc-by-sa" name="license[]" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-600">
                        </div>
                        <div class="text-sm leading-6">
                            <label for="cc-by-sa" class="text-gray-500">CC BY-SA</label>
                        </div>
                    </div>
                    <div class="relative flex gap-x-3">
                        <div class="flex items-center h-6">
                            <input id="cc-by-nd" name="license[]" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-600">
                        </div>
                        <div class="text-sm leading-6">
                            <label for="cc-by-nd" class="text-gray-500">CC BY-ND</label>
                        </div>
                    </div>
                    <div class="relative flex gap-x-3">
                        <div class="flex items-center h-6">
                            <input id="cc-by-nc" name="license[]" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-600">
                        </div>
                        <div class="text-sm leading-6">
                            <label for="cc-by-nc" class="text-gray-500">CC BY-NC</label>
                        </div>
                    </div>
                    <div class="relative flex gap-x-3">
                        <div class="flex items-center h-6">
                            <input id="cc-by-nc-sa" name="license[]" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-600">
                        </div>
                        <div class="text-sm leading-6">
                            <label for="cc-by-nc-sa" class="text-gray-500">CC BY-NC-SA</label>
                        </div>
                    </div>
                    <div class="relative flex gap-x-3">
                        <div class="flex items-center h-6">
                            <input id="cc-by-nc-nd" name="license[]" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-600">
                        </div>
                        <div class="text-sm leading-6">
                            <label for="cc-by-nc-nd" class="text-gray-500">CC BY-NC-ND</label>
                        </div>
                    </div>
                    <div class="relative flex gap-x-3">
                        <div class="flex items-center h-6">
                            <input id="cc0" name="license[]" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-600">
                        </div>
                        <div class="text-sm leading-6">
                            <label for="cc0" class="text-gray-500">CC0</label>
                        </div>
                    </div>
                    <div class="relative flex gap-x-3">
                        <div class="flex items-center h-6">
                            <input id="pub_domain" name="license[]" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-600">
                        </div>
                        <div class="text-sm leading-6">
                            <label for="pub_domain" class="text-gray-500">Public domain</label>
                        </div>
                    </div>
                    <div class="relative flex gap-x-3">
                        <div class="flex items-center h-6">
                            <input id="own_license" name="license[]" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-600">
                        </div>
                        <div class="text-sm leading-6">
                            <label for="own_license" class="text-gray-500">Publisher's own license</label>
                        </div>
                    </div>
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
                                        @if(auth()->user()->review_policy_accepted) checked @else disabled @endif>
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="review_policy_accepted" class="text-gray-500">
                                        I accept the
                                        @if(!auth()->user()->review_policy_accepted)
                                            <button type="button" onclick="showReviewPolicyModal()" class="p-0 text-blue-600 underline bg-transparent border-none cursor-pointer hover:text-blue-800">JAPR Review Policy</button>
                                        @else
                                            <a href="{{ route('review-policy.show') }}" target="_blank" class="text-blue-600 underline hover:text-blue-800">JAPR Review Policy</a>
                                        @endif
                                        and agree to comply with all review standards and procedures
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
    <div id="loadingOverlay" class="fixed inset-0 z-50 bg-gray-600 bg-opacity-50" style="display: none;">
        <div class="flex items-center justify-center h-full">
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-6 h-6 border-b-2 border-green-600 rounded-full animate-spin"></div>
                    <span class="text-gray-700">Processing...</span>
                </div>
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
                fileNameSpan.textContent = `Uploading: ${file.name}`;
                fileNameSpan.style.display = 'inline-block';
            } else {
                fileNameSpan.textContent = '';
                fileNameSpan.style.display = 'none';
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
            checkbox.disabled = false;
            checkbox.value = '1';

            // Update the UI to show policy link instead of button
            const label = checkbox.parentElement.nextElementSibling.querySelector('label');
            const policyLink = label.querySelector('button, a');
            if (policyLink && policyLink.tagName === 'BUTTON') {
                // Replace button with link
                const newLink = document.createElement('a');
                newLink.href = '{{ route("review-policy.show") }}';
                newLink.target = '_blank';
                newLink.className = 'text-blue-600 hover:text-blue-800 underline';
                newLink.textContent = 'JAPR Review Policy';
                policyLink.parentNode.replaceChild(newLink, policyLink);
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

        // Form submission with review policy validation
        const form = document.querySelector('form');
        const reviewPolicyCheckbox = document.getElementById('review_policy_accepted');

        form.addEventListener('submit', function(e) {
            const submitValue = e.submitter.value;

            // Only check policy for actual submission, not drafts
            if (submitValue === 'submit') {
                // Check if policy is accepted (either checkbox is checked or hidden input exists)
                const hiddenInput = document.querySelector('input[name="review_policy_accepted"][type="hidden"]');
                const policyAccepted = reviewPolicyCheckbox.checked || hiddenInput;

                if (!policyAccepted) {
                    e.preventDefault();
                    showNotification('Please accept the JAPR Review Policy before submitting your manuscript.', 'warning');
                    showReviewPolicyModal();
                    return false;
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
