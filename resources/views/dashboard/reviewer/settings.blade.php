<x-layouts.reviewer_layout>
    <x-slot:title>
        Account Settings - JAPR
    </x-slot:title>
    
    <!-- Breadcrumb -->
    <div class="breadcrumb mb-24">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('reviewer.dashboard') }}" class="text-gray-600 fw-normal text-15 hover-text-gray-800">Home</a></li>
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
            <form method="post" action="{{ route('reviewer.user.settings.update', $user->uuid) }}">
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
                    <a href="{{ route('reviewer.dashboard') }}" class="btn btn-outline-gray radius-8 px-32 py-11">
                        <i class="ph ph-arrow-left me-8"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.reviewer_layout>
