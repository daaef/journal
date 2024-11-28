<x-layouts.admin_layout>
    <x-slot:title>
        Welcome to your Dashboard
    </x-slot:title>

    <div class="grettings-box position-relative rounded-16 bg-[#ff830c] overflow-hidden gap-16 flex-wrap z-1">
        <img src="{{ loadAssetFile('assets/images/bg/grettings-pattern.png') }}" alt=""
            class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 opacity-6">
        <div class="row gy-4">
            <div class="col-sm-7">
                <div class="grettings-box__content py-xl-4">
                    <h2 class="text-white mb-0">Hello {{ Str::words(auth()->user()->fullname, 1, '') }}! </h2>
                    <p class="text-15 fw-light mt-4 text-white">Let's create something today</p>
                </div>
            </div>
            <div class="col-sm-5 d-sm-block d-none">
                <div class="text-center h-100 d-flex justify-content-center align-items-end ">
                    <img src="{{ loadAssetFile('assets/images/thumbs/gretting-img.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>

    <!-- Widgets Start -->
    <div class="card mt-20">
        <div class="card-body">
            <form class="py-5" method="post" action="{{ route('user.settings.update', $user->uuid) }}">
                @csrf
                <div class="space-y-12">
                    <div class="">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">
                            {{ Str::words(auth()->user()->fullname, 1, '') }}'s Setting</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Update user information</p>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Role: <span
                                class="inline-flex ml-4 items-center gap-x-1.5 py-1 px-3.5 rounded-full text-xs font-medium bg-secondary-900 text-gray-100"> Admin </span>
                        </p>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                            <input type="hidden" name="uuid" value="{{ $user->uuid }}">
                            <div>
                                <label for="fullname" class="block text-sm font-medium leading-6 text-gray-900">First
                                    Name</label>
                                <div class="mt-2">
                                    <input id="fullname" name="fullname" type="text"
                                           value="{{ $user->fullname }}" autocomplete="fullname"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div>
                                <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                                <div class="mt-2">
                                    <input id="username" name="username" type="text"
                                           value="{{ $user->username }}" autocomplete="username"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div>
                                <label for="institution"
                                       class="block text-sm font-medium leading-6 text-gray-900">Institution</label>
                                <div class="mt-2">
                                    <input id="institution" name="username" type="text"
                                           value="{{ $user->institution }}" autocomplete="institution"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Country
                                    /
                                    Region</label>
                                <div class="mt-2">
                                    {{-- <label for="country" class="form-label mb-8 h6"> Country</label> --}}
                                    <div class="position-relative">
                                        <select name="country" id="country"
                                                class="block w-full bg-[#F9FAFB] rounded-md border-0 px-3 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                                            <option value="">Select your country</option>
                                            <optgroup label="Central Africa">
                                                <option
                                                    value="Cameroon" {{ $user->country == 'Cameroon' ? 'selected' : '' }}>
                                                    Cameroon
                                                </option>
                                                <option
                                                    value="Central African Republic" {{ $user->country == 'Central African Republic' ? 'selected' : '' }}>
                                                    Central African Republic
                                                </option>
                                                <option
                                                    value="Chad" {{ $user->country == 'Chad' ? 'selected' : '' }}>
                                                    Chad
                                                </option>
                                                <option
                                                    value="Congo, Democratic Republic of the" {{ $user->country == 'Congo, Democratic Republic of the' ? 'selected' : '' }}>
                                                    Congo, Democratic Republic of
                                                    the
                                                </option>
                                                <option
                                                    value="Congo, Republic of the" {{ $user->country == 'Congo, Republic of the' ? 'selected' : '' }}>
                                                    Congo, Republic of the
                                                </option>
                                                <option
                                                    value="Equatorial Guinea" {{ $user->country == 'Equatorial Guinea' ? 'selected' : '' }}>
                                                    Equatorial Guinea
                                                </option>
                                                <option
                                                    value="Gabon" {{ $user->country == 'Gabon' ? 'selected' : '' }}>
                                                    Gabon
                                                </option>
                                                <option
                                                    value="Sao Tome and Principe" {{ $user->country == 'Sao Tome and Principe' ? 'selected' : '' }}>
                                                    Sao Tome and Principe
                                                </option>
                                            </optgroup>
                                            <optgroup label="Eastern Africa">
                                                <option
                                                    value="Burundi" {{ $user->country == 'Burundi' ? 'selected' : '' }}>
                                                    Burundi
                                                </option>
                                                <option
                                                    value="Comoros" {{ $user->country == 'Comoros' ? 'selected' : '' }}>
                                                    Comoros
                                                </option>
                                                <option
                                                    value="Djibouti" {{ $user->country == 'Djibouti' ? 'selected' : '' }}>
                                                    Djibouti
                                                </option>
                                                <option
                                                    value="Eritrea" {{ $user->country == 'Eritrea' ? 'selected' : '' }}>
                                                    Eritrea
                                                </option>
                                                <option
                                                    value="Ethiopia" {{ $user->country == 'Ethiopia' ? 'selected' : '' }}>
                                                    Ethiopia
                                                </option>
                                                <option
                                                    value="Kenya" {{ $user->country == 'Kenya' ? 'selected' : '' }}>
                                                    Kenya
                                                </option>
                                                <option
                                                    value="Madagascar" {{ $user->country == 'Madagascar' ? 'selected' : '' }}>
                                                    Madagascar
                                                </option>
                                                <option
                                                    value="Malawi" {{ $user->country == 'Malawi' ? 'selected' : '' }}>
                                                    Malawi
                                                </option>
                                                <option
                                                    value="Mauritius" {{ $user->country == 'Mauritius' ? 'selected' : '' }}>
                                                    Mauritius
                                                </option>
                                                <option
                                                    value="Mozambique" {{ $user->country == 'Mozambique' ? 'selected' : '' }}>
                                                    Mozambique
                                                </option>
                                                <option
                                                    value="Rwanda" {{ $user->country == 'Rwanda' ? 'selected' : '' }}>
                                                    Rwanda
                                                </option>
                                                <option
                                                    value="Seychelles" {{ $user->country == 'Seychelles' ? 'selected' : '' }}>
                                                    Seychelles
                                                </option>
                                                <option
                                                    value="Somalia" {{ $user->country == 'Somalia' ? 'selected' : '' }}>
                                                    Somalia
                                                </option>
                                                <option
                                                    value="South Sudan" {{ $user->country == 'South Sudan' ? 'selected' : '' }}>
                                                    South Sudan
                                                </option>
                                                <option
                                                    value="Tanzania" {{ $user->country == 'Tanzania' ? 'selected' : '' }}>
                                                    Tanzania
                                                </option>
                                                <option
                                                    value="Uganda" {{ $user->country == 'Uganda' ? 'selected' : '' }}>
                                                    Uganda
                                                </option>
                                                <option
                                                    value="Zambia" {{ $user->country == 'Zambia' ? 'selected' : '' }}>
                                                    Zambia
                                                </option>
                                                <option
                                                    value="Zimbabwe" {{ $user->country == 'Zimbabwe' ? 'selected' : '' }}>
                                                    Zimbabwe
                                                </option>
                                            </optgroup>
                                            <optgroup label="Northern Africa">
                                                <option
                                                    value="Algeria" {{ $user->country == 'Algeria' ? 'selected' : '' }}>
                                                    Algeria
                                                </option>
                                                <option
                                                    value="Egypt" {{ $user->country == 'Egypt' ? 'selected' : '' }}>
                                                    Egypt
                                                </option>
                                                <option
                                                    value="Libya" {{ $user->country == 'Libya' ? 'selected' : '' }}>
                                                    Libya
                                                </option>
                                                <option
                                                    value="Morocco" {{ $user->country == 'Morocco' ? 'selected' : '' }}>
                                                    Morocco
                                                </option>
                                                <option
                                                    value="Sudan" {{ $user->country == 'Sudan' ? 'selected' : '' }}>
                                                    Sudan
                                                </option>
                                                <option
                                                    value="Tunisia" {{ $user->country == 'Tunisia' ? 'selected' : '' }}>
                                                    Tunisia
                                                </option>
                                                <option
                                                    value="Western Sahara" {{ $user->country == 'Western Sahara' ? 'selected' : '' }}>
                                                    Western Sahara
                                                </option>
                                            </optgroup>
                                            <optgroup label="Southern Africa">
                                                <option
                                                    value="Angola" {{ $user->country == 'Angola' ? 'selected' : '' }}>
                                                    Angola
                                                </option>
                                                <option
                                                    value="Botswana" {{ $user->country == 'Botswana' ? 'selected' : '' }}>
                                                    Botswana
                                                </option>
                                                <option
                                                    value="Lesotho" {{ $user->country == 'Lesotho' ? 'selected' : '' }}>
                                                    Lesotho
                                                </option>
                                                <option
                                                    value="Namibia" {{ $user->country == 'Namibia' ? 'selected' : '' }}>
                                                    Namibia
                                                </option>
                                                <option
                                                    value="South Africa" {{ $user->country == 'South Africa' ? 'selected' : '' }}>
                                                    South Africa
                                                </option>
                                                <option
                                                    value="Swaziland" {{ $user->country == 'Swaziland' ? 'selected' : '' }}>
                                                    Swaziland
                                                </option>
                                            </optgroup>
                                            <optgroup label="Western Africa">
                                                <option
                                                    value="Benin" {{ $user->country == 'Benin' ? 'selected' : '' }}>
                                                    Benin
                                                </option>
                                                <option
                                                    value="Burkina Faso" {{ $user->country == 'Burkina Faso' ? 'selected' : '' }}>
                                                    Burkina Faso
                                                </option>
                                                <option
                                                    value="Cape Verde" {{ $user->country == 'Cape Verde' ? 'selected' : '' }}>
                                                    Cape Verde
                                                </option>
                                                <option
                                                    value="Cote d'Ivoire" {{ $user->country == `Cote d'Ivoire` ? 'selected' : '' }}>
                                                    Cote d'Ivoire
                                                </option>
                                                <option
                                                    value="Gambia" {{ $user->country == 'Gambia' ? 'selected' : '' }}>
                                                    Gambia
                                                </option>
                                                <option
                                                    value="Ghana" {{ $user->country == 'Ghana' ? 'selected' : '' }}>
                                                    Ghana
                                                </option>
                                                <option
                                                    value="Guinea" {{ $user->country == 'Guinea' ? 'selected' : '' }}>
                                                    Guinea
                                                </option>
                                                <option
                                                    value="Guinea-Bissau" {{ $user->country == 'Guinea-Bissau' ? 'selected' : '' }}>
                                                    Guinea-Bissau
                                                </option>
                                                <option
                                                    value="Liberia" {{ $user->country == 'Liberia' ? 'selected' : '' }}>
                                                    Liberia
                                                </option>
                                                <option
                                                    value="Mali" {{ $user->country == 'Mali' ? 'selected' : '' }}>
                                                    Mali
                                                </option>
                                                <option
                                                    value="Mauritania" {{ $user->country == 'Mauritania' ? 'selected' : '' }}>
                                                    Mauritania
                                                </option>
                                                <option
                                                    value="Niger" {{ $user->country == 'Niger' ? 'selected' : '' }}>
                                                    Niger
                                                </option>
                                                <option
                                                    value="Nigeria" {{ $user->country == 'Nigeria' ? 'selected' : '' }}>
                                                    Nigeria
                                                </option>
                                                <option
                                                    value="Senegal" {{ $user->country == 'Senegal' ? 'selected' : '' }}>
                                                    Senegal
                                                </option>
                                                <option
                                                    value="Sierra Leone" {{ $user->country == 'Sierra Leone' ? 'selected' : '' }}>
                                                    Sierra Leone
                                                </option>
                                                <option
                                                    value="Togo" {{ $user->country == 'Togo' ? 'selected' : '' }}>
                                                    Togo
                                                </option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                                <div class="mt-2">
                                    <input id="email" name="email" type="email" value="{{ $user->email }}"
                                           autocomplete="email"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div>
                                <label for="old_password"
                                       class="block text-sm font-medium leading-6 text-gray-900">Old
                                    Password</label>
                                <div class="mt-2">
                                    <input id="old_password" name="old_password" type="password"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            {{-- <div>
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Confirm
                                    Email</label>
                                <div class="mt-2">
                                    <input id="email" name="email" type="text" autocomplete="email"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div> --}}
                            <div>
                                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">New
                                    Password</label>
                                <div class="mt-2">
                                    <input id="password" name="password" type="password"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div>
                                <label for="confirm_password"
                                       class="block text-sm font-medium leading-6 text-gray-900">Confirm New
                                    Password</label>
                                <div class="mt-2">
                                    <input id="confirm_password" name="confirm_password" type="password"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="submit"
                            class="rounded-md bg-green-800 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                        Update Account
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Widgets End -->
</x-layouts.admin_layout>
