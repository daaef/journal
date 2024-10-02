<x-layouts.auth_layout>
    <x-slot:title>
        Create a new JAPR account password password
    </x-slot>
    <header class="lg:grid grid-cols-2 min-h-screen">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <img class="h-20 w-auto" src="{{ asset('images/japr-logo.png') }}" alt="Your Company">
                    <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Create a new JAPR account password password!</h2>
                </div>

                <div class="mt-6">
                    <div>
                        <form action="" method="post" class="space-y-6">

                            @csrf

                            <div>
                                <label for="password"
                                       class="block @if ($errors->has('password')) text-red-600 @endif text-sm font-medium leading-6 text-gray-900">Password</label>
                                <div class="max-w-sm">
                                    <div class="flex mb-2">
                                        <div class="flex-1 relative">
                                            <input type="password" id="hs-strong-password-with-indicator-and-hint" required
                                                   name="password"
                                                   class="block w-full bg-[#F9FAFB] rounded-md border-0 px-3 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @if ($errors->has('password')) text-red-600 ring-red-600 @endif"
                                                   placeholder="••••••••••">
                                            <div id="hs-strong-password"
                                                 data-hs-strong-password='{
                                                "target": "#hs-strong-password-with-indicator-and-hint",
                                                "hints": "#hs-strong-password-hints",
                                                "stripClasses": "hs-strong-password:opacity-100 hs-strong-password-accepted:bg-teal-500 h-2 flex-auto rounded-full bg-red-600 opacity-50 mx-1"
                                            }'
                                                 class="flex mt-2 -mx-1"></div>
                                            <button type="button"
                                                    data-hs-toggle-password='{ "target": "#hs-strong-password-with-indicator-and-hint" }'
                                                    class="absolute inset-y-0 end-0 flex items-center translate-y-[-10%] z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-none focus:text-secondary-700">
                                                <svg class="shrink-0 size-3.5" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path class="hs-password-active:hidden"
                                                          d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                                                    <path class="hs-password-active:hidden"
                                                          d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68">
                                                    </path>
                                                    <path class="hs-password-active:hidden"
                                                          d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61">
                                                    </path>
                                                    <line class="hs-password-active:hidden" x1="2" x2="22"
                                                          y1="2" y2="22"></line>
                                                    <path class="hidden hs-password-active:block"
                                                          d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                    <circle class="hidden hs-password-active:block" cx="12"
                                                            cy="12" r="3"></circle>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="confirm_password"
                                       class="block text-sm font-medium leading-6 text-gray-900">Confirm
                                    Password</label>
                                <div class="max-w-sm relative">
                                    <div class="flex mb-2">
                                        <div class="flex-1">
                                            <input type="password" id="confirm_password" required name="confirm_password"
                                                   class="block w-full bg-[#F9FAFB] rounded-md border-0 px-3 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6endif"
                                                   placeholder="••••••••••">
                                        </div>
                                    </div>
                                    <button type="button" data-hs-toggle-password='{ "target": "#confirm_password" }'
                                            class="absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-none focus:text-secondary-700">
                                        <svg class="shrink-0 size-3.5" width="24" height="24" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <path class="hs-password-active:hidden" d="M9.88 9.88a3 3 0 1 0 4.24 4.24">
                                            </path>
                                            <path class="hs-password-active:hidden"
                                                  d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68">
                                            </path>
                                            <path class="hs-password-active:hidden"
                                                  d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61">
                                            </path>
                                            <line class="hs-password-active:hidden" x1="2" x2="22"
                                                  y1="2" y2="22"></line>
                                            <path class="hidden hs-password-active:block"
                                                  d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                            <circle class="hidden hs-password-active:block" cx="12" cy="12"
                                                    r="3"></circle>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                {{-- <div class="flex items-center">
                                    <input id="remember-me" name="remember-me" type="checkbox"
                                           class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    <label for="remember-me" class="ml-3 block text-sm leading-6 text-gray-700">Remember
                                        me</label>
                                </div> --}}
                            </div>

                            <div>
                                <button type="submit"
                                    class="flex w-full justify-center rounded-md bg-secondary-900 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-secondary-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Reset password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative hidden w-full flex-1 lg:block">
            <img class="absolute inset-0 h-full w-full object-cover" src="{{ asset('images/forgot-password.jpg') }}" alt="">
        </div>
    </header>

</x-layouts.auth_layout>
