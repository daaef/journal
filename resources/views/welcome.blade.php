<x-layout>
    <x-slot:title>
        Welcome to JAPR Homepage
    </x-slot>
    <section id="hero" class="py-[100px] min-h-[100vh] pt-[200px]">
        <div class="container grid grid-cols-[300px_1fr]">
            <div class="border-[1px] rounded-[15px] p-2 border-primary-900 rounded-r-none border-r-0">
                <div class="flex justify-between items-center">
                    <h3 class="pb-1 text-sm">Categories Filter</h3>
                    <a href="#" class="text-xs font-light">Clear All</a>
                </div>
                <hr class="border-b border-t-0 border-primary-900 border-[px] mb-2">
                <!-- Tree Root -->
                <div class="hs-accordion-treeview-root" role="tree" aria-orientation="vertical">
                    <!-- 1st Level Accordion Group -->
                    <div class="hs-accordion-group" role="group" data-hs-accordion-always-open="">
                        <!-- 1st Level Accordion -->
                        <div class="hs-accordion active" role="treeitem" aria-expanded="true"
                             id="hs-basic-tree-heading-one">
                            <!-- 1st Level Accordion Heading -->
                            <div class="hs-accordion-heading py-0.5 flex items-center gap-x-0.5 w-full">
                                <button
                                    class="hs-accordion-toggle size-6 flex justify-center items-center hover:bg-gray-100 rounded-md focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
                                    aria-expanded="true" aria-controls="hs-basic-tree-collapse-one">
                                    <svg class="size-4 text-gray-800"
                                         xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                        <path class="hs-accordion-active:hidden block" d="M12 5v14"></path>
                                    </svg>
                                </button>

                                <div
                                    class="grow hs-accordion-selectable hs-accordion-selected:bg-gray-100 px-1.5 rounded-md cursor-pointer">
                                    <div class="flex items-center gap-x-3">
                                        <svg class="shrink-0 size-4 text-gray-500"
                                             xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <path
                                                d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path>
                                        </svg>
                                        <div class="grow">
                                          <span class="text-sm text-gray-800">
                                            assets
                                          </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End 1st Level Accordion Heading -->

                            <!-- 1st Level Collapse -->
                            <div id="hs-basic-tree-collapse-one"
                                 class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                 role="group" aria-labelledby="hs-basic-tree-heading-one">
                                <!-- 2nd Level Accordion Group -->
                                <div
                                    class="hs-accordion-group ps-7 relative before:absolute before:top-0 before:start-3 before:w-0.5 before:-ms-px before:h-full before:bg-gray-100"
                                    role="group" data-hs-accordion-always-open="">
                                    <!-- 2nd Level Nested Accordion -->
                                    <div class="hs-accordion active" role="treeitem" aria-expanded="true"
                                         id="hs-basic-tree-sub-heading-one">
                                        <!-- 2nd Level Accordion Heading -->
                                        <div class="hs-accordion-heading py-0.5 flex items-center gap-x-0.5 w-full">
                                            <button
                                                class="hs-accordion-toggle size-6 flex justify-center items-center hover:bg-gray-100 rounded-md focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
                                                aria-expanded="true" aria-controls="hs-basic-tree-sub-collapse-one">
                                                <svg class="size-4 text-gray-800"
                                                     xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M5 12h14"></path>
                                                    <path class="hs-accordion-active:hidden block" d="M12 5v14"></path>
                                                </svg>
                                            </button>

                                            <div
                                                class="grow hs-accordion-selectable hs-accordion-selected:bg-gray-100 px-1.5 rounded-md cursor-pointer">
                                                <div class="flex items-center gap-x-3">
                                                    <svg class="shrink-0 size-4 text-gray-500"
                                                         xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                         stroke-width="1.5" stroke-linecap="round"
                                                         stroke-linejoin="round">
                                                        <path
                                                            d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path>
                                                    </svg>
                                                    <div class="grow">
                    <span class="text-sm text-gray-800">
                      css
                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End 2nd Level Accordion Heading -->

                                        <!-- 2nd Level Collapse -->
                                        <div id="hs-basic-tree-sub-collapse-one"
                                             class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                             role="group" aria-labelledby="hs-basic-tree-sub-heading-one">
                                            <!-- 3rd Level Accordion Group -->
                                            <div
                                                class="hs-accordion-group ps-7 relative before:absolute before:top-0 before:start-3 before:w-0.5 before:-ms-px before:h-full before:bg-gray-100"
                                                role="group" data-hs-accordion-always-open="">
                                                <!-- 3rd Level Accordion -->
                                                <div class="hs-accordion active" role="treeitem" aria-expanded="true"
                                                     id="hs-basic-tree-sub-level-two-heading-one">
                                                    <!-- 3rd Level Accordion Heading -->
                                                    <div
                                                        class="hs-accordion-heading py-0.5 flex items-center gap-x-0.5 w-full">
                                                        <button
                                                            class="hs-accordion-toggle size-6 flex justify-center items-center hover:bg-gray-100 rounded-md focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
                                                            aria-expanded="true"
                                                            aria-controls="hs-basic-tree-sub-level-two-collapse-one">
                                                            <svg class="size-4 text-gray-800"
                                                                 xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24"
                                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                 stroke-width="1.5" stroke-linecap="round"
                                                                 stroke-linejoin="round">
                                                                <path d="M5 12h14"></path>
                                                                <path class="hs-accordion-active:hidden block"
                                                                      d="M12 5v14"></path>
                                                            </svg>
                                                        </button>

                                                        <div
                                                            class="grow hs-accordion-selectable hs-accordion-selected:bg-gray-100 px-1.5 rounded-md cursor-pointer">
                                                            <div class="flex items-center gap-x-3">
                                                                <svg
                                                                    class="shrink-0 size-4 text-gray-500"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path
                                                                        d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path>
                                                                </svg>
                                                                <div class="grow">
                                                                  <span class="text-sm text-gray-800">
                                                                    main
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End 3rd Level Accordion Heading -->

                                                    <!-- 3rd Level Collapse -->
                                                    <div id="hs-basic-tree-sub-level-two-collapse-one"
                                                         class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                                         role="group"
                                                         aria-labelledby="hs-basic-tree-sub-level-two-heading-one">
                                                        <div
                                                            class="ms-3 ps-3 relative before:absolute before:top-0 before:start-0 before:w-0.5 before:-ms-px before:h-full before:bg-gray-100">
                                                            <!-- 3rd Level Item -->
                                                            <div
                                                                class="hs-accordion-selectable hs-accordion-selected:bg-gray-100 px-2 rounded-md cursor-pointer"
                                                                role="treeitem">
                                                                <div class="flex items-center gap-x-3">
                                                                    <svg
                                                                        class="shrink-0 size-4 text-gray-500"
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                        <path
                                                                            d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                                                    </svg>
                                                                    <div class="grow">
                                                                    <span class="text-sm text-gray-800">
                                                                      main.css
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End 3rd Level Item -->

                                                            <!-- 3rd Level Item -->
                                                            <div
                                                                class="hs-accordion-selectable hs-accordion-selected:bg-gray-100 px-2 rounded-md cursor-pointer"
                                                                role="treeitem">
                                                                <div class="flex items-center gap-x-3">
                                                                    <svg
                                                                        class="shrink-0 size-4 text-gray-500"
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                        <path
                                                                            d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                                                    </svg>
                                                                    <div class="grow">
                                                                    <span class="text-sm text-gray-800">
                                                                      docs.css
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End 3rd Level Item -->

                                                            <!-- 3rd Level Item -->
                                                            <div class="px-2">
                                                            <span class="text-sm text-gray-800">
                                                              README.txt
                                                            </span>
                                                            </div>
                                                            <!-- End 3rd Level Item -->
                                                        </div>
                                                    </div>
                                                    <!-- End 3rd Level Collapse -->
                                                </div>
                                                <!-- End 3rd Level Accordion -->

                                                <!-- 3rd Level Accordion -->
                                                <div class="hs-accordion" role="treeitem" aria-expanded="false"
                                                     id="hs-basic-tree-sub-level-two-heading-two">
                                                    <!-- 3rd Level Accordion Heading -->
                                                    <div
                                                        class="hs-accordion-heading py-0.5 flex items-center gap-x-0.5 w-full">
                                                        <button
                                                            class="hs-accordion-toggle size-6 flex justify-center items-center hover:bg-gray-100 rounded-md focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
                                                            aria-expanded="false"
                                                            aria-controls="hs-basic-tree-sub-level-two-collapse-two">
                                                            <svg class="size-4 text-gray-800"
                                                                 xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24"
                                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                 stroke-width="1.5" stroke-linecap="round"
                                                                 stroke-linejoin="round">
                                                                <path d="M5 12h14"></path>
                                                                <path class="hs-accordion-active:hidden block"
                                                                      d="M12 5v14"></path>
                                                            </svg>
                                                        </button>

                                                        <div
                                                            class="grow hs-accordion-selectable hs-accordion-selected:bg-gray-100 px-1.5 rounded-md cursor-pointer">
                                                            <div class="flex items-center gap-x-3">
                                                                <svg
                                                                    class="shrink-0 size-4 text-gray-500"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path
                                                                        d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path>
                                                                </svg>
                                                                <div class="grow">
                                                                  <span class="text-sm text-gray-800">
                                                                    tailwind
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End 3rd Level Accordion Heading -->

                                                    <!-- 3rd Level Collapse -->
                                                    <div id="hs-basic-tree-sub-level-two-collapse-two"
                                                         class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                                                         role="group"
                                                         aria-labelledby="hs-basic-tree-sub-level-two-heading-two">
                                                        <div
                                                            class="ms-3 ps-3 relative before:absolute before:top-0 before:start-0 before:w-0.5 before:-ms-px before:h-full before:bg-gray-100">
                                                            <!-- 3rd Level Item -->
                                                            <div
                                                                class="hs-accordion-selectable hs-accordion-selected:bg-gray-100 px-2 rounded-md cursor-pointer"
                                                                role="treeitem">
                                                                <div class="flex items-center gap-x-3">
                                                                    <svg
                                                                        class="shrink-0 size-4 text-gray-500"
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                        <path
                                                                            d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                                                    </svg>
                                                                    <div class="grow">
                                                                    <span class="text-sm text-gray-800">
                                                                      input.css
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End 3rd Level Item -->
                                                        </div>
                                                    </div>
                                                    <!-- End 3rd Level Collapse -->
                                                </div>
                                                <!-- End 3rd Level Accordion -->

                                                <!-- 3rd Level Heading -->
                                                <div class="py-0.5 px-1.5" role="treeitem">
                                                  <span class="text-sm text-gray-800">
                                                    .gitignore
                                                  </span>
                                                </div>
                                                <!-- End 3rd Level Heading -->
                                            </div>
                                            <!-- End 3rd Level Accordion Group -->
                                        </div>
                                        <!-- End 2nd Level Collapse -->
                                    </div>
                                    <!-- End 2nd Level Nested Accordion -->
                                </div>
                                <!-- 2nd Level Accordion Group -->
                            </div>
                            <!-- End 1st Level Collapse -->
                        </div>
                        <!-- End 1st Level Accordion -->
                    </div>
                    <!-- End 1st Level Accordion Group -->
                </div>
                <!-- End Tree Root -->
            </div>
            <div class="h-[560px] bg-secondary-900 rounded-r-[15px] grid grid-cols-2 overflow-x-hidden">
                <div class="px-14 flex justify-center gap-4 flex-col">
                    <h3 class="text-5xl font-bold from-white to-primary-500 bg-gradient-to-r bg-clip-text text-transparent">
                        Gateway to African Knowledge</h3>
                    <p class="text-white text-xl">Explore Journals, Literature, and Research Across the Continent</p>
                    <div class="flex rounded-[15px] shadow-sm relative">
                        <input type="text" id="hs-trailing-button-add-on-with-icon"
                               name="hs-trailing-button-add-on-with-icon"
                               class="py-3 px-4 block w-full border-gray-200 shadow-sm rounded-[15px] text-sm focus:z-10 focus:border-primary-500 focus:ring-primary-500 disabled:opacity-50 disabled:pointer-events-none"
                               placeholder="Search  for a keyword, title, publication date, ISSN, ISBN, DOI ">
                        <button type="button"
                                class="w-[2.875rem] z-[1000] h-[2.875rem] absolute right-0 shrink-0 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-[15px] border border-transparent bg-primary-500 text-white hover:bg-primary-900 focus:outline-none focus:bg-primary-950 disabled:opacity-50 disabled:pointer-events-none">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <img class="w-full h-[560px] object-fit-cover" src="{{ asset('/images/headerImg.png') }}" alt="">
            </div>
        </div>
    </section>
    <section id="most_viewed" class="py-[100px]">
        <div class="container">
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-arrow-right">
                            <path d="M5 12h14"/>
                            <path d="m12 5 7 7-7 7"/>
                        </svg>
                    </div>
                </a>
                <a href="#"
                   class="relative flex flex-col justify-end h-[180px] after:bg-secondary-900/45 after:absolute after:top-0 after:left-0 after:w-full after:h-full rounded-[15px] after:rounded-[15px]">
                    <img class="w-full h-full absolute" src="{{ asset('/images/history.png') }}" alt="">
                    <div class="relative p-4 z-[200] text-white flex items-center justify-between">
                        <h5 class="font-bold">History</h5>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-arrow-right">
                            <path d="M5 12h14"/>
                            <path d="m12 5 7 7-7 7"/>
                        </svg>
                    </div>
                </a>
                <a href="#"
                   class="relative flex flex-col justify-end h-[180px] after:bg-secondary-900/45 after:absolute after:top-0 after:left-0 after:w-full after:h-full rounded-[15px] after:rounded-[15px]">
                    <img class="w-full h-full absolute" src="{{ asset('/images/sports.png') }}" alt="">
                    <div class="relative p-4 z-[200] text-white flex items-center justify-between">
                        <h5 class="font-bold">Sports</h5>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-arrow-right">
                            <path d="M5 12h14"/>
                            <path d="m12 5 7 7-7 7"/>
                        </svg>
                    </div>
                </a>
                <a href="#"
                   class="relative flex flex-col justify-end h-[180px] after:bg-secondary-900/45 after:absolute after:top-0 after:left-0 after:w-full after:h-full rounded-[15px] after:rounded-[15px]">
                    <img class="w-full h-full absolute" src="{{ asset('/images/science.png') }}" alt="">
                    <div class="relative p-4 z-[200] text-white flex items-center justify-between">
                        <h5 class="font-bold">Science</h5>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-arrow-right">
                            <path d="M5 12h14"/>
                            <path d="m12 5 7 7-7 7"/>
                        </svg>
                    </div>
                </a>
                <a href="#"
                   class="relative flex flex-col justify-end h-[180px] after:bg-secondary-900/45 after:absolute after:top-0 after:left-0 after:w-full after:h-full rounded-[15px] after:rounded-[15px]">
                    <img class="w-full h-full absolute" src="{{ asset('/images/technology.png') }}" alt="">
                    <div class="relative p-4 z-[200] text-white flex items-center justify-between">
                        <h5 class="font-bold">Technology</h5>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-arrow-right">
                            <path d="M5 12h14"/>
                            <path d="m12 5 7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </section>
    <section id="about_japr" class="py-[100px]">
        <div class="container">
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
        </div>
    </section>
    <section id="stats" class="py-[100px]">
        <div class="container grid grid-cols-4 gap-8">
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
</x-layout>
