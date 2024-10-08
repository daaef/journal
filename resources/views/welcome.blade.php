<x-layouts.layout>
    <x-slot:title>
        Welcome to JAPR Homepage
    </x-slot>
    <form class="grid grid-cols-[300px_1fr] w-full" action="{{ route('journals') }}" method="get">
        <div class="border-[1px] rounded-[15px] h-[560px] p-2 border-primary-900 rounded-r-none border-r-0">
            <div class="flex justify-between items-center">
                <h3 class="pb-1 text-sm">Categories Filter</h3>
                {{--                    <a href="#" class="text-xs font-light">Clear All</a> --}}
            </div>
            <hr class="border-b border-t-0 border-primary-900 border-[px] mb-2">
            <!-- Tree Root -->
            <div class="sidebar overflow-y-auto h-[500px] pb-2 w-full">
                <ul class="tree">
                    @foreach ($categories as $category)
                        <li class="category collapsed font-semibold">
                            <span class="caret-icon">
                                <svg class="inline" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </span>
                            <input type="checkbox" name="category[]" value="{{ $category->id }}" class="category-checkbox" id="category-{{ $category->id }}" />
                            <label class="category-label" for="category-{{ $category->id }}">
                                {{ $category->name }}
                            </label>
                            @if ($category->subCategories->count() > 0)
                                <ul class="subcategories">
                                    @foreach ($category->subCategories as $subCategory)
                                        <li class="subcategory">
                                            <span class="caret-icon">
                                                <svg class="inline" xmlns="http://www.w3.org/2000/svg" width="20"
                                                    height="20" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="m9 18 6-6-6-6" />
                                                </svg>
                                            </span>
                                            <input type="checkbox" class="subcategory-checkbox" name="subcategory"
                                                id="subcategory-{{ $subCategory->id }}" value="{{ $subCategory->id }}" />
                                            <label class="subcategory-label" for="subcategory-{{ $subCategory->id }}">
                                                {{ $subCategory->name }}
                                            </label>
                                            @if ($subCategory->subSubCategories->count() > 0)
                                                <ul class="subsubcategories">
                                                    @foreach ($subCategory->subSubCategories as $subSubCategory)
                                                        <li class="subsubcategory">
                                                            <input type="checkbox" name="subsubcategory[]" class="subsubcategory-checkbox"
                                                                id="subsubcategory-{{ $subSubCategory->id }}" value="{{ $subSubCategory->id }}" />
                                                            <label class="subsubcategory-label"
                                                                for="subsubcategory-{{ $subSubCategory->id }}">
                                                                {{ $subSubCategory->name }}
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- End Tree Root -->
        </div>
        <div class="h-[560px] bg-secondary-900 rounded-r-[15px] grid grid-cols-2 overflow-x-hidden">
            <div class="px-14 flex justify-center gap-4 flex-col">
                <h3 class="text-5xl font-bold from-white to-primary-500 bg-gradient-to-r bg-clip-text text-transparent">
                    Gateway to African Knowledge</h3>
                <p class="text-white text-xl">Explore Journals, Literature, and Research Across the Continent</p>
                <div class="flex rounded-[15px] shadow-sm relative">

                    <input type="text" id="search"
                        name="search"
                        class="py-3 px-4 block w-full border-gray-200 shadow-sm rounded-[15px] text-sm focus:z-10 focus:border-primary-500 focus:ring-primary-500 disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="Search  for a keyword, title, publication date, ISSN, ISBN, DOI ">
                    <button type="submit"
                        class="w-[2.875rem] z-[1000] h-[2.875rem] absolute right-0 shrink-0 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-[15px] border border-transparent bg-primary-500 text-white hover:bg-primary-900 focus:outline-none focus:bg-primary-950 disabled:opacity-50 disabled:pointer-events-none">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                    </button>

                </div>
            </div>
            <img class="w-full h-[560px] object-fit-cover" src="{{ asset('/images/headerImg.png') }}" alt="">
        </div>
    </form>
    <section id="most_viewed" class="py-[50px]">
        <div class="flex justify-between">
            <h3 class="font-bold text-primary-500">Most Viewed</h3>
            <a href="#" class="text-secondary-900 text-sm">Clear All</a>
        </div>
        <div class="grid grid-cols-5 gap-x-[30px] mt-6">
            <a href="#"
                class="relative flex flex-col justify-end h-[180px] after:bg-secondary-900/45 after:absolute after:top-0 after:left-0 after:w-full after:h-full rounded-[15px] after:rounded-[15px]">
                <img class="w-full h-full absolute" src="{{ asset('/images/education.png') }}" alt="">
                <div class="relative p-4 z-[200] text-white flex items-center justify-between">
                    <h5 class="font-bold">Education</h5>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-arrow-right">
                        <path d="M5 12h14" />
                        <path d="m12 5 7 7-7 7" />
                    </svg>
                </div>
            </a>
            <a href="#"
                class="relative flex flex-col justify-end h-[180px] after:bg-secondary-900/45 after:absolute after:top-0 after:left-0 after:w-full after:h-full rounded-[15px] after:rounded-[15px]">
                <img class="w-full h-full absolute" src="{{ asset('/images/history.png') }}" alt="">
                <div class="relative p-4 z-[200] text-white flex items-center justify-between">
                    <h5 class="font-bold">History</h5>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-arrow-right">
                        <path d="M5 12h14" />
                        <path d="m12 5 7 7-7 7" />
                    </svg>
                </div>
            </a>
            <a href="#"
                class="relative flex flex-col justify-end h-[180px] after:bg-secondary-900/45 after:absolute after:top-0 after:left-0 after:w-full after:h-full rounded-[15px] after:rounded-[15px]">
                <img class="w-full h-full absolute" src="{{ asset('/images/sports.png') }}" alt="">
                <div class="relative p-4 z-[200] text-white flex items-center justify-between">
                    <h5 class="font-bold">Sports</h5>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-arrow-right">
                        <path d="M5 12h14" />
                        <path d="m12 5 7 7-7 7" />
                    </svg>
                </div>
            </a>
            <a href="#"
                class="relative flex flex-col justify-end h-[180px] after:bg-secondary-900/45 after:absolute after:top-0 after:left-0 after:w-full after:h-full rounded-[15px] after:rounded-[15px]">
                <img class="w-full h-full absolute" src="{{ asset('/images/science.png') }}" alt="">
                <div class="relative p-4 z-[200] text-white flex items-center justify-between">
                    <h5 class="font-bold">Science</h5>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-arrow-right">
                        <path d="M5 12h14" />
                        <path d="m12 5 7 7-7 7" />
                    </svg>
                </div>
            </a>
            <a href="#"
                class="relative flex flex-col justify-end h-[180px] after:bg-secondary-900/45 after:absolute after:top-0 after:left-0 after:w-full after:h-full rounded-[15px] after:rounded-[15px]">
                <img class="w-full h-full absolute" src="{{ asset('/images/technology.png') }}" alt="">
                <div class="relative p-4 z-[200] text-white flex items-center justify-between">
                    <h5 class="font-bold">Technology</h5>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-arrow-right">
                        <path d="M5 12h14" />
                        <path d="m12 5 7 7-7 7" />
                    </svg>
                </div>
            </a>
        </div>
    </section>
    <section id="about_japr" class="py-[50px]">
        <h3 class="text-2xl font-bold text-primary-500 mb-4">About JAPR</h3>
        <p class="text-secondary-900">
            The Journal of African Policy was originally established to encourage an interdisciplinary academic and
            professional outlet about African political, social, cultural, and economic themes and the components of
            African development issues in the post-independence periods.</p>
        <p>
            The general thrust of The Journal of African Policy Review (JAPR) is that theoretical and conceptual
            discourse of development efforts in Africa must be interdisciplinary whereby policy makers, development
            practitioners, Artists, film- makers and academics will have an academic and professional journal
            through
            which empirical studies and interdisciplinary research could advance scholarship on Africa. Submissions
            are invited that generate ideas on policy implementation that advance the economic, political, and
            cultural
            development of African peoples.
        </p>
    </section>
    <section id="stats" class="py-[100px]">
        <div class="grid grid-cols-4 gap-8">
            <div class="rounded-[15px] p-6 bg-secondary-900 flex flex-col items-center gap-6">
                <div class="flex gap-4 items-center flex-col">
                    <img src="{{ asset('images/metric.svg') }}" alt="Metric">
                    <h4 class="font-bold text-xl text-white">Journals</h4>
                </div>
                <h2 class="text-5xl text-primary-500 font-bold">1004</h2>
            </div>
            <div class="rounded-[15px] p-6 bg-secondary-900 flex flex-col items-center gap-6">
                <div class="flex gap-4 items-center flex-col">
                    <img src="{{ asset('images/metric.svg') }}" alt="Metric">
                    <h4 class="font-bold text-xl text-white">Authors</h4>
                </div>
                <h2 class="text-5xl text-primary-500 font-bold">740</h2>
            </div>
            <div class="rounded-[15px] p-6 bg-secondary-900 flex flex-col items-center gap-6">
                <div class="flex gap-4 items-center flex-col">
                    <img src="{{ asset('images/metric.svg') }}" alt="Metric">
                    <h4 class="font-bold text-xl text-white">Reviewers</h4>
                </div>
                <h2 class="text-5xl text-primary-500 font-bold">72</h2>
            </div>
            <div class="rounded-[15px] p-6 bg-secondary-900 flex flex-col items-center gap-6">
                <div class="flex gap-4 items-center flex-col">
                    <img src="{{ asset('images/metric.svg') }}" alt="Metric">
                    <h4 class="font-bold text-xl text-white">Manuscripts</h4>
                </div>
                <h2 class="text-5xl text-primary-500 font-bold">1604</h2>
            </div>
        </div>
    </section>
