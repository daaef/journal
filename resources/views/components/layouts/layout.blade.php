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
    @vite(['resources/js/app.js', 'resources/sass/style.scss'])
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
</body>
</html>
