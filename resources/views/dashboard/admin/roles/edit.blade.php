<x-layouts.admin_layout>
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li><a href="" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">Editing - {{ $role->name }}</span></li>
            </ul>
        </div>
    </div>
    <div class="card">
        <div class="card-header border-bottom border-gray-100 flex-between flex-wrap gap-8">
            <div class="flex-align gap-8 flex-wrap">
                <h5 class="mb-0">Manage User Role</h5>
                <button type="button" class="text-main-600 text-md d-flex" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="User Roles">
                    <i class="ph-fill ph-question"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('roles.update', $role->uuid) }}" method="post">
                @csrf

                <div class="mb-20">
                    <label for="name" class="h6 mb-8 fw-semibold">Name</label>
                    <input type="text" class="form-control fw-medium text-15" id="name" name="name"
                        value="{{ $role->name }}" placeholder="Role Name" readonly>
                </div>

                <div class="mb-20">
                    <label for="active_status" class="h6 mb-8 fw-semibold">Active Status</label>
                    <div class="select-has-ico">
                        <select class="form-control form-select rounded-8 bg-gray-50 border border-main-200 py-19"
                            id="active_status" name="active_status">
                            <option value="" disabled>Select status</option>
                            <option value="1" {{ old('active_status') || $role->is_active == 1 ? 'selected' : '' }}>Enable</option>
                            <option value="0" {{ old('active_status') || $role->is_active == 0 ? 'selected' : '' }}>Disable</option>
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
