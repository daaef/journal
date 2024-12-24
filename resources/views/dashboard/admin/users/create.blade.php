<x-layouts.admin_layout>
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li><a href="" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">Create a User</span></li>
            </ul>
        </div>
    </div>
    <div class="card">
        <div class="card-header border-bottom border-gray-100 flex-between flex-wrap gap-8">
            <div class="flex-align gap-8 flex-wrap">
                <h5 class="mb-0">Create a User</h5>
                <button type="button" class="text-main-600 text-md d-flex" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="Create a User">
                    <i class="ph-fill ph-question"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('users.store') }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-20">
                            <label for="fullname" class="h6 mb-8 fw-semibold">Fullname</label>
                            <input type="text" class="form-control fw-medium text-15" id="fullname" name="fullname"
                                value="{{ old('fullname') }}" placeholder="First Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-20">
                            <label for="username" class="h6 mb-8 fw-semibold">Username</label>
                            <input type="text" class="form-control fw-medium text-15" id="username" name="username"
                                value="{{ old('username') }}" placeholder="Username">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-20">
                            <label for="email" class="h6 mb-8 fw-semibold">Email</label>
                            <input type="text" class="form-control fw-medium text-15" id="email" name="email"
                                value="{{ old('email') }}" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-20">
                            <label class="h6 mb-8 fw-semibold" for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control fw-medium text-15" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-20">
                            <label class="h6 mb-8 fw-semibold" for="password_confirmation">Confirm Password</label>
                            <input type="password" name="confirm_password" id="password_confirmation" class="form-control fw-medium text-15" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-20">
                            <label for="country" class="h6 mb-8 fw-semibold">Country</label>
                            <select name="country" id="country" class="form-select py-9 placeholder-13 text-15">
                                <option value="">Select a Country</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="Ghana">Ghana</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-20">
                            <label for="role" class="h6 mb-8 fw-semibold">Assign User Role</label>
                            <select name="role" id="role" class="form-select py-9 placeholder-13 text-15">
                                <option value="">Select a Country</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>


                <div class="mb-20">
                    <label for="active_status" class="h6 mb-8 fw-semibold">Active Status</label>
                    <div class="select-has-ico">
                        <select class="form-control form-select rounded-8 bg-gray-50 border border-main-200 py-19" id="active_status" name="active_status">
                            <option value="" disabled>Select status</option>
                            <option value="1" selected>Enable</option>
                            <option value="0">Disable</option>
                        </select>
                    </div>
                </div>
                <div class="flex-align justify-content-end gap-8">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-main rounded-pill py-9">Back</a>
                    <button type="submit" class="btn btn-main rounded-pill py-9">Continue</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin_layout>
