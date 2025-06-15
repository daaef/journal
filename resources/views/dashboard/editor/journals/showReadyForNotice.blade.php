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
                                                            onclick="showApprovalForm('{{ $journal->uuid }}', '{{ $journal->title }}')">
                                                        <i class="ph ph-check-circle me-2"></i>Send Approval Notice
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-danger" 
                                                            onclick="showDeclineForm('{{ $journal->uuid }}', '{{ $journal->title }}')">
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
    <div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approvalModalLabel">
                        <i class="ph ph-check-circle text-success me-2"></i>Send Approval Notice
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="approvalForm" method="POST" action="{{ route('editor.journals.sendApprovalNotice') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="approval-journal-uuid" name="journal_uuid" value="">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Manuscript</label>
                            <p id="approval-manuscript-title" class="text-muted"></p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="approval-comment" class="form-label fw-semibold">Comments (Optional)</label>
                            <textarea name="comment" id="approval-comment" class="form-control" rows="4" 
                                      placeholder="Add any comments for the author regarding the approval..."></textarea>
                            <div class="form-text">This message will be sent to the author along with the approval notice.</div>
                        </div>
                        
                        <div class="alert alert-success">
                            <i class="ph ph-info me-2"></i>
                            <strong>This action will:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Approve the manuscript for publication</li>
                                <li>Send notification to the author</li>
                                <li>Notify Editor-in-Chief and other editors</li>
                                <li>Change manuscript status to "Approved"</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="ph ph-paper-plane me-2"></i>Send Approval Notice
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Decline Notice Modal -->
    <div class="modal fade" id="declineModal" tabindex="-1" aria-labelledby="declineModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="declineModalLabel">
                        <i class="ph ph-x-circle text-danger me-2"></i>Send Decline Notice
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="declineForm" method="POST" action="{{ route('editor.journals.sendDeclineNotice') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="decline-journal-uuid" name="journal_uuid" value="">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Manuscript</label>
                            <p id="decline-manuscript-title" class="text-muted"></p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="decline-reason" class="form-label fw-semibold">Reason for Decline <span class="text-danger">*</span></label>
                            <textarea name="reason" id="decline-reason" class="form-control" rows="4" 
                                      placeholder="Provide a clear reason for declining this manuscript..." required></textarea>
                            <div class="form-text">This message will be sent to the author explaining the decline decision.</div>
                        </div>
                        
                        <div class="alert alert-warning">
                            <i class="ph ph-warning me-2"></i>
                            <strong>This action will:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Decline the manuscript for publication</li>
                                <li>Send notification to the author with reason</li>
                                <li>Notify Editor-in-Chief and other editors</li>
                                <li>Change manuscript status to "Declined"</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="ph ph-paper-plane me-2"></i>Send Decline Notice
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showApprovalForm(journalUuid, journalTitle) {
            document.getElementById('approval-journal-uuid').value = journalUuid;
            document.getElementById('approval-manuscript-title').textContent = journalTitle;
            document.getElementById('approval-comment').value = '';
            
            const modal = new bootstrap.Modal(document.getElementById('approvalModal'));
            modal.show();
        }

        function showDeclineForm(journalUuid, journalTitle) {
            document.getElementById('decline-journal-uuid').value = journalUuid;
            document.getElementById('decline-manuscript-title').textContent = journalTitle;
            document.getElementById('decline-reason').value = '';
            
            const modal = new bootstrap.Modal(document.getElementById('declineModal'));
            modal.show();
        }
    </script>
</x-layouts.editor_layout>
