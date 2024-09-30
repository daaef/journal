<x-layout>
    <x-slot:title>
        Welcome to JAPR Homepage
    </x-slot>
    <section id="hero" class="py-[50px] min-h-[80vh] pt-[120px]">
        <div class="container px-4">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-2xl font-bold mb-4">Select Your Interests</h1>
                <div class="masonry grid grid-cols-3 gap-4 lg:grid-cols-4">
                    <button class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Technology</span>
                    </button>
                    <button class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Health</span>
                    </button>
                    <button class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Finance</span>
                    </button>
                    <button class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Travel</span>
                    </button>
                    <button class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Education</span>
                    </button>
                    <button class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Food</span>
                    </button>
                    <button class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Travel</span>
                    </button>
                    <button class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Education</span>
                    </button>
                    <button class="masonry-item w-full p-4 rounded-lg shadow hover:shadow-md transition duration-200 bg-gray-300">
                        <span class="text-lg">Food</span>
                    </button>
                    <!-- Add more categories as needed -->
                </div>
            </div>

        </div>
    </section>
</x-layout>
<script>
    // JavaScript to handle button toggle functionality
    let selected = 0
    document.querySelectorAll('.masonry-item').forEach(button => {
        button.addEventListener('click', () => {
            console.log('selected', selected)
            if(selected <= 5 ) button.classList.toggle('active')
        });
    });
</script>
