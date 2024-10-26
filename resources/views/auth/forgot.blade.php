<x-layouts.auth_layout>
    <x-slot:title>
        Forgot your JAPR account password?
    </x-slot>
    <header class="lg:grid grid-cols-2 min-h-screen">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <img class="h-20 w-auto" src="{{ loadAssetFile('images/japr-logo.png') }}" alt="Your Company">
                    <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Forgot your password?</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        No worries, we'll send you a reset link.
                    </p>
                </div>

                <div class="mt-6">
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div>
                        <form action="{{ route('auth.forgot-password') }}" method="post" class="space-y-6">

                            @csrf
                            <div>
                                <label for="username"
                                    class="block @if ($errors->has('email')) text-red-600 @endif text-sm font-medium leading-6 text-gray-900">Email
                                    address</label>
                                <div class="mt-2">
                                    <input id="username" name="email" type="email" autocomplete="email"
                                        placeholder="name@example.com" value="{{ old('email') }}"
                                        class="block w-full bg-[#F9FAFB] rounded-md border-0 px-3 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @if ($errors->has('email')) text-red-600 ring-red-600 @endif">
                                </div>
                                @if ($errors->has('email'))
                                    <p class="text-sm text-red-600 mt-2" id="hs-validation-name-error-helper">
                                        {{ $errors->first('email') }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="text-sm leading-6">
                                    <a href="{{ route('auth.login.get') }}"
                                        class="font-semibold text-secondary-900 hover:text-secondary-700">Sign in</a>
                                </div>
                            </div>

                            <div>
                                <button type="submit"
                                    class="flex w-full justify-center rounded-md bg-secondary-900 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-secondary-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Reset my password
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
            <img class="absolute inset-0 h-full w-full object-cover" src="{{ loadAssetFile('images/forgot-password.jpg') }}" alt="">
        </div>
    </header>

</x-layouts.auth_layout>
