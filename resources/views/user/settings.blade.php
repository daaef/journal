<x-layouts.layout>
    <x-slot:title>
        Custom Title
    </x-slot>

    <x-slot:title>
        Welcome to your JAPR Settings Page
    </x-slot>
    <x-slot:breadcrumb>
        <div class="border-b border-gray-200 pb-5 sm:flex w-full sm:items-center sm:justify-between">
            <h3 class="text-lg font-bold leading-6 text-gray-900">Settings</h3>
            <div>
                <h4>{{ Str::words(auth()->user()->fullname, 1, '') }}'s Dashboard</h4>
            </div>
        </div>
        <hr class="">
    </x-slot:breadcrumb>

    <form class="py-5" method="post" action="{{ route('user.settings.update', $user->uuid) }}">
        @csrf
        <div class="space-y-12">
            <div class="">
                <h2 class="text-base font-semibold leading-7 text-gray-900">
                    {{ Str::words(auth()->user()->fullname, 1, '') }}'s Setting</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Update user information</p>
                <p class="mt-1 text-sm leading-6 text-gray-600">Role: <span
                        class="inline-flex ml-4 items-center gap-x-1.5 py-1 px-1.5 rounded-full text-xs font-medium bg-secondary-900 text-gray-200">Publisher</span>
                </p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">

                    <div>
                        <label for="fullname" class="block text-sm font-medium leading-6 text-gray-900">First
                            Name</label>
                        <div class="mt-2">
                            <input id="fullname" name="fullname" type="text" value="{{ $user->fullname }}" autocomplete="fullname"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div>
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                        <div class="mt-2">
                            <input id="username" name="username" type="text" value="{{ $user->username }}" autocomplete="username"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div class="w-full">
                        <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Country /
                            Region</label>
                        <div class="mt-2">
                            <select id="country" name="country" autocomplete="country-name"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                                <option>United States</option>
                                <option>Canada</option>
                                <option>Mexico</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" value="{{ $user->email }}" autocomplete="email"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div>
                        <label for="old_password" class="block text-sm font-medium leading-6 text-gray-900">Old Password</label>
                        <div class="mt-2">
                            <input id="old_password" name="old_password" type="password"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    {{-- <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Confirm
                            Email</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="text" autocomplete="email"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div> --}}
                    <div>
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">New Password</label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium leading-6 text-gray-900">Confirm New
                            Password</label>
                        <div class="mt-2">
                            <input id="confirm_password" name="confirm_password" type="password"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="submit"
                class="rounded-md bg-green-800 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                Update Account
            </button>
        </div>
    </form>
</x-layouts.layout>
