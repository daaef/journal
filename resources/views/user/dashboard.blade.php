<x-layouts.layout>
    <x-slot:title>
        Author Dashboard - JAPR
    </x-slot>
    <x-slot:breadcrumb>
        <div class="border-b border-gray-200 pb-5 sm:flex w-full sm:items-center sm:justify-between">
            <h3 class="text-lg font-bold leading-6 text-gray-900">Dashboard</h3>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">Welcome, {{ Str::words(auth()->user()->fullname, 1, '') }}</span>
            </div>
        </div>
    </x-slot:breadcrumb>
    
    <div class="py-6">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Submissions</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $mySubmissions->count() > 0 ? $mySubmissions->count() : '0' }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Under Review</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $mySubmissions->whereIn('approval_status', ['pending', 'in_progress', 'reviewed'])->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Approved</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $mySubmissions->where('approval_status', 'approved')->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Revisions Needed</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $mySubmissions->where('approval_status', 'revision_requested')->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Submissions -->
        @if($mySubmissions->count() > 0)
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Recent Submissions</h3>
                    <a href="{{ route('user.submissions') }}" class="text-sm text-primary-600 hover:text-primary-700">
                        View all submissions
                    </a>
                </div>
                
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul class="divide-y divide-gray-200">
                        @foreach($mySubmissions->take(3) as $submission)
                            <li>
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-primary-600 truncate">
                                                <a href="{{ route('journals.view', $submission->slug) }}">{{ $submission->title }}</a>
                                            </p>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($submission->approval_status === 'approved') bg-green-100 text-green-800
                                                    @elseif($submission->approval_status === 'rejected') bg-red-100 text-red-800
                                                    @elseif($submission->approval_status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($submission->approval_status === 'in_progress') bg-blue-100 text-blue-800
                                                    @elseif($submission->approval_status === 'reviewed') bg-purple-100 text-purple-800
                                                    @elseif($submission->approval_status === 'revision_requested') bg-orange-100 text-orange-800
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $submission->approval_status)) }}
                                                </span>
                                                
                                                @if($submission->category)
                                                    <span class="mx-2">•</span>
                                                    <span>{{ $submission->category->name }}</span>
                                                @endif
                                                
                                                @if($submission->reviewers_count > 0)
                                                    <span class="mx-2">•</span>
                                                    <span>{{ $submission->reviewers_count }} review(s)</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            @if($submission->approval_status === 'revision_requested')
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                                    Action Required
                                                </span>
                                            @endif
                                            <span class="text-xs text-gray-500">
                                                {{ $submission->updated_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- My Collections (Published Journals) -->
        @if (count($myCollections) > 0)
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">My Journal Collections</h3>
                    <a href="{{ route('journals') }}" class="text-sm text-primary-600 hover:text-primary-700">
                        Browse all journals
                    </a>
                </div>
                <div class="grid gap-4">
                    <x-journal :journals="$myCollections"/>
                </div>
            </div>
        @endif

        <!-- Quick Actions -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('submit-manuscript') }}" 
                   class="flex items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Submit New Manuscript</p>
                        <p class="text-sm text-gray-500">Upload your research for review</p>
                    </div>
                </a>

                <a href="{{ route('user.submissions') }}" 
                   class="flex items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">View All Submissions</p>
                        <p class="text-sm text-gray-500">Track your manuscript status</p>
                    </div>
                </a>

                <a href="{{ route('journals') }}" 
                   class="flex items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Browse Journals</p>
                        <p class="text-sm text-gray-500">Explore published research</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Empty State for New Users -->
        @if(count($myCollections) === 0 && $mySubmissions->count() === 0)
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Welcome to JAPR!</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by submitting your first manuscript for review.</p>
                <div class="mt-6">
                    <a href="{{ route('submit-manuscript') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Submit Your First Manuscript
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-layouts.layout>
