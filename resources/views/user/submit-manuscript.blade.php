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
        <div class="border-b border-gray-200 pb-5 sm:flex w-full sm:items-center sm:justify-between">
            <h3 class="text-lg font-bold leading-6 text-gray-900">Submissions</h3>
            <div>
                <h4>{{ Str::words(auth()->user()->fullname, 1, '') }}'s Dashboard</h4>
            </div>
        </div>
        <hr class="">
    </x-slot:breadcrumb>
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="space-y-12">
            <div class="">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Submit a Manuscript</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Submit a manuscript for reviews by our editors</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">

                    <div>
                        <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Manuscript Title</label>
                        <div class="mt-2">
                            <input id="title" name="title" type="text" value="{{ old('title') }}" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div>
                        <label for="author" class="block text-sm font-medium leading-6 text-gray-900">Author's Name(s)</label>
                        <div class="mt-2">
                            <input id="author" name="author" type="text"
                                value="{{ old('author') ?: auth()->user()->fullname }}" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                    <div class="w-full">
                        <label for="category_id" class="block text-sm font-medium leading-6 text-gray-900">Category</label>
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
                    <div id="subcategories">
                        <label for="subcategory_id" class="block text-sm font-medium leading-6 text-gray-900">Sub Category</label>
                        <div class="mt-2">
                            <select id="subcategory_id" name="subcategory_id" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                                <!-- subcategories will be listed here using option -->
                            </select>
                        </div>
                    </div>

                    <script>
                        const categorySelect = document.getElementById('category_id');
                        const subcategorySelect = document.getElementById('subcategory_id');

                        categorySelect.addEventListener('change', () => {
                            const categoryId = categorySelect.value;
                            fetch(`/api/subcategories/${categoryId}`)
                                .then(response => response.json())
                                .then(data => {
                                    subcategorySelect.innerHTML = '';
                                    data.forEach(subcategory => {
                                        const option = document.createElement('option');
                                        option.value = subcategory.id;
                                        option.textContent = subcategory.name;
                                        subcategorySelect.appendChild(option);
                                    });
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                });
                        });
                    </script>
                    <div class="col-span-full">
                        <label for="abstract" class="block text-sm font-medium leading-6 text-gray-900">Abstract</label>
                        <div class="mt-2">
                            <textarea id="abstract" name="abstract" rows="3" value="{{ old('abstract') }}"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                {{ old('abstract') }}
                            </textarea>
                        </div>
                    </div>
                    <div class="col-span-full">
                        <label for="cover-photo"
                            class="block text-sm font-medium leading-6 text-gray-900">Manuscript</label>
                        <div
                            class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                    <label for="file-upload"
                                        class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload Manuscript</span>
                                        <input id="file-upload" name="manuscripts" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <span id="file-name" class="text-sm font-medium hidden inline-block text-gray-100 py-2 px-4 bg-primary-600 rounded-md"></span>
                                <p class="text-xs leading-5 text-gray-600">PDF up to 10MB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-b border-gray-900/10 pb-12">
                <div class="mt-10 space-y-10">
                    <fieldset>
                        <div class="mt-6 space-y-6">
                            <div class="relative flex gap-x-3">
                                <div class="flex h-6 items-center">
                                    <input id="accept" name="accept" type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600"
                                        required>
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="accept" class="text-gray-500">I agree with JAPR's Review
                                        Policy</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 space-y-6">
                            <div class="relative flex gap-x-3">
                                <div class="flex h-6 items-center">
                                    <input id="accept" name="accept" type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600"
                                        required>
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="accept" class="text-gray-500">
                                        I agree that I haven't publis
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="{{ url()->previous() }}"
                class="rounded-md px-3 py-2 text-sm hover:bg-red-500 font-semibold bg-red-600 leading-6 text-gray-200">Cancel</a>
            <button type="submit" name="submit" value="draft"
                class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                Save Draft
            </button>
            <button type="submit" name="submit" value = "submit"
                class="rounded-md bg-green-800 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                Submit
            </button>
        </div>
    </form><script>
        const fileInput = document.getElementById('file-upload');
        const fileNameSpan = document.getElementById('file-name');

        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];
            if (file) {
                fileNameSpan.textContent = `Uploading: ${file.name}`;
                fileNameSpan.classList.remove('hidden');
            } else {
                fileNameSpan.textContent = '';
                fileNameSpan.classList.add('hidden');
            }
        });
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
