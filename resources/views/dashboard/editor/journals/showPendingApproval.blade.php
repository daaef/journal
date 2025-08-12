<x-layouts.editor_layout>
    <x-slot name="title">
        Pending Approval
    </x-slot>
    <div class="row gy-4">
        <div class="col-lg-12">
            <!-- Table Start -->
            <div class="card mt-24 overflow-hidden">
                <div class="card-header">
                    <div class="mb-0 flex-between flex-wrap gap-8">
                        <h4 class="mb-0">All Pending Manuscripts ({{ $journals->count() }})</h4>
                        <div class="flex gap-8 items-center">
                            <span class="text-sm text-gray-600">Filter by:</span>
                            <select id="statusFilter" class="form-select form-select-sm" style="width: auto;">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="in-review">In Review</option>
                                <option value="approved_with_comment">Approved with Comment</option>
                                <option value="ready_for_managing_editor_notice">Ready for Notice</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 overflow-x-auto scroll-sm scroll-sm-horizontal">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th class="w-[100px]">Author</th>
                                <th>Region</th>
                                <th>Category</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($journals as $journal)
                                <tr class="cursor-pointer" data-status="{{ $journal->approval_status }}">
                                    <td>
                                        <div class="flex-align gap-8">
                                            <div class="w-40 h-40 rounded-circle bg-main-600 flex-center flex-shrink-0">
                                                <img src="assets/images/icons/course-name-icon1.png" alt="">
                                            </div>
                                            <div class="">
                                                <h6 class="mb-0">{{ $journal->title }}</h6>
                                                <div class="table-list">
                                                    <span class="text-13 text-gray-600">{{ $journal->created_at->format('d F Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-13 text-gray-600">{{ $journal->author }}</span>
                                    </td>
                                    <td>
                                        <span class="text-13 text-gray-600">{{ $journal->region ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-13 text-gray-600">{{ $journal->category->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <div class="flex-align justify-content-center gap-16">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-warning-50 text-warning-600',
                                                    'in-review' => 'bg-info-50 text-info-600',
                                                    'approved_with_comment' => 'bg-success-50 text-success-600',
                                                    'ready_for_managing_editor_notice' => 'bg-primary-50 text-primary-600'
                                                ];
                                                $statusColor = $statusColors[$journal->approval_status] ?? 'bg-gray-50 text-gray-600';
                                            @endphp
                                            <span class="text-13 py-2 px-8 {{ $statusColor }} d-inline-flex align-items-center gap-8 rounded-pill">
                                                <span class="w-6 h-6 bg-current rounded-circle flex-shrink-0"></span>
                                                {{ ucfirst(str_replace('_', ' ', $journal->approval_status)) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex-align flex justify-content-center gap-8">
                                            @if($journal->approval_status === 'ready_for_managing_editor_notice' && auth()->user()->hasRole('Managing Editor'))
                                                <a href="{{ route('editor.journals.readyForNotice') }}" 
                                                   class="btn btn-sm btn-primary" 
                                                   title="Send Approval/Decline Notice">
                                                    <i class="ph ph-bell"></i> Send Notice
                                                </a>
                                            @endif
                                            
                                            @if(in_array($journal->approval_status, ['pending', 'in-review']) && auth()->user()->hasAnyRole(['Editor in Chief', 'Managing Editor']))
                                                <a href="{{ route('editor.regional-assignment', $journal->uuid) }}" 
                                                   class="btn btn-sm btn-success" 
                                                   title="Assign Regional Reviewers">
                                                    <i class="ph ph-users"></i> Assign
                                                </a>
                                            @endif
                                            
                                            <a href="{{ route('editor.journals.preview', [$journal->uuid, $journal->slug]) }}"
                                                class="btn btn-sm btn-primary"
                                                title="View Details">
                                                <i class="ph ph-eye"></i> View
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <p class="mt-2 text-gray-500 dark:text-neutral-400 text-center">No pending manuscripts at the moment</p>
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

    <script>
        // Add status filtering functionality
        document.getElementById('statusFilter').addEventListener('change', function() {
            const selectedStatus = this.value;
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const status = row.getAttribute('data-status');
                if (!selectedStatus || status === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</x-layouts.editor_layout>