</x-layouts.layout>
<script>
    const treeElements = document.querySelectorAll('.tree .category');
    treeElements.forEach((element, index) => {
        element.id = `element-${index}`;
        console.log(element)
        elementTriggers(element)


        const subCategories = element.querySelectorAll('.subcategories .subcategory')
        subCategories.forEach((subCategory) => {
            elementTriggers(subCategory)
            const subSubCategories = subCategory.querySelectorAll('.subsubcategories .subsubcategory')
            elementTriggers(subSubCategories)
        })
    });

    function elementTriggers(el) {
        if (el && typeof el.querySelector === 'function') {
            const checkbox = el.querySelector('[type="checkbox"]')
            console.log('checkbox', checkbox);
            const label = el.querySelector('label');
            console.log('label', label);
            const caretIcon = el.querySelector('.caret-icon');
            console.log('caretIcon', caretIcon);

            const categoryId = checkbox.id.replace('category-', ''); // Extract category ID


            // Add event listener to the caret icon for collapsing/expanding
            caretIcon.addEventListener('click', () => {
                toggleCategory(el);
                el.classList.toggle('collapsed') // Use category ID to toggle
            });

            // Add event listener to the label for collapsing/expanding
            label.addEventListener('click', () => {
                if (checkbox.checked) {
                    checkAllDescendants(el);
                } else {
                    uncheckAllDescendants(el);
                } // Use category ID to toggle
            });

            // Add event listener to the checkbox for "check all" functionality
            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    checkAllDescendants(el);
                } else {
                    uncheckAllDescendants(el);
                }
            });
        } else {
            console.error('elementTriggers received an invalid element');
        }

    }

    function toggleCategory(el) {
        const subcategoriesElement = el.querySelector(`li`); // Select the subcategories UL
        if (subcategoriesElement) {
            subcategoriesElement.classList.toggle('collapsed');
        }
    }

    function toggleSubElements(element, isChecked) {
        const subElements = element.querySelectorAll('li');
        subElements.forEach((subElement) => {
            const subCheckbox = subElement.querySelector('input[type="checkbox"]');
            subCheckbox.checked = isChecked;
            toggleSubElements(subElement, isChecked);
        });
    }

    function checkAllDescendants(element) {
        const descendants = element.querySelectorAll('input[type="checkbox"]');
        descendants.forEach((descendant) => {
            descendant.checked = true;
        });
    }

    function uncheckAllDescendants(element) {
        const descendants = element.querySelectorAll('input[type="checkbox"]');
        descendants.forEach((descendant) => {
            descendant.checked = false;
        });
    }
</script>
