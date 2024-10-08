<x-layouts.layout>
    <x-slot:title>
        Welcome to JAPR | Select your Interests
    </x-slot>
    <div class="border-b border-gray-200 pb-5 sm:flex w-full sm:items-center sm:justify-between">
        <div class="flex flex-col">
            <h3 class="text-lg font-bold leading-6 text-primary-500">Interests</h3>
            <h4>Select 5 categories that interest you</h4>
        </div>
        <div>
            <a href="#" class="flex font-medium text-sm text-secondary-900 gap-2 items-center">
                Skip
                <img class="h-4" src="{{ asset('images/skip.png') }}" alt="">
            </a>
        </div>
    </div>
    <hr class="mb-8">
    <form id="interests-form" action="" method="POST">
        @csrf
        <div class="mx-auto">
            <div class="masonry grid grid-cols-3 gap-4 lg:grid-cols-5">
                <label for="cat1">
                    <input type="checkbox" class="hidden checker" id="cat1" name="technology">
                    <button
                        class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Technology</span>
                    </button>
                </label>
                <label for="cat2">
                    <input type="checkbox" class="hidden" id="cat2">
                    <button
                        class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Health</span>
                    </button>
                </label>
                <label for="cat3">
                    <input type="checkbox" class="hidden" id="cat3">
                    <button
                        class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Finance</span>
                    </button>
                </label>
                <label for="cat4">
                    <input type="checkbox" class="hidden" id="cat4">
                    <button
                        class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Travel</span>
                    </button>
                </label>
                <label for="cat5">
                    <input type="checkbox" class="hidden" id="cat5">
                    <button
                        class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Education</span>
                    </button>
                </label>
                <label for="cat6">
                    <input type="checkbox" class="hidden" id="cat6">
                    <button
                        class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Food</span>
                    </button>
                </label>
                <label for="cat7">
                    <input type="checkbox" class="hidden" id="cat7">
                    <button
                        class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Travel</span>
                    </button>
                </label>
                <label for="cat8">
                    <input type="checkbox" class="hidden" id="cat8">
                    <button
                        class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Education</span>
                    </button>
                </label>
                <label for="cat9">
                    <input type="checkbox" class="hidden" id="cat9">
                    <button
                        class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Food</span>
                    </button>
                </label>
            </div>
        </div>
        <button type="submit" id="submit-interests"
            class="mt-6 inline-block rounded-[8px] bg-secondary-900 hover:bg-primary-500 text-white font-bold py-2 px-4 rounded">
            Submit Interests
        </button>
    </form>
</x-layouts.layout>
<script>
    // JavaScript to handle button toggle functionality with a limit of 5 selections
    const maxSelections = 5;
    const form = document.getElementById('interests-form');
    const checkboxes = form.querySelectorAll('input[type="checkbox"]');
    const buttons = form.querySelectorAll('.masonry-item');
    const submitButton = document.getElementById('submit-interests');

    function updateButtonStyles() {
        checkboxes.forEach((checkbox, index) => {
            if (checkbox.checked) {
                buttons[index].classList.add('active');
            } else {
                buttons[index].classList.remove('active');
            }
        });
    }

    function getSelectedCount() {
        return form.querySelectorAll('input[type="checkbox"]:checked').length;
    }

    buttons.forEach((button, index) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const checkbox = checkboxes[index];
            const selectedCount = getSelectedCount();

            if (checkbox.checked) {
                checkbox.checked = false;
            } else if (selectedCount < maxSelections) {
                checkbox.checked = true;
            } else {
                toastr.options.timeOut = 10000;
                toastr.info("You can only select 5 interests");
            }

            updateButtonStyles();
        });
    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const selectedCount = getSelectedCount();

        if (selectedCount === 0) {
            toastr.error("Please select at least one interest.");
        } else if (selectedCount > maxSelections) {
            toastr.error(`Please select no more than ${maxSelections} interests.`);
        } else {
            // Form is valid, you can submit it here
            console.log('Form submitted with interests:', Array.from(checkboxes).filter(cb => cb.checked).map(
                cb => cb.value));
            // Uncomment the next line when you're ready to actually submit the form
            // form.submit();
        }
    });

    // Initial setup
    updateButtonStyles();
</script>
