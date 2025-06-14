<x-layouts.editor_layout>
    <div class="breadcrumb mb-24">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('editor.dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">Preview Journal: {{ $journal->title }}</span></li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-md-9">
            <!-- Course Card Start -->
            <div class="card">
                <div class="card-body p-lg-20 p-sm-3">
                    <div class="flex-between flex-wrap gap-12 mb-20">
                        <div>
                            <h3 class="mb-4">{{ $journal->title }}</h3>
                            <p class="text-gray-600 text-15"> Author {{ $journal->author }}</p>
                        </div>

                        <div class="flex-align flex-wrap gap-24">
                            <span class="py-6 px-16 bg-main-50 text-main-600 rounded-pill text-15">Category:
                                {{ $journal->category->name }}</span>
                            <div class=" share-social position-relative">
                                <button type="button"
                                    class="share-social__button text-gray-200 text-26 d-flex hover-text-main-600"><i
                                        class="ph ph-share-network"></i></button>
                                <div
                                    class="share-social__icons bg-white box-shadow-2xl p-16 border border-gray-100 rounded-8 position-absolute inset-block-start-100 inset-inline-end-0">
                                    <ul class="flex-align gap-8">
                                        <li>
                                            <a href="https://www.facebook.com"
                                                class="flex-center w-36 h-36 border border-main-600 text-white rounded-circle text-xl bg-main-600 hover-bg-main-800 hover-border-main-800"><i
                                                    class="ph ph-facebook-logo"></i></a>
                                        </li>
                                        <li>
                                            <a href="https://www.google.com"
                                                class="flex-center w-36 h-36 border border-main-600 text-white rounded-circle text-xl bg-main-600 hover-bg-main-800 hover-border-main-800">
                                                <i class="ph ph-twitter-logo"></i></a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com"
                                                class="flex-center w-36 h-36 border border-main-600 text-white rounded-circle text-xl bg-main-600 hover-bg-main-800 hover-border-main-800"><i
                                                    class="ph ph-linkedin-logo"></i></a>
                                        </li>
                                        <li>
                                            <a href="https://www.instagram.com"
                                                class="flex-center w-36 h-36 border border-main-600 text-white rounded-circle text-xl bg-main-600 hover-bg-main-800 hover-border-main-800"><i
                                                    class="ph ph-instagram-logo"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>



                    <div class="mt-24">
                        <div class="mb-24 pb-24 border-bottom border-gray-100">
                            <h5 class="mb-12 fw-bold">Abstract</h5>
                            <p class="text-gray-300 text-15">{!! $journal->abstract !!}</p>
                        </div>
                        <div class="mb-24 pb-24 border-bottom border-gray-100">
                            <h5 class="mb-12 fw-bold">Manuscript</h5>
                            
                            <!-- Document Reader -->
                            <div class="card border-2 border-blue-200">
                                <div class="card-header bg-blue-50 border-bottom border-blue-200">
                                    <div class="flex-between">
                                        <div>
                                            <h6 class="mb-0 text-blue-800 fw-bold">
                                                <i class="ph ph-file-pdf me-8"></i>Manuscript Document Reader
                                            </h6>
                                            <small class="text-blue-600">Review the manuscript directly in your browser</small>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="button" onclick="openEditorFullscreen()" 
                                                    class="btn btn-sm btn-outline-primary rounded"
                                                    title="Open in fullscreen">
                                                <i class="ph ph-corners-out"></i>
                                            </button>
                                            <button type="button" onclick="resizeEditorViewer('expand')" 
                                                    class="btn btn-sm btn-outline-primary rounded"
                                                    title="Expand viewer">
                                                <i class="ph ph-arrows-out"></i>
                                            </button>
                                            <button type="button" onclick="resizeEditorViewer('shrink')" 
                                                    class="btn btn-sm btn-outline-primary rounded"
                                                    title="Shrink viewer">
                                                <i class="ph ph-arrows-in"></i>
                                            </button>
                                            <a href="{{ asset('storage/' . $journal->journal_url) }}" target="_blank"
                                               class="btn btn-sm btn-outline-success rounded"
                                               title="Open in new tab">
                                                <i class="ph ph-arrow-square-out"></i>
                                            </a>
                                            <a href="{{ asset('storage/' . $journal->journal_url) }}" download
                                               class="btn btn-sm btn-outline-info rounded"
                                               title="Download PDF">
                                                <i class="ph ph-download-simple"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="bg-gray-100 px-16 py-8 border-bottom d-flex justify-content-between align-items-center">
                                        <small class="text-gray-600">
                                            <i class="ph ph-lightbulb me-4"></i>
                                            <strong>Tip:</strong> Use Ctrl+F to search within the document
                                        </small>
                                        <small class="text-gray-500">
                                            <i class="ph ph-info me-4"></i>
                                            File: {{ basename($journal->journal_url) }}
                                        </small>
                                    </div>
                                    
                                    <!-- PDF Viewer -->
                                    <iframe id="editorPdfViewer" 
                                            src="{{ asset('storage/' . $journal->journal_url) }}#toolbar=1&navpanes=1&scrollbar=1" 
                                            style="width: 100%; height: 600px; border: none; background: #f8f9fa;"
                                            loading="lazy"
                                            title="Manuscript PDF Viewer">
                                        <div class="p-24 text-center">
                                            <div class="alert alert-warning">
                                                <i class="ph ph-warning-circle me-8"></i>
                                                <strong>PDF Preview Not Available</strong>
                                                <p class="mb-16">Your browser does not support embedded PDFs.</p>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <a href="{{ asset('storage/' . $journal->journal_url) }}" target="_blank" 
                                                       class="btn btn-primary">
                                                        <i class="ph ph-arrow-square-out me-8"></i>Open in New Tab
                                                    </a>
                                                    <a href="{{ asset('storage/' . $journal->journal_url) }}" download
                                                       class="btn btn-success">
                                                        <i class="ph ph-download-simple me-8"></i>Download PDF
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </iframe>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <h5 class="mb-12 fw-bold">Author(s)</h5>
                            <div class="flex-align gap-8">
                                {{-- <img src="assets/images/thumbs/mentor-img1.png" alt="" class="w-44 h-44 rounded-circle object-fit-cover flex-shrink-0"> --}}
                                <div class="d-flex flex-column">
                                    <h6 class="text-15 fw-bold mb-0">{{ $journal->author }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Course Card End -->
        </div>

        <div class="col-md-3">
            <!-- Community Groups card Start -->
            @if (auth()->user()->hasRole('Editor in Chief') || auth()->user()->hasRole('Managing Editor'))
                <div class="card">
                    <div class="card-body">
                        <div class="mb-20 flex-between flex-wrap gap-8">
                            <h5 class="mb-0">Add Associate Editors</h5>
                            <div id="reviewer-counter" class="badge bg-info">
                                Selected: <span id="selected-count">{{ $assignedReviewers->count() }}</span>/4
                            </div>
                        </div>

                        @if($assignedReviewers->count() >= 4)
                            <div class="alert alert-warning">
                                <i class="ph ph-warning-circle"></i> Maximum of 4 reviewers allowed. Remove some reviewers to add new ones.
                            </div>
                        @elseif($assignedReviewers->count() < 2)
                            <div class="alert alert-info">
                                <i class="ph ph-info"></i> Minimum of 2 reviewers required. {{ 2 - $assignedReviewers->count() }} more needed.
                            </div>
                        @endif

                        <form action="{{ route('editor.journals.reviewers.save', $journal->uuid) }}" method="post" id="reviewer-assignment-form">
                            @csrf
                            <div class="col">
                                <label for="reviewer" class="h6 mb-8 fw-semibold font-heading">Select Associate Editors
                                    <span class="text-13 text-gray-400 fw-medium">(2-4 Required)</span>
                                </label>
                                <div class="position-relative">
                                    <select id="reviewerSelect" class="form-select py-9 placeholder-13 text-15" {{ $assignedReviewers->count() >= 4 ? 'disabled' : '' }}>
                                        <option value="" disabled selected>
                                            {{ $assignedReviewers->count() >= 4 ? 'Maximum reviewers reached' : 'Select an Associate Editor' }}
                                        </option>
                                        @foreach ($reviewers as $reviewer)
                                            @if(!$assignedReviewers->contains('user_id', $reviewer->id))
                                                <option value="{{ $reviewer->uuid }}">{{ $reviewer->fullname }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="selectedReviewers" class="mt-4">
                                <!-- Pre-populate existing reviewers -->
                                @foreach($assignedReviewers as $reviewer)
                                    <div class="d-flex align-items-center justify-content-between gap-2 mb-2 p-3 border rounded" id="reviewer-{{ $reviewer->user->uuid }}">
                                        <span class="fw-medium">{{ $reviewer->user->fullname }}</span>
                                        <i class="ph ph-x text-danger" style="cursor: pointer;" onclick="removeReviewer('{{ $reviewer->user->uuid }}', '{{ $reviewer->user->fullname }}')" title="Remove reviewer"></i>
                                        <input type="hidden" name="reviewers[]" value="{{ $reviewer->user->uuid }}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="col">
                                <button type="submit" id="assign-btn" class="btn btn-main rounded-pill py-11 w-100 mt-16"
                                    {{ $assignedReviewers->count() < 2 ? 'disabled' : '' }}>
                                    @if($assignedReviewers->count() < 2)
                                        Need {{ 2 - $assignedReviewers->count() }} more reviewer(s)
                                    @else
                                        Save Associate Editor(s)
                                    @endif
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="card {{ auth()->user()->hasRole('Reviewer') ? ' ' : 'mt-24' }}">
                    <div class="card-body">
                        <div class="mb-20 flex-between flex-wrap gap-8">
                            <h5 class="mb-0">Associate Editors</h5>
                        </div>
                        <ul class="list-inside">
                            @forelse ($assignedReviewers as $assignedReviewer)
                                {{-- <li class="text-gray-600 mb-4"></li> --}}
                                <li class="flex-align gap-6 text-gray-300 text-15 mb-12">
                                    <span class="flex-shrink-0 text-22 d-flex text-main-600"><i class="ph ph-eye"></i>
                                    </span>
                                    {{ $assignedReviewer->fullname }}
                                </li>
                            @empty
                                <li class="flex-align gap-6 text-gray-300 text-15 mb-12">
                                    <span class="flex-shrink-0 text-22 d-flex text-main-600"><i
                                            class="ph ph-eye-closed"></i>
                                    </span>
                                    No Associate Editors assigned
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            @endif

            <div class="card mt-24">
                <div class="card-body">
                    <div class="mb-20 flex-between flex-wrap gap-8">
                        <h5 class="mb-0">Comments</h5>
                    </div>
                    <ul class="list-inside">
                        @forelse ($comments as $comment)
                            <li class="flex-align gap-6 text-gray-300 text-15 mb-12">
                                <span class="flex-shrink-0 text-22 d-flex text-main-600"><i class="ph ph-notepad"></i>
                                </span>
                                {{ $comment->comment }}
                            </li>
                        @empty
                            <li class="flex-align gap-6 text-gray-300 text-15 mb-12">
                                <span class="flex-shrink-0 text-22 d-flex text-main-600"><i class="ph ph-pen"></i>
                                </span>
                                No comments yet
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            @if (auth()->user()->hasRole('Reviewer'))
                <div class="card mt-24">
                    <div class="card-body">
                        {{-- <div class="mb-20 flex-between flex-wrap gap-8">
                            <h5 class="mb-0">Add Comments</h5>
                        </div> --}}
                        <div class="col-sm-12">
                            <form action="{{ route('reviewer.journals.approveJournalWithComment') }}" method="post">
                                @csrf
                                <label for="comment" class="h6 mb-8 fw-semibold font-heading">Add Comments<span
                                        class="text-13 text-gray-400 fw-medium">(Required)</span> </label>
                                <div class="position-relative">
                                    <textarea name="comment" class="text-counter placeholder-13 form-control py-11 pe-76" maxlength="1000"
                                        id="comment" rows="10"> </textarea>
                                    <div
                                        class="text-gray-400 position-absolute inset-inline-end-0 top-50 translate-middle-y me-16">
                                        <span id="current">0</span>
                                        <span id="maximum">/ 1000</span>
                                    </div>
                                </div>
                                <input type="hidden" name="journal_uuid" value="{{ $journal->uuid }}" />
                                <input type="hidden" name="reviewer_uuid" value="{{ auth()->user()->uuid }}" />

                                <button type="submit" class="btn btn-main rounded-pill py-11 w-100  mt-16">Save</button>
                            </form>

                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->hasRole('Editor in Chief') || auth()->user()->hasRole('Managing Editor'))
                <!-- Editor Decision Interface -->
                <div class="card mt-24">
                    <div class="card-body">
                        @if($journal->approval_status === 'reviewed')
                            <!-- Final Decision Interface for Reviewed Manuscripts -->
                            <h5 class="mb-20 fw-semibold">Final Editorial Decision</h5>
                            <p class="text-gray-600 mb-20">This manuscript has completed the review process. Please make your final decision:</p>

                            <!-- Decision Buttons -->
                            <div class="d-flex flex-column gap-3 mb-3">
                                <!-- Approve for Publication -->
                                <button type="button" class="btn btn-success rounded-pill py-11" onclick="showDecisionForm('approve')">
                                    <i class="ph ph-check-circle me-2"></i>Approve for Publication
                                </button>

                                <!-- Request Revisions -->
                                <button type="button" class="btn btn-warning rounded-pill py-11" onclick="showDecisionForm('revisions')">
                                    <i class="ph ph-note-pencil me-2"></i>Request Revisions
                                </button>

                                <!-- Reject Manuscript -->
                                <button type="button" class="btn btn-danger rounded-pill py-11" onclick="showDecisionForm('reject')">
                                    <i class="ph ph-x-circle me-2"></i>Reject Manuscript
                                </button>
                            </div>

                            <!-- Approve for Publication Form -->
                            <div id="approve-form" class="decision-form" style="display: none;">
                                <form method="post" action="{{ route('editor.journals.approveForPublication') }}">
                                    @csrf
                                    <input type="hidden" name="journal_uuid" value="{{ $journal->uuid }}" />

                                    <div class="mb-3">
                                        <label for="approve-comment" class="form-label fw-semibold">Comments (Optional)</label>
                                        <textarea name="comment" id="approve-comment" class="form-control" rows="4"
                                                  placeholder="Add any final comments for the author..."></textarea>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-success">Confirm Approval</button>
                                        <button type="button" class="btn btn-secondary" onclick="hideAllForms()">Cancel</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Request Revisions Form -->
                            <div id="revisions-form" class="decision-form" style="display: none;">
                                <form method="post" action="{{ route('editor.journals.requestRevisions') }}">
                                    @csrf
                                    <input type="hidden" name="journal_uuid" value="{{ $journal->uuid }}" />

                                    <div class="mb-3">
                                        <label for="revision-changes" class="form-label fw-semibold">Revision Requirements <span class="text-danger">*</span></label>
                                        <textarea name="changes" id="revision-changes" class="form-control" rows="6"
                                                  placeholder="Describe the specific changes or improvements needed..." required></textarea>
                                        <div class="form-text">Be specific about what changes are needed for the manuscript to be acceptable.</div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-warning">Send Revision Request</button>
                                        <button type="button" class="btn btn-secondary" onclick="hideAllForms()">Cancel</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Reject Manuscript Form -->
                            <div id="reject-form" class="decision-form" style="display: none;">
                                <form method="post" action="{{ route('editor.journals.rejectManuscript') }}">
                                    @csrf
                                    <input type="hidden" name="journal_uuid" value="{{ $journal->uuid }}" />

                                    <div class="mb-3">
                                        <label for="reject-reason" class="form-label fw-semibold">Rejection Reason <span class="text-danger">*</span></label>
                                        <textarea name="reason" id="reject-reason" class="form-control" rows="5"
                                                  placeholder="Provide a clear reason for rejection..." required></textarea>
                                        <div class="form-text">Explain why the manuscript cannot be accepted for publication.</div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-danger">Confirm Rejection</button>
                                        <button type="button" class="btn btn-secondary" onclick="hideAllForms()">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <!-- Status Information for Non-Reviewed Manuscripts -->
                            <div class="alert alert-info">
                                <h6 class="fw-semibold mb-3">
                                    <i class="ph ph-clock me-2"></i>Review Process Status
                                </h6>

                                @if($journal->approval_status === 'pending')
                                    <p class="mb-2">This manuscript is waiting for reviewer assignment.</p>
                                    @if($assignedReviewers->count() === 0)
                                        <p class="text-warning mb-0">
                                            <i class="ph ph-warning me-1"></i>
                                            <strong>Action Required:</strong> Please assign 2-4 Associate Editors above.
                                        </p>
                                    @else
                                        <p class="mb-0">
                                            <i class="ph ph-users me-1"></i>
                                            {{ $assignedReviewers->count() }} Associate Editor(s) assigned. Review process will begin once they accept invitations.
                                        </p>
                                    @endif

                                @elseif($journal->approval_status === 'in_progress')
                                    <p class="mb-2">This manuscript is currently under review.</p>

                                    @php
                                        $totalReviewers = $assignedReviewers->count();
                                        $completedReviews = $journal->comments()->where('comment_type', 'review')->count();
                                        $reviewProgress = $totalReviewers > 0 ? ($completedReviews / $totalReviewers) * 100 : 0;
                                    @endphp

                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small>Review Progress</small>
                                            <small>{{ $completedReviews }}/{{ $totalReviewers }} completed</small>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-primary" style="width: {{ $reviewProgress }}%"></div>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        @foreach($assignedReviewers as $reviewer)
                                            @php
                                                $hasReviewed = $journal->comments()->where('comment_type', 'review')->where('user_id', $reviewer->user->id)->exists();
                                            @endphp
                                            <div class="col-6">
                                                <div class="d-flex align-items-center p-2 border rounded-2">
                                                    <div class="flex-shrink-0 me-2">
                                                        @if($hasReviewed)
                                                            <i class="ph ph-check-circle text-success"></i>
                                                        @else
                                                            <i class="ph ph-clock text-warning"></i>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="text-13 fw-medium">{{ $reviewer->user->fullname }}</div>
                                                        <div class="text-11 text-gray-600">
                                                            @if($hasReviewed)
                                                                Review Complete
                                                            @else
                                                                Review Pending
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                @else
                                    <p class="mb-0">This manuscript requires review completion before editorial decisions can be made.</p>
                                @endif

                                <div class="mt-3 p-3 bg-light rounded-2">
                                    <p class="text-13 mb-0">
                                        <i class="ph ph-info me-1"></i>
                                        <strong>Note:</strong> Editorial decisions (approve, reject, request revisions) will be available once all assigned reviewers have completed their reviews.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <script>
                function showDecisionForm(formType) {
                    // Hide all forms first
                    hideAllForms();

                    // Show the selected form
                    const formId = formType + '-form';
                    document.getElementById(formId).style.display = 'block';
                }

                function hideAllForms() {
                    const forms = document.querySelectorAll('.decision-form');
                    forms.forEach(form => {
                        form.style.display = 'none';
                    });
                }
                </script>
            @endif
        </div>
    </div>
</x-layouts.editor_layout>
<script>
    // Global variables for tracking reviewer state
    let currentReviewerCount = {{ $assignedReviewers->count() }};
    const MIN_REVIEWERS = 2;
    const MAX_REVIEWERS = 4;

    function updateReviewerCounter() {
        const counterSpan = document.getElementById('selected-count');
        const assignButton = document.getElementById('assign-btn');
        const reviewerSelect = document.getElementById('reviewerSelect');
        const alerts = document.querySelectorAll('.alert');

        // Update counter
        counterSpan.textContent = currentReviewerCount;

        // Remove existing alerts
        alerts.forEach(alert => {
            if (alert.classList.contains('alert-warning') || alert.classList.contains('alert-info')) {
                alert.remove();
            }
        });

        // Handle max reviewers reached
        if (currentReviewerCount >= MAX_REVIEWERS) {
            reviewerSelect.disabled = true;
            reviewerSelect.innerHTML = '<option value="" disabled selected>Maximum reviewers reached</option>';

            // Show warning alert
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-warning';
            alertDiv.innerHTML = '<i class="ph ph-warning-circle"></i> Maximum of 4 reviewers allowed. Remove some reviewers to add new ones.';
            document.getElementById('reviewer-assignment-form').insertBefore(alertDiv, document.querySelector('.col'));
        } else {
            // Re-enable and repopulate select
            reviewerSelect.disabled = false;
            repopulateReviewerSelect();
        }

        // Handle minimum reviewers requirement
        if (currentReviewerCount < MIN_REVIEWERS) {
            assignButton.disabled = true;
            assignButton.textContent = `Need ${MIN_REVIEWERS - currentReviewerCount} more reviewer(s)`;

            // Show info alert
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-info';
            alertDiv.innerHTML = `<i class="ph ph-info"></i> Minimum of 2 reviewers required. ${MIN_REVIEWERS - currentReviewerCount} more needed.`;
            document.getElementById('reviewer-assignment-form').insertBefore(alertDiv, document.querySelector('.col'));
        } else {
            assignButton.disabled = false;
            assignButton.textContent = 'Save Associate Editor(s)';
        }
    }

    function repopulateReviewerSelect() {
        const reviewerSelect = document.getElementById('reviewerSelect');
        const selectedReviewerIds = Array.from(document.querySelectorAll('input[name="reviewers[]"]')).map(input => input.value);

        // Clear current options
        reviewerSelect.innerHTML = '<option value="" disabled selected>Select an Associate Editor</option>';

        // Get all available reviewers from the original data
        const availableReviewers = [
            @foreach ($reviewers as $reviewer)
                {
                    uuid: '{{ $reviewer->uuid }}',
                    name: '{{ addslashes($reviewer->fullname) }}'
                },
            @endforeach
        ];

        // Add options for reviewers that aren't selected
        availableReviewers.forEach(reviewer => {
            if (!selectedReviewerIds.includes(reviewer.uuid)) {
                const option = document.createElement('option');
                option.value = reviewer.uuid;
                option.textContent = reviewer.name;
                reviewerSelect.appendChild(option);
            }
        });
    }

    function addReviewer(reviewerId, reviewerName, selectedReviewerid) {
        // Check if already at maximum
        if (currentReviewerCount >= MAX_REVIEWERS) {
            alert('Maximum of 4 reviewers allowed!');
            return;
        }

        const selectedReviewersDiv = document.getElementById('selectedReviewers');
        const activeDiv = document.getElementById(`reviewer-${reviewerId}`);

        // Check if the reviewer is already selected
        if (activeDiv) {
            return; // Don't add if already exists
        }

        const reviewerDiv = document.createElement('div');
        reviewerDiv.className = 'd-flex align-items-center justify-content-between gap-2 mb-2 p-3 border rounded';
        reviewerDiv.id = `reviewer-${reviewerId}`;

        const reviewerNameSpan = document.createElement('span');
        reviewerNameSpan.textContent = reviewerName;
        reviewerNameSpan.className = 'fw-medium';

        const reviewerCheckbox = document.createElement('input');
        reviewerCheckbox.type = "hidden";
        reviewerCheckbox.name = "reviewers[]";
        reviewerCheckbox.value = selectedReviewerid;

        const removeButton = document.createElement('i');
        removeButton.className = 'ph ph-x text-danger cursor-pointer';
        removeButton.setAttribute('title', 'Remove reviewer');
        removeButton.style.cursor = 'pointer';
        removeButton.addEventListener('click', () => {
            removeReviewer(reviewerId, reviewerName);
        });

        reviewerDiv.appendChild(reviewerNameSpan);
        reviewerDiv.appendChild(removeButton);
        reviewerDiv.appendChild(reviewerCheckbox);
        selectedReviewersDiv.appendChild(reviewerDiv);

        // Update counter and UI state
        currentReviewerCount++;
        updateReviewerCounter();

        // Reset select dropdown
        document.getElementById('reviewerSelect').value = '';
    }

    function removeReviewer(reviewerId, reviewerName) {
        const reviewerDiv = document.getElementById(`reviewer-${reviewerId}`);
        if (reviewerDiv) {
            reviewerDiv.remove();
            currentReviewerCount--;
            updateReviewerCounter
        }
    }

    // Make removeReviewer function globally accessible for existing reviewers
    window.removeReviewer = removeReviewer;

    // Event listener for select dropdown
    const reviewerSelect = document.getElementById('reviewerSelect');
    reviewerSelect.addEventListener('change', () => {
        const selectedReviewerId = reviewerSelect.value;
        const selectedReviewerName = reviewerSelect.options[reviewerSelect.selectedIndex].text;
        const selectedReviewerid = reviewerSelect.options[reviewerSelect.selectedIndex].value;

        if (selectedReviewerId) {
            addReviewer(selectedReviewerId, selectedReviewerName, selectedReviewerid);
        }
    });

    // Form validation before submission
    document.getElementById('reviewer-assignment-form').addEventListener('submit', function(e) {
        if (currentReviewerCount < MIN_REVIEWERS) {
            e.preventDefault();
            alert(`Please select at least ${MIN_REVIEWERS} reviewers before submitting.`);
            return false;
        }

        if (currentReviewerCount > MAX_REVIEWERS) {
            e.preventDefault();
            alert(`Please select no more than ${MAX_REVIEWERS} reviewers.`);
            return false;
        }

        return true;
    });

    // Initialize UI state on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateReviewerCounter();
    });

    // Document viewer controls for editor
    window.openEditorFullscreen = function() {
        const viewer = document.getElementById('editorPdfViewer');
        if (!viewer) return;
        
        if (viewer.requestFullscreen) {
            viewer.requestFullscreen();
        } else if (viewer.webkitRequestFullscreen) { /* Safari */
            viewer.webkitRequestFullscreen();
        } else if (viewer.msRequestFullscreen) { /* IE11 */
            viewer.msRequestFullscreen();
        }
    };

    window.resizeEditorViewer = function(action) {
        const viewer = document.getElementById('editorPdfViewer');
        if (!viewer) return;
        
        const currentHeight = parseInt(viewer.style.height) || 600;
        
        if (action === 'expand' && currentHeight < 1000) {
            viewer.style.height = (currentHeight + 100) + 'px';
        } else if (action === 'shrink' && currentHeight > 400) {
            viewer.style.height = (currentHeight - 100) + 'px';
        }
    };
</script>
