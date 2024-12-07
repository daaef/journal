<x-layouts.admin_layout>
    <x-slot name="title">
        Roles
    </x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold leading-9 text-gray-900">User Roles</h2>
            <a href="{{ route('roles.create') }}"
                class="flex items-center justify-center px-3 py-1.5 bg-primary-600 text-white font-semibold leading-6 rounded-md shadow-sm hover:bg-primary-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Create a Role
            </a>
        </div>

        <div class="card overflow-hidden">
            <div class="card-body p-0">
                <table id="assignmentTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="h6 text-gray-300">S/N</th>
                            <th class="h6 text-gray-300">Name</th>
                            <th class="h6 text-gray-300">Guard</th>
                            <th class="h6 text-gray-300">Status</th>
                            <th class="h6 text-gray-300">Created At</th>
                            <th class="h6 text-gray-300">Updated At</th>
                            <th class="h6 text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex-align gap-8">
                                        <img src="{{ asset('images/journal.png') }}" alt=""
                                            class="w-40 h-40 rounded-circle">
                                        <span class="h6 mb-0 fw-medium text-gray-300">
                                            {{ $role->name }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">
                                        {{ $role->guard_name }}
                                    </span>
                                </td>
                                <td>
                                    @if ($role->is_active == '1')
                                        <span
                                            class="text-13 py-2 px-8 bg-green-50 text-green-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                            <span class="w-6 h-6 bg-green-600 rounded-circle flex-shrink-0"></span>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="text-13 py-2 px-8 bg-danger-50 text-danger-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                            <span class="w-6 h-6 bg-danger-600 rounded-circle flex-shrink-0"></span>
                                            Disabled
                                        </span>
                                    @endif

                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">
                                        {{ $role->created_at }}
                                    </span>
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">
                                        {{ $role->updated_at }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('roles.edit', $role->uuid) }}"
                                        class="bg-main-50 text-main-600 py-2 px-14 rounded-pill hover-bg-main-600 hover-text-white">
                                        Edit</a>
                                    <a href="{{ route('roles.destroy', $role->uuid) }}"
                                        class="bg-danger-50 text-danger-600 py-2 px-14 rounded-pill hover-bg-danger-600 hover-text-white">
                                        Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin_layout>

