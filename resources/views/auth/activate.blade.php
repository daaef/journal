<x-auth_layout>
    <x-slot:title>
        Create a new JAPR account password password
    </x-slot>
    <header class="lg:grid grid-cols-2 min-h-screen">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <img class="h-20 w-auto" src="{{ asset('images/japr-logo.png') }}" alt="Your Company">
                    <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Two-Step Varification</h2>
                    <p class="mt-2 text-sm text-gray-600">Enter the 6 digits activation code sent to your email address to
                        activate your account</p>
                </div>

                <div class="mt-6">
                    <div>
                        <form action="{{ route('auth.activate.post') }}" method="post" class="space-y-6">

                            @csrf

                            <div>
                                <label for="code"
                                    class="block @if ($errors->has('code')) text-red-600 @endif text-sm font-medium leading-6 text-gray-900">
                                    Enter Activation Code
                                </label>
                                <div class="max-w-sm">
                                    <div class="flex mb-2">
                                        <div class="flex-1 relative">
                                            <input type="text" id="hs-strong-password-with-indicator-and-hint"
                                                required name="code"
                                                class="block w-full bg-[#F9FAFB] rounded-md border-0 px-3 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @if ($errors->has('code')) text-red-600 ring-red-600 @endif"
                                                placeholder="123456">

                                            <input type="hidden" name="email" value="{{ request()->email }}">
                                            <input type="hidden" name="id" value="{{ request()->id }}">
                                        </div>
                                    </div>
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
                                    Activate my account
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative hidden w-full flex-1 lg:block">
            <img class="absolute inset-0 h-full w-full object-cover" src="{{ asset('images/forgot-password.jpg') }}"
                alt="">
        </div>
    </header>

</x-auth_layout>
