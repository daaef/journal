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
</x-layouts.editor_layout>
