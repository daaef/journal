<x-layouts.layout>
    <x-slot:title>
        Welcome to JAPR Homepage
    </x-slot>
    <x-slot:breadcrumb>
        <div class="border-b border-gray-200 pb-5 sm:flex w-full sm:items-center sm:justify-between">
            <h3 class="text-lg font-bold leading-6 text-gray-900">Journals</h3>
            <div>
                <form class="flex rounded-lg border min-w-full" action="{{ route('journals') }}" method="get">
                    <input type="text" id="hs-trailing-multiple-add-on" name="search"
                        value="{{ old('search') ?: request()->search }}"
                        class="py-3 lg:w-[400px] px-4 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="Search  for a keyword or title">
                    <div class="inline-flex items-center min-w-[180px] rounded-e-md">
                        <select
                            data-hs-select='{
  "placeholder": "<span class=\"inline-flex items-center\"><svg class=\"shrink-0 size-3.5 me-2\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polygon points=\"22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3\"/></svg> Filter</span>",
  "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
  "toggleClasses": "hs-select-disabled:pointer-events-none border-s-0 hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-0 text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[180px]",
  "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-0 overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-0 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
  "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-0 focus:outline-none focus:bg-gray-100",
  "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
  "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
}'
                            class="hidden">
                            <option selected>Title</option>
                            <option>Keyword</option>
                        </select>
                    </div>
                    <button
                        type="submit"
                        class="px-4 inline-flex items-center min-w-fit rounded-e-md border border-s-0 bg-primary-500 text-white">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </x-slot:breadcrumb>
    <div class="grid lg:grid-cols-[300px_1fr] relative gap-[30px] overflow-x-hidden">
        <div id="filter" class="lg:translate-x-0 translate-x-[-100%] lg:static absolute transition-all duration-300">
            <div class="flex gap-x-2 px-2.5 mb-4 relative items-center">
                <img class="h-[25px] cursor-pointer lg:static absolute right-0 lg:translate-x-0 translate-x-[100%] top-0" src="{{ loadAssetFile('images/filter.png') }}" alt="Filter Image">
                <span id="filter-toggle" class="text-primary-500 font-bold">Filter Results</span>
            </div>
            <nav class="hs-accordion-group " data-hs-accordion-always-open>
                <form action="{{ route('journals') }}" class="w-full flex space-y-2.5 flex-col flex-wrap"
                    method="get">
                    <ul class="space-y-1.5">
                        <li class="hs-accordion" id="account-accordion">
                            <button type="button"
                                class="hs-accordion-toggle hs-accordion-active:text-secondary-900 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-secondary-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 uppercase"
                                aria-expanded="true" aria-controls="account-accordion">
                                Categories

                                <svg class="hs-accordion-active:block ms-auto hidden size-4 text-gray-600 group-hover:text-gray-500 "
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="m18 15-6-6-6 6" />
                                </svg>

                                <svg class="hs-accordion-active:hidden ms-auto block size-4 text-gray-600 group-hover:text-gray-500 "
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                            @if ('$categories')
                                <div id="account-accordion"
                                    class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                                    role="region" aria-labelledby="account-accordion">
                                    <ul class="pt-2 ps-2 max-h-[200px] overflow-y-auto">
                                        @foreach ($categories as $category)
                                            <li>
                                                <label
                                                    class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 "
                                                    for="cat-{{ $category->id }}">
                                                    <input type="checkbox" id="cat-{{ $category->id }}"
                                                        name="category[]" value="{{ $category->id }}">
                                                    <span class="inline-block">{{ $category->name }}</span>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </li>

                        <li class="hs-accordion" id="projects-accordion">
                            <button type="button"
                                class="hs-accordion-toggle hs-accordion-active:text-primary-900 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-primary-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 uppercase"
                                aria-expanded="true" aria-controls="projects-accordion">
                                Languages

                                <svg class="hs-accordion-active:block ms-auto hidden size-4 text-gray-600 group-hover:text-gray-500 "
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="m18 15-6-6-6 6" />
                                </svg>

                                <svg class="hs-accordion-active:hidden ms-auto block size-4 text-gray-600 group-hover:text-gray-500 "
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            <div id="projects-accordion"
                                class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                                role="region" aria-labelledby="projects-accordion">
                                <ul class="pt-2 ps-2">
                                    <li>
                                        <label
                                            class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 "
                                            for="lang-1">
                                            <input type="checkbox" id="lang-1">
                                            <span class="inline-block">British English</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label
                                            class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 "
                                            for="lang-2">
                                            <input type="checkbox" id="lang-2">
                                            <span class="inline-block">American English</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label
                                            class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 "
                                            for="lang-3">
                                            <input type="checkbox" id="lang-3">
                                            <span class="inline-block">French</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="hs-accordion" id="projects-accordion">
                            <button type="button"
                                class="hs-accordion-toggle hs-accordion-active:text-primary-900 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-primary-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 uppercase"
                                aria-expanded="true" aria-controls="projects-accordion">
                                Licenses

                                <svg class="hs-accordion-active:block hs-accordion-active:text-primary-900  ms-auto hidden size-4 text-primary-800"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m18 15-6-6-6 6" />
                                </svg>

                                <svg class="hs-accordion-active:hidden ms-auto block size-4 text-gray-600 group-hover:text-gray-500 "
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            <div id="projects-accordion"
                                class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                                role="region" aria-labelledby="projects-accordion">
                                <ul class="pt-2 ps-2">
                                    <li class="relative flex gap-x-3 px-2.5">
                                        <div class="flex h-6 items-center">
                                            <input id="cc-by" name="license[]" type="checkbox"
                                                   class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="cc-by" class="text-gray-500">CC BY</label>
                                        </div>
                                    </li>
                                    <li class="relative flex gap-x-3 px-2.5">
                                        <div class="flex h-6 items-center">
                                            <input id="cc-by-sa" name="license[]" type="checkbox"
                                                   class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="cc-by-sa" class="text-gray-500">CC BY-SA</label>
                                        </div>
                                    </li>
                                    <li class="relative flex gap-x-3 px-2.5">
                                        <div class="flex h-6 items-center">
                                            <input id="cc-by-nd" name="license[]" type="checkbox"
                                                   class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="cc-by-nd" class="text-gray-500">CC BY-ND</label>
                                        </div>
                                    </li>
                                    <li class="relative flex gap-x-3 px-2.5">
                                        <div class="flex h-6 items-center">
                                            <input id="cc-by-nc" name="license[]" type="checkbox"
                                                   class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="cc-by-nc" class="text-gray-500">CC BY-NC</label>
                                        </div>
                                    </li>
                                    <li class="relative flex gap-x-3 px-2.5">
                                        <div class="flex h-6 items-center">
                                            <input id="cc-by-nc-sa" name="license[]" type="checkbox"
                                                   class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="cc-by-nc-sa" class="text-gray-500">CC BY-NC-SA</label>
                                        </div>
                                    </li>
                                    <li class="relative flex gap-x-3 px-2.5">
                                        <div class="flex h-6 items-center">
                                            <input id="cc-by-nc-nd" name="license[]" type="checkbox"
                                                   class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="cc-by-nc-nd" class="text-gray-500">CC BY-NC-ND</label>
                                        </div>
                                    </li>
                                    <li class="relative flex gap-x-3 px-2.5">
                                        <div class="flex h-6 items-center">
                                            <input id="cc0" name="license[]" type="checkbox"
                                                   class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="cc0" class="text-gray-500">CC0</label>
                                        </div>
                                    </li>
                                    <li class="relative flex gap-x-3 px-2.5">
                                        <div class="flex h-6 items-center">
                                            <input id="pub_domain" name="license[]" type="checkbox"
                                                   class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="pub_domain" class="text-gray-500">Public domain</label>
                                        </div>
                                    </li>
                                    <li class="relative flex gap-x-3 px-2.5">
                                        <div class="flex h-6 items-center">
                                            <input id="own_license" name="license[]" type="checkbox"
                                                   class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="own_license" class="text-gray-500">Publisher's own license</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="hs-accordion" id="projects-accordion">
                            <button type="button"
                                class="hs-accordion-toggle hs-accordion-active:text-primary-900 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-primary-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 uppercase"
                                aria-expanded="true" aria-controls="projects-accordion">
                                Country

                                <svg class="hs-accordion-active:block hs-accordion-active:text-primary-900  ms-auto hidden size-4 text-primary-800"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m18 15-6-6-6 6" />
                                </svg>

                                <svg class="hs-accordion-active:hidden ms-auto block size-4 text-gray-600 group-hover:text-gray-500 "
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            <div id="projects-accordion"
                                class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                                role="region" aria-labelledby="projects-accordion">

                                <ul class="pt-2 ps-2 max-h-[200px] overflow-y-auto">
                                    @foreach ($regions as $region => $countries)
                                        @foreach ($countries as $country)
                                        <li class="relative flex gap-x-3 px-2.5">
                                            <div class="flex h-6 items-center">
                                                <input id="{{ $country }}" name="country[]" type="checkbox"
                                                       class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600" value="{{ $country }}">
                                            </div>
                                            <div class="text-sm leading-6">
                                                <label for="{{ $country }}" class="text-gray-500">{{ $country }}</label>
                                            </div>
                                        </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </li>

                        {{--<li class="hs-accordion" id="projects-accordion">
                            <button type="button"
                                class="hs-accordion-toggle hs-accordion-active:text-primary-900 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-primary-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 uppercase"
                                aria-expanded="true" aria-controls="projects-accordion">
                                Peer Review Type

                                <svg class="hs-accordion-active:block hs-accordion-active:text-primary-900  ms-auto hidden size-4 text-primary-800"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m18 15-6-6-6 6" />
                                </svg>

                                <svg class="hs-accordion-active:hidden ms-auto block size-4 text-gray-600 group-hover:text-gray-500 "
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            <div id="projects-accordion"
                                class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                                role="region" aria-labelledby="projects-accordion">
                                <ul class="pt-2 ps-2">
                                    <li>
                                        <label
                                            class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 "
                                            for="lang-1">
                                            <input type="checkbox" id="lang-1">
                                            <span class="inline-block">British English</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label
                                            class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 "
                                            for="lang-2">
                                            <input type="checkbox" id="lang-2">
                                            <span class="inline-block">American English</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label
                                            class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 "
                                            for="lang-3">
                                            <input type="checkbox" id="lang-3">
                                            <span class="inline-block">French</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="hs-accordion" id="projects-accordion">
                            <button type="button"
                                class="hs-accordion-toggle hs-accordion-active:text-primary-900 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-primary-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 uppercase"
                                aria-expanded="true" aria-controls="projects-accordion">
                                Date added

                                <svg class="hs-accordion-active:block hs-accordion-active:text-primary-900  ms-auto hidden size-4 text-primary-800"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m18 15-6-6-6 6" />
                                </svg>

                                <svg class="hs-accordion-active:hidden ms-auto block size-4 text-gray-600 group-hover:text-gray-500 "
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            <div id="projects-accordion"
                                class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                                role="region" aria-labelledby="projects-accordion">
                                <ul class="pt-2 ps-2">
                                    <li>
                                        <label
                                            class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 "
                                            for="lang-1">
                                            <input type="checkbox" id="lang-1">
                                            <span class="inline-block">British English</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label
                                            class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 "
                                            for="lang-2">
                                            <input type="checkbox" id="lang-2">
                                            <span class="inline-block">American English</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label
                                            class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 "
                                            for="lang-3">
                                            <input type="checkbox" id="lang-3">
                                            <span class="inline-block">French</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </li>--}}

                    </ul>
                    <button class="py-2 px-5 bg-primary-500 text-gray-100 rounded-[8px]">
                        Apply filter
                    </button>
                </form>
            </nav>
        </div>
        <div class="lg:border pl-8 border-transparent border-l-secondary-900/50">

            {{--<div class="flex justify-between mb-6">
                <div class="grid gap-2">
                    <label for="">Sort by</label>
                    <select
                        data-hs-select='{
  "placeholder": "<span class=\"inline-flex items-center\"><svg class=\"shrink-0 size-3.5 me-2\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polygon points=\"22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3\"/></svg> Filter</span>",
  "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
  "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-0 text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[240px]",
  "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-0 overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-0 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
  "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-0 focus:outline-none focus:bg-gray-100",
  "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
  "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
}'
                        class="hidden">
                        <option value="">Filter</option>
                        <option selected>Added to JAPR (newest)</option>
                        <option>Added to JAPR (oldest)</option>
                        <option>Last Updated (most recent)</option>
                        <option>Last Updated (less recent)</option>
                        <option>Title (A - Z)</option>
                        <option>Title (Z - A)</option>
                        <option>Relevance</option>
                    </select>
                </div>
                <div class="grid gap-2">
                    <label for="">Sort by</label>
                    <select name="" id="">
                        <option value="">10</option>
                        <option value="">50</option>
                        <option value="">100</option>
                        <option value="">200</option>
                    </select>
                </div>
            </div>--}}
            <div class="flex justify-between mb-6">
                <div class="flex gap-x-4">
                    <a href="#" class="flex gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-chevrons-left">
                            <path d="m11 17-5-5 5-5" />
                            <path d="m18 17-5-5 5-5" />
                        </svg>
                        First
                    </a>
                    <a href="#" class="flex gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-chevron-left">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        Previous
                    </a>
                </div>
                <div class="flex gap-x-4">
                    <a href="#" class="flex gap-1">
                        Next
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-chevron-right">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </a>
                    <a href="#" class="flex gap-1">
                        Last
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-chevrons-right">
                            <path d="m6 17 5-5-5-5" />
                            <path d="m13 17 5-5-5-5" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="grid gap-4">

                <x-journal :journals="$journals" />
            </div>
            <div class="flex justify-between mt-6">
                <div class="flex gap-x-4">
                    <a href="#" class="flex gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="lucide lucide-chevrons-left">
                            <path d="m11 17-5-5 5-5" />
                            <path d="m18 17-5-5 5-5" />
                        </svg>
                        First
                    </a>
                    <a href="#" class="flex gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="lucide lucide-chevron-left">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        Previous
                    </a>
                </div>
                <div class="flex gap-x-4">
                    <a href="#" class="flex gap-1">
                        Next
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="lucide lucide-chevron-right">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </a>
                    <a href="#" class="flex gap-1">
                        Last
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="lucide lucide-chevrons-right">
                            <path d="m6 17 5-5-5-5" />
                            <path d="m13 17 5-5-5-5" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.layout>
