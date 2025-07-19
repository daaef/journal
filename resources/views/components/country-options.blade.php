{{-- Country options for select dropdowns --}}
@php
    $countriesByRegion = \App\Models\Country::getAllGroupedByRegion();
@endphp

@foreach($countriesByRegion as $regionName => $countries)
    <optgroup label="{{ $regionName }}">
        @foreach($countries as $country)
            <option value="{{ $country->name }}" {{ $selectedCountry == $country->name ? 'selected' : '' }}>
                {{ $country->name }}
            </option>
        @endforeach
    </optgroup>
@endforeach
