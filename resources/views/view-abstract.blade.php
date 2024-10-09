
<x-layouts.layout>
    <x-slot:title>
        Welcome to JAPR Homepage
    </x-slot>
    <x-slot:breadcrumb>
        <div class="border-b border-gray-200 pb-5 sm:flex w-full sm:items-center sm:justify-between">
            <h3 class="text-lg font-bold leading-6 text-gray-900">Abstract for {{ $journal->title }}</h3>
            <div>
                <a class="font-bold text-gray-100 rounded-[8px] inline-block py-2 px-6 bg-primary-500" href="{{ route('journals') }}">Back to Journals</a>
            </div>
        </div>
        <hr class="">
    </x-slot:breadcrumb>
    <div class="max-w-lg w-full mx-auto border p-8 rounded-[8px]">
        {{ $journal->abstract }}
    </div>
</x-layouts.layout>
