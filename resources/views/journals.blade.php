<x-layout>
    <x-slot:title>
        Welcome to JAPR Homepage
    </x-slot>
    <section id="hero" class="py-[50px] min-h-[80vh] pt-[120px]">
        <div class="container px-4">
            <div class="border-b border-gray-200 pb-5 sm:flex w-full sm:items-center sm:justify-between">
                <h3 class="text-lg font-bold leading-6 text-gray-900">Journals</h3>
                <div>
                    <div class="flex rounded-lg border min-w-full">
                        <input type="text" id="hs-trailing-multiple-add-on" name="inline-add-on" class="py-3 lg:w-[400px] px-4 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Search  for a keyword, title, publication date, ISSN, ISBN, DOI ">
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
}' class="hidden">
                                <option value="">Filter</option>
                                <option selected>Keyword</option>
                                <option>Title</option>
                                <option>Publication date</option>
                                <option>ISSN</option>
                                <option>ISBN</option>
                                <option>DOI</option>
                            </select>
                        </div>
                        <button class="px-4 inline-flex items-center min-w-fit rounded-e-md border border-s-0 bg-primary-500 text-white">
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
