<x-layouts.editor_layout>
    <x-slot name="title">
        Approved for Copy Editing
    </x-slot>
    <div class="row gy-4">
        <div class="col-lg-12">
            <!-- Table Start -->
            <div class="card mt-24 overflow-hidden">
                <div class="card-header">
                    <div class="mb-0 flex-between flex-wrap gap-8">
                        <h4 class="mb-0">Manuscripts Approved for Copy Editing</h4>
                        <span class="text-13 fw-medium text-emerald-600">{{ $journals->count() }} Total</span>
                    </div>
                </div>
                <div class="card-body p-0 overflow-x-auto scroll-sm scroll-sm-horizontal">
                    <table class="table style-two mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Approval Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($journals as $journal)
                                <tr>
                                    <td>
                                        <div class="flex-align gap-8">
                                            <div class="w-40 h-40 rounded-circle bg-emerald-600 flex-center flex-shrink-0">
                                                <i class="ph ph-check-circle text-white text-xl"></i>
                                            </div>
                                            <div class="">
                                                <h6 class="mb-0">{{ Str::limit($journal->title, 60) }}</h6>
                                                <div class="table-list">
                                                    <span class="text-13 text-gray-600">Submitted: {{ $journal->created_at->format('M j, Y') }}</span>
                                                    @if($journal->managing_editor_notice_sent_at)
                                                        <span class="text-13 text-emerald-600">Approved: {{ $journal->managing_editor_notice_sent_at->format('M j, Y') }}</span>
                                                    @endif
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
                                        @if($journal->managing_editor_notice_sent_at)
                                            <div>
                                                <span class="text-14 fw-medium">{{ $journal->managing_editor_notice_sent_at->format('M j, Y') }}</span>
                                                <div class="text-13 text-gray-600">{{ $journal->managing_editor_notice_sent_at->format('g:i A') }}</div>
                                            </div>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-emerald-100 text-emerald-800 px-8 py-4 text-13 fw-medium">
                                            {{ $journal->status_label }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="flex-align justify-content-center gap-8">
                                            <a href="{{ route('editor.journals.preview', [$journal->uuid, $journal->slug]) }}" 
                                               class="action-btn action-btn-outline-primary action-btn-sm">
                                                <i class="ph ph-eye me-4"></i>View Details
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-center py-40">
                                            <i class="ph ph-check-circle text-gray-400 text-64 mb-16"></i>
                                            <h6 class="text-gray-600 mb-8">No Manuscripts Approved for Copy Editing</h6>
                                            <p class="text-gray-500">Manuscripts approved for copy editing will appear here.</p>
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
