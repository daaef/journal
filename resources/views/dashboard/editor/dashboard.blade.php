<x-layouts.editor_layout>
    <x-slot:title>
        Welcome to your Dashboard
    </x-slot:title>

    <div class="row gy-4">
        <div class="col-lg-9">
            <!-- Grettings Box Start -->
            <div class="grettings-box position-relative rounded-16 bg-main-600 overflow-hidden gap-16 flex-wrap z-1">
                <img src="assets/images/bg/grettings-pattern.png" alt="" class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 opacity-6">
                <div class="row gy-4">
                    <div class="col-sm-7">
                        <div class="grettings-box__content py-xl-4">
                            <h2 class="text-white mb-0">Hello, {{ Str::words(auth()->user()->fullname, 1, '') }}! </h2>
                            <p class="text-15 fw-light mt-4 text-white">Let’s learning something today</p>
                            <p class="text-lg fw-light mt-24 text-white">Set your study plan and growth with community</p>
                        </div>
                    </div>
                    <div class="col-sm-5 d-sm-block d-none">
                        <div class="text-center h-100 d-flex justify-content-center align-items-end ">
                            <img src="assets/images/thumbs/gretting-img.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Grettings Box End -->

            <div class="row gy-4">
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">155+</h4>
                            <span class="text-gray-600">Completed Courses</span>
                            <div class="flex-between gap-8 mt-16">
                                <span class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-main-600 text-white text-2xl"><i class="ph-fill ph-book-open"></i></span>
                                <div id="complete-course" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">39+</h4>
                            <span class="text-gray-600">Earned Certificate</span>
                            <div class="flex-between gap-8 mt-16">
                                <span class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-main-two-600 text-white text-2xl"><i class="ph-fill ph-certificate"></i></span>
                                <div id="earned-certificate" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">25+</h4>
                            <span class="text-gray-600">Course in Progress</span>
                            <div class="flex-between gap-8 mt-16">
                                <span class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-purple-600 text-white text-2xl"> <i class="ph-fill ph-graduation-cap"></i></span>
                                <div id="course-progress" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">18k+</h4>
                            <span class="text-gray-600">Community Support</span>
                            <div class="flex-between gap-8 mt-16">
                                <span class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-warning-600 text-white text-2xl"><i class="ph-fill ph-users-three"></i></span>
                                <div id="community-support" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-3">

            <!-- Calendar Start -->
            <div class="card">
                <div class="card-body">
                    <div class="calendar">
                        <div class="calendar__header">
                            <button type="button" class="calendar__arrow left"><i class="ph ph-caret-left"></i></button>
                            <p class="display h6 mb-0">""</p>
                            <button type="button" class="calendar__arrow right"><i class="ph ph-caret-right"></i></button>
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
