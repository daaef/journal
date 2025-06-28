<x-layouts.editor_layout>
    <x-slot name="title">
        Approved Manuscripts
    </x-slot>
    <div class="row gy-4">
        <div class="col-lg-12">
            <!-- Table Start -->
            <div class="card mt-24 overflow-hidden">
                <div class="card-header">
                    <div class="mb-0 flex-between flex-wrap gap-8">
                        <h4 class="mb-0">Reviewed Manuscripts - Awaiting Editorial Decision</h4>
                        <div class="text-sm text-gray-600">
                            {{ $journals->count() }} manuscript(s) completed review process and require final editorial decision
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 overflow-x-auto scroll-sm scroll-sm-horizontal">
                    <table class="table style-two mb-0">
                        <thead>
                            <tr>
                                <th>Manuscript Details</th>
                                <th>Review Summary</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($journals as $journal)
                                <tr>
                                    <td>
                                        <div class="flex-align gap-8">
                                            <div class="w-40 h-40 rounded-circle bg-main-600 flex-center flex-shrink-0">
                                                <i class="ph ph-file-text text-white"></i>
                                            </div>
                                            <div class="">
                                                <h6 class="mb-0">{{ Str::limit($journal->title, 60) }}</h6>
                                                <div class="table-list">
                                                    <span class="text-13 text-gray-600">{{ $journal->author }}</span>
                                                    <span class="text-13 text-gray-600">{{ $journal->created_at->format('d M Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-13">
                                            @if($journal->reviewers_ratings && is_array($journal->reviewers_ratings))
                                                <div class="mb-1">
                                                    <span class="fw-medium">{{ count($journal->reviewers_ratings) }} reviewer(s)</span>
                                                </div>
                                                @if($journal->rating_percentage)
                                                    <div class="flex-align gap-4 mb-1">
                                                        <span class="text-gray-600">Rating:</span>
                                                        <span class="fw-medium text-main-600">{{ number_format($journal->rating_percentage, 1) }}%</span>
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-gray-500">Review data unavailable</span>
                                            @endif
                                            <div class="text-12 text-gray-500">
                                                Completed: {{ $journal->updated_at->format('d M Y') }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @php
                                                $completedReviews = $journal->reviewerAssignments ? $journal->reviewerAssignments->whereNotNull('review_submitted_at')->count() : 0;
                                                $canDecide = $completedReviews >= 2;
                                            @endphp
                                            <span class="text-13 py-2 px-8 {{ $canDecide ? 'bg-green-50 text-green-600' : 'bg-yellow-50 text-yellow-600' }} d-inline-flex align-items-center gap-8 rounded-pill">
                                                <span class="w-6 h-6 {{ $canDecide ? 'bg-green-600' : 'bg-yellow-600' }} rounded-circle flex-shrink-0"></span>
                                                {{ $canDecide ? 'Ready for Decision' : 'Awaiting More Reviews' }}
                                            </span>
                                            <div class="text-12 text-gray-500 mt-1">
                                                {{ $completedReviews }}/2 reviews completed
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex-align justify-content-center gap-8">
                                            <!-- Quick Actions -->
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-main dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('editor.journals.preview', [$journal->uuid, $journal->slug]) }}">
                                                            <i class="ph ph-eye me-2"></i>Review & Decide
                                                        </a>
                                                    </li>
                                                    @if($completedReviews >= 2)
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form method="post" action="{{ route('editor.journals.approveForPublication') }}" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="journal_uuid" value="{{ $journal->uuid }}" />
                                                                <button type="submit" class="dropdown-item text-success"
                                                                        onclick="return confirm('Are you sure you want to approve this manuscript for publication?')">
                                                                    <i class="ph ph-check-circle me-2"></i>Approve for Publication
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-warning" href="#" onclick="openRevisionModal('{{ $journal->uuid }}')">
                                                                <i class="ph ph-note-pencil me-2"></i>Request Revisions
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-danger" href="#" onclick="openRejectModal('{{ $journal->uuid }}')">
                                                                <i class="ph ph-x-circle me-2"></i>Reject Manuscript
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li class="dropdown-item-text text-muted small">
                                                            <i class="ph ph-info me-2"></i>Need {{ 2 - $completedReviews }} more review(s)
                                                        </li>
                                                    @endif
                                                </ul>
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
                                                No manuscripts awaiting editorial decision at the moment
                                            </p>
                                            <p class="text-sm text-gray-400">
                                                Manuscripts will appear here once the review process is completed
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

    <!-- Reject Manuscript Modal -->
    <div id="rejectModal" class="modal fade" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger-subtle">
                    <h5 class="modal-title text-danger" id="rejectModalLabel">
                        <i class="ph ph-x-circle me-2"></i>Reject Manuscript
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="rejectForm" method="POST" action="{{ route('editor.journals.rejectManuscript') }}">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="journal_uuid" id="rejectJournalUuid">
                        
                        <div class="alert alert-warning d-flex align-items-start">
                            <i class="ph ph-warning-circle me-2 mt-1"></i>
                            <div>
                                <strong>Important:</strong> This action will permanently reject the manuscript. 
                                Please provide detailed feedback to help the author understand the decision.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="rejectionReason" class="form-label fw-medium">
                                Rejection Reason <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="rejection_reason" id="rejectionReason" required>
                                <option value="">Select rejection reason...</option>
                                <option value="scope">Outside journal scope</option>
                                <option value="quality">Insufficient quality/rigor</option>
                                <option value="methodology">Methodological issues</option>
                                <option value="significance">Limited significance/impact</option>
                                <option value="plagiarism">Plagiarism concerns</option>
                                <option value="ethics">Ethical issues</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="rejectionComments" class="form-label fw-medium">
                                Detailed Comments <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" name="reason" id="rejectionComments" 
                                      rows="6" placeholder="Provide detailed feedback explaining the rejection decision..." required></textarea>
                            <div class="form-text">
                                <span id="rejectionCommentsCount">0</span>/1000 characters
                            </div>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="notify_author" id="notifyAuthorReject" checked>
                            <label class="form-check-label" for="notifyAuthorReject">
                                Send notification email to author
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="ph ph-x-circle me-2"></i>Reject Manuscript
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Request Revisions Modal -->
    <div id="revisionModal" class="modal fade" tabindex="-1" aria-labelledby="revisionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title text-warning-emphasis" id="revisionModalLabel">
                        <i class="ph ph-note-pencil me-2"></i>Request Revisions
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="revisionForm" method="POST" action="{{ route('editor.journals.requestRevisions') }}">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="journal_uuid" id="revisionJournalUuid">
                        
                        <div class="alert alert-info d-flex align-items-start">
                            <i class="ph ph-info me-2 mt-1"></i>
                            <div>
                                The author will be notified of the revision request and can resubmit their manuscript 
                                with the requested changes.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="revisionType" class="form-label fw-medium">
                                Revision Type <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="revision_type" id="revisionType" required>
                                <option value="">Select revision type...</option>
                                <option value="minor">Minor Revisions (2-4 weeks)</option>
                                <option value="major">Major Revisions (6-8 weeks)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="revisionComments" class="form-label fw-medium">
                                Revision Instructions <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" name="changes" id="revisionComments" 
                                      rows="6" placeholder="Provide clear instructions for the required revisions..." required></textarea>
                            <div class="form-text">
                                <span id="revisionCommentsCount">0</span>/2000 characters
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="revisionDeadline" class="form-label fw-medium">
                                Revision Deadline
                            </label>
                            <input type="date" class="form-control" name="revision_deadline" id="revisionDeadline">
                            <div class="form-text">Optional: Set a specific deadline for revisions</div>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="notify_author" id="notifyAuthorRevision" checked>
                            <label class="form-check-label" for="notifyAuthorRevision">
                                Send notification email to author
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="ph ph-note-pencil me-2"></i>Request Revisions
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function openRejectModal(journalUuid) {
            document.getElementById('rejectJournalUuid').value = journalUuid;
            const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            modal.show();
        }

        function openRevisionModal(journalUuid) {
            document.getElementById('revisionJournalUuid').value = journalUuid;
            const modal = new bootstrap.Modal(document.getElementById('revisionModal'));
            modal.show();
        }

        // Character counters
        document.addEventListener('DOMContentLoaded', function() {
            // Rejection comments counter
            const rejectionTextarea = document.getElementById('rejectionComments');
            const rejectionCounter = document.getElementById('rejectionCommentsCount');
            
            if (rejectionTextarea && rejectionCounter) {
                rejectionTextarea.addEventListener('input', function() {
                    const count = this.value.length;
                    rejectionCounter.textContent = count;
                    if (count > 1000) {
                        rejectionCounter.parentElement.classList.add('text-danger');
                    } else {
                        rejectionCounter.parentElement.classList.remove('text-danger');
                    }
                });
            }

            // Revision comments counter
            const revisionTextarea = document.getElementById('revisionComments');
            const revisionCounter = document.getElementById('revisionCommentsCount');
            
            if (revisionTextarea && revisionCounter) {
                revisionTextarea.addEventListener('input', function() {
                    const count = this.value.length;
                    revisionCounter.textContent = count;
                    if (count > 2000) {
                        revisionCounter.parentElement.classList.add('text-danger');
                    } else {
                        revisionCounter.parentElement.classList.remove('text-danger');
                    }
                });
            }

            // Set default revision deadline based on type
            const revisionTypeSelect = document.getElementById('revisionType');
            const revisionDeadlineInput = document.getElementById('revisionDeadline');
            
            if (revisionTypeSelect && revisionDeadlineInput) {
                revisionTypeSelect.addEventListener('change', function() {
                    const today = new Date();
                    let deadline = new Date(today);
                    
                    if (this.value === 'minor') {
                        deadline.setDate(today.getDate() + 28); // 4 weeks
                    } else if (this.value === 'major') {
                        deadline.setDate(today.getDate() + 56); // 8 weeks
                    }
                    
                    if (this.value) {
                        revisionDeadlineInput.value = deadline.toISOString().split('T')[0];
                    } else {
                        revisionDeadlineInput.value = '';
                    }
                });
            }

            // Form validation and submission
            document.getElementById('rejectForm').addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalHTML = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
                
                // Reset button after 10 seconds if form doesn't submit
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHTML;
                }, 10000);
            });

            document.getElementById('revisionForm').addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalHTML = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
                
                // Reset button after 10 seconds if form doesn't submit
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHTML;
                }, 10000);
            });
        });
    </script>
</x-layouts.editor_layout>
