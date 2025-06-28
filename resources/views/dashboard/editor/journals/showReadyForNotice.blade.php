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
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="table-layout: fixed; width: 100%;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 35%;">Manuscript Details</th>
                                    <th style="width: 25%;">Peer Review Summary</th>
                                    <th style="width: 15%;" class="text-center">Status</th>
                                    <th style="width: 25%;" class="text-center">Actions</th>
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
                                    <td style="width: 35%; word-wrap: break-word; overflow: hidden;">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="flex-shrink-0">
                                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="ph ph-file-text text-white"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 min-w-0">
                                                <h6 class="mb-1">
                                                    <a href="{{ route('editor.journals.preview', [$journal->uuid, $journal->slug]) }}" 
                                                       class="text-decoration-none text-primary fw-bold text-truncate d-block">
                                                        {{ Str::limit($journal->title, 50) }}
                                                    </a>
                                                </h6>
                                                <div class="text-muted small">
                                                    <div class="text-truncate">{{ $journal->author }}</div>
                                                    <div>{{ $journal->created_at->format('M j, Y') }}</div>
                                                </div>
                                                @if($journal->category)
                                                    <span class="badge bg-light text-dark small">{{ $journal->category->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td style="width: 25%; word-wrap: break-word;">
                                        <div class="small">
                                            <div class="mb-2">
                                                <strong>Total Reviews:</strong> {{ $completedReviews }}
                                            </div>
                                            <div class="d-flex flex-wrap gap-1 mb-2">
                                                @if($approvedReviews > 0)
                                                    <span class="badge bg-success small">{{ $approvedReviews }} Accept</span>
                                                @endif
                                                @if($rejectedReviews > 0)
                                                    <span class="badge bg-danger small">{{ $rejectedReviews }} Reject</span>
                                                @endif
                                                @if($revisionReviews > 0)
                                                    <span class="badge bg-warning small">{{ $revisionReviews }} Revision</span>
                                                @endif
                                            </div>
                                            <div class="text-muted">
                                                Completed: {{ $journal->updated_at->format('M j, Y') }}
                                            </div>
                                        </div>
                                    </td>
                                    <td style="width: 15%;" class="text-center">
                                        <span class="badge bg-info text-white small">
                                            Ready for Notice
                                        </span>
                                    </td>                    <td style="width: 25%;" class="text-center">
                        <div class="d-flex flex-column gap-1">
                            <!-- Direct Review Link -->
                            <a href="{{ route('editor.journals.preview', [$journal->uuid, $journal->slug]) }}" 
                               class="btn btn-sm btn-primary">
                                <i class="ph ph-eye me-1"></i>Review
                            </a>
                            
                            <!-- Direct Action Buttons -->
                            <div class="d-flex gap-1">
                                <button type="button" class="btn btn-sm btn-success flex-fill" 
                                        onclick="showApprovalForm('{{ $journal->uuid }}', '{{ $journal->title }}')">
                                    <i class="ph ph-check-circle me-1"></i>Approve
                                </button>
                                <button type="button" class="btn btn-sm btn-danger flex-fill" 
                                        onclick="showDeclineForm('{{ $journal->uuid }}', '{{ $journal->title }}')">
                                    <i class="ph ph-x-circle me-1"></i>Decline
                                </button>
                            </div>
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
    <div class="modal fade z-[8000]" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
        <div class="modal-dialog h-screen flex items-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approvalModalLabel">
                        <i class="ph ph-check-circle text-success me-2"></i>Approve Manuscript
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
                            <i class="ph ph-check-circle me-2"></i>Approve
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Decline Notice Modal -->
    <div class="modal fade z-[8000]" id="declineModal" tabindex="-1" aria-labelledby="declineModalLabel" aria-hidden="true">
        <div class="modal-dialog h-screen flex items-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="declineModalLabel">
                        <i class="ph ph-x-circle text-danger me-2"></i>Decline Manuscript
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
                            <i class="ph ph-x-circle me-2"></i>Decline
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

    <style>
        /* Fix table width issues */
        .table-responsive {
            max-width: 100%;
            overflow-x: auto;
        }
        
        .table {
            table-layout: fixed !important;
            width: 100% !important;
            max-width: 100% !important;
        }
        
        .table td,
        .table th {
            word-wrap: break-word !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }
        
        /* Ensure content doesn't overflow */
        .min-w-0 {
            min-width: 0;
        }
        
        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .table td,
            .table th {
                padding: 0.5rem !important;
            }
            
            .d-flex.flex-column {
                gap: 0.25rem !important;
            }
        }
        
        /* Action buttons styling */
        .btn-sm {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        
        .d-flex.gap-1 {
            gap: 0.25rem !important;
        }
        
        .flex-fill {
            flex: 1 1 auto;
        }
    </style>
</x-layouts.editor_layout>
