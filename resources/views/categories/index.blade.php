<x-master>
    <x-slot name="title">
        Categories
    </x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold leading-9 text-gray-900">Categories</h2>
            <a href="{{ route('categories.create') }}"
                class="flex items-center justify-center px-3 py-1.5 bg-primary-600 text-white font-semibold leading-6 rounded-md shadow-sm hover:bg-primary-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Create Category
            </a>
        </div>

        <div class="card overflow-hidden">
            <div class="card-body p-0">
                <table id="assignmentTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="h6 text-gray-300">S/N</th>
                            <th class="h6 text-gray-300">Category Name</th>
                            <th class="h6 text-gray-300">Description</th>
                            <th class="h6 text-gray-300">Created At</th>
                            <th class="h6 text-gray-300">Updated At</th>
                            <th class="h6 text-gray-300">Status</th>
                            <th class="h6 text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
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
                                            {{ $category->name }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">
                                        {{ $category->description }}
                                    </span>
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">
                                        {{ $category->created_at }}
                                    </span>
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">
                                        {{ $category->updated_at }}
                                    </span>
                                </td>
                                <td>
                                    @if ($category->is_active == '1')
                                        <span
                                            class="text-13 py-2 px-8 bg-green-50 text-green-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                            <span class="w-6 h-6 bg-green-600 rounded-circle flex-shrink-0"></span>
                                            Active
                                        </span>

                                    @else
                                        <span class="text-13 py-2 px-8 bg-danger-50 text-danger-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                            <span class="w-6 h-6 bg-danger-600 rounded-circle flex-shrink-0"></span>
                                            Decline
                                        </span>
                                    @endif

                                </td>
                                <td>
                                    <a href="{{ route('categories.edit', $category->uuid) }}"
                                        class="bg-main-50 text-main-600 py-2 px-14 rounded-pill hover-bg-main-600 hover-text-white">
                                        Edit</a>
                                    <a href="{{ route('categories.destroy', $category->uuid) }}"
                                        class="bg-danger-50 text-danger-600 py-2 px-14 rounded-pill hover-bg-danger-600 hover-text-white">
                                        Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


</x-master>
