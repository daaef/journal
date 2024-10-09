<x-layouts.layout>
    <x-slot:title>
        Welcome to JAPR: Dashboard
    </x-slot>
    <x-slot:breadcrumb>
        <div class="border-b border-gray-200 pb-5 sm:flex w-full sm:items-center sm:justify-between">
            <h3 class="text-lg font-bold leading-6 text-gray-900">Dashboard</h3>
            <div>
                <h4>{{ Str::words(auth()->user()->fullname, 1, '') }}'s Dashboard</h4>
            </div>
        </div>
        <hr class="">
    </x-slot:breadcrumb>
    <div class="min-h-[40vh] py-5 flex items-center justify-center gap-5">
        @if (count($journals) > 0)
            <div class="grid w-full gap-2">
                {{-- @dd($journals) --}}
                <x-journal :journals="$journals"/>
            </div>
        @else
            <a class="flex flex-col items-center" href="{{ route('submit-manuscript') }}">
                <img class="h-[100px] opacity-40" src="{{ asset('images/create-collection.png') }}" alt="">
                <p class="text-primary-500 font-semibold">Click to Create Collection</p>
            </a>
        @endif
    </div>
</x-layouts.layout>
