<header class="flex flex-wrap sm:justify-start h-[80px] sm:flex-nowrap w-full fixed z-[20000] bg-white text-sm py-3">
    <nav class="container w-full mx-auto px-4 flex flex-wrap basis-full items-center justify-between relative">
        <div class="flex gap-5 items-center">
            <a class="flex-none text-xl lg:static lg:translate-y-0 absolute top-[30px] left-[20px] translate-y-[-50%] font-semibold dark:text-white focus:outline-none focus:opacity-80"
                href="#">
                <img class="h-14" src="{{ asset('images/japr-logo.png') }}" alt="japr logo">
            </a>
            <div id="hs-navbar-alignment"
                class="hs-collapse hidden overflow-hidden top-[80px] transition-all duration-300 basis-full grow lg:grow-0 lg:basis-auto lg:static lg:px-0 px-[20px] max-[1023px]:container max-[1023px]:translate-x-[-50%] max-[1023px]:left-[50%] py-[20px] fixed left-0 bg-white w-full lg:block"
                aria-labelledby="hs-navbar-alignment-collapse">
                <div class="flex flex-col gap-5 mt-5 lg:flex-row lg:items-center lg:mt-0 lg:ps-5">

                    <a class="focus:outline-none @if (Route::is('home')) text-primary-500 font-bold @elseif(true) text-gray-900 font-medium @endif"
                        href="{{ route('home') }}" aria-current="page">Home</a>

                    <a class="font-medium text-gray-900 hover:text-gray-400 focus:outline-none focus:text-gray-400 "
                        href="#">About JAPR</a>
                    <a class="hover:text-gray-400 focus:outline-none focus:text-gray-400 @if (Route::is('journals.index')) text-primary-500 font-bold @elseif(true) text-gray-900 font-medium @endif"
                        href="{{ route('journals') }}">Journals</a>
                    <a class="font-medium text-gray-900 hover:text-gray-400 focus:outline-none focus:text-gray-400 "
                        href="#">Contact Us</a>
                    {{-- @dd(Auth::check()) --}}
                    @auth()
                        <a class="font-bold lg:hidden text-gray-900 hover:text-gray-400 focus:outline-none focus:text-gray-400 "
                            href="#">
                            Dashboard
                        </a>
                    @else
                        <a class="font-bold lg:hidden text-gray-900 hover:text-gray-400 focus:outline-none focus:text-gray-400 "
                            href="{{ route('auth.login.get') }}">
                            Submit Manuscript
                        </a>
                        <a class="font-bold lg:hidden text-gray-900 hover:text-gray-400 focus:outline-none focus:text-gray-400 "
                           href="{{ route('auth.login.get') }}">Login</a>
                        <a class="font-bold lg:hidden text-gray-900 hover:text-gray-400 focus:outline-none focus:text-gray-400 "
                           href="{{ route('auth.register.get') }}">Register</a>
                    @endauth
                </div>
            </div>
        </div>
        <div class="flex items-center gap-x-2">
            @auth
                <div class="hs-dropdown [--strategy:static] sm:[--strategy:fixed] [--adaptive:none] ">
                    <button id="hs-navbar-example-dropdown" type="button" class="hs-dropdown-toggle flex items-center w-full text-gray-600 hover:text-gray-400 focus:outline-none focus:text-gray-400 font-medium" aria-haspopup="menu" aria-expanded="false" aria-label="Mega Menu">
                        {{ Str::words(auth()->user()->fullname, 1, '') }}
                        <svg class="hs-dropdown-open:-rotate-180 sm:hs-dropdown-open:rotate-0 duration-300 ms-1 shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </button>

                    <div class="hs-dropdown-menu transition-[opacity,margin] ease-in-out duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 sm:w-48 z-10 bg-white sm:shadow-md rounded-lg p-1 space-y-1 before:absolute top-full sm:border before:-top-5 before:start-0 before:w-full before:h-5 hidden" role="menu" aria-orientation="vertical" aria-labelledby="hs-navbar-example-dropdown">
                        <a class="@if (Route::is('dashboard')) text-primary-500 font-bold @else text-gray-800 font-medium @endif flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm  hover:bg-gray-100 focus:outline-none focus:bg-gray-100" href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                        <a class="@if (Route::is('settings')) text-primary-500 font-bold @else text-gray-800 font-medium @endif flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100" href="{{ route('user.settings') }}">
                            Settings
                        </a>
                    </div>
                </div>
                <a class="py-2 hidden px-6 lg:inline-flex items-center gap-x-2 text-sm font-medium text-gray-900 hover:text-gray-400 focus:outline-none focus:text-gray-400"
                   href="{{ route('auth.logout') }}">
                    Logout
                </a>
            @else
                <a class="py-2 hidden px-6 lg:inline-flex items-center gap-x-2 text-sm font-medium rounded-[15px] border border-transparent bg-secondary-800 text-white hover:bg-primary-900 focus:outline-none focus:bg-secondary-950 disabled:opacity-50 disabled:pointer-events-none"
                    href="{{ route('auth.login.get') }}">
                    Submit Manuscript
                </a>
                <a href="{{ route('auth.login.get') }}"
                   class="py-2 px-6 hidden lg:inline-flex items-center gap-x-2 text-sm font-medium rounded-[15px] border border-primary-500 text-primary-500 hover:border-primary-600 hover:text-primary-600 focus:outline-none focus:border-primary-600 focus:text-primary-600 disabled:opacity-50 disabled:pointer-events-none">
                    Login
                </a>
                <a href="{{ route('auth.register.get') }}"
                   class="py-2 hidden px-6 lg:inline-flex items-center gap-x-2 text-sm font-medium rounded-[15px] border border-transparent bg-primary-500 text-white hover:bg-primary-600 focus:outline-none focus:bg-primary-700 disabled:opacity-50 disabled:pointer-events-none">
                    Register
                </a>
            @endauth
            <button type="button"
                class="lg:hidden hs-collapse-toggle absolute top-[30px] right-[20px] translate-y-[-50%] size-7 flex justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                id="hs-navbar-alignment-collapse" aria-expanded="false" aria-controls="hs-navbar-alignment"
                aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-alignment">
                <svg class="hs-collapse-open:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" x2="21" y1="6" y2="6" />
                    <line x1="3" x2="21" y1="12" y2="12" />
                    <line x1="3" x2="21" y1="18" y2="18" />
                </svg>
                <svg class="hs-collapse-open:block hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
                <span class="sr-only">Toggle</span>
            </button>
        </div>
    </nav>
</header>
