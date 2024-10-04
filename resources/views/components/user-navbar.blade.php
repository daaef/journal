<div class="border-b border-gray-200">
    <nav class="flex gap-x-6">
        <a href="{{ route('dashboard') }}" class="@if (Route::is('dashboard')) font-semibold border-primary-500 text-primary-500 @else text-gray-500 border-transparent @endif py-4 px-1 inline-flex items-center gap-x-2 border-b-2 text-sm whitespace-nowrap hover:text-primary-600 focus:outline-none focus:text-primary-600 disabled:opacity-50 disabled:pointer-events-none" id="tabs-with-underline-item-1" aria-selected="true" data-hs-tab="#tabs-with-underline-1" aria-controls="tabs-with-underline-1" role="tab">
            My Collections
        </a>
        <a href="{{ route('user.submissions') }}" class="@if (Route::is('user.submissions')) font-semibold border-primary-500 text-primary-500 @else text-gray-500 border-transparent @endif py-4 px-1 inline-flex items-center gap-x-2 border-b-2 text-sm whitespace-nowrap hover:text-primary-600 focus:outline-none focus:text-primary-600 disabled:opacity-50 disabled:pointer-events-none" id="tabs-with-underline-item-2" aria-selected="false" data-hs-tab="#tabs-with-underline-2" aria-controls="tabs-with-underline-2" role="tab">
            My Submissions
        </a>
        <a href="{{ route('user.settings', auth()->user()->uuid) }}" class="@if (Route::is('dashboard.settings')) font-semibold border-primary-500 text-primary-500 @else text-gray-500 border-transparent @endif py-4 px-1 inline-flex items-center gap-x-2 border-b-2 text-sm whitespace-nowrap hover:text-primary-600 focus:outline-none focus:text-primary-600 disabled:opacity-50 disabled:pointer-events-none" id="tabs-with-underline-item-3" aria-selected="false" data-hs-tab="#tabs-with-underline-3" aria-controls="tabs-with-underline-3" role="tab">
            Settings
        </a>
    </nav>
</div>
