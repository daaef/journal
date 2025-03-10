<x-layouts.auth_layout>
    <x-slot:title>
        Create a new JAPR account password password
    </x-slot>
    <header class="lg:grid grid-cols-2 min-h-screen">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full flex flex-col max-w-sm lg:w-96">
                <div class="flex-col flex items-center text-center">
                    <img class="h-20 w-auto" src="{{ loadAssetFile('images/success_icon.png') }}" alt="Your Company">
                    <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Your password has been
                        successfully reset!</h2>
                    <p>you can now log in with your new password. If you
                        encounter any issues, please contact support</p>
                </div>

                <div class="mt-6">
                    <div>
                        <form action="{{ route('auth.login.post') }}" method="post" class="space-y-6">

                            @csrf

                            <div>
                                <a href="{{ route('auth.login.get') }}" type="submit"
                                    class="flex w-full justify-center rounded-md bg-secondary-900 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-secondary-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Back to Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative hidden w-full flex-1 lg:block">
            <img class="absolute inset-0 h-full w-full object-cover" src="{{ asset('images/success.jpg') }}" alt="">
        </div>
    </header>

</x-layouts.auth_layout>
