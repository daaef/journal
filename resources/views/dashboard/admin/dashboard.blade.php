<x-layouts.dash_layout>
    <x-slot:title>
        Welcome to your Dashboard
    </x-slot:title>
    <div
        class="grettings-box position-relative rounded-16 bg-[#ff830c] overflow-hidden gap-16 flex-wrap z-1">
        <img src="{{ asset('assets/images/bg/grettings-pattern.png') }}" alt=""
             class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 opacity-6">
        <div class="row gy-4">
            <div class="col-sm-7">
                <div class="grettings-box__content py-xl-4">
                    <h2 class="text-white mb-0">Hello {{ Str::words(auth()->user()->fullname, 1, '') }}! </h2>
                    <p class="text-15 fw-light mt-4 text-white">Let’s create something today</p>
                </div>
            </div>
            <div class="col-sm-5 d-sm-block d-none">
                <div class="text-center h-100 d-flex justify-content-center align-items-end ">
                    <img src="{{ asset('assets/images/thumbs/gretting-img.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</x-layouts.dash_layout>
