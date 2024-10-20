@forelse ($submission as $journal)
    <div class="grid bg-white border border-t-4 border-t-blue-500 shadow-sm rounded-xl">
        <div class="p-4 md:p-5 space-y-1.5">
            <h3 class="text-lg font-bold text-gray-800">
                {{ $journal->title }}
            </h3>
            <p class="mt-2 text-gray-500 dark:text-neutral-400">
                {!! $journal->description !!}
            </p>
            <p class="mt-1 text-sm leading-6 text-gray-600">Status: <span class="inline-flex ml-4 items-center gap-x-1.5 py-1 px-1.5 rounded-full text-xs font-medium bg-blue-500 text-gray-200">{{ $journal->approval_status }}</span>
        </div>
        <div class="p-4 border-t grid grid-cols-[auto_auto] justify-between items-center gap-4">
            <a href="{{ route('journals.view', $journal->slug) }}"
                class="text-gray-100 bg-primary-500 text-center rounded-[8px] px-4 py-1 font-bold hover:bg-primary-600">View
            </a>
            <p class="text-gray-500 text-xs">Last modified {{ $journal->updated_at->format('d F Y') }}</p>
        </div>
    </div>
@empty
    <p class="mt-2 text-gray-500 dark:text-neutral-400">No published journals at the moment</p>
    <a class="flex flex-col items-center" href="{{ route('submit-manuscript') }}">
        <img class="h-[100px] opacity-40" src="{{ asset('images/submit-manuscript.png') }}" alt="">
        <p class="text-primary-500 font-semibold">Click to Submit Manuscript</p>
    </a>
@endforelse
