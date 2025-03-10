<x-layouts.auth_layout>
    <x-slot:title>
        Login to your JAPR account
    </x-slot>
    <header class="lg:grid grid-cols-2 min-h-screen">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <img class="h-20 w-auto" src="{{ loadAssetFile('images/japr-logo.png') }}" alt="Your Company">
                    <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Welcome back!</h2>
                </div>

                <div class="mt-10">
                    <div class="mb-6">
                        <a href="{{ route('auth.google.redirect') }}"
                            class="flex w-full items-center justify-center gap-3 rounded-md px-3 py-1.5 text-sm text-black border-[2px]">
                            <svg class="w-4 h-auto" width="46" height="47" viewBox="0 0 46 47" fill="none">
                                <path
                                    d="M46 24.0287C46 22.09 45.8533 20.68 45.5013 19.2112H23.4694V27.9356H36.4069C36.1429 30.1094 34.7347 33.37 31.5957 35.5731L31.5663 35.8669L38.5191 41.2719L38.9885 41.3306C43.4477 37.2181 46 31.1669 46 24.0287Z"
                                    fill="#4285F4" />
                                <path
                                    d="M23.4694 47C29.8061 47 35.1161 44.9144 39.0179 41.3012L31.625 35.5437C29.6301 36.9244 26.9898 37.8937 23.4987 37.8937C17.2793 37.8937 12.0281 33.7812 10.1505 28.1412L9.88649 28.1706L2.61097 33.7812L2.52296 34.0456C6.36608 41.7125 14.287 47 23.4694 47Z"
                                    fill="#34A853" />
                                <path
                                    d="M10.1212 28.1413C9.62245 26.6725 9.32908 25.1156 9.32908 23.5C9.32908 21.8844 9.62245 20.3275 10.0918 18.8588V18.5356L2.75765 12.8369L2.52296 12.9544C0.909439 16.1269 0 19.7106 0 23.5C0 27.2894 0.909439 30.8731 2.49362 34.0456L10.1212 28.1413Z"
                                    fill="#FBBC05" />
                                <path
                                    d="M23.4694 9.07688C27.8699 9.07688 30.8622 10.9863 32.5344 12.5725L39.1645 6.11C35.0867 2.32063 29.8061 0 23.4694 0C14.287 0 6.36607 5.2875 2.49362 12.9544L10.0918 18.8588C11.9987 13.1894 17.25 9.07688 23.4694 9.07688Z"
                                    fill="#EB4335" />
                            </svg>
                            Sign in with Google
                        </a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm font-medium leading-6">
                            <span class="bg-white px-6 text-gray-900">Or continue with</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <div>
                        <form action="{{ route('auth.login.post') }}" method="post" class="space-y-6">
                            @csrf
                            <div>
                                <label for="username"
                                    class="block @if ($errors->has('email')) text-red-600 @endif text-sm font-medium leading-6 text-gray-900">Email
                                    address</label>
                                <div class="mt-2">
                                    <input id="username" name="email" type="email" autocomplete="email"
                                        placeholder="name@example.com" value="{{ old('email') }}"
                                        class="block w-full bg-[#F9FAFB] rounded-md border-0 px-3 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @if ($errors->has('emaifl')) text-red-600 ring-red-600 @endif">
                                </div>
                                @if ($errors->has('email'))
                                    <p class="text-sm text-red-600 mt-2" id="hs-validation-name-error-helper">
                                        {{ $errors->first('email') }}</p>
                                @endif
                            </div>

                            <div>
                                <label for="password"
                                    class="block @if ($errors->has('password')) text-red-600 @endif text-sm font-medium leading-6 text-gray-900">Password</label>
                                <div class="max-w-sm">
                                    <div class="flex mb-2">
                                        <div class="flex-1 relative">
                                            <input type="password" id="password" name="password"
                                                class="block w-full bg-[#F9FAFB] rounded-md border-0 px-3 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @if ($errors->has('password')) text-red-600 ring-red-600 @endif"
                                                placeholder="••••••••••">
                                            <button type="button" data-hs-toggle-password='{ "target": "#password" }'
                                                class="absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-none focus:text-secondary-700">
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
                                                    <line class="hs-password-active:hidden" x1="2"
                                                        x2="22" y1="2" y2="22"></line>
                                                    <path class="hidden hs-password-active:block"
                                                        d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                    <circle class="hidden hs-password-active:block" cx="12"
                                                        cy="12" r="3"></circle>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->has('password'))
                                    <p class="text-sm text-red-600 mt-2" id="hs-validation-name-error-helper">
                                        {{ $errors->first('password') }}</p>
                                @endif
                            </div>

                            <div class="flex items-center justify-between">
                                {{-- <div class="flex items-center">
                                    <input id="remember-me" name="remember-me" type="checkbox"
                                           class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    <label for="remember-me" class="ml-3 block text-sm leading-6 text-gray-700">Remember
                                        me</label>
                                </div> --}}

                                <div class="text-sm leading-6">
                                    <a href="{{ route('auth.forgot-password') }}"
                                        class="font-semibold text-secondary-900 hover:text-secondary-700">Forgot
                                        password?</a>
                                </div>
                            </div>

                            <div>
                                <button type="submit"
                                    class="flex w-full justify-center rounded-md bg-secondary-900 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-secondary-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Sign in
                                </button>
                            </div>
                            <div>
                                <div class="text-center">
                                    <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                                        Don't have an account yet?
                                        <a class="text-secondary-900 decoration-2 hover:underline focus:outline-none focus:underline font-medium"
                                            href="{{ route('auth.register.get') }}">
                                            Sign up here
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative hidden w-full flex-1 lg:block">
            <img class="absolute inset-0 h-full w-full object-cover" src="{{ loadAssetFile('images/loginImg.png') }}"
                alt="">
        </div>
    </header>

</x-layouts.auth_layout>
