<x-layouts.editor_layout>
    <x-slot name="title">
        Revision Requested
    </x-slot>
    <div class="row gy-4">
        <div class="col-lg-12">
            <!-- Table Start -->
            <div class="card mt-24 overflow-hidden">
                <div class="card-header">
                    <div class="mb-0 flex-between flex-wrap gap-8">
                        <h4 class="mb-0">Manuscripts with Revision Requested</h4>
                        <span class="text-13 fw-medium text-orange-600">{{ $journals->count() }} Total</span>
                    </div>
                </div>
                <div class="card-body p-0 overflow-x-auto scroll-sm scroll-sm-horizontal">
                    <table class="table style-two mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Request Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($journals as $journal)
                                <tr>
                                    <td>
                                        <div class="flex-align gap-8">
                                            <div class="w-40 h-40 rounded-circle bg-orange-600 flex-center flex-shrink-0">
                                                <i class="ph ph-clock text-white text-xl"></i>
                                            </div>
                                            <div class="">
                                                <h6 class="mb-0">{{ Str::limit($journal->title, 60) }}</h6>
                                                <div class="table-list">
                                                    <span class="text-13 text-gray-600">Submitted: {{ $journal->created_at->format('M j, Y') }}</span>
                                                    <span class="text-13 text-gray-600">Updated: {{ $journal->updated_at->format('M j, Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0 text-14">{{ $journal->author }}</h6>
                                            @if($journal->user)
                                                <span class="text-13 text-gray-600">{{ $journal->user->email }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="text-14 fw-medium">{{ $journal->updated_at->format('M j, Y') }}</span>
                                            <div class="text-13 text-gray-600">{{ $journal->updated_at->format('g:i A') }}</div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-orange-100 text-orange-800 px-8 py-4 text-13 fw-medium">
                                            {{ $journal->status_label }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="flex-align justify-content-center gap-8">
                                            <a href="{{ route('editor.journals.preview', [$journal->uuid, $journal->slug]) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="ph ph-eye me-4"></i>View Details
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-center py-40">
                                            <i class="ph ph-clock text-gray-400 text-64 mb-16"></i>
                                            <h6 class="text-gray-600 mb-8">No Manuscripts with Revision Requested</h6>
                                            <p class="text-gray-500">Manuscripts requiring revisions will appear here.</p>
                                        </div>
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
