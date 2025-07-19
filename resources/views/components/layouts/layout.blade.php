<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'JAPR Website' }}</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
{{--    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css " rel="stylesheet"/>--}}
    @vite(['resources/js/app.js', 'resources/sass/style.scss'])
    
    <!-- Custom Form Styling -->
    <style>
        /* Custom Form Styling - Updated UI */
        .form-control {
            border-radius: 8px;
            font-weight: 400;
            outline: none;
            width: 100%;
            padding: 13px 16px;
            background-color: #ffffff !important;
            border: 1px solid #e5e7eb;
            color: #374151;
            line-height: 1.5;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        
        .form-control:hover {
            border-color: #d1d5db;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .form-control.is-invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }
        
        .form-control.is-invalid:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }
        
        /* Multiple Select Styling */
        select[multiple].form-control {
            min-height: 120px;
            padding: 12px 16px;
            background-image: none;
        }
        
        select[multiple].form-control option {
            padding: 8px 12px;
            margin: 2px 0;
            border-radius: 4px;
            background-color: #ffffff;
            color: #374151;
            transition: all 0.2s ease-in-out;
        }
        
        select[multiple].form-control option:hover {
            background-color: #f3f4f6;
        }
        
        select[multiple].form-control option:checked {
            background-color: #3b82f6;
            color: #ffffff;
            font-weight: 500;
        }
        
        select[multiple].form-control option:checked:hover {
            background-color: #2563eb;
        }
        
        /* Optgroup styling */
        select[multiple].form-control optgroup {
            font-weight: 600;
            color: #6b7280;
            background-color: #f9fafb;
            padding: 4px 8px;
            margin: 4px 0;
            border-radius: 4px;
        }
        
        select[multiple].form-control optgroup option {
            margin-left: 8px;
            padding-left: 16px;
        }
        
        /* Card Styling */
        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        
        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            background-color: #f9fafb;
            border-radius: 12px 12px 0 0;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Button Styling */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            line-height: 1.25rem;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        
        .btn:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .btn-primary {
            background-color: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }
        
        .btn-outline-secondary {
            background-color: #ffffff;
            color: #374151;
            border-color: #d1d5db;
        }
        
        .btn-outline-secondary:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
        }
        
        /* Settings Form Specific */
        .settings-form .space-y-6 {
            margin-bottom: 2rem;
        }
        
        .settings-form .space-y-6:last-child {
            margin-bottom: 0;
        }
        
        .settings-form .border-b {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .settings-form .grid {
            display: grid;
            gap: 1.5rem;
        }
        
        .settings-form .sm\\:grid-cols-2 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
        @media (min-width: 640px) {
            .settings-form .sm\\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        
        .settings-form .sm\\:col-span-2 {
            grid-column: span 2 / span 2;
        }
        
        @media (max-width: 639px) {
            .settings-form .sm\\:col-span-2 {
                grid-column: span 1 / span 1;
            }
        }
        
        /* Table Actions Column Width - Comprehensive */
        .table th:last-child,
        .table td:last-child,
        .table-striped th:last-child,
        .table-striped td:last-child,
        .table-hover th:last-child,
        .table-hover td:last-child,
        .style-two th:last-child,
        .style-two td:last-child {
            min-width: 200px;
            width: 200px;
        }
        
        /* For tables with many columns, give actions more space */
        .table th:nth-last-child(1),
        .table td:nth-last-child(1),
        .table-striped th:nth-last-child(1),
        .table-striped td:nth-last-child(1),
        .table-hover th:nth-last-child(1),
        .table-hover td:nth-last-child(1),
        .style-two th:nth-last-child(1),
        .style-two td:nth-last-child(1) {
            min-width: 180px;
            width: 180px;
        }
        
        /* Ensure action buttons have proper spacing */
        .table td:last-child .btn,
        .table td:last-child a,
        .table-striped td:last-child .btn,
        .table-striped td:last-child a,
        .table-hover td:last-child .btn,
        .table-hover td:last-child a,
        .style-two td:last-child .btn,
        .style-two td:last-child a {
            margin: 2px 4px;
            white-space: nowrap;
        }
        
        /* For tables with action buttons in a flex container */
        .table td:last-child .flex-align,
        .table td:last-child .d-flex,
        .table-striped td:last-child .flex-align,
        .table-striped td:last-child .d-flex,
        .table-hover td:last-child .flex-align,
        .table-hover td:last-child .d-flex,
        .style-two td:last-child .flex-align,
        .style-two td:last-child .d-flex {
            gap: 8px;
            flex-wrap: wrap;
        }
        
        /* Responsive table actions */
        @media (max-width: 768px) {
            .table th:last-child,
            .table td:last-child,
            .table-striped th:last-child,
            .table-striped td:last-child,
            .table-hover th:last-child,
            .table-hover td:last-child,
            .style-two th:last-child,
            .style-two td:last-child {
                min-width: 150px;
                width: 150px;
            }
        }
        
        /* Action Button Styling with Real Colors */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            margin: 2px 4px;
            white-space: nowrap;
        }
        
        /* Primary Action Button */
        .action-btn-primary {
            background-color: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
        }
        
        .action-btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
        }
        
        /* Secondary Action Button */
        .action-btn-secondary {
            background-color: #6b7280;
            color: #ffffff;
            border-color: #6b7280;
        }
        
        .action-btn-secondary:hover {
            background-color: #4b5563;
            border-color: #4b5563;
            color: #ffffff;
        }
        
        /* Success Action Button */
        .action-btn-success {
            background-color: #10b981;
            color: #ffffff;
            border-color: #10b981;
        }
        
        .action-btn-success:hover {
            background-color: #059669;
            border-color: #059669;
            color: #ffffff;
        }
        
        /* Warning Action Button */
        .action-btn-warning {
            background-color: #f59e0b;
            color: #ffffff;
            border-color: #f59e0b;
        }
        
        .action-btn-warning:hover {
            background-color: #d97706;
            border-color: #d97706;
            color: #ffffff;
        }
        
        /* Danger Action Button */
        .action-btn-danger {
            background-color: #ef4444;
            color: #ffffff;
            border-color: #ef4444;
        }
        
        .action-btn-danger:hover {
            background-color: #dc2626;
            border-color: #dc2626;
            color: #ffffff;
        }
        
        /* Info Action Button */
        .action-btn-info {
            background-color: #06b6d4;
            color: #ffffff;
            border-color: #06b6d4;
        }
        
        .action-btn-info:hover {
            background-color: #0891b2;
            border-color: #0891b2;
            color: #ffffff;
        }
        
        /* Outline Variants */
        .action-btn-outline-primary {
            background-color: transparent;
            color: #3b82f6;
            border-color: #3b82f6;
        }
        
        .action-btn-outline-primary:hover {
            background-color: #3b82f6;
            color: #ffffff;
        }
        
        .action-btn-outline-secondary {
            background-color: transparent;
            color: #6b7280;
            border-color: #6b7280;
        }
        
        .action-btn-outline-secondary:hover {
            background-color: #6b7280;
            color: #ffffff;
        }
        
        .action-btn-outline-success {
            background-color: transparent;
            color: #10b981;
            border-color: #10b981;
        }
        
        .action-btn-outline-success:hover {
            background-color: #10b981;
            color: #ffffff;
        }
        
        .action-btn-outline-warning {
            background-color: transparent;
            color: #f59e0b;
            border-color: #f59e0b;
        }
        
        .action-btn-outline-warning:hover {
            background-color: #f59e0b;
            color: #ffffff;
        }
        
        .action-btn-outline-danger {
            background-color: transparent;
            color: #ef4444;
            border-color: #ef4444;
        }
        
        .action-btn-outline-danger:hover {
            background-color: #ef4444;
            color: #ffffff;
        }
        
        .action-btn-outline-info {
            background-color: transparent;
            color: #06b6d4;
            border-color: #06b6d4;
        }
        
        .action-btn-outline-info:hover {
            background-color: #06b6d4;
            color: #ffffff;
        }
        
        /* Small Action Buttons */
        .action-btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        /* Large Action Buttons */
        .action-btn-lg {
            padding: 12px 24px;
            font-size: 16px;
        }
    </style>
    
    <style>
        .swiper-wrapper {
            height: max-content !important;

            width: max-content;
        }

        .swiper-button-next,
        .swiper-button-prev {
            top: 25%;
            z-index: 1000;
        }

        .swiper-button-next {
            right: -0px !important;
        }

        .swiper-button-prev {
            left: 0px !important;
        }

        .swiper-button-prev:after,
        .swiper-rtl .swiper-button-next:after {
            content: "" !important;
        }

        .mySwiper {
            max-width: 320px !important;
            margin: 0 auto !important;
        }

        .swiper-button-next:after,
        .swiper-rtl .swiper-button-prev:after {
            content: "" !important;
        }

        .mySwiper .swiper-slide.swiper-slide-thumb-active>.swiper-slide\:w-16 {
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
        }

        .mySwiper .swiper-slide.swiper-slide-thumb-active>.swiper-slide\:border-indigo-600 {
            --tw-border-opacity: 1;
            border-color: rgb(79 70 229 / var(--tw-border-opacity));
        }

        .teamswiper .swiper-wrapper {
            height: max-content !important;
            padding-bottom: 64px !important;
        }

        .teamswiper .swiper-horizontal>.swiper-scrollbar,
        .teamswiper .swiper-scrollbar.swiper-scrollbar-horizontal {
            max-width: 140px !important;
            height: 3px !important;
            bottom: 25px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
        }

        .teamswiper .swiper-pagination-fraction {
            bottom: 0 !important;
        }

        .teamswiper .swiper-slide.swiper-slide-active>.slide\:border-indigo-600 {
            --tw-border-opacity: 1;
            border-color: rgb(79 70 229 / var(--tw-border-opacity));
        }

        .teamswiper .swiper-pagination-total {
            color: rgb(156 163 175) !important;
        }

        .teamswiper .swiper-scrollbar-drag {
            background: rgb(79 70 229);
        }

        .teamswiper .swiper-pagination-fraction {
            bottom: 0 !important;
        }

        .teamswiper .swiper-button-prev:after,
        .teamswiper .swiper-rtl .swiper-button-next:after {
            content: '' !important;
        }

        .teamswiper .swiper-button-prev {
            top: 93% !important;
            left: 35% !important;
            z-index: 100 !important;
        }

        .teamswiper .swiper-button-next {
            top: 93% !important;
            right: 35% !important;
            z-index: 100 !important;
        }

        .teamswiper .swiper-button-next:after,
        .teamswiper .swiper-rtl .swiper-button-prev:after {
            content: '' !important;
        }

        .teamswiper .swiper-button-next svg,
        .teamswiper .swiper-button-prev svg {
            width: 24px !important;
            height: 24px !important;
        }
    </style>
</head>
<body>
<x-navbar/>
<section id="hero" class="py-[50px] min-h-[80vh] pt-[120px]">
    <div class="container px-4">
        @isset($breadcrumb)
            <div class="mb-4">
                {{ $breadcrumb }}
            </div>
        @endisset
        @if((str_starts_with(Route::currentRouteName(), 'user.') || (Route::is('dashboard'))) && auth()->check())
            <x-user-navbar/>
        @endif
        {{ $slot }}
    </div>
</section>
<x-footer/>
<script>
    window.HSStaticMethods.autoInit();
</script>
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    @if (Session::has('message'))
    const type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
        case 'info':

            toastr.options.timeOut = 10000;
            toastr.info("{{ Session::get('message') }}");
            var audio = new Audio('audio.mp3');
            audio.play();
            break;
        case 'success':

            toastr.options.timeOut = 10000;
            toastr.success("{{ Session::get('message') }}");
            var audio = new Audio('audio.mp3');
            audio.play();

            break;
        case 'warning':
            toastr.options.timeOut = 10000;
            toastr.warning("{{ Session::get('message') }}");
            var audio = new Audio('audio.mp3');
            audio.play();

            break;
        case 'error':

            toastr.options.timeOut = 10000;
            toastr.error("{{ Session::get('message') }}");
            var audio = new Audio('audio.mp3');
            audio.play();

            break;
    }
    @endif
</script>

{{--<script src="https://cdn.jsdelivr.net/npm/pagedone@1.1.2/src/js/pagedone.js"><//script>--}}

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        spaceBetween: -10,
        slidesPerView: 3,
        watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".mySwiper2", {
        loop: true,
        spaceBetween: 32,
        thumbs: {
            swiper: swiper,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>
<script>
    const catFilter = document.querySelector('#filter')
    const filterToggle = document.querySelector('#filter-toggle')

    filterToggle.addEventListener('click', ()=> {
        console.log('toggling')
        console.log('catFilter', catFilter)
        catFilter.classList.toggle('translate-x-[-100%]')
    })
</script>
</body>
</html>
