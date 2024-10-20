<x-layouts.editor_layout>
    <div class="breadcrumb mb-24">
        <ul class="flex-align gap-4">
            <li><a href="index.html" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">Preview Journal: {{ $journal->title }}</span></li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-md-9">
            <!-- Course Card Start -->
            <div class="card">
                <div class="card-body p-lg-20 p-sm-3">
                    <div class="flex-between flex-wrap gap-12 mb-20">
                        <div>
                            <h3 class="mb-4">{{ $journal->title }}</h3>
                            <p class="text-gray-600 text-15"> Author {{ $journal->author }}</p>
                        </div>

                        <div class="flex-align flex-wrap gap-24">
                            <span class="py-6 px-16 bg-main-50 text-main-600 rounded-pill text-15">Category:
                                {{ $journal->category->name }}</span>
                            <div class=" share-social position-relative">
                                <button type="button"
                                    class="share-social__button text-gray-200 text-26 d-flex hover-text-main-600"><i
                                        class="ph ph-share-network"></i></button>
                                <div
                                    class="share-social__icons bg-white box-shadow-2xl p-16 border border-gray-100 rounded-8 position-absolute inset-block-start-100 inset-inline-end-0">
                                    <ul class="flex-align gap-8">
                                        <li>
                                            <a href="https://www.facebook.com"
                                                class="flex-center w-36 h-36 border border-main-600 text-white rounded-circle text-xl bg-main-600 hover-bg-main-800 hover-border-main-800"><i
                                                    class="ph ph-facebook-logo"></i></a>
                                        </li>
                                        <li>
                                            <a href="https://www.google.com"
                                                class="flex-center w-36 h-36 border border-main-600 text-white rounded-circle text-xl bg-main-600 hover-bg-main-800 hover-border-main-800">
                                                <i class="ph ph-twitter-logo"></i></a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com"
                                                class="flex-center w-36 h-36 border border-main-600 text-white rounded-circle text-xl bg-main-600 hover-bg-main-800 hover-border-main-800"><i
                                                    class="ph ph-linkedin-logo"></i></a>
                                        </li>
                                        <li>
                                            <a href="https://www.instagram.com"
                                                class="flex-center w-36 h-36 border border-main-600 text-white rounded-circle text-xl bg-main-600 hover-bg-main-800 hover-border-main-800"><i
                                                    class="ph ph-instagram-logo"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>



                    <div class="mt-24">
                        <div class="mb-24 pb-24 border-bottom border-gray-100">
                            <h5 class="mb-12 fw-bold">Abstract</h5>
                            <p class="text-gray-300 text-15">{{ $journal->abstract }}</p>
                        </div>
                        <div class="mb-24 pb-24 border-bottom border-gray-100">
                            <h5 class="mb-12 fw-bold">Uploaded</h5>
                            <object class="pdf w-full"
                                data=
"https://media.geeksforgeeks.org/wp-content/cdn-uploads/20210101201653/PDF.pdf"
                                 height="500">
                            </object>
                        </div>

                        <div class="">
                            <h5 class="mb-12 fw-bold">Author(s)</h5>
                            <div class="flex-align gap-8">
                                {{-- <img src="assets/images/thumbs/mentor-img1.png" alt="" class="w-44 h-44 rounded-circle object-fit-cover flex-shrink-0"> --}}
                                <div class="d-flex flex-column">
                                    <h6 class="text-15 fw-bold mb-0">{{ $journal->author }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Course Card End -->
        </div>

        <div class="col-md-3">
            <!-- Community Groups card Start -->
            <div class="card">
                <div class="card-body">
                    <div class="mb-20 flex-between flex-wrap gap-8">
                        <h5 class="mb-0">Reviewers</h5>
                    </div>
                    <form action="">
                        <div class="col">
                            <label for="reviewer" class="h5 mb-8 fw-semibold font-heading">Select Reviewers
                            </label>
                            <div class="position-relative">
                                <select name="reviewer[]" id="reviewerSelect" class="form-select py-9 placeholder-13 text-15">
                                    <option value="1" disabled selected>Select a reviewer</option>
                                    <option value="computer-science">Computer Science </option>
                                    <option value="business">Business </option>
                                    <option value="management">Management </option>
                                    <option value="humanities">Humanities </option>
                                    <option value="data-science">Data Science</option>
                                    <option value="artificial-intelligence">Artificial Intelligence</option>
                                </select>
                            </div>
                        </div>
                        <div id="selectedReviewers" class="mt-4 gap-2 grid">
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-main rounded-pill py-11 w-100  mt-16">Save Reviewer(s)</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-24">
                <div class="card-body">
                    <div class="mb-20 flex-between flex-wrap gap-8">
                        <h5 class="mb-0">Comments</h5>
                    </div>
                    <ul class="list-inside">
                        <li class="text-gray-600 mb-4">1. Set up multiple pricing levels with different </li>
                        <li class="text-gray-600 mb-4">2. Continuously test different price points and </li>
                        <li class="text-gray-600 mb-4">3. Price your course based on the perceived </li>
                    </ul>
                </div>
            </div>
            <!-- Community Groups card End -->
            <div class="card mt-24">
                <div class="card-body">
                    {{-- <h4 class="mb-20">Action</h4> --}}
                    <form method="post" action="{{ route('editor.journals.approveJournal') }}">
                        @csrf
                        <input type="hidden" name="journal_uuid" value="{{ $journal->uuid }}" />
                        <button type="submit" class="btn btn-main rounded-pill py-11 w-100  mt-16">Approve
                            Journal</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-layouts.editor_layout>
<script>
    function addReviewer(reviewerId, reviewerName, selectedReviewerid) {
        const selectedReviewersDiv = document.getElementById('selectedReviewers');
        const activeDiv = document.getElementById(`reviewer-${reviewerId}`)
        // Check if the reviewer is already selected
        if (activeDiv) {
            selectedReviewersDiv.removeChild(activeDiv);
            return; // Don't add if already exists
        }

        const reviewerDiv = document.createElement('div');
        reviewerDiv.classList.add('flex', 'items-center', 'gap-4', 'mb-2', 'p-4', 'border', 'rounded-md', 'justify-between');
        reviewerDiv.id = `reviewer-${reviewerId}`;

        const reviewerNameSpan = document.createElement('span');
        reviewerNameSpan.textContent = reviewerName;

        const reviewerCheckbox = document.createElement('input');
        reviewerCheckbox.type = "hidden";
        reviewerCheckbox.name = "reviewer[]";
        reviewerCheckbox.value = selectedReviewerid;

        const removeButton = document.createElement('i');
        removeButton.classList.add('ph', 'ph-x', 'cursor-pointer');
        removeButton.addEventListener('click', () => {
            selectedReviewersDiv.removeChild(reviewerDiv);
        });

        reviewerDiv.appendChild(reviewerNameSpan);
        reviewerDiv.appendChild(removeButton);
        reviewerDiv.appendChild(reviewerCheckbox);
        selectedReviewersDiv.appendChild(reviewerDiv);
    }

    const reviewerSelect = document.getElementById('reviewerSelect');
    reviewerSelect.addEventListener('change', () => {
        const selectedReviewerId = reviewerSelect.value;
        const selectedReviewerName = reviewerSelect.options[reviewerSelect.selectedIndex].text;
        const selectedReviewerid = reviewerSelect.options[reviewerSelect.selectedIndex].value;
        addReviewer(selectedReviewerId, selectedReviewerName, selectedReviewerid);
    });
</script>
