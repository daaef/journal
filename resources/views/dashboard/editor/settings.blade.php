<x-layouts.editor_layout>
    <x-slot:title>
        Account Settings - JAPR
    </x-slot:title>
    
    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('editor.dashboard') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-900 text-sm font-medium ml-2">Account Settings</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Account Settings</h1>
        <p class="text-gray-600">Manage your account information and preferences</p>
    </div>

    <!-- Display Success/Error Messages -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
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

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
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

    <!-- Settings Form -->
    <div class="card">
        <!-- Header -->
        <div class="card-header">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ Str::words(auth()->user()->fullname, 1, '') }}'s Settings
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">
                        Role: 
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ auth()->user()->roles->pluck('name')->join(', ') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <form method="post" action="{{ route('editor.user.settings.update', $user->uuid) }}" class="card-body settings-form">
            @csrf
            
            <!-- Basic Information Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Basic Information
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Your personal and contact information</p>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="fullname" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="fullname" id="fullname" 
                               value="{{ old('fullname', $user->fullname) }}"
                               class="form-control @error('fullname') is-invalid @enderror" 
                               placeholder="Enter your full name" required>
                        @error('fullname')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" id="username" 
                               value="{{ old('username', $user->username) }}"
                               class="form-control @error('username') is-invalid @enderror" 
                               placeholder="Enter your username" required>
                        @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" 
                               value="{{ old('email', $user->email) }}"
                               class="form-control @error('email') is-invalid @enderror" 
                               placeholder="Enter your email address" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                            Country <span class="text-red-500">*</span>
                        </label>
                        <select name="country" id="country" 
                                class="form-control @error('country') is-invalid @enderror" required>
                            <option value="">Select your country</option>
                            @include('components.country-options', ['selectedCountry' => old('country', $user->country)])
                        </select>
                        @error('country')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="institution" class="block text-sm font-medium text-gray-700 mb-2">
                            Institution/Organization
                        </label>
                        <input type="text" name="institution" id="institution" 
                               value="{{ old('institution', $user->institution) }}"
                               class="form-control" 
                               placeholder="Enter your institution or organization">
                    </div>
                </div>
            </div>

            <!-- Academic Profile Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Academic Profile
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Your academic background and expertise</p>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="academic_degree" class="block text-sm font-medium text-gray-700 mb-2">
                            Academic Degree
                        </label>
                        <input type="text" name="academic_degree" id="academic_degree" 
                               value="{{ old('academic_degree', $user->academic_degree) }}"
                               class="form-control" 
                               placeholder="e.g., Ph.D., M.Sc., B.Sc.">
                    </div>

                    <div>
                        <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">
                            Specialization
                        </label>
                        <input type="text" name="specialization" id="specialization" 
                               value="{{ old('specialization', $user->specialization) }}"
                               class="form-control" 
                               placeholder="e.g., Computer Science, Medicine, etc.">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="regional_expertise" class="block text-sm font-medium text-gray-700 mb-2">
                            Regional Expertise <span class="text-xs text-gray-500">(Multiple selection)</span>
                        </label>
                        <div class="custom-multiselect">
                            <div class="multiselect-trigger form-control @error('regional_expertise') is-invalid @enderror" onclick="toggleDropdown('regional_expertise')">
                                <span class="selected-text">Select regions...</span>
                                <svg class="dropdown-arrow" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                    <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="multiselect-dropdown" id="regional_expertise_dropdown">
                                @php
                                    $countriesByRegion = \App\Models\Country::getAllGroupedByRegion();
                                @endphp
                                @foreach($countriesByRegion as $regionName => $countries)
                                    <div class="option-group">
                                        <div class="group-header">{{ $regionName }}</div>
                                        @foreach($countries as $country)
                                            <label class="option-item">
                                                <input type="checkbox" name="regional_expertise[]" value="{{ $country->name }}" 
                                                       {{ in_array($country->name, old('regional_expertise', $user->regional_expertise ?? [])) ? 'checked' : '' }}
                                                       onchange="updateSelectedText('regional_expertise')">
                                                <span class="checkmark"></span>
                                                <span class="option-text">{{ $country->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @error('regional_expertise')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Click to open dropdown and select multiple regions</p>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="research_interests" class="block text-sm font-medium text-gray-700 mb-2">
                            Research Interests <span class="text-xs text-gray-500">(Multiple selection)</span>
                        </label>
                        <div class="custom-multiselect">
                            <div class="multiselect-trigger form-control @error('research_interests') is-invalid @enderror" onclick="toggleDropdown('research_interests')">
                                <span class="selected-text">Select interests...</span>
                                <svg class="dropdown-arrow" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                    <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="multiselect-dropdown" id="research_interests_dropdown">
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Agriculture" {{ in_array('Agriculture', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Agriculture</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Medicine" {{ in_array('Medicine', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Medicine</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Engineering" {{ in_array('Engineering', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Engineering</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Social Sciences" {{ in_array('Social Sciences', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Social Sciences</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Natural Sciences" {{ in_array('Natural Sciences', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Natural Sciences</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Technology" {{ in_array('Technology', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Technology</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Business" {{ in_array('Business', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Business</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Education" {{ in_array('Education', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Education</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Public Health" {{ in_array('Public Health', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Public Health</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Environmental Science" {{ in_array('Environmental Science', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Environmental Science</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Computer Science" {{ in_array('Computer Science', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Computer Science</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Economics" {{ in_array('Economics', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Economics</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Psychology" {{ in_array('Psychology', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Psychology</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Law" {{ in_array('Law', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Law</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Arts and Humanities" {{ in_array('Arts and Humanities', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Arts and Humanities</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Mathematics" {{ in_array('Mathematics', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Mathematics</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Physics" {{ in_array('Physics', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Physics</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Chemistry" {{ in_array('Chemistry', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Chemistry</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Biology" {{ in_array('Biology', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Biology</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Geology" {{ in_array('Geology', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Geology</span>
                                </label>
                                <label class="option-item">
                                    <input type="checkbox" name="research_interests[]" value="Astronomy" {{ in_array('Astronomy', old('research_interests', $user->research_interests ?? [])) ? 'checked' : '' }} onchange="updateSelectedText('research_interests')">
                                    <span class="checkmark"></span>
                                    <span class="option-text">Astronomy</span>
                                </label>
                            </div>
                        </div>
                        @error('research_interests')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Click to open dropdown and select multiple interests</p>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="biography" class="block text-sm font-medium text-gray-700 mb-2">
                            Academic Biography
                        </label>
                        <textarea name="biography" id="biography" rows="4" 
                                  class="form-control @error('biography') is-invalid @enderror" 
                                  placeholder="Brief description of your academic background and expertise">{{ old('biography', $user->biography) }}</textarea>
                        @error('biography')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="publications" class="block text-sm font-medium text-gray-700 mb-2">
                            Publications
                        </label>
                        <textarea name="publications" id="publications" rows="3" 
                                  class="form-control" 
                                  placeholder="List your key publications or research work">{{ old('publications', $user->publications) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Password Change Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Change Password
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Leave blank if you don't want to change your password</p>
                </div>
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="old_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Current Password
                        </label>
                        <input type="password" name="old_password" id="old_password" 
                               class="form-control @error('old_password') is-invalid @enderror" 
                               placeholder="Enter current password">
                        @error('old_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div></div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            New Password
                        </label>
                        <input type="password" name="password" id="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Enter new password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm New Password
                        </label>
                        <input type="password" name="confirm_password" id="confirm_password" 
                               class="form-control @error('confirm_password') is-invalid @enderror" 
                               placeholder="Confirm new password">
                        @error('confirm_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('editor.dashboard') }}" 
                   class="btn btn-outline-secondary">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Cancel
                </a>
                <button type="submit" 
                        class="btn btn-primary">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Account
                </button>
            </div>
        </form>
    </div>

</x-layouts.editor_layout>
