<x-layouts.reviewer_layout>
    <x-slot:title>
        Account Settings - JAPR
    </x-slot:title>
    
    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('reviewer.dashboard') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
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
    <div class="bg-white shadow rounded-lg border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
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

        <form method="post" action="{{ route('reviewer.user.settings.update', $user->uuid) }}" class="p-6 space-y-8">
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
                               class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 @error('fullname') ring-red-500 focus:ring-red-500 @enderror" 
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
                               class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 @error('username') ring-red-500 focus:ring-red-500 @enderror" 
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
                               class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 @error('email') ring-red-500 focus:ring-red-500 @enderror" 
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
                                class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 @error('country') ring-red-500 focus:ring-red-500 @enderror" required>
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
                               class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" 
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
                               class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" 
                               placeholder="e.g., Ph.D., M.Sc., B.Sc.">
                    </div>

                    <div>
                        <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">
                            Specialization
                        </label>
                        <input type="text" name="specialization" id="specialization" 
                               value="{{ old('specialization', $user->specialization) }}"
                               class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" 
                               placeholder="e.g., Computer Science, Medicine, etc.">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="regional_expertise" class="block text-sm font-medium text-gray-700 mb-2">
                            Regional Expertise
                        </label>
                        <select name="regional_expertise[]" id="regional_expertise" multiple 
                                class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 @error('regional_expertise') ring-red-500 focus:ring-red-500 @enderror">
                            @php
                                $countriesByRegion = \App\Models\Country::getAllGroupedByRegion();
                            @endphp
                            @foreach($countriesByRegion as $regionName => $countries)
                                <optgroup label="{{ $regionName }}">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->name }}" {{ in_array($country->name, old('regional_expertise', $user->regional_expertise ?? [])) ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('regional_expertise')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Hold Ctrl/Cmd to select multiple regions</p>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="research_interests" class="block text-sm font-medium text-gray-700 mb-2">
                            Research Interests
                        </label>
                        <select name="research_interests[]" id="research_interests" multiple 
                                class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 @error('research_interests') ring-red-500 focus:ring-red-500 @enderror">
                            <option value="Agriculture" {{ in_array('Agriculture', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Agriculture</option>
                            <option value="Medicine" {{ in_array('Medicine', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Medicine</option>
                            <option value="Engineering" {{ in_array('Engineering', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Engineering</option>
                            <option value="Social Sciences" {{ in_array('Social Sciences', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Social Sciences</option>
                            <option value="Natural Sciences" {{ in_array('Natural Sciences', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Natural Sciences</option>
                            <option value="Technology" {{ in_array('Technology', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Technology</option>
                            <option value="Business" {{ in_array('Business', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Business</option>
                            <option value="Education" {{ in_array('Education', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Education</option>
                            <option value="Public Health" {{ in_array('Public Health', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Public Health</option>
                            <option value="Environmental Science" {{ in_array('Environmental Science', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Environmental Science</option>
                            <option value="Computer Science" {{ in_array('Computer Science', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Computer Science</option>
                            <option value="Economics" {{ in_array('Economics', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Economics</option>
                            <option value="Psychology" {{ in_array('Psychology', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Psychology</option>
                            <option value="Law" {{ in_array('Law', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Law</option>
                            <option value="Arts and Humanities" {{ in_array('Arts and Humanities', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Arts and Humanities</option>
                            <option value="Mathematics" {{ in_array('Mathematics', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Mathematics</option>
                            <option value="Physics" {{ in_array('Physics', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Physics</option>
                            <option value="Chemistry" {{ in_array('Chemistry', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Chemistry</option>
                            <option value="Biology" {{ in_array('Biology', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Biology</option>
                            <option value="Geology" {{ in_array('Geology', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Geology</option>
                            <option value="Astronomy" {{ in_array('Astronomy', old('research_interests', $user->research_interests ?? [])) ? 'selected' : '' }}>Astronomy</option>
                        </select>
                        @error('research_interests')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Hold Ctrl/Cmd to select multiple interests</p>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="biography" class="block text-sm font-medium text-gray-700 mb-2">
                            Academic Biography
                        </label>
                        <textarea name="biography" id="biography" rows="4" 
                                  class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 @error('biography') ring-red-500 focus:ring-red-500 @enderror" 
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
                                  class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" 
                                  placeholder="List your key publications or research work">{{ old('publications', $user->publications) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Review Preferences Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Review Preferences
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Your review availability and preferences</p>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <div class="flex items-center">
                            <input type="checkbox" name="available_for_review" id="available_for_review" value="1" 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                                   {{ old('available_for_review', $user->available_for_review) ? 'checked' : '' }}>
                            <label for="available_for_review" class="ml-2 block text-sm text-gray-900">
                                I am available to review manuscripts
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="max_reviews_per_month" class="block text-sm font-medium text-gray-700 mb-2">
                            Max Reviews per Month
                        </label>
                        <input type="number" name="max_reviews_per_month" id="max_reviews_per_month" 
                               value="{{ old('max_reviews_per_month', $user->max_reviews_per_month ?? 5) }}"
                               class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" 
                               min="1" max="20" placeholder="5">
                    </div>

                    <div>
                        <label for="preferred_review_types" class="block text-sm font-medium text-gray-700 mb-2">
                            Preferred Review Types
                        </label>
                        <select name="preferred_review_types[]" id="preferred_review_types" multiple 
                                class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                            <option value="research_paper" {{ in_array('research_paper', old('preferred_review_types', $user->preferred_review_types ?? [])) ? 'selected' : '' }}>Research Papers</option>
                            <option value="review_article" {{ in_array('review_article', old('preferred_review_types', $user->preferred_review_types ?? [])) ? 'selected' : '' }}>Review Articles</option>
                            <option value="case_study" {{ in_array('case_study', old('preferred_review_types', $user->preferred_review_types ?? [])) ? 'selected' : '' }}>Case Studies</option>
                            <option value="methodology" {{ in_array('methodology', old('preferred_review_types', $user->preferred_review_types ?? [])) ? 'selected' : '' }}>Methodology Papers</option>
                            <option value="commentary" {{ in_array('commentary', old('preferred_review_types', $user->preferred_review_types ?? [])) ? 'selected' : '' }}>Commentaries</option>
                            <option value="short_communication" {{ in_array('short_communication', old('preferred_review_types', $user->preferred_review_types ?? [])) ? 'selected' : '' }}>Short Communications</option>
                            <option value="letter_to_editor" {{ in_array('letter_to_editor', old('preferred_review_types', $user->preferred_review_types ?? [])) ? 'selected' : '' }}>Letters to Editor</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Hold Ctrl/Cmd to select multiple types</p>
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
                               class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 @error('old_password') ring-red-500 focus:ring-red-500 @enderror" 
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
                               class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 @error('password') ring-red-500 focus:ring-red-500 @enderror" 
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
                               class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 @error('confirm_password') ring-red-500 focus:ring-red-500 @enderror" 
                               placeholder="Confirm new password">
                        @error('confirm_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('reviewer.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Account
                </button>
            </div>
        </form>
    </div>

</x-layouts.reviewer_layout>
