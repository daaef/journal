<x-layouts.layout>
    <x-slot:title>
        Custom Title
    </x-slot>

    <x-slot:title>
        Welcome to your JAPR Submissions Page
    </x-slot>
    <x-slot:breadcrumb>
        <div class="border-b border-gray-200 pb-5 sm:flex w-full sm:items-center sm:justify-between">
            <h3 class="text-lg font-bold leading-6 text-gray-900">Submissions</h3>
            <div>
                <h4>{{ Str::words(auth()->user()->fullname, 1, '') }}'s Dashboard</h4>
            </div>
        </div>
        <hr class="">
    </x-slot:breadcrumb>
    <div class="min-h-[40vh] justify-center flex items-center">
        <a class="flex flex-col items-center" href="{{ route('submit-manuscript') }}">
            <img class="h-[100px] opacity-40" src="{{ asset('images/submit-manuscript.png') }}" alt="">
            <p class="text-primary-500 font-semibold">Click to Submit Manuscript</p>
        </a>
    </div>
</x-layouts.layout>
