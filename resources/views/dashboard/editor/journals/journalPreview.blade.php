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
                            <span class="py-6 px-16 bg-main-50 text-main-600 rounded-pill text-15">Category: {{ $journal->category->name }}</span>
                            <div class=" share-social position-relative">
                                <button type="button" class="share-social__button text-gray-200 text-26 d-flex hover-text-main-600"><i class="ph ph-share-network"></i></button>
                                <div class="share-social__icons bg-white box-shadow-2xl p-16 border border-gray-100 rounded-8 position-absolute inset-block-start-100 inset-inline-end-0">
                                    <ul class="flex-align gap-8">
                                        <li>
                                            <a href="https://www.facebook.com" class="flex-center w-36 h-36 border border-main-600 text-white rounded-circle text-xl bg-main-600 hover-bg-main-800 hover-border-main-800"><i class="ph ph-facebook-logo"></i></a>
                                        </li>
                                        <li>
                                            <a href="https://www.google.com" class="flex-center w-36 h-36 border border-main-600 text-white rounded-circle text-xl bg-main-600 hover-bg-main-800 hover-border-main-800"> <i class="ph ph-twitter-logo"></i></a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com" class="flex-center w-36 h-36 border border-main-600 text-white rounded-circle text-xl bg-main-600 hover-bg-main-800 hover-border-main-800"><i class="ph ph-linkedin-logo"></i></a>
                                        </li>
                                        <li>
                                            <a href="https://www.instagram.com" class="flex-center w-36 h-36 border border-main-600 text-white rounded-circle text-xl bg-main-600 hover-bg-main-800 hover-border-main-800"><i class="ph ph-instagram-logo"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="bookmark-icon text-gray-200 text-26 d-flex hover-text-main-600">
                                <i class="ph ph-bookmarks"></i>
                            </button>
                        </div>
                    </div>



                    <div class="mt-24">
                        <div class="mb-24 pb-24 border-bottom border-gray-100">
                            <h5 class="mb-12 fw-bold">Abstract</h5>
                            <p class="text-gray-300 text-15">{{ $journal->abstract }}</p>
                        </div>
                        <div class="mb-24 pb-24 border-bottom border-gray-100">
                            <h5 class="mb-12 fw-bold">Description</h5>
                            <p class="text-gray-300 text-15 mb-8">Lorem ipsum dolor sit amet consectetur. Molestie pharetra gravida morbi eget. Diam quam non pretium malesuada. Elit porta aliquam cursus id. Fermentum  adipiscing et nisl dignissim lectus ornare amet metus. Eget leo aliquet diam dictum et sit enim. Diam enim in eu rutrum est. Eu tristique euismod malesuada velit amet tellus. Ornare viverra dignissim odio magna dui fermentum non scelerisque scelerisque. Non pellentesque commodo ut sagittis felis. </p>
                            <p class="text-gray-300 text-15">Aliquam pharetra a urna varius proin quis. Diam amet blandit ullamcorper diam lectus at eget. Erat molestie purus et vitae lectus aenean in cursus. Arcu gravida tellus purus ultricies tristique. Ac turpis aliquam consectetur sit cras.</p>
                        </div>
                        <div class="mb-24 pb-24 border-bottom border-gray-100">
                            <h5 class="mb-16 fw-bold">This Course Includes</h5>
                            <div class="row g-20">
                                <div class="col-md-4 col-sm-6">
                                    <ul>
                                        <li class="flex-align gap-6 text-gray-300 text-15 mb-12">
                                            <span class="flex-shrink-0 text-22 d-flex text-main-600"><i class="ph ph-checks"></i> </span>
                                            1.3 Hours on-demand video
                                        </li>
                                        <li class="flex-align gap-6 text-gray-300 text-15 mb-12">
                                            <span class="flex-shrink-0 text-22 d-flex text-main-600"><i class="ph ph-checks"></i> </span>
                                            7 Design Exercise
                                        </li>
                                        <li class="flex-align gap-6 text-gray-300 text-15 mb-12">
                                            <span class="flex-shrink-0 text-22 d-flex text-main-600"><i class="ph ph-checks"></i> </span>
                                            vide48 Articleso
                                        </li>
                                        <li class="flex-align gap-6 text-gray-300 text-15 mb-12">
                                            <span class="flex-shrink-0 text-22 d-flex text-main-600"><i class="ph ph-checks"></i> </span>
                                            120 Download Resources
                                        </li>
                                        <li class="flex-align gap-6 text-gray-300 text-15 mb-12">
                                            <span class="flex-shrink-0 text-22 d-flex text-main-600"><i class="ph ph-checks"></i> </span>
                                            Access on Mobile
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <ul>
                                        <li class="flex-align gap-6 text-gray-300 text-15 mb-12">
                                            <span class="flex-shrink-0 text-22 d-flex text-main-600"><i class="ph ph-checks"></i> </span>
                                            35 Quizes
                                        </li>
                                        <li class="flex-align gap-6 text-gray-300 text-15 mb-12">
                                            <span class="flex-shrink-0 text-22 d-flex text-main-600"><i class="ph ph-checks"></i> </span>
                                            Lectures: 19
                                        </li>
                                        <li class="flex-align gap-6 text-gray-300 text-15 mb-12">
                                            <span class="flex-shrink-0 text-22 d-flex text-main-600"><i class="ph ph-checks"></i> </span>
                                            Captions: Yes
                                        </li>
                                        <li class="flex-align gap-6 text-gray-300 text-15 mb-12">
                                            <span class="flex-shrink-0 text-22 d-flex text-main-600"><i class="ph ph-checks"></i> </span>
                                            Video: 1.5 total hours
                                        </li>
                                        <li class="flex-align gap-6 text-gray-300 text-15 mb-12">
                                            <span class="flex-shrink-0 text-22 d-flex text-main-600"><i class="ph ph-checks"></i> </span>
                                            Language English
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <h5 class="mb-12 fw-bold">Author(s)</h5>
                            <div class="flex-align gap-8">
                                <img src="assets/images/thumbs/mentor-img1.png" alt="" class="w-44 h-44 rounded-circle object-fit-cover flex-shrink-0">
                                <div class="d-flex flex-column">
                                    <h6 class="text-15 fw-bold mb-0">{{ $journal->author }}</h6>
                                    <span class="text-13 text-gray-300">Web Design Instructor</span>
                                    <div class="flex-align gap-4 mt-4">
                                        <span class="text-15 fw-bold text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                        <span class="text-13 fw-bold text-gray-600">4.9</span>
                                        <span class="text-13 fw-bold text-gray-300">(12k)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Course Card End -->
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="mb-20">Action</h4> --}}
                    <form method="post" action="{{ route('editor.journals.approveJournal') }}">
                        @csrf
                        <input type="hidden" name="journal_uuid" value="{{ $journal->uuid }}" />
                        <button type="submit" class="btn btn-main rounded-pill py-11 w-100  mt-16">Approve Journal</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-layouts.editor_layout>
