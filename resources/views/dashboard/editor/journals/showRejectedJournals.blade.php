<x-layouts.editor_layout>
    <x-slot name="title">
        Approved Journals
    </x-slot>
    <div class="row gy-4">
        <div class="col-lg-12">
            <!-- Table Start -->
            <div class="card mt-24 overflow-hidden">
                <div class="card-header">
                    <div class="mb-0 flex-between flex-wrap gap-8">
                        <h4 class="mb-0">All Declined Journals</h4>
                        <a href=""
                            class="text-13 fw-medium text-main-600 hover-text-decoration-underline">See All</a>
                    </div>
                </div>
                <div class="card-body p-0 overflow-x-auto scroll-sm scroll-sm-horizontal">
                    <table class="table style-two mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Progress</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($journals as $journal)
                                <tr>
                                    <td>
                                        <div class="flex-align gap-8">
                                            <div class="w-40 h-40 rounded-circle bg-main-600 flex-center flex-shrink-0">
                                                <img src="assets/images/icons/course-name-icon1.png" alt="">
                                            </div>
                                            <div class="">
                                                <h6 class="mb-0">{{ $journal->title }}</h6>
                                                <div class="table-list">
                                                    <span class="text-13 text-gray-600">{{ $journal->author }}</span>
                                                    <span class="text-13 text-gray-600">{{ $journal->created_at->format('d F Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex-align gap-8 mt-12">
                                            <div class="progress w-100px  bg-main-100 rounded-pill h-4"
                                                role="progressbar" aria-label="Basic example" aria-valuenow="32"
                                                aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar bg-main-600 rounded-pill" style="width: 100%">
                                                </div>
                                            </div>
                                            <span class="text-main-600 flex-shrink-0 text-13 fw-medium">100%</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex-align justify-content-center gap-16">
                                            <span class="text-13 py-2 px-8 bg-green-50 text-success-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                                <span class="w-6 h-6 bg-green-600 rounded-circle flex-shrink-0"></span>
                                                Declined
                                            </span>
                                            <a href="{{ route('editor.journals.preview', [$journal->uuid, $journal->slug]) }}"
                                                class="text-gray-900 hover-text-main-600 text-md d-flex">
                                                <i class="ph ph-caret-right"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <p class="mt-2 text-gray-500 dark:text-neutral-400">
                                            No declined journals at the moment
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Table End -->

        </div>
    </div>
</x-layouts.editor_layout>
