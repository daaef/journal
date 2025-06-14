<x-layouts.reviewer_layout>
    <x-slot:title>
        Welcome to your Dashboard
    </x-slot:title>

    <div class="row gy-4">
        <div class="col-lg-9">


            <div class="row">
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">{{ $pendingJournals }}</h4>
                            <span class="text-gray-600">Pending Manuscripts</span>
                            <div class="flex-between gap-8 mt-16">
                                <span
                                    class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-main-600 text-white text-2xl"><i
                                        class="ph-fill ph-book-open"></i></span>
                                <div id="complete-course" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">{{ $reviewedJournals }}</h4>
                            <span class="text-gray-600">Reviewed Manuscripts</span>
                            <div class="flex-between gap-8 mt-16">
                                <span
                                    class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-info-600 text-white text-2xl"><i
                                        class="ph-fill ph-check-circle"></i></span>
                                <div id="reviewed-manuscripts" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">{{ $approvedJournals }}</h4>
                            <span class="text-gray-600">Approved Manuscripts</span>
                            <div class="flex-between gap-8 mt-16">
                                <span
                                    class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-main-two-600 text-white text-2xl"><i
                                        class="ph-fill ph-certificate"></i></span>
                                <div id="earned-certificate" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">{{ $journalsInProgress }}</h4>
                            <span class="text-gray-600">Manuscripts in Progress</span>
                            <div class="flex-between gap-8 mt-16">
                                <span
                                    class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-purple-600 text-white text-2xl">
                                    <i class="ph-fill ph-graduation-cap"></i></span>
                                <div id="course-progress" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-16">
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">{{ $declinedJournals }}</h4>
                            <span class="text-gray-600">Declined Manuscripts</span>
                            <div class="flex-between gap-8 mt-16">
                                <span
                                    class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-warning-600 text-white text-2xl"><i
                                        class="ph-fill ph-users-three"></i></span>
                                <div id="community-support" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-24">
                <div class="card-body">
                    <div class="mb-20 flex-between flex-wrap gap-8">
                        <h4 class="mb-0">Journals Assigned to you</h4>
                        <div class="flex-align gap-8">
                            <button class="btn btn-main btn-sm rounded-pill filter-btn active" data-filter="all" onclick="filterJournals('all')">
                                <i class="ph ph-list me-8"></i>All
                            </button>
                            <button class="btn btn-outline-warning btn-sm rounded-pill filter-btn" data-filter="pending" onclick="filterJournals('pending')">
                                <i class="ph ph-clock me-8"></i>Pending
                            </button>
                            <button class="btn btn-outline-success btn-sm rounded-pill filter-btn" data-filter="reviewed" onclick="filterJournals('reviewed')">
                                <i class="ph ph-check-circle me-8"></i>Reviewed
                            </button>
                            <button class="btn btn-outline-info btn-sm rounded-pill filter-btn" data-filter="in-progress" onclick="filterJournals('in-progress')">
                                <i class="ph ph-spinner me-8"></i>In Progress
                            </button>
                        </div>
                    </div>
                    @if($allJournals->count() > 0)
                        @forelse ($allJournals as $journal)
                            <div class="p-xl-4 py-16 px-12 rounded-8 border border-gray-100 hover-border-gray-200 transition-1 mb-16 journal-card"
                                 data-status="{{ $journal->approval_status }}">
                                <div class="flex-between gap-8 mb-12">
                                    <div class="flex-align flex-wrap gap-8">
                                        <span class="text-main-600 bg-main-50 w-44 h-44 rounded-circle flex-center text-2xl flex-shrink-0">
                                            <i class="ph-fill ph-graduation-cap"></i>
                                        </span>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-2">{{ $journal->title }}</h6>
                                            <div class="flex-align flex-wrap gap-12 mb-2">
                                                <p class="text-13 text-gray-500 fw-medium mb-0">Author(s): {{ $journal->author }}</p>
                                                <span class="badge bg-{{
                                                    $journal->approval_status === 'pending' ? 'warning' :
                                                    ($journal->approval_status === 'reviewed' ? 'success' :
                                                    ($journal->approval_status === 'in-progress' ? 'info' : 'secondary'))
                                                }} rounded-pill">
                                                    {{ ucwords(str_replace('-', ' ', $journal->approval_status)) }}
                                                </span>
                                            </div>
                                            @if($journal->created_at)
                                                <p class="text-12 text-gray-400 mb-0">
                                                    <i class="ph ph-calendar me-4"></i>
                                                    Submitted: {{ $journal->created_at->format('M d, Y') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        @if($journal->updated_at && $journal->updated_at->diffInDays() <= 7)
                                            <span class="badge bg-info rounded-pill mb-2">
                                                <i class="ph ph-star me-4"></i>Recent
                                            </span>
                                        @endif
                                        @php
                                            $urgentDate = now()->subDays(14);
                                            $isUrgent = $journal->created_at && $journal->created_at <= $urgentDate && $journal->approval_status === 'pending';
                                        @endphp
                                        @if($isUrgent)
                                            <span class="badge bg-danger rounded-pill">
                                                <i class="ph ph-warning me-4"></i>Urgent
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Enhanced Action Buttons -->
                                <div class="flex-align gap-8 mt-12">
                                    <a href="{{ route('reviewer.journals.review', [$journal->uuid, $journal->slug]) }}"
                                       class="btn btn-outline-main btn-sm rounded-pill">
                                        <i class="ph ph-eye me-8"></i>Preview
                                    </a>
                                    <a href="{{ route('reviewer.journals.review', [$journal->uuid, $journal->slug]) }}"
                                       class="btn btn-main btn-sm rounded-pill">
                                        <i class="ph ph-star me-8"></i>Enhanced Review
                                    </a>
                                    @if($journal->approval_status === 'pending')
                                        <button class="btn btn-success btn-sm rounded-pill"
                                                onclick="quickApprove('{{ $journal->uuid }}')">
                                            <i class="ph ph-check me-8"></i>Quick Approve
                                        </button>
                                        <button class="btn btn-warning btn-sm rounded-pill"
                                                onclick="requestChanges('{{ $journal->uuid }}')">
                                            <i class="ph ph-pencil me-8"></i>Request Changes
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-40">
                                <i class="ph ph-book-open text-5xl text-gray-300 mb-16"></i>
                                <p class="text-gray-500 mb-0">No assigned journals at the moment</p>
                                <p class="text-sm text-gray-400">New assignments will appear here when available</p>
                            </div>
                        @endforelse

                        @if($allJournals->count() > 0)
                            <!-- Pagination if needed -->
                            <div class="mt-20 d-flex justify-content-center">
                                {{ $allJournals->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Performance Metrics Section -->
            <div class="card mt-24">
                <div class="card-body">
                    <div class="mb-20">
                        <h4 class="mb-2">Review Performance</h4>
                        <p class="text-gray-500 mb-0">Your review activity and performance metrics</p>
                    </div>

                    <div class="row gy-3">
                        <div class="col-md-3 col-sm-6">
                            <div class="bg-main-50 rounded-8 p-16 text-center">
                                <div class="text-main-600 text-2xl mb-8">
                                    <i class="ph-fill ph-clock"></i>
                                </div>
                                <h6 class="mb-4">Avg. Review Time</h6>
                                <p class="text-sm text-gray-600 mb-0">
                                    @php
                                        $avgTime = rand(2, 7); // In a real app, calculate from actual data
                                    @endphp
                                    {{ $avgTime }} days
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="bg-success-50 rounded-8 p-16 text-center">
                                <div class="text-success-600 text-2xl mb-8">
                                    <i class="ph-fill ph-check-circle"></i>
                                </div>
                                <h6 class="mb-4">Completion Rate</h6>
                                <p class="text-sm text-gray-600 mb-0">
                                    @php
                                        $totalAssigned = $allJournals->count();
                                        $completed = $allJournals->whereIn('approval_status', ['approved', 'reviewed'])->count();
                                        $rate = $totalAssigned > 0 ? round(($completed / $totalAssigned) * 100) : 0;
                                    @endphp
                                    {{ $rate }}%
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="bg-warning-50 rounded-8 p-16 text-center">
                                <div class="text-warning-600 text-2xl mb-8">
                                    <i class="ph-fill ph-calendar"></i>
                                </div>
                                <h6 class="mb-4">This Month</h6>
                                <p class="text-sm text-gray-600 mb-0">
                                    @php
                                        $thisMonth = $allJournals->where('created_at', '>=', now()->startOfMonth())->count();
                                    @endphp
                                    {{ $thisMonth }} reviews
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="bg-info-50 rounded-8 p-16 text-center">
                                <div class="text-info-600 text-2xl mb-8">
                                    <i class="ph-fill ph-star"></i>
                                </div>
                                <h6 class="mb-4">Quality Score</h6>
                                <p class="text-sm text-gray-600 mb-0">
                                    @php
                                        $qualityScore = rand(85, 98); // In a real app, calculate from feedback
                                    @endphp
                                    {{ $qualityScore }}/100
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Row -->
                    <div class="mt-20 pt-20 border-top border-gray-100">
                        <h6 class="mb-12">Quick Actions</h6>
                        <div class="flex-align gap-8 flex-wrap">
                            <a href="{{ route('reviewer.journals.pendingApproval') }}" class="btn btn-outline-warning btn-sm rounded-pill">
                                <i class="ph ph-list me-8"></i>View Pending Reviews
                            </a>
                            <a href="{{ route('reviewer.journals.myAssignedReviews') }}" class="btn btn-outline-info btn-sm rounded-pill">
                                <i class="ph ph-user-check me-8"></i>My Assigned Reviews
                            </a>
                            <a href="{{ route('reviewer.notifications.dashboard') }}" class="btn btn-outline-main btn-sm rounded-pill">
                                <i class="ph ph-bell me-8"></i>View Notifications
                            </a>
                            <a href="{{ route('reviewer.user.settings', auth()->user()->uuid) }}" class="btn btn-outline-gray btn-sm rounded-pill">
                                <i class="ph ph-gear me-8"></i>Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-3">

            <!-- Calendar Start -->
            <div class="card">
                <div class="card-body">
                    <div class="calendar">
                        <div class="calendar__header">
                            <button type="button" class="calendar__arrow left"><i
                                    class="ph ph-caret-left"></i></button>
                            <p class="display h6 mb-0">""</p>
                            <button type="button" class="calendar__arrow right"><i
                                    class="ph ph-caret-right"></i></button>
                        </div>

                        <div class="calendar__week week">
                            <div class="calendar__week-text">Su</div>
                            <div class="calendar__week-text">Mo</div>
                            <div class="calendar__week-text">Tu</div>
                            <div class="calendar__week-text">We</div>
                            <div class="calendar__week-text">Th</div>
                            <div class="calendar__week-text">Fr</div>
                            <div class="calendar__week-text">Sa</div>
                        </div>
                        <div class="days"></div>
                    </div>

                </div>
            </div>
            <!-- Calendar End -->

        </div>
    </div>

    <!-- Enhanced Dashboard Scripts -->
    <script>
        // Filter journals by status
        function filterJournals(status) {
            const journalCards = document.querySelectorAll('.journal-card');
            const buttons = document.querySelectorAll('.filter-btn');

            // Update active button state
            buttons.forEach(btn => {
                btn.classList.remove('active');
                const filter = btn.dataset.filter;
                
                // Reset to outline styles for inactive buttons
                if (filter === 'all') {
                    btn.classList.remove('btn-main');
                    btn.classList.add('btn-outline-main');
                } else if (filter === 'pending') {
                    btn.classList.remove('btn-warning');
                    btn.classList.add('btn-outline-warning');
                } else if (filter === 'reviewed') {
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-outline-success');
                } else if (filter === 'in-progress') {
                    btn.classList.remove('btn-info');
                    btn.classList.add('btn-outline-info');
                }
            });

            // Set active button style
            const activeButton = document.querySelector(`[data-filter="${status}"]`);
            if (activeButton) {
                activeButton.classList.add('active');
                const filter = activeButton.dataset.filter;
                
                // Change active button to solid style
                if (filter === 'all') {
                    activeButton.classList.remove('btn-outline-main');
                    activeButton.classList.add('btn-main');
                } else if (filter === 'pending') {
                    activeButton.classList.remove('btn-outline-warning');
                    activeButton.classList.add('btn-warning');
                } else if (filter === 'reviewed') {
                    activeButton.classList.remove('btn-outline-success');
                    activeButton.classList.add('btn-success');
                } else if (filter === 'in-progress') {
                    activeButton.classList.remove('btn-outline-info');
                    activeButton.classList.add('btn-info');
                }
            }

            // Filter cards
            journalCards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeIn 0.3s ease-in';
                } else {
                    card.style.display = 'none';
                }
            });

            // Update count display
            const visibleCards = document.querySelectorAll('.journal-card[style*="block"], .journal-card:not([style*="none"])').length;
            updateFilterCount(status, visibleCards);
        }

        // Initialize filter buttons on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Buttons are now properly initialized in HTML
            updateFilterCount('all', document.querySelectorAll('.journal-card').length);
        });

        function updateFilterCount(status, count) {
            const statusText = status === 'all' ? 'Total' : status.charAt(0).toUpperCase() + status.slice(1);
            // You can add a count display element if needed
        }

        // Quick approve functionality
        function quickApprove(journalUuid) {
            if (confirm('Are you sure you want to approve this journal?')) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("reviewer.journals.approveJournal") }}';

                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Add journal UUID
                const uuidInput = document.createElement('input');
                uuidInput.type = 'hidden';
                uuidInput.name = 'journal_uuid';
                uuidInput.value = journalUuid;
                form.appendChild(uuidInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        // Request changes functionality
        function requestChanges(journalUuid) {
            const comment = prompt('Please provide comments for the requested changes:');
            if (comment && comment.trim() !== '') {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("journals.request-change", "") }}/' + journalUuid;

                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Add comment
                const commentInput = document.createElement('input');
                commentInput.type = 'hidden';
                commentInput.name = 'comment';
                commentInput.value = comment;
                form.appendChild(commentInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .journal-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }

            .badge {
                font-size: 11px;
                padding: 4px 8px;
            }

            .btn-sm {
                font-size: 12px;
                padding: 6px 12px;
            }
        `;
        document.head.appendChild(style);

        // Auto-refresh notifications every 30 seconds
        setInterval(function() {
            // Refresh notification count without full page reload
            fetch('{{ route("reviewer.notifications.unread-count") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.querySelector('.notification-badge');
                    if (data.unread_count > 0) {
                        badge.textContent = data.unread_count;
                        badge.style.display = 'block';
                    } else {
                        badge.style.display = 'none';
                    }
                })
                .catch(error => console.log('Notification update failed:', error));
        }, 30000);
    </script>


</x-layouts.reviewer_layout>
