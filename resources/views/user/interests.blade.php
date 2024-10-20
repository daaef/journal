<x-layouts.layout>
    <x-slot:title>
        Welcome to JAPR | Update your Interests
    </x-slot>
    <x-slot:breadcrumb>
        <div class="border-b border-gray-200 pb-5 sm:flex w-full sm:items-center sm:justify-between">
            <div class="flex flex-col">
                <h3 class="text-lg font-bold leading-6 text-primary-500">Interests</h3>
                <h4>Update Your Interests (Only 5 can be selected)</h4>
            </div>
            <div>
                <a href="{{ route('dashboard') }}" class="flex font-medium text-sm text-secondary-900 gap-2 items-center">
                    Skip
                    <img class="h-4" src="{{ asset('images/skip.png') }}" alt="">
                </a>
            </div>
        </div>
        <hr>
    </x-slot:breadcrumb>
    <form id="interests-form" class="mt-8" action="{{ route('interests.store') }}" method="POST">
        @csrf
        <div class="mx-auto">
            <div class="masonry grid grid-cols-3 gap-4 lg:grid-cols-5">
                @if($categories)
                    @foreach($categories as $category)
                        <label for="category-{{ $category->id }}">
                            <input type="checkbox" class="hidden checker" id="category-{{ $category->id }}" name="interests[]" value="{{ $category->uuid }}" @if(in_array($category->uuid, $interests)) checked @endif>
                            <button
                                class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                                <span class="font-medium text-sm">{{ $category->name }}</span>
                            </button>
                        </label>
                    @endforeach
                @endif
            </div>
        </div>
        <button type="submit" id="submit-interests"
            class="mt-6 inline-block rounded-[8px] bg-secondary-900 hover:bg-primary-500 text-white font-bold py-2 px-4 rounded">
            Save  Interests
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
                toastr.warning("You can only select 5 interests");
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
                cb => cb.uuid));
            // Uncomment the next line when you're ready to actually submit the form
            form.submit();
        }
    });

    // Initial setup
    updateButtonStyles();
</script>
