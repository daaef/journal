<x-layouts.editor_layout>
    <x-slot name="title">
        Ready for Notice
    </x-slot>
    
    <div class="row gy-4">
        <div class="col-lg-12">
            <!-- Header Section -->
            <div class="card mt-24">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-2">Manuscripts Ready for Managing Editor Notice</h4>
                            <p class="text-muted mb-0">
                                These manuscripts have completed peer review and require your approval or decline decision.
                            </p>
                        </div>
                        <div class="text-end">
                            <div class="h3 mb-0 text-primary">{{ $journals->count() }}</div>
                            <small class="text-muted">Total Manuscripts</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Review and Decision</h5>
                        <div class="d-flex gap-2">
                            <span class="badge bg-info text-white">
                                <i class="ph ph-check-circle me-1"></i>
                                Ready for Notice
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 30%;">Manuscript Details</th>
                                    <th style="width: 25%;">Peer Review Summary</th>
                                    <th style="width: 20%;">Author Information</th>
                                    <th style="width: 15%;" class="text-center">Status</th>
                                    <th style="width: 10%;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($journals as $journal)
                                    @php
                                        $completedReviews = $journal->reviewerAssignments->where('review_submitted_at', '!=', null)->count();
                                        $totalReviews = $journal->reviewerAssignments->count();
                                        $approvedReviews = $journal->reviewerAssignments->where('recommendation', 'accept')->count();
                                        $rejectedReviews = $journal->reviewerAssignments->whereIn('recommendation', ['reject'])->count();
                                        $revisionReviews = $journal->reviewerAssignments->whereIn('recommendation', ['minor_revision', 'major_revision'])->count();
                                    @endphp
                                    
                                    <tr>
                                        <!-- Manuscript Details -->
                                        <td>
                                            <div class="d-flex align-items-start gap-3">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                        <i class="ph ph-file-text text-white"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 min-w-0">
                                                    <h6 class="mb-1">
                                                        <a href="{{ route('editor.journals.preview', [$journal->uuid, $journal->slug]) }}" 
                                                           class="text-decoration-none text-primary fw-bold">
                                                            {{ Str::limit($journal->title, 80) }}
                                                        </a>
                                                    </h6>
                                                    <div class="text-muted small">
                                                        <div class="mb-1">
                                                            <i class="ph ph-calendar me-1"></i>
                                                            Submitted: {{ $journal->created_at->format('M j, Y') }}
                                                        </div>
                                                        @if($journal->category)
                                                            <span class="badge bg-light text-dark small">
                                                                {{ $journal->category->name }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Peer Review Summary -->
                                        <td>
                                            <div class="small">
                                                <div class="mb-2">
                                                    <strong class="text-primary">{{ $completedReviews }}/{{ $totalReviews }}</strong> reviews completed
                                                </div>
                                                
                                                @if($completedReviews > 0)
                                                    <div class="d-flex flex-wrap gap-1 mb-2">
                                                        @if($approvedReviews > 0)
                                                            <span class="badge bg-success small">
                                                                {{ $approvedReviews }} Accept
                                                            </span>
                                                        @endif
                                                        @if($rejectedReviews > 0)
                                                            <span class="badge bg-danger small">
                                                                {{ $rejectedReviews }} Reject
                                                            </span>
                                                        @endif
                                                        @if($revisionReviews > 0)
                                                            <span class="badge bg-warning small">
                                                                {{ $revisionReviews }} Revision
                                                            </span>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="text-muted">
                                                        <i class="ph ph-clock me-1"></i>
                                                        Completed: {{ $journal->updated_at->format('M j, Y') }}
                                                    </div>
                                                @else
                                                    <span class="text-muted">No reviews submitted yet</span>
                                                @endif
                                            </div>
                                        </td>
                                        
                                        <!-- Author Information -->
                                        <td>
                                            <div class="small">
                                                <div class="fw-medium mb-1">{{ $journal->author }}</div>
                                                @if($journal->user && $journal->user->email)
                                                    <div class="text-muted">
                                                        <i class="ph ph-envelope me-1"></i>
                                                        {{ $journal->user->email }}
                                                    </div>
                                                @endif
                                                @if($journal->user && $journal->user->country)
                                                    <div class="text-muted">
                                                        <i class="ph ph-map-pin me-1"></i>
                                                        {{ $journal->user->country }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        
                                        <!-- Status -->
                                        <td class="text-center">
                                            <span class="badge bg-info text-white px-3 py-2">
                                                <i class="ph ph-bell me-1"></i>
                                                Ready for Notice
                                            </span>
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td class="text-center">
                                            <div class="d-flex flex-column gap-2">
                                                <!-- Review Button -->
                                                <a href="{{ route('editor.journals.preview', [$journal->uuid, $journal->slug]) }}" 
                                                   class="action-btn action-btn-outline-primary action-btn-sm">
                                                    <i class="ph ph-eye me-4"></i>Review
                                                </a>
                                                
                                                <!-- Decision Buttons -->
                                                <div class="d-flex gap-1">
                                                    <button type="button" 
                                                            class="btn btn-sm btn-success flex-fill" 
                                                            onclick="showApprovalForm('{{ $journal->uuid }}', '{{ addslashes($journal->title) }}')"
                                                            title="Approve Manuscript">
                                                        <i class="ph ph-check-circle"></i>
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-danger flex-fill" 
                                                            onclick="showDeclineForm('{{ $journal->uuid }}', '{{ addslashes($journal->title) }}')"
                                                            title="Decline Manuscript">
                                                        <i class="ph ph-x-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-center">
                                                <div class="mb-3">
                                                    <i class="ph ph-clipboard-text text-muted" style="font-size: 3rem;"></i>
                                                </div>
                                                <h6 class="text-muted mb-2">No Manuscripts Ready for Notice</h6>
                                                <p class="text-muted small mb-0">
                                                    Manuscripts will appear here once they complete the peer review process.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approval Modal -->
    <div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approvalModalLabel">Approve Manuscript</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('editor.journals.sendApprovalNotice') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="journal_uuid" id="approvalJournalUuid">
                        <div class="mb-3">
                            <label for="approvalComment" class="form-label">Approval Comment (Optional)</label>
                            <textarea class="form-control" id="approvalComment" name="comment" rows="4" 
                                      placeholder="Add any comments for the author..."></textarea>
                        </div>
                        <div class="alert alert-info">
                            <i class="ph ph-info me-2"></i>
                            <strong>Manuscript:</strong> <span id="approvalManuscriptTitle"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="ph ph-check-circle me-1"></i>
                            Approve Manuscript
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Decline Modal -->
    <div class="modal fade" id="declineModal" tabindex="-1" aria-labelledby="declineModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="declineModalLabel">Decline Manuscript</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('editor.journals.sendDeclineNotice') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="journal_uuid" id="declineJournalUuid">
                        <div class="mb-3">
                            <label for="declineReason" class="form-label">Reason for Decline <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="declineReason" name="reason" rows="4" 
                                      placeholder="Please provide a detailed reason for declining this manuscript..." required></textarea>
                        </div>
                        <div class="alert alert-warning">
                            <i class="ph ph-warning me-2"></i>
                            <strong>Manuscript:</strong> <span id="declineManuscriptTitle"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="ph ph-x-circle me-1"></i>
                            Decline Manuscript
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showApprovalForm(uuid, title) {
            document.getElementById('approvalJournalUuid').value = uuid;
            document.getElementById('approvalManuscriptTitle').textContent = title;
            new bootstrap.Modal(document.getElementById('approvalModal')).show();
        }

        function showDeclineForm(uuid, title) {
            document.getElementById('declineJournalUuid').value = uuid;
            document.getElementById('declineManuscriptTitle').textContent = title;
            new bootstrap.Modal(document.getElementById('declineModal')).show();
        }
    </script>
</x-layouts.editor_layout>
