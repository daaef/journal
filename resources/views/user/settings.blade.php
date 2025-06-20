@php
    $user = auth()->user();
@endphp

<x-layouts.layout>
    <x-slot:title>
        Welcome to JAPR : Settings
    </x-slot>
    <x-slot:breadcrumb>
        <div class="border-b border-gray-200 pb-5 sm:flex w-full sm:items-center sm:justify-between">
            <h3 class="text-lg font-bold leading-6 text-gray-900">Settings</h3>
            <div>
                <h4>{{ Str::words($user->fullname, 1, '') }}'s Dashboard</h4>
            </div>
        </div>
        <hr class="">
    </x-slot:breadcrumb>

    <form class="py-5" method="post" action="{{ route('user.settings.update', $user->uuid) }}">
        @csrf
        
        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were errors with your submission:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Display success message --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="space-y-12">
            <div class="">
                <h2 class="text-base font-semibold leading-7 text-gray-900">
                    {{ Str::words($user->fullname, 1, '') }}'s Settings</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Update your account information and preferences</p>
                <p class="mt-1 text-sm leading-6 text-gray-600">
                    Role: 
                    @foreach($user->roles as $role)
                        <span class="inline-flex ml-2 items-center gap-x-1.5 py-1 px-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $role->name }}
                        </span>
                    @endforeach
                </p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                    <input type="hidden" name="uuid" value="{{ $user->uuid }}">
                    <div>
                        <label for="fullname" class="block text-sm font-medium leading-6 text-gray-900">Full Name</label>
                        <div class="mt-2">
                            <input id="fullname" name="fullname" type="text" value="{{ old('fullname', $user->fullname) }}" autocomplete="fullname" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('fullname') ring-red-500 focus:ring-red-500 @enderror">
                            @error('fullname')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                        <div class="mt-2">
                            <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}" autocomplete="username" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('username') ring-red-500 focus:ring-red-500 @enderror">
                            @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="institution" class="block text-sm font-medium leading-6 text-gray-900">Institution</label>
                        <div class="mt-2">
                            <input id="institution" name="institution" type="text" value="{{ old('institution', $user->institution) }}" autocomplete="institution"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('institution') ring-red-500 focus:ring-red-500 @enderror">
                            @error('institution')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="interests" class="block text-sm font-medium leading-6 text-gray-900">
                            Interests <a href="{{ route('user.interests') }}" class="text-primary-500 font-bold hover:underline">Edit</a></label>
                        <div class="mt-2">
                            <input disabled id="interests" name="interests" type="text" value="{{ $interests ?? 'No interests set' }}" autocomplete="interests"
                                class="block w-full pointer-events-none rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div class="w-full">
                        <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Country / Region</label>
                        <div class="mt-2">
                            <select name="country" id="country" class="block w-full bg-white rounded-md border-0 px-3 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('country') ring-red-500 focus:ring-red-500 @enderror">
                                <option value="">Select your country</option>
                                @include('components.country-options', ['selectedCountry' => old('country', $user->country)])
                            </select>
                            @error('country')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" autocomplete="email" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('email') ring-red-500 focus:ring-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="old_password" class="block text-sm font-medium leading-6 text-gray-900">Current Password</label>
                        <div class="mt-2">
                            <input id="old_password" name="old_password" type="password" autocomplete="current-password"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('old_password') ring-red-500 focus:ring-red-500 @enderror">
                            @error('old_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Leave blank if you don't want to change your password</p>
                        </div>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">New Password</label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" autocomplete="new-password"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('password') ring-red-500 focus:ring-red-500 @enderror">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Confirm New Password</label>
                        <div class="mt-2">
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="submit" id="updateButton"
                class="rounded-md bg-green-800 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                <span id="buttonText">Update Account</span>
                <span id="buttonSpinner" class="hidden">
                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Updating...
                </span>
            </button>
        </div>
    </form>

<script>
document.getElementById('updateButton').addEventListener('click', function() {
    const button = this;
    const buttonText = document.getElementById('buttonText');
    const buttonSpinner = document.getElementById('buttonSpinner');
    
    // Show loading state
    buttonText.classList.add('hidden');
    buttonSpinner.classList.remove('hidden');
    button.disabled = true;
    
    // Re-enable button after form submission (fallback)
    setTimeout(() => {
        buttonText.classList.remove('hidden');
        buttonSpinner.classList.add('hidden');
        button.disabled = false;
    }, 5000);
});

// Password confirmation validation
document.getElementById('password_confirmation').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmation = this.value;
    
    if (password && confirmation && password !== confirmation) {
        this.setCustomValidity('Passwords do not match');
    } else {
        this.setCustomValidity('');
    }
});
</script>

</x-layouts.layout>
