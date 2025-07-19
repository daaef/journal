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

    <form class="py-5 settings-form" method="post" action="{{ route('user.settings.update', $user->uuid) }}">
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
                                class="form-control @error('fullname') is-invalid @enderror">
                            @error('fullname')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                        <div class="mt-2">
                            <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}" autocomplete="username" required
                                class="form-control @error('username') is-invalid @enderror">
                            @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="institution" class="block text-sm font-medium leading-6 text-gray-900">Institution</label>
                        <div class="mt-2">
                            <input id="institution" name="institution" type="text" value="{{ old('institution', $user->institution) }}" autocomplete="institution"
                                class="form-control @error('institution') is-invalid @enderror">
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
                                class="form-control pointer-events-none">
                        </div>
                    </div>
                    <div class="w-full">
                        <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Country / Region</label>
                        <div class="mt-2">
                            <select name="country" id="country" class="form-control @error('country') is-invalid @enderror">
                                <option value="">Select your country</option>
                                @include('components.country-options', ['selectedCountry' => old('country', $user->country)])
                            </select>
                            @error('country')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    @if($user->hasRole('Associate Editor'))
                    <div class="w-full">
                        <label for="regional_expertise" class="block text-sm font-medium leading-6 text-gray-900">
                            Regional Expertise <span class="text-xs text-gray-500">(For Associate Editors)</span>
                        </label>
                        <div class="mt-2">
                            <select name="regional_expertise[]" id="regional_expertise" multiple class="form-control @error('regional_expertise') is-invalid @enderror">
                                <option value="West Africa">West Africa</option>
                                <option value="East Africa">East Africa</option>
                                <option value="Central Africa">Central Africa</option>
                                <option value="Southern Africa">Southern Africa</option>
                                <option value="North Africa">North Africa</option>
                                <option value="Europe">Europe</option>
                                <option value="North America">North America</option>
                                <option value="Asia">Asia</option>
                                <option value="South America">South America</option>
                                <option value="Oceania">Oceania</option>
                            </select>
                            @error('regional_expertise')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Hold Ctrl/Cmd to select multiple regions</p>
                        </div>
                    </div>
                    
                    <div class="w-full">
                        <label for="research_interests" class="block text-sm font-medium leading-6 text-gray-900">
                            Research Interests <span class="text-xs text-gray-500">(For Associate Editors)</span>
                        </label>
                        <div class="mt-2">
                            <select name="research_interests[]" id="research_interests" multiple class="form-control @error('research_interests') is-invalid @enderror">
                                <option value="Agriculture">Agriculture</option>
                                <option value="Medicine">Medicine</option>
                                <option value="Engineering">Engineering</option>
                                <option value="Social Sciences">Social Sciences</option>
                                <option value="Natural Sciences">Natural Sciences</option>
                                <option value="Technology">Technology</option>
                                <option value="Business">Business</option>
                                <option value="Education">Education</option>
                                <option value="Public Health">Public Health</option>
                                <option value="Environmental Science">Environmental Science</option>
                                <option value="Computer Science">Computer Science</option>
                                <option value="Economics">Economics</option>
                                <option value="Psychology">Psychology</option>
                                <option value="Law">Law</option>
                                <option value="Arts and Humanities">Arts and Humanities</option>
                                <option value="Mathematics">Mathematics</option>
                                <option value="Physics">Physics</option>
                                <option value="Chemistry">Chemistry</option>
                                <option value="Biology">Biology</option>
                                <option value="Geology">Geology</option>
                                <option value="Astronomy">Astronomy</option>
                            </select>
                            @error('research_interests')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Hold Ctrl/Cmd to select multiple interests</p>
                        </div>
                    </div>
                    
                    <div class="w-full">
                        <label for="biography" class="block text-sm font-medium leading-6 text-gray-900">
                            Academic Biography <span class="text-xs text-gray-500">(For Associate Editors)</span>
                        </label>
                        <div class="mt-2">
                            <textarea name="biography" id="biography" rows="4" class="form-control @error('biography') is-invalid @enderror">{{ old('biography', $user->biography) }}</textarea>
                            @error('biography')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Brief description of your academic background and expertise</p>
                        </div>
                    </div>
                    
                    <div class="w-full">
                        <label for="available_for_review" class="block text-sm font-medium leading-6 text-gray-900">
                            Available for Review <span class="text-xs text-gray-500">(For Associate Editors)</span>
                        </label>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="available_for_review" value="1" {{ old('available_for_review', $user->available_for_review) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">I am available to review manuscripts</span>
                            </label>
                        </div>
                    </div>
                    @endif
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
// Pre-select existing values for multiple select fields
document.addEventListener('DOMContentLoaded', function() {
    // Regional expertise
    const regionalExpertise = @json($user->regional_expertise ?? []);
    const regionalSelect = document.getElementById('regional_expertise');
    if (regionalSelect) {
        regionalExpertise.forEach(region => {
            const option = regionalSelect.querySelector(`option[value="${region}"]`);
            if (option) option.selected = true;
        });
    }
    
    // Research interests
    const researchInterests = @json($user->research_interests ?? []);
    const researchSelect = document.getElementById('research_interests');
    if (researchSelect) {
        researchInterests.forEach(interest => {
            const option = researchSelect.querySelector(`option[value="${interest}"]`);
            if (option) option.selected = true;
        });
    }
});

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
