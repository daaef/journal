<x-layouts.admin_layout>
    <x-slot:title>
        Welcome to your Dashboard
    </x-slot:title>

    <div class="grettings-box position-relative rounded-16 bg-[#ff830c] overflow-hidden gap-16 flex-wrap z-1">
        <img src="{{ asset('assets/images/bg/grettings-pattern.png') }}" alt=""
            class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 opacity-6">
        <div class="row gy-4">
            <div class="col-sm-7">
                <div class="grettings-box__content py-xl-4">
                    <h2 class="text-white mb-0">Hello {{ Str::words(auth()->user()->fullname, 1, '') }}! </h2>
                    <p class="text-15 fw-light mt-4 text-white">Let's create something today</p>
                </div>
            </div>
            <div class="col-sm-5 d-sm-block d-none">
                <div class="text-center h-100 d-flex justify-content-center align-items-end ">
                    <img src="{{ asset('assets/images/thumbs/gretting-img.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>

    <!-- Widgets Start -->
    <div class="row gy-4 mt-2">
        <div class="col-xxl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-2">{{ $journals }}</h4>
                    <span class="text-gray-600">Total Journals</span>
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
                    <h4 class="mb-2">{{ $journalsApproved }}</h4>
                    <span class="text-gray-600">Journals Approved</span>
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
                    <h4 class="mb-2">{{ $journalsPending }}</h4>
                    <span class="text-gray-600">Pending Manuscripts</span>
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
                    <h4 class="mb-2">{{ $journalsRejected }}</h4>
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
    <!-- Widgets End -->
</x-layouts.admin_layout>
