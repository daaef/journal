<x-layouts.layout>
    <x-slot:title>
        Version History - {{ $journal->title }}
    </x-slot>
    
    <x-slot:breadcrumb>
        <div class="border-b border-gray-200 pb-5">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('user.submissions') }}" class="text-gray-600 hover:text-primary-600">
                            My Submissions
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500">Version History</span>
                        </div>
                    </li>
                </ol>
            </nav>
            
            <div class="sm:flex w-full sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-bold leading-6 text-gray-900">Version History</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $journal->title }}</p>
                </div>
                <div class="mt-3 sm:mt-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($journal->approval_status === 'approved') bg-green-100 text-green-800
                        @elseif($journal->approval_status === 'rejected') bg-red-100 text-red-800
                        @elseif($journal->approval_status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($journal->approval_status === 'in_progress') bg-blue-100 text-blue-800
                        @elseif($journal->approval_status === 'reviewed') bg-purple-100 text-purple-800
                        @elseif($journal->approval_status === 'revision_requested') bg-orange-100 text-orange-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $journal->approval_status)) }}
                    </span>
                </div>
            </div>
        </div>
    </x-slot:breadcrumb>

    <div class="py-6">
        @if($versions->count() > 0)
            <div class="space-y-6">
                @foreach($versions as $version)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                            @if($loop->first) bg-blue-100 text-blue-800 @else bg-gray-100 text-gray-800 @endif">
                                            Version {{ $version->version_number }}
                                        </span>
                                        
                                        @if($loop->first)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800">
                                                Current
                                            </span>
                                        @endif
                                        
                                        @if($version->status)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-yellow-100 text-yellow-800">
                                                {{ ucfirst($version->status) }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @if($version->title && $version->title !== $journal->title)
                                        <h4 class="text-lg font-medium text-gray-900 mb-2">{{ $version->title }}</h4>
                                    @endif
                                    
                                    @if($version->changes_summary)
                                        <div class="mb-4">
                                            <h5 class="text-sm font-medium text-gray-700 mb-2">Changes Made:</h5>
                                            <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-md">{{ $version->changes_summary }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($version->revision_notes)
                                        <div class="mb-4">
                                            <h5 class="text-sm font-medium text-gray-700 mb-2">Revision Notes:</h5>
                                            <p class="text-sm text-gray-600 bg-blue-50 p-3 rounded-md border-l-4 border-blue-400">{{ $version->revision_notes }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($version->change_requests && count($version->change_requests) > 0)
                                        <div class="mb-4">
                                            <h5 class="text-sm font-medium text-gray-700 mb-2">Addressed Change Requests:</h5>
                                            <div class="space-y-2">
                                                @foreach($version->change_requests as $request)
                                                    <div class="text-sm text-gray-600 bg-orange-50 p-2 rounded border-l-4 border-orange-400">
                                                        @if(is_array($request))
                                                            <span class="font-medium">{{ $request['category'] ?? 'General' }}:</span>
                                                            {{ $request['description'] ?? $request }}
                                                        @else
                                                            {{ $request }}
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="text-right text-sm text-gray-500 ml-6">
                                    <p class="mb-1">
                                        @if($version->author)
                                            by {{ $version->author->fullname }}
                                        @endif
                                    </p>
                                    <p class="mb-1">{{ $version->created_at->format('M j, Y') }}</p>
                                    <p>{{ $version->created_at->format('g:i A') }}</p>
                                </div>
                            </div>
                            
                            @if($version->file_path)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Manuscript File Available
                                        </div>
                                        <a href="{{ route('download-journal', $journal->uuid) }}" 
                                           class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No version history</h3>
                <p class="mt-1 text-sm text-gray-500">This manuscript has only one version.</p>
            </div>
        @endif
        
        <div class="mt-8 flex justify-center">
            <a href="{{ route('user.submissions') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Submissions
            </a>
        </div>
    </div>
</x-layouts.layout>
