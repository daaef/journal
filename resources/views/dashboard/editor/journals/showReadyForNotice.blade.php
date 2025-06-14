<x-layouts.editor_layout>
    <x-slot name="title">
        Ready for Notice
    </x-slot>
    <div class="row gy-4">
        <div class="col-lg-12">
            <!-- Table Start -->
            <div class="card mt-24 overflow-hidden">
                <div class="card-header">
                    <div class="mb-0 flex-between flex-wrap gap-8">
                        <h4 class="mb-0">Manuscripts Ready for Managing Editor Notice</h4>
                        <div class="text-sm text-gray-600">
                            {{ $journals->count() }} manuscript(s) completed peer review and require Managing Editor notice
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 overflow-x-auto scroll-sm scroll-sm-horizontal">
                    <table class="table style-two mb-0">
                        <thead>
                            <tr>
                                <th>Manuscript Details</th>
                                <th>Peer Review Summary</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($journals as $journal)
                                @php
                                    $completedReviews = $journal->reviewerAssignments->where('review_submitted_at', '!=', null)->count();
                                    $approvedReviews = $journal->reviewerAssignments->where('recommendation', 'accept')->count();
                                    $rejectedReviews = $journal->reviewerAssignments->whereIn('recommendation', ['reject'])->count();
                                    $revisionReviews = $journal->reviewerAssignments->whereIn('recommendation', ['minor_revision', 'major_revision'])->count();
                                @endphp
                                <tr>
                                    <td>
                                        <div class="flex-align gap-8">
                                            <div class="w-40 h-40 rounded-circle bg-main-600 flex-center flex-shrink-0">
                                                <i class="ph ph-file-text text-white"></i>
                                            </div>
                                            <div class="">
                                                <h6 class="mb-0">{{ $journal->title }}</h6>
                                                <div class="table-list">
                                                    <span class="text-13 text-gray-600">{{ $journal->author }}</span>
                                                    <span class="text-13 text-gray-600">{{ $journal->created_at->format('d F Y') }}</span>
                                                </div>
                                                @if($journal->category)
                                                    <span class="text-11 text-gray-500">{{ $journal->category->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mb-2">
                                            <small class="text-muted">Total Reviews: {{ $completedReviews }}</small>
                                        </div>
                                        <div class="d-flex flex-wrap gap-1 mb-2">
                                            @if($approvedReviews > 0)
                                                <span class="badge bg-success">{{ $approvedReviews }} Accept</span>
                                            @endif
                                            @if($rejectedReviews > 0)
                                                <span class="badge bg-danger">{{ $rejectedReviews }} Reject</span>
                                            @endif
                                            @if($revisionReviews > 0)
                                                <span class="badge bg-warning">{{ $revisionReviews }} Revision</span>
                                            @endif
                                        </div>
                                        <div class="text-11 text-gray-500">
                                            Peer review completed on {{ $journal->updated_at->format('M j, Y') }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info text-white">
                                            Ready for Notice
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-main dropdown-toggle" type="button" 
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('editor.journals.preview', [$journal->uuid, $journal->slug]) }}">
                                                        <i class="ph ph-eye me-2"></i>Review Details
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-success" 
                                                            onclick="openApprovalModal('{{ $journal->uuid }}', '{{ $journal->title }}')">
                                                        <i class="ph ph-check-circle me-2"></i>Send Approval Notice
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-danger" 
                                                            onclick="openDeclineModal('{{ $journal->uuid }}', '{{ $journal->title }}')">
                                                        <i class="ph ph-x-circle me-2"></i>Send Decline Notice
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="text-center py-5">
                                            <i class="ph ph-clipboard-text text-gray-400" style="font-size: 3rem;"></i>
                                            <p class="mt-2 text-gray-500 dark:text-neutral-400 mb-0">
                                                No manuscripts ready for notice at the moment
                                            </p>
                                            <p class="text-sm text-gray-400">
                                                Manuscripts will appear here once peer review is completed
                                            </p>
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

    <!-- Approval Notice Modal -->
    <div class="modal fade" id="approvalNoticeModal" tabindex="-1" aria-labelledby="approvalNoticeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approvalNoticeModalLabel">Send Approval Notice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('editor.journals.sendApprovalNotice') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="journal_uuid" id="approval_journal_uuid" />
                        
                        <div class="mb-3">
                            <p class="fw-semibold">Manuscript: <span id="approval_manuscript_title"></span></p>
                            <p class="text-muted">
                                You are about to send an approval notice to the author, with copies to the Editor-in-Chief and Desk Editor.
                                The manuscript will proceed to copy editing stage.
                            </p>
                        </div>

                        <div class="mb-3">
                            <label for="notice_comment" class="form-label">Comments to Author (Optional)</label>
                            <textarea name="notice_comment" id="notice_comment" class="form-control" rows="4"
                                      placeholder="Add any comments for the author about the approval..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Send Approval Notice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Decline Notice Modal -->
    <div class="modal fade" id="declineNoticeModal" tabindex="-1" aria-labelledby="declineNoticeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="declineNoticeModalLabel">Send Decline Notice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('editor.journals.sendDeclineNotice') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="journal_uuid" id="decline_journal_uuid" />
                        
                        <div class="mb-3">
                            <p class="fw-semibold">Manuscript: <span id="decline_manuscript_title"></span></p>
                            <p class="text-muted">
                                You are about to send a decline notice to the author, with copies to the Editor-in-Chief and Desk Editor.
                                This action cannot be undone.
                            </p>
                        </div>

                        <div class="mb-3">
                            <label for="decline_reason" class="form-label">Reason for Decline <span class="text-danger">*</span></label>
                            <textarea name="decline_reason" id="decline_reason" class="form-control" rows="4"
                                      placeholder="Provide a clear reason for declining the manuscript..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Send Decline Notice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openApprovalModal(journalUuid, manuscriptTitle) {
            document.getElementById('approval_journal_uuid').value = journalUuid;
            document.getElementById('approval_manuscript_title').textContent = manuscriptTitle;
            
            const modal = new bootstrap.Modal(document.getElementById('approvalNoticeModal'));
            modal.show();
        }

        function openDeclineModal(journalUuid, manuscriptTitle) {
            document.getElementById('decline_journal_uuid').value = journalUuid;
            document.getElementById('decline_manuscript_title').textContent = manuscriptTitle;
            
            const modal = new bootstrap.Modal(document.getElementById('declineNoticeModal'));
            modal.show();
        }
    </script>
</x-layouts.editor_layout>
