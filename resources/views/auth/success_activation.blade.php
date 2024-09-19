<x-auth_layout>
    <x-slot:title>
        Successfully activated JAPR account
    </x-slot>
    <header class="lg:grid grid-cols-2 min-h-screen">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full flex flex-col max-w-sm lg:w-96">
                <div class="flex-col flex items-center text-center">
                    <img class="h-20 w-auto" src="{{ asset('images/congratulations.png') }}" alt="Your Company">
                    <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Congratulations!</h2>
                    <p>You have successfully registered. We sent you an activation email. Please
                        check your inbox</p>
                </div>

                <div class="mt-6">
                    <div>
                        <form action="{{ route('auth.login.post') }}" method="post" class="space-y-6">

                            @csrf

                            <div class="text-center">
                                <a href="{{ route('auth.login.get') }}" type="submit"
                                   class="text-gray-700">
                                    Didn’t receive an email? <span class="font-bold">Resend</span>
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

</x-auth_layout>
