<x-layouts.layout>
    <x-slot:title>
        Welcome to JAPR | Select your Interests
    </x-slot>
    <div class="border-b border-gray-200 pb-5 sm:flex w-full sm:items-center sm:justify-between">
        <h3 class="text-lg font-bold leading-6 text-gray-900">Interests</h3>
        <div>
            <h4>Select 5 categories that interest you</h4>
        </div>
    </div>
    <hr class="mb-8">
    <div class="mx-auto">
        <div class="masonry grid grid-cols-3 gap-4 lg:grid-cols-5">
            <button
                class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                <span class="text-lg">Technology</span>
            </button>
            <button
                class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                <span class="text-lg">Health</span>
            </button>
            <button
                class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                <span class="text-lg">Finance</span>
            </button>
            <button
                class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                <span class="text-lg">Travel</span>
            </button>
            <button
                class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                <span class="text-lg">Education</span>
            </button>
            <button
                class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                <span class="text-lg">Food</span>
            </button>
            <button
                class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                <span class="text-lg">Travel</span>
            </button>
            <button
                class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                <span class="text-lg">Education</span>
            </button>
            <button
                class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                <span class="text-lg">Food</span>
            </button>
        </div>
    </div>
    <a href="{{ route('home') }}" id="submit-interests"
        class="mt-6 inline-block rounded-[8px] bg-secondary-900 hover:bg-primary-500 text-white font-bold py-2 px-4 rounded">
        Submit Interests
    </a>
</x-layouts.layout>
<script>
    // JavaScript to handle button toggle functionality with a limit of 5 selections
    let selected = 0;
    const maxSelections = 5;
    const selectionCountElement = document.getElementById('selection-count');

    document.querySelectorAll('.masonry-item').forEach(button => {
        button.addEventListener('click', () => {
            if (button.classList.contains('active')) {
                button.classList.remove('active');
                selected--;
            } else if (selected < maxSelections) {
                button.classList.add('active');
                selected++;
            } else {
                toastr.options.timeOut = 10000;
                toastr.info("You can only select 5 interests");
            }

            updateSelectionCount();
        });
    });

    function updateSelectionCount() {
        selectionCountElement.textContent = `Selected: ${selected}/${maxSelections}`;
    }
</script>
