<x-layouts.reviewer_layout>
    <div class="breadcrumb mb-24">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('reviewer.dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a>
            </li>
            <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
            <li><span class="text-main-600 fw-normal text-15">Preview Journal: {{ $journal->title }}</span></li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-md-6 h-minus-145">
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
                            <p class="text-gray-300 text-15">{!! $journal->abstract !!}</p>
                        </div>
                        <div class="mb-24 pb-24 border-bottom border-gray-100">
                            <h5 class="mb-12 fw-bold">Menuscript</h5>
                            <object class="pdf w-full" data="{{ storage_path('app/public/' . $journal->journal_url) }}"
                                    height="800">
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

        <div class="col-md-6 h-minus-145">
            <!-- Community Groups card Start -->
            <div class="card">
                <div class="card-body">
                    <div class="mb-20 flex-between flex-wrap gap-8">
                        <h5 class="mb-0">Comments</h5>
                    </div>
                    <ul class="list-inside">
                        @forelse ($comments as $comment)
                            <li class="flex-align gap-6 text-gray-300 text-15 mb-12">
                                <span class="flex-shrink-0 text-22 d-flex text-main-600"><i class="ph ph-notepad"></i>
                                </span>
                                {{ $comment->comment }}
                            </li>
                        @empty
                            <li class="flex-align gap-6 text-gray-300 text-15 mb-12">
                                <span class="flex-shrink-0 text-22 d-flex text-main-600"><i class="ph ph-pen"></i>
                                </span>
                                No comments yet
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="card mt-24 h-full">
                <div class="card-body h-full">
                    {{-- <div class="mb-20 flex-between flex-wrap gap-8">
                        <h5 class="mb-0">Add Comments</h5>
                    </div> --}}
                    <div class="col-sm-12 h-full">
                        <form class="h-full" action="{{ route('reviewer.journals.approveJournalWithComment') }}"
                              method="post">
                            @csrf
                            <label for="comment" class="h6 mb-8 fw-semibold font-heading">Add Comments<span
                                    class="text-13 text-gray-400 fw-medium">(Required)</span> </label>
                            <div class="position-relative">
                                    <textarea name="comment"
                                              class="text-counter placeholder-13 form-control py-11 pe-76"
                                              maxlength="1500"
                                              id="comment" rows="30"> </textarea>
                                <div
                                    class="text-gray-400 position-absolute inset-inline-end-0 top-50 translate-middle-y me-16">
                                    <span id="current">0</span>
                                    <span id="maximum">/ 1500</span>
                                </div>
                            </div>
                            <input type="hidden" name="journal_uuid" value="{{ $journal->uuid }}"/>
                            <input type="hidden" name="reviewer_uuid" value="{{ auth()->user()->uuid }}"/>

                            <div class="flex">
                                <button type="submit" name="action" value="approve" class="btn btn-main rounded-pill py-11 w-100  mt-16">Approve</button>
                                <button type="submit" name="action" value="decline" class="btn btn-danger rounded-pill py-11 w-100  mt-16 ml-4">Decline</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layouts.reviewer_layout>
