<x-layouts.editor_layout>
    <x-slot:title>
        Account Settings - JAPR
    </x-slot:title>
    
    <!-- Breadcrumb -->
    <div class="breadcrumb mb-24">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('editor.dashboard') }}" class="text-gray-600 fw-normal text-15 hover-text-gray-800">Home</a></li>
            <li><span class="text-gray-400 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
            <li><span class="text-gray-800 fw-normal text-15">Account Settings</span></li>
        </ul>
    </div>

    <!-- Page Header -->
    <div class="mb-24">
        <h1 class="h2 text-gray-800 mb-8">Account Settings</h1>
        <p class="text-gray-600 text-15">Manage your account information and preferences</p>
    </div>

    <!-- Display Success/Error Messages -->
    @if (session('alert-type') && session('message'))
        <div class="alert alert-{{ session('alert-type') == 'success' ? 'success' : 'danger' }} alert-dismissible fade show mb-24" role="alert">
            <i class="ph ph-{{ session('alert-type') == 'success' ? 'check-circle' : 'warning-circle' }} me-8"></i>
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-24" role="alert">
            <i class="ph ph-warning-circle me-8"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-8">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Settings Card -->
    <div class="card border">
        <div class="card-header bg-gray-50 border-bottom">
            <h5 class="mb-0 text-gray-800">
                <i class="ph ph-gear me-12"></i>{{ Str::words(auth()->user()->fullname, 1, '') }}'s Settings
            </h5>
            <p class="text-13 text-gray-600 mb-0 mt-4">
                Role: <span class="badge bg-primary text-white">{{ auth()->user()->roles->pluck('name')->join(', ') }}</span>
            </p>
        </div>
        <div class="card-body p-24">
            <form method="post" action="{{ route('editor.user.settings.update', $user->uuid) }}">
                @csrf
                
                <!-- Basic Information Section -->
                <div class="mb-32">
                    <h4 class="text-gray-800 mb-16">Basic Information</h4>
                    <div class="row gy-20">
                        <div class="col-md-6">
                            <label for="fullname" class="form-label fw-semibold text-primary-light text-sm mb-8">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="fullname" id="fullname" 
                                   value="{{ old('fullname', $user->fullname) }}"
                                   class="form-control radius-8 @error('fullname') border-danger @enderror" 
                                   placeholder="Enter your full name" required>
                            @error('fullname')
                                <div class="text-danger text-sm mt-4">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="username" class="form-label fw-semibold text-primary-light text-sm mb-8">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" id="username" 
                                   value="{{ old('username', $user->username) }}"
                                   class="form-control radius-8 @error('username') border-danger @enderror" 
                                   placeholder="Enter your username" required>
                            @error('username')
                                <div class="text-danger text-sm mt-4">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" 
                                   value="{{ old('email', $user->email) }}"
                                   class="form-control radius-8 @error('email') border-danger @enderror" 
                                   placeholder="Enter your email address" required>
                            @error('email')
                                <div class="text-danger text-sm mt-4">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="country" class="form-label fw-semibold text-primary-light text-sm mb-8">Country <span class="text-danger">*</span></label>
                            <select name="country" id="country" class="form-control radius-8 @error('country') border-danger @enderror" required>
                                <option value="">Select your country</option>
                                <option value="Nigeria" {{ old('country', $user->country) == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                                <option value="Ghana" {{ old('country', $user->country) == 'Ghana' ? 'selected' : '' }}>Ghana</option>
                                <option value="Kenya" {{ old('country', $user->country) == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                                <option value="South Africa" {{ old('country', $user->country) == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                <option value="Egypt" {{ old('country', $user->country) == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                                <option value="Morocco" {{ old('country', $user->country) == 'Morocco' ? 'selected' : '' }}>Morocco</option>
                                <option value="Tanzania" {{ old('country', $user->country) == 'Tanzania' ? 'selected' : '' }}>Tanzania</option>
                                <option value="Uganda" {{ old('country', $user->country) == 'Uganda' ? 'selected' : '' }}>Uganda</option>
                                <option value="Cameroon" {{ old('country', $user->country) == 'Cameroon' ? 'selected' : '' }}>Cameroon</option>
                                <option value="Ethiopia" {{ old('country', $user->country) == 'Ethiopia' ? 'selected' : '' }}>Ethiopia</option>
                                <option value="Other" {{ old('country', $user->country) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('country')
                                <div class="text-danger text-sm mt-4">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="institution" class="form-label fw-semibold text-primary-light text-sm mb-8">Institution/Organization</label>
                            <input type="text" name="institution" id="institution" 
                                   value="{{ old('institution', $user->institution) }}"
                                   class="form-control radius-8" 
                                   placeholder="Enter your institution or organization">
                        </div>
                    </div>
                </div>

                <!-- Password Change Section -->
                <div class="mb-32">
                    <h4 class="text-gray-800 mb-16">Change Password</h4>
                    <p class="text-gray-600 text-sm mb-20">Leave blank if you don't want to change your password.</p>
                    
                    <div class="row gy-20">
                        <div class="col-md-6">
                            <label for="old_password" class="form-label fw-semibold text-primary-light text-sm mb-8">Current Password</label>
                            <input type="password" name="old_password" id="old_password" 
                                   class="form-control radius-8 @error('old_password') border-danger @enderror" 
                                   placeholder="Enter current password">
                            @error('old_password')
                                <div class="text-danger text-sm mt-4">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6"></div>

                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold text-primary-light text-sm mb-8">New Password</label>
                            <input type="password" name="password" id="password" 
                                   class="form-control radius-8 @error('password') border-danger @enderror" 
                                   placeholder="Enter new password">
                            @error('password')
                                <div class="text-danger text-sm mt-4">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="confirm_password" class="form-label fw-semibold text-primary-light text-sm mb-8">Confirm New Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" 
                                   class="form-control radius-8 @error('confirm_password') border-danger @enderror" 
                                   placeholder="Confirm new password">
                            @error('confirm_password')
                                <div class="text-danger text-sm mt-4">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex-align gap-16">
                    <button type="submit" class="btn btn-primary radius-8 px-32 py-11">
                        <i class="ph ph-floppy-disk me-8"></i>
                        Update Account
                    </button>
                    <a href="{{ route('editor.dashboard') }}" class="btn btn-outline-gray radius-8 px-32 py-11">
                        <i class="ph ph-arrow-left me-8"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
                                                </option>
                                                <option
                                                    value="Gabon" {{ $user->country == 'Gabon' ? 'selected' : '' }}>
                                                    Gabon
                                                </option>
                                                <option
                                                    value="Sao Tome and Principe" {{ $user->country == 'Sao Tome and Principe' ? 'selected' : '' }}>
                                                    Sao Tome and Principe
                                                </option>
                                            </optgroup>
                                            <optgroup label="Eastern Africa">
                                                <option
                                                    value="Burundi" {{ $user->country == 'Burundi' ? 'selected' : '' }}>
                                                    Burundi
                                                </option>
                                                <option
                                                    value="Comoros" {{ $user->country == 'Comoros' ? 'selected' : '' }}>
                                                    Comoros
                                                </option>
                                                <option
                                                    value="Djibouti" {{ $user->country == 'Djibouti' ? 'selected' : '' }}>
                                                    Djibouti
                                                </option>
                                                <option
                                                    value="Eritrea" {{ $user->country == 'Eritrea' ? 'selected' : '' }}>
                                                    Eritrea
                                                </option>
                                                <option
                                                    value="Ethiopia" {{ $user->country == 'Ethiopia' ? 'selected' : '' }}>
                                                    Ethiopia
                                                </option>
                                                <option
                                                    value="Kenya" {{ $user->country == 'Kenya' ? 'selected' : '' }}>
                                                    Kenya
                                                </option>
                                                <option
                                                    value="Madagascar" {{ $user->country == 'Madagascar' ? 'selected' : '' }}>
                                                    Madagascar
                                                </option>
                                                <option
                                                    value="Malawi" {{ $user->country == 'Malawi' ? 'selected' : '' }}>
                                                    Malawi
                                                </option>
                                                <option
                                                    value="Mauritius" {{ $user->country == 'Mauritius' ? 'selected' : '' }}>
                                                    Mauritius
                                                </option>
                                                <option
                                                    value="Mozambique" {{ $user->country == 'Mozambique' ? 'selected' : '' }}>
                                                    Mozambique
                                                </option>
                                                <option
                                                    value="Rwanda" {{ $user->country == 'Rwanda' ? 'selected' : '' }}>
                                                    Rwanda
                                                </option>
                                                <option
                                                    value="Seychelles" {{ $user->country == 'Seychelles' ? 'selected' : '' }}>
                                                    Seychelles
                                                </option>
                                                <option
                                                    value="Somalia" {{ $user->country == 'Somalia' ? 'selected' : '' }}>
                                                    Somalia
                                                </option>
                                                <option
                                                    value="South Sudan" {{ $user->country == 'South Sudan' ? 'selected' : '' }}>
                                                    South Sudan
                                                </option>
                                                <option
                                                    value="Tanzania" {{ $user->country == 'Tanzania' ? 'selected' : '' }}>
                                                    Tanzania
                                                </option>
                                                <option
                                                    value="Uganda" {{ $user->country == 'Uganda' ? 'selected' : '' }}>
                                                    Uganda
                                                </option>
                                                <option
                                                    value="Zambia" {{ $user->country == 'Zambia' ? 'selected' : '' }}>
                                                    Zambia
                                                </option>
                                                <option
                                                    value="Zimbabwe" {{ $user->country == 'Zimbabwe' ? 'selected' : '' }}>
                                                    Zimbabwe
                                                </option>
                                            </optgroup>
                                            <optgroup label="Northern Africa">
                                                <option
                                                    value="Algeria" {{ $user->country == 'Algeria' ? 'selected' : '' }}>
                                                    Algeria
                                                </option>
                                                <option
                                                    value="Egypt" {{ $user->country == 'Egypt' ? 'selected' : '' }}>
                                                    Egypt
                                                </option>
                                                <option
                                                    value="Libya" {{ $user->country == 'Libya' ? 'selected' : '' }}>
                                                    Libya
                                                </option>
                                                <option
                                                    value="Morocco" {{ $user->country == 'Morocco' ? 'selected' : '' }}>
                                                    Morocco
                                                </option>
                                                <option
                                                    value="Sudan" {{ $user->country == 'Sudan' ? 'selected' : '' }}>
                                                    Sudan
                                                </option>
                                                <option
                                                    value="Tunisia" {{ $user->country == 'Tunisia' ? 'selected' : '' }}>
                                                    Tunisia
                                                </option>
                                                <option
                                                    value="Western Sahara" {{ $user->country == 'Western Sahara' ? 'selected' : '' }}>
                                                    Western Sahara
                                                </option>
                                            </optgroup>
                                            <optgroup label="Southern Africa">
                                                <option
                                                    value="Angola" {{ $user->country == 'Angola' ? 'selected' : '' }}>
                                                    Angola
                                                </option>
                                                <option
                                                    value="Botswana" {{ $user->country == 'Botswana' ? 'selected' : '' }}>
                                                    Botswana
                                                </option>
                                                <option
                                                    value="Lesotho" {{ $user->country == 'Lesotho' ? 'selected' : '' }}>
                                                    Lesotho
                                                </option>
                                                <option
                                                    value="Namibia" {{ $user->country == 'Namibia' ? 'selected' : '' }}>
                                                    Namibia
                                                </option>
                                                <option
                                                    value="South Africa" {{ $user->country == 'South Africa' ? 'selected' : '' }}>
                                                    South Africa
                                                </option>
                                                <option
                                                    value="Swaziland" {{ $user->country == 'Swaziland' ? 'selected' : '' }}>
                                                    Swaziland
                                                </option>
                                            </optgroup>
                                            <optgroup label="Western Africa">
                                                <option
                                                    value="Benin" {{ $user->country == 'Benin' ? 'selected' : '' }}>
                                                    Benin
                                                </option>
                                                <option
                                                    value="Burkina Faso" {{ $user->country == 'Burkina Faso' ? 'selected' : '' }}>
                                                    Burkina Faso
                                                </option>
                                                <option
                                                    value="Cape Verde" {{ $user->country == 'Cape Verde' ? 'selected' : '' }}>
                                                    Cape Verde
                                                </option>
                                                <option
                                                    value="Cote d'Ivoire" {{ $user->country == `Cote d'Ivoire` ? 'selected' : '' }}>
                                                    Cote d'Ivoire
                                                </option>
                                                <option
                                                    value="Gambia" {{ $user->country == 'Gambia' ? 'selected' : '' }}>
                                                    Gambia
                                                </option>
                                                <option
                                                    value="Ghana" {{ $user->country == 'Ghana' ? 'selected' : '' }}>
                                                    Ghana
                                                </option>
                                                <option
                                                    value="Guinea" {{ $user->country == 'Guinea' ? 'selected' : '' }}>
                                                    Guinea
                                                </option>
                                                <option
                                                    value="Guinea-Bissau" {{ $user->country == 'Guinea-Bissau' ? 'selected' : '' }}>
                                                    Guinea-Bissau
                                                </option>
                                                <option
                                                    value="Liberia" {{ $user->country == 'Liberia' ? 'selected' : '' }}>
                                                    Liberia
                                                </option>
                                                <option
                                                    value="Mali" {{ $user->country == 'Mali' ? 'selected' : '' }}>
                                                    Mali
                                                </option>
                                                <option
                                                    value="Mauritania" {{ $user->country == 'Mauritania' ? 'selected' : '' }}>
                                                    Mauritania
                                                </option>
                                                <option
                                                    value="Niger" {{ $user->country == 'Niger' ? 'selected' : '' }}>
                                                    Niger
                                                </option>
                                                <option
                                                    value="Nigeria" {{ $user->country == 'Nigeria' ? 'selected' : '' }}>
                                                    Nigeria
                                                </option>
                                                <option
                                                    value="Senegal" {{ $user->country == 'Senegal' ? 'selected' : '' }}>
                                                    Senegal
                                                </option>
                                                <option
                                                    value="Sierra Leone" {{ $user->country == 'Sierra Leone' ? 'selected' : '' }}>
                                                    Sierra Leone
                                                </option>
                                                <option
                                                    value="Togo" {{ $user->country == 'Togo' ? 'selected' : '' }}>
                                                    Togo
                                                </option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                                <div class="mt-2">
                                    <input id="email" name="email" type="email" value="{{ $user->email }}"
                                           autocomplete="email"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div>
                                <label for="old_password"
                                       class="block text-sm font-medium leading-6 text-gray-900">Old
                                    Password</label>
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
                                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">New
                                    Password</label>
                                <div class="mt-2">
                                    <input id="password" name="password" type="password"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div>
                                <label for="confirm_password"
                                       class="block text-sm font-medium leading-6 text-gray-900">Confirm New
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
                            class="rounded-md bg-green-800 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                        Update Account
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Widgets End -->
</x-layouts.admin_layout>
