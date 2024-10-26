<x-layouts.auth_layout>
    <x-slot:title>
        Successfully registered JAPR account
    </x-slot>
    <header class="lg:grid grid-cols-2 min-h-screen">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full flex flex-col max-w-sm lg:w-96">
                <div class="flex-col flex items-center text-center">
                    <img class="h-20 w-auto" src="{{ loadAssetFile('images/congratulations.png') }}" alt="Your Company">
                    <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Congratulations!</h2>
                    <p>You have successfully registered. Please enter the activation code sent to your email.</p>
                </div>

                <div class="mt-6">
                    <div>
                        <form action="{{ route('auth.activate.post') }}" method="post" class="space-y-6">
                            @csrf
                            <input type="hidden" name="email" value="{{ session('user_email') }}">
                            <div class="flex gap-x-3 justify-center h-[30px]" data-hs-pin-input="">
                                <input type="text" name="code[]" class="block w-[38px] text-center border-gray-200 rounded-md text-sm focus:border-primary-500 focus:ring-primary-500 disabled:opacity-50 disabled:pointer-events-none border" maxlength="1" required>
                                <input type="text" name="code[]" class="block w-[38px] text-center border-gray-200 rounded-md text-sm focus:border-primary-500 focus:ring-primary-500 disabled:opacity-50 disabled:pointer-events-none border" maxlength="1" required>
                                <input type="text" name="code[]" class="block w-[38px] text-center border-gray-200 rounded-md text-sm focus:border-primary-500 focus:ring-primary-500 disabled:opacity-50 disabled:pointer-events-none border" maxlength="1" required>
                                <input type="text" name="code[]" class="block w-[38px] text-center border-gray-200 rounded-md text-sm focus:border-primary-500 focus:ring-primary-500 disabled:opacity-50 disabled:pointer-events-none border" maxlength="1" required>
                                <input type="text" name="code[]" class="block w-[38px] text-center border-gray-200 rounded-md text-sm focus:border-primary-500 focus:ring-primary-500 disabled:opacity-50 disabled:pointer-events-none border" maxlength="1" required>
                                <input type="text" name="code[]" class="block w-[38px] text-center border-gray-200 rounded-md text-sm focus:border-primary-500 focus:ring-primary-500 disabled:opacity-50 disabled:pointer-events-none border" maxlength="1" required>
                            </div>
                           {{-- <div class="text-center">
                                <a href="{{ route('auth.activate.resend') }}" class="text-gray-700">
                                    Didn't receive an email? <span class="font-bold">Resend</span>
                                </a>
                            </div>--}}

                            <div>
                                <button type="submit"
                                        class="flex w-full justify-center rounded-md bg-secondary-900 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-secondary-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Activate Account
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative hidden w-full flex-1 lg:block">
            <img class="absolute inset-0 h-full w-full object-cover" src="{{ loadAssetFile('images/success.jpg') }}" alt="">
        </div>
    </header>
</x-layouts.auth_layout>
