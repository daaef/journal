<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Dashboard</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/file-upload.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plyr.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/full-calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/editor-quill.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-jvectormap-2.0.5.css') }}">
    @vite(['resources/js/app.js', 'resources/sass/main.scss'])
</head>

<body>

    <!--==================== Preloader Start ====================-->
    <div class="preloader">
        <div class="loader"></div>
    </div>
    <!--==================== Preloader End ====================-->

    <!--==================== Sidebar Overlay End ====================-->
    <div class="side-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->


    <!-- ============================ Sidebar Start ============================ -->

    <aside class="sidebar">
        <!-- sidebar close btn -->
        <button type="button"
            class="sidebar-close-btn text-gray-500 hover-text-white hover-bg-main-600 text-md w-24 h-24 border border-gray-100 hover-border-main-600 d-xl-none d-flex flex-center rounded-circle position-absolute"><i
                class="ph ph-x"></i></button>
        <!-- sidebar close btn -->

        <a href="index.html"
            class="sidebar__logo text-center p-20 position-sticky inset-block-start-0 bg-white w-100 z-1 pb-10">
            <img class="w-25s" src="{{ asset('images/japr-logo.png') }}" alt="Logo">
        </a>

        <div class="sidebar-menu-wrapper overflow-y-auto scroll-sm">
            <div class="p-20 pt-10">
                <ul class="sidebar-menu">
                    <li class="sidebar-menu__item">
                        <a href="javascript:void(0)" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-squares-four"></i></span>
                            <span class="text">Dashboard</span>
                            {{-- <span class="link-badge">3</span> --}}
                        </a>
                        <!-- Submenu End -->
                    </li>
                    <li class="sidebar-menu__item">
                        <a href="{{ route('categories.index') }}" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-squares-four"></i></span>
                            <span class="text">Categories</span>
                            {{-- <span class="link-badge">3</span> --}}
                        </a>
                        <!-- Submenu End -->
                    </li>
                    <li class="sidebar-menu__item">
                        <span
                            class="text-gray-300 text-sm px-20 pt-20 fw-semibold border-top border-gray-100 d-block text-uppercase">Settings</span>
                    </li>
                    <li class="sidebar-menu__item">
                        <a href="" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-gear"></i></span>
                            <span class="text">Account Settings</span>
                        </a>
                    </li>


                </ul>
            </div>
        </div>

    </aside>
    <!-- ============================ Sidebar End  ============================ -->


    <div class="dashboard-main-wrapper">

        <div class="top-navbar flex-between gap-16">

            <div class="flex-align gap-16">
                <!-- Toggle Button Start -->
                <button type="button" class="toggle-btn d-xl-none d-flex text-26 text-gray-500"><i
                        class="ph ph-list"></i></button>
                <!-- Toggle Button End -->

                <form action="#" class="w-350 d-sm-block d-none">
                    <div class="position-relative">
                        <button type="submit" class="input-icon text-xl d-flex text-gray-100 pointer-event-none"><i
                                class="ph ph-magnifying-glass"></i></button>
                        <input type="text"
                            class="form-control ps-40 h-40 border-transparent focus-border-main-600 bg-main-50 rounded-pill placeholder-15"
                            placeholder="Search...">
                    </div>
                </form>
            </div>

            <div class="flex-align gap-16">
                <div class="flex-align gap-8">
                    <!-- Notification Start -->
                    <div class="dropdown">
                        <button
                            class="dropdown-btn shaking-animation text-gray-500 w-40 h-40 bg-main-50 hover-bg-main-100 transition-2 rounded-circle text-xl flex-center"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="position-relative">
                                <i class="ph ph-bell"></i>
                                <span class="alarm-notify position-absolute end-0"></span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu--lg border-0 bg-transparent p-0">
                            <div class="card border border-gray-100 rounded-12 box-shadow-custom p-0 overflow-hidden">
                                <div class="card-body p-0">
                                    <div class="py-8 px-24 bg-main-600">
                                        <div class="flex-between">
                                            <h5 class="text-xl fw-semibold text-white mb-0">Notifications</h5>
                                            <div class="flex-align gap-12">
                                                <button type="button"
                                                    class="bg-white rounded-6 text-sm px-8 py-2 hover-text-primary-600">
                                                    New </button>
                                                <button type="button"
                                                    class="close-dropdown hover-scale-1 text-xl text-white"><i
                                                        class="ph ph-x"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-24 max-h-270 overflow-y-auto scroll-sm">
                                        <div class="d-flex align-items-start gap-12">
                                            <img src="assets/images/thumbs/notification-img1.png" alt=""
                                                class="w-48 h-48 rounded-circle object-fit-cover">
                                            <div class="border-bottom border-gray-100 mb-24 pb-24">
                                                <div class="flex-align gap-4">
                                                    <a href="#"
                                                        class="fw-medium text-15 mb-0 text-gray-300 hover-text-main-600 text-line-2">Ashwin
                                                        Bose is requesting access to Design File - Final Project. </a>
                                                    <!-- Three Dot Dropdown Start -->
                                                    <div class="dropdown flex-shrink-0">
                                                        <button class="text-gray-200 rounded-4" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ph-fill ph-dots-three-outline"></i>
                                                        </button>
                                                        <div
                                                            class="dropdown-menu dropdown-menu--md border-0 bg-transparent p-0">
                                                            <div
                                                                class="card border border-gray-100 rounded-12 box-shadow-custom">
                                                                <div class="card-body p-12">
                                                                    <div
                                                                        class="max-h-200 overflow-y-auto scroll-sm pe-8">
                                                                        <ul>
                                                                            <li class="mb-0">
                                                                                <a href="#"
                                                                                    class="py-6 text-15 px-8 hover-bg-gray-50 text-gray-300 rounded-8 fw-normal text-xs d-block">
                                                                                    <span class="text">Mark as
                                                                                        read</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="mb-0">
                                                                                <a href="#"
                                                                                    class="py-6 text-15 px-8 hover-bg-gray-50 text-gray-300 rounded-8 fw-normal text-xs d-block">
                                                                                    <span class="text">Delete
                                                                                        Notification</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="mb-0">
                                                                                <a href="#"
                                                                                    class="py-6 text-15 px-8 hover-bg-gray-50 text-gray-300 rounded-8 fw-normal text-xs d-block">
                                                                                    <span class="text">Report</span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Three Dot Dropdown End -->
                                                </div>
                                                <div class="flex-align gap-6 mt-8">
                                                    <img src="assets/images/icons/google-drive.png" alt="">
                                                    <div class="flex-align gap-4">
                                                        <p class="text-gray-900 text-sm text-line-1">Design brief and
                                                            ideas.txt</p>
                                                        <span class="text-xs text-gray-200 flex-shrink-0">2.2 MB</span>
                                                    </div>
                                                </div>
                                                <div class="mt-16 flex-align gap-8">
                                                    <button type="button"
                                                        class="btn btn-main py-8 text-15 fw-normal px-16">Accept</button>
                                                    <button type="button"
                                                        class="btn btn-outline-gray py-8 text-15 fw-normal px-16">Decline</button>
                                                </div>
                                                <span class="text-gray-200 text-13 mt-8">2 mins ago</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-start gap-12">
                                            <img src="assets/images/thumbs/notification-img2.png" alt=""
                                                class="w-48 h-48 rounded-circle object-fit-cover">
                                            <div class="">
                                                <a href="#"
                                                    class="fw-medium text-15 mb-0 text-gray-300 hover-text-main-600 text-line-2">Patrick
                                                    added a comment on Design Assets - Smart Tags file:</a>
                                                <span class="text-gray-200 text-13">2 mins ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#"
                                        class="py-13 px-24 fw-bold text-center d-block text-primary-600 border-top border-gray-100 hover-text-decoration-underline">
                                        View All </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Notification Start -->

                    <!-- Language Start -->
                    <div class="dropdown">
                        <button
                            class="text-gray-500 w-40 h-40 bg-main-50 hover-bg-main-100 transition-2 rounded-circle text-xl flex-center"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ph ph-globe"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu--md border-0 bg-transparent p-0">
                            <div class="card border border-gray-100 rounded-12 box-shadow-custom">
                                <div class="card-body">
                                    <div class="max-h-270 overflow-y-auto scroll-sm pe-8">
                                        <div
                                            class="form-check form-radio d-flex align-items-center justify-content-between ps-0 mb-16">
                                            <label
                                                class="ps-0 form-check-label line-height-1 fw-medium text-secondary-light"
                                                for="arabic">
                                                <span
                                                    class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-8">
                                                    <img src="assets/images/thumbs/flag1.png" alt=""
                                                        class="w-32-px h-32-px border borde border-gray-100 rounded-circle flex-shrink-0">
                                                    <span class="text-15 fw-semibold mb-0">Arabic</span>
                                                </span>
                                            </label>
                                            <input class="form-check-input" type="radio" name="language"
                                                id="arabic">
                                        </div>
                                        <div
                                            class="form-check form-radio d-flex align-items-center justify-content-between ps-0 mb-16">
                                            <label
                                                class="ps-0 form-check-label line-height-1 fw-medium text-secondary-light"
                                                for="germany">
                                                <span
                                                    class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-8">
                                                    <img src="assets/images/thumbs/flag2.png" alt=""
                                                        class="w-32-px h-32-px border borde border-gray-100 rounded-circle flex-shrink-0">
                                                    <span class="text-15 fw-semibold mb-0">Germany</span>
                                                </span>
                                            </label>
                                            <input class="form-check-input" type="radio" name="language"
                                                id="germany">
                                        </div>
                                        <div
                                            class="form-check form-radio d-flex align-items-center justify-content-between ps-0 mb-16">
                                            <label
                                                class="ps-0 form-check-label line-height-1 fw-medium text-secondary-light"
                                                for="english">
                                                <span
                                                    class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-8">
                                                    <img src="assets/images/thumbs/flag3.png" alt=""
                                                        class="w-32-px h-32-px border borde border-gray-100 rounded-circle flex-shrink-0">
                                                    <span class="text-15 fw-semibold mb-0">English</span>
                                                </span>
                                            </label>
                                            <input class="form-check-input" type="radio" name="language"
                                                id="english">
                                        </div>
                                        <div
                                            class="form-check form-radio d-flex align-items-center justify-content-between ps-0">
                                            <label
                                                class="ps-0 form-check-label line-height-1 fw-medium text-secondary-light"
                                                for="spanish">
                                                <span
                                                    class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-8">
                                                    <img src="assets/images/thumbs/flag4.png" alt=""
                                                        class="w-32-px h-32-px border borde border-gray-100 rounded-circle flex-shrink-0">
                                                    <span class="text-15 fw-semibold mb-0">Spanish</span>
                                                </span>
                                            </label>
                                            <input class="form-check-input" type="radio" name="language"
                                                id="spanish">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Language Start -->
                </div>


                <!-- User Profile Start -->
                <div class="dropdown">
                    <button
                        class="users arrow-down-icon border border-gray-200 rounded-pill p-4 d-inline-block pe-40 position-relative"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="position-relative">
                            <img src="assets/images/thumbs/user-img.png" alt="Image"
                                class="h-32 w-32 rounded-circle">
                            <span
                                class="activation-badge w-8 h-8 position-absolute inset-block-end-0 inset-inline-end-0"></span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu--lg border-0 bg-transparent p-0">
                        <div class="card border border-gray-100 rounded-12 box-shadow-custom">
                            <div class="card-body">
                                <div class="flex-align gap-8 mb-20 pb-20 border-bottom border-gray-100">
                                    <img src="assets/images/thumbs/user-img.png" alt=""
                                        class="w-54 h-54 rounded-circle">
                                    <div class="">
                                        <h4 class="mb-0">Michel John</h4>
                                        <p class="fw-medium text-13 text-gray-200">examplemail@mail.com</p>
                                    </div>
                                </div>
                                <ul class="max-h-270 overflow-y-auto scroll-sm pe-4">
                                    <li class="mb-4">
                                        <a href="setting.html"
                                            class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                            <span class="text-2xl text-primary-600 d-flex"><i
                                                    class="ph ph-gear"></i></span>
                                            <span class="text">Account Settings</span>
                                        </a>
                                    </li>
                                    <li class="mb-4">
                                        <a href="pricing-plan.html"
                                            class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                            <span class="text-2xl text-primary-600 d-flex"><i
                                                    class="ph ph-chart-bar"></i></span>
                                            <span class="text">Upgrade Plan</span>
                                        </a>
                                    </li>
                                    <li class="mb-4">
                                        <a href="analytics.html"
                                            class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                            <span class="text-2xl text-primary-600 d-flex"><i
                                                    class="ph ph-chart-line-up"></i></span>
                                            <span class="text">Daily Activity</span>
                                        </a>
                                    </li>
                                    <li class="mb-4">
                                        <a href="message.html"
                                            class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                            <span class="text-2xl text-primary-600 d-flex"><i
                                                    class="ph ph-chats-teardrop"></i></span>
                                            <span class="text">Inbox</span>
                                        </a>
                                    </li>
                                    <li class="mb-4">
                                        <a href="email.html"
                                            class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                            <span class="text-2xl text-primary-600 d-flex"><i
                                                    class="ph ph-envelope-simple"></i></span>
                                            <span class="text">Email</span>
                                        </a>
                                    </li>
                                    <li class="pt-8 border-top border-gray-100">
                                        <a href="sign-in.html"
                                            class="py-12 text-15 px-20 hover-bg-danger-50 text-gray-300 hover-text-danger-600 rounded-8 flex-align gap-8 fw-medium text-15">
                                            <span class="text-2xl text-danger-600 d-flex"><i
                                                    class="ph ph-sign-out"></i></span>
                                            <span class="text">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Profile Start -->

            </div>
        </div>


        <div class="dashboard-body">
            <div class="row gy-4">
                <div class="col-lg-9">
                    <!-- Grettings Box Start -->
                    <div
                        class="grettings-box position-relative rounded-16 bg-[#ff830c] overflow-hidden gap-16 flex-wrap z-1">
                        <img src="assets/images/bg/grettings-pattern.png" alt=""
                            class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 opacity-6">
                        <div class="row gy-4">
                            <div class="col-sm-7">
                                <div class="grettings-box__content py-xl-4">
                                    <h2 class="text-white mb-0">Hello! </h2>
                                    <p class="text-15 fw-light mt-4 text-white">Let’s create something today</p>
{{--                                    <p class="text-lg fw-light mt-24 text-white">Set your plan and growth with--}}
{{--                                        community</p>--}}
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
                    <!-- Table End -->

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

                            <!-- Events start -->
                            <div class="">
                                <div class="mt-24 mb-24">
                                    <div class="flex-align mb-8 gap-16">
                                        <span class="text-sm text-gray-300 flex-shrink-0">Today</span>
                                        <span class="border border-gray-50 border-dashed flex-grow-1"></span>
                                    </div>
                                    <div class="event-item bg-gray-50 rounded-8 p-16">
                                        <div class=" flex-between gap-4">
                                            <div class="flex-align gap-8">
                                                <span
                                                    class="icon d-flex w-44 h-44 bg-white rounded-8 flex-center text-2xl"><i
                                                        class="ph ph-squares-four"></i></span>
                                                <div class="">
                                                    <h6 class="mb-2">Element of design test</h6>
                                                    <span class="">10:00 - 11:00 AM</span>
                                                </div>
                                            </div>
                                            <div class="dropdown flex-shrink-0">
                                                <button class="text-gray-400 text-xl d-flex rounded-4" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ph-fill ph-dots-three-outline"></i>
                                                </button>
                                                <div
                                                    class="dropdown-menu dropdown-menu--md border-0 bg-transparent p-0">
                                                    <div
                                                        class="card border border-gray-100 rounded-12 box-shadow-custom">
                                                        <div class="card-body p-12">
                                                            <div class="max-h-200 overflow-y-auto scroll-sm pe-8">
                                                                <ul>
                                                                    <li class="mb-0">
                                                                        <button type="button"
                                                                            class="delete-btn py-6 text-15 px-8 hover-bg-gray-50 text-gray-300 w-100 rounded-8 fw-normal text-xs d-block text-start hover-text-gray-600">
                                                                            <span
                                                                                class="text d-flex align-items-center gap-8">
                                                                                <i class="ph ph-trash"></i>
                                                                                Remove</span>
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="mt-24">
                                    <div class="flex-align mb-8 gap-16">
                                        <span class="text-sm text-gray-300 flex-shrink-0">Sat, Aug 24</span>
                                        <span class="border border-gray-50 border-dashed flex-grow-1"></span>
                                    </div>
                                    <div class="event-item bg-gray-50 rounded-8 p-16">
                                        <div class=" flex-between gap-4">
                                            <div class="flex-align gap-8">
                                                <span
                                                    class="icon d-flex w-44 h-44 bg-white rounded-8 flex-center text-2xl"><i
                                                        class="ph ph-magic-wand"></i></span>
                                                <div class="">
                                                    <h6 class="mb-2">Design Principles test</h6>
                                                    <span class="">10:00 - 11:00 AM</span>
                                                </div>
                                            </div>
                                            <div class="dropdown flex-shrink-0">
                                                <button class="text-gray-400 text-xl d-flex rounded-4" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ph-fill ph-dots-three-outline"></i>
                                                </button>
                                                <div
                                                    class="dropdown-menu dropdown-menu--md border-0 bg-transparent p-0">
                                                    <div
                                                        class="card border border-gray-100 rounded-12 box-shadow-custom">
                                                        <div class="card-body p-12">
                                                            <div class="max-h-200 overflow-y-auto scroll-sm pe-8">
                                                                <ul>
                                                                    <li class="mb-0">
                                                                        <button type="button"
                                                                            class="delete-btn py-6 text-15 px-8 hover-bg-gray-50 text-gray-300 w-100 rounded-8 fw-normal text-xs d-block text-start hover-text-gray-600">
                                                                            <span
                                                                                class="text d-flex align-items-center gap-8">
                                                                                <i class="ph ph-trash"></i>
                                                                                Remove</span>
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="event-item bg-gray-50 rounded-8 p-16 mt-16">
                                        <div class=" flex-between gap-4">
                                            <div class="flex-align gap-8">
                                                <span
                                                    class="icon d-flex w-44 h-44 bg-white rounded-8 flex-center text-2xl"><i
                                                        class="ph ph-briefcase"></i></span>
                                                <div class="">
                                                    <h6 class="mb-2">Prepare Job Interview</h6>
                                                    <span class="">09:00 - 10:00 AM</span>
                                                </div>
                                            </div>
                                            <div class="dropdown flex-shrink-0">
                                                <button class="text-gray-400 text-xl d-flex rounded-4" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ph-fill ph-dots-three-outline"></i>
                                                </button>
                                                <div
                                                    class="dropdown-menu dropdown-menu--md border-0 bg-transparent p-0">
                                                    <div
                                                        class="card border border-gray-100 rounded-12 box-shadow-custom">
                                                        <div class="card-body p-12">
                                                            <div class="max-h-200 overflow-y-auto scroll-sm pe-8">
                                                                <ul>
                                                                    <li class="mb-0">
                                                                        <button type="button"
                                                                            class="delete-btn py-6 text-15 px-8 hover-bg-gray-50 text-gray-300 w-100 rounded-8 fw-normal text-xs d-block text-start hover-text-gray-600">
                                                                            <span
                                                                                class="text d-flex align-items-center gap-8">
                                                                                <i class="ph ph-trash"></i>
                                                                                Remove</span>
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="event.html" class="btn btn-main w-100 mt-24">All Events</a>
                            </div>
                            <!-- Events End -->

                        </div>
                    </div>
                    <!-- Calendar End -->
                </div>
            </div>
        </div>

        <div class="dashboard-footer">
            <div class="flex-between flex-wrap gap-16">
                <p class="text-gray-300 text-13 fw-normal"> &copy; Copyright Edmate 2024, All Right Reserverd</p>
                <div class="flex-align flex-wrap gap-16">
                    <a href="#"
                        class="text-gray-300 text-13 fw-normal hover-text-main-600 hover-text-decoration-underline">License</a>
                    <a href="#"
                        class="text-gray-300 text-13 fw-normal hover-text-main-600 hover-text-decoration-underline">More
                        Themes</a>
                    <a href="#"
                        class="text-gray-300 text-13 fw-normal hover-text-main-600 hover-text-decoration-underline">Documentation</a>
                    <a href="#"
                        class="text-gray-300 text-13 fw-normal hover-text-main-600 hover-text-decoration-underline">Support</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery js -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/boostrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/phosphor-icon.js') }}"></script>
    <script src="{{ asset('assets/js/file-upload.js') }}"></script>
    <script src="{{ asset('assets/js/plyr.js') }}"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="{{ asset('assets/js/full-calendar.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/js/editor-quill.js') }}"></script>
    <script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/calendar.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/js/main.js') }}"></script>



    <script>
        // ============================ Donut Chart Start ==========================
        var options = {
            series: [65.2, 25, 9.8],
            chart: {
                height: 200,
                type: 'donut',
            },
            colors: ['#3D7FF9', '#27CFA7', '#FA902F'],
            enabled: true, // Enable data labels
            formatter: function(val, opts) {
                return opts.w.config.series[opts.seriesIndex] + '%';
            },
            dropShadow: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '55%' // Fixed slice width
                    }
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        show: false
                    }
                }
            }],
            legend: {
                position: 'right',
                offsetY: 0,
                height: 230,
                show: false
            }
        };

        var chart = new ApexCharts(document.querySelector("#activityDonutChart"), options);
        chart.render();
        // ============================ Donut Chart End ==========================

        // ============================ Hour Spent Chart Start ==========================
        var options = {
            series: [{
                name: 'Study',
                data: [44, 55, 41, 50, 36, 43, 50, 44, 55, 41, 50, 36]
            }, {
                name: 'Exam',
                data: [26, 23, 20, 40, 32, 27, 30, 26, 23, 20, 40, 32]
            }],
            colors: ['#27CFA7', '#A9ECDC'],
            chart: {
                type: 'bar',
                height: 400,
                stacked: true,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: true
                }
            },
            plotOptions: {
                bar: {
                    columnWidth: "35%",
                    horizontal: false,
                    borderRadius: 10,
                    borderRadiusApplication: 'end', // 'around', 'end'
                    borderRadiusWhenStacked: 'last', // 'all', 'last'
                    dataLabels: {
                        total: {
                            enabled: false,
                            style: {
                                fontSize: '13px',
                                fontWeight: 900,
                            }
                        }
                    }
                },
            },
            dataLabels: {
                enabled: false // Disable bar labels globally
            },
            grid: {
                show: true,
                borderColor: '#d5dbe7',
                strokeDashArray: 3,
                position: 'back',
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return "$" + value + "Hr";
                    },
                    style: {
                        fontSize: "14px"
                    }
                },
            },
            legend: {
                show: false,
                position: 'top',
                offsetY: 0,
                horizontalAlign: 'start',
                markers: {
                    // shape: 'circle'
                    radius: 50,
                }
            },
            fill: {
                opacity: 1
            }
        };

        var chart = new ApexCharts(document.querySelector("#stackedColumnChart"), options);
        chart.render();
        // ============================ Hour Spent Chart Start ==========================

        // Delete Event Item
        $('.delete-btn').on('click', function() {
            $(this).closest('.event-item').addClass('d-none')
        });
    </script>

</body>

</html>
