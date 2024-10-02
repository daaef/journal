<x-layouts.layout>
    <x-slot:title>
        Custom Title
    </x-slot>

    <x-slot:title>
        Welcome to your JAPR Settings Page
    </x-slot>
    <x-slot:breadcrumb>
    <div class="border-b border-gray-200 pb-5 sm:flex w-full sm:items-center sm:justify-between">
        <h3 class="text-lg font-bold leading-6 text-gray-900">Settings</h3>
        <div>
            <h4>{{ Str::words(auth()->user()->fullname, 1, '') }}'s Dashboard</h4>
        </div>
    </div>
    <hr class="">
    </x-slot:breadcrumb>
</x-layouts.layout>
