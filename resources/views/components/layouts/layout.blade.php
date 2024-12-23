<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title ?? 'JAPR Website' }}</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
{{--    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css " rel="stylesheet"/>--}}
    @vite(['resources/js/app.js', 'resources/sass/style.scss'])
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
