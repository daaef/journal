<x-layouts.editor_layout>
    <x-slot:title>
        Welcome to your Dashboard
    </x-slot:title>

    <div class="row gy-4">
        <div class="col-lg-9">


            <div class="row">
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">{{ $pendingJournals }}</h4>
                            <span class="text-gray-600">Pending Manuscripts</span>
                            <div class="flex-between gap-8 mt-16">
                                <span
                                    class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-main-600 text-white text-2xl"><i
                                        class="ph-fill ph-book-open"></i></span>
                                <div id="complete-course" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">{{ $approvedJournals }}</h4>
                            <span class="text-gray-600">Approved Journals</span>
                            <div class="flex-between gap-8 mt-16">
                                <span
                                    class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-main-two-600 text-white text-2xl"><i
                                        class="ph-fill ph-certificate"></i></span>
                                <div id="earned-certificate" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">{{ $journalsInProgress }}</h4>
                            <span class="text-gray-600">Manuscripts in Progress</span>
                            <div class="flex-between gap-8 mt-16">
                                <span
                                    class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-purple-600 text-white text-2xl">
                                    <i class="ph-fill ph-graduation-cap"></i></span>
                                <div id="course-progress" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">{{ $declinedJournals }}</h4>
                            <span class="text-gray-600">Declined Manuscripts</span>
                            <div class="flex-between gap-8 mt-16">
                                <span
                                    class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-warning-600 text-white text-2xl"><i
                                        class="ph-fill ph-users-three"></i></span>
                                <div id="community-support" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-24">
                <div class="card-body">
                    <div class="mb-20 flex-between flex-wrap gap-8">
                        <h4 class="mb-0">Journals Pending Reviews</h4>
                    </div>

                    @forelse ($journals as $journal)
                    <div class="p-xl-4 py-16 px-12 flex-between gap-8 rounded-8 border border-gray-100 hover-border-gray-200 transition-1 mb-16">
                        <div class="flex-align flex-wrap gap-8">
                            <span class="text-main-600 bg-main-50 w-44 h-44 rounded-circle flex-center text-2xl flex-shrink-0"><i class="ph-fill ph-graduation-cap"></i></span>
                            <div>
                                <h6 class="mb-0">{{ $journal->title }}</h6>
                                <span class="text-13 text-gray-500 fw-medium">Author(s) : {{ $journal->author }}</span>
                            </div>
                        </div>
                        <a href="{{ route('reviewer.journals.review', [$journal->uuid, $journal->slug]) }}" class="text-gray-900 hover-text-main-600"><i class="ph ph-caret-right"></i></a>
                    </div>
                    @empty
                    <p class="mt-2 text-gray-500 dark:text-neutral-400">No assigned journals at the moment</p>
                    @endforelse

                </div>
            </div>

        </div>
        <div class="col-lg-3">

            <!-- Calendar Start -->
            <div class="card">
                <div class="card-body">
                    <div class="calendar">
                        <div class="calendar__header">
                            <button type="button" class="calendar__arrow left"><i
                                    class="ph ph-caret-left"></i></button>
                            <p class="display h6 mb-0">""</p>
                            <button type="button" class="calendar__arrow right"><i
                                    class="ph ph-caret-right"></i></button>
                        </div>

                        <div class="calendar__week week">
                            <div class="calendar__week-text">Su</div>
                            <div class="calendar__week-text">Mo</div>
                            <div class="calendar__week-text">Tu</div>
                            <div class="calendar__week-text">We</div>
                            <div class="calendar__week-text">Th</div>
                            <div class="calendar__week-text">Fr</div>
                            <div class="calendar__week-text">Sa</div>
                        </div>
                        <div class="days"></div>
                    </div>

                </div>
            </div>
            <!-- Calendar End -->

        </div>
    </div>


</x-layouts.editor_layout>
