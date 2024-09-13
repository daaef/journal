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
    @vite(['resources/js/app.js', 'resources/sass/style.scss'])
</head>
<body>
    <header class="flex flex-wrap sm:justify-start sm:flex-nowrap w-full bg-transparent text-sm py-3">
        <nav class="max-w-[85rem] w-full mx-auto px-4 flex flex-wrap basis-full items-center justify-between">
            <div class="flex gap-5 items-center">
                <a class="flex-none text-xl font-semibold dark:text-white focus:outline-none focus:opacity-80" href="#">
                    <img class="h-14" src="{{ asset('images/japr-logo.png') }}" alt="japr logo">
                </a>
                <div id="hs-navbar-alignment" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow sm:grow-0 sm:basis-auto sm:block" aria-labelledby="hs-navbar-alignment-collapse">
                    <div class="flex flex-col gap-5 mt-5 sm:flex-row sm:items-center sm:mt-0 sm:ps-5">
                        <a class="font-bold text-primary-500 focus:outline-none" href="#" aria-current="page">Home</a>
                        <a class="font-medium text-gray-900 hover:text-gray-400 focus:outline-none focus:text-gray-400 " href="#">About JAPR</a>
                        <a class="font-medium text-gray-900 hover:text-gray-400 focus:outline-none focus:text-gray-400 " href="#">Search</a>
                        <a class="font-medium text-gray-900 hover:text-gray-400 focus:outline-none focus:text-gray-400 " href="#">Contact Us</a>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-x-2">
                <button type="button" class="sm:hidden hs-collapse-toggle relative size-7 flex justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-transparent dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" id="hs-navbar-alignment-collapse" aria-expanded="false" aria-controls="hs-navbar-alignment" aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-alignment">
                    <svg class="hs-collapse-open:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
                    <svg class="hs-collapse-open:block hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    <span class="sr-only">Toggle</span>
                </button>
                <a href="#" class="py-2 px-6 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-primary-500 text-primary-500 hover:border-primary-600 hover:text-primary-600 focus:outline-none focus:border-primary-600 focus:text-primary-600 disabled:opacity-50 disabled:pointer-events-none">
                    Login
                </a>
                <a href="#" class="py-2 px-6 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-primary-500 text-white hover:bg-primary-600 focus:outline-none focus:bg-primary-700 disabled:opacity-50 disabled:pointer-events-none">
                    Register
                </a>
            </div>
        </nav>
    </header>
    {{ $slot }}
</body>
</html>
