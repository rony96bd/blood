@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @include($activeTemplate . 'partials.breadcrumb')
    <div class="donor-search-area">
        <div class="container">
            <form method="GET" action="{{ route('donor.search') }}" class="hero__blood-search-form">
                <div class="input-field">
                    <i class="las la-tint"></i>
                    <select name="blood_id">
                        <option value="" selected="" disabled="">@lang('রক্তের গ্রুপ')</option>
                        @foreach ($bloods as $blood)
                            <option value="{{ __($blood->id) }}">{{ __($blood->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-field">
                    <i class="las la-location-arrow"></i>
                    <select class="select" name="division_id" id="division-dropdown">
                        <option value="" disabled="" selected="">@lang('বিভাগ')</option>
                        @foreach ($divisions as $data)
                            <option value="{{ $data->id }}">
                                {{ $data->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-field">
                    <i class="las la-location-arrow"></i>
                    <select class="select" name="city_id" id="city-dropdown">
                        <option value="" disabled="" selected="">@lang('জেলা')</option>
                    </select>
                </div>
                <div class="input-field">
                    <i class="las la-location-arrow"></i>
                    <select class="select" name="location_id" id="location-dropdown">
                        <option value="" disabled="" selected="">@lang('উপজেলা')</option>
                    </select>
                </div>
                <div class="btn-area">
                    <button type="submit" class="btn btn-md btn--base"><i class="las la-search"></i>
                        @lang('খুঁজুন')</button>
                </div>
            </form>
        </div>
    </div>
    <style>
        .section-header h4::after {
            content: '';
            height: 2px;
            width: 90px;
            background: hsl(0, 100%, 50%);
            display: block;
            margin: 0 auto;
            margin-top: 2px;
        }
    </style>
    @if (\Request::route()->getName() != 'donor.search')
    @else
        <section>
            <div class="container" style="padding: 0px;">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section-header text-center">
                            <h4 style="font-weight: bold">অনুসন্ধান ফলাফল</h4>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <nav
                        style="background: white; padding: 3px 0px 0px 10px; border-radius: 8px; font-weight: 600; color: #00B074;">
                        @php
                            $division = app('request')->input('division_id');
                            $city = app('request')->input('city_id');

                            $division_name = App\Models\Division::where('id', $division)->first();
                            $city_name = App\Models\City::where('id', $city)->first();
                        @endphp
                        {{ $division_name->name ?? ""}} > {{ $city_name->name ?? ""}} - ( {{ $don_count }} )
                    </nav>
                </div>
        </section>
    @endif

    <section class="pb-50" style="padding-top: 20px">
        <div class="container">
            <div class="row">
                <div class="col-xl-2 d-xl-block d-none">
                    @php
                        echo advertisements('All_Donor_Left');
                    @endphp
                </div>
                <div class="col-xl-8 col-lg-9 col-md-12">
                    <div class="row gy-4">
                        @forelse($donors as $donor)
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="donor-item has--link" style="font-family: 'Noto Sans Bengali',  sans-serif;">

                                    <div class="donor-item__thumb">
                                        <img src="{{ getImage('assets/images/donor/' . $donor->image, imagePath()['donor']['size']) }}"
                                            alt="@lang('image')">
                                    </div>
                                    <div class="donor-item__content">
                                        <h5 class="donor-item__name">{{ __($donor->name) }}</h5>
                                        <ul class="donor-item__list">
                                            <li class="donor-item__list">
                                                <i style="color: red" class="las la-tint"></i> @lang('ব্লাড গ্রুপ') :
                                                <span style="color: red">
                                                    {{ __($donor->blood->name) }}
                                                    @if ($donor->blood->name == 'A+')
                                                        (এ পজেটিভ)
                                                    @elseif ($donor->blood->name == 'A-')
                                                        (এ নেগেটিভ)
                                                    @elseif ($donor->blood->name == 'B+')
                                                        (বি পজেটিভ)
                                                    @elseif ($donor->blood->name == 'B-')
                                                        (বি নেগেটিভ)
                                                    @elseif ($donor->blood->name == 'AB+')
                                                        (এবি পজেটিভ)
                                                    @elseif ($donor->blood->name == 'AB-')
                                                        (এবি নেগেটিভ)
                                                    @elseif ($donor->blood->name == 'O+')
                                                        (ও পজেটিভ)
                                                    @elseif ($donor->blood->name == 'O-')
                                                        (ও নেগেটিভ)
                                                    @else
                                                    @endif
                                                </span>
                                            </li>
                                            {{-- <li>
                                                সর্বশেষ রক্ত প্রদান: {{ showDateTime($donor->last_donate, 'd M Y') }}
                                            </li> --}}
                                            <li class="text-truncate" style="margin-bottom: 3px; font-weight: bold;">
                                                <i style="color:#00B074" class="las la-map-marker-alt"></i>
                                                {{ __($donor->location->name) }},
                                                {{ __($donor->city->name) }},
                                                {{ __($donor->division->name) }}
                                            </li>
                                        </ul>
                                        <div class="row">
                                            <div class="col-7 text-white"><span><a
                                                        href="{{ route('donor.details', [slug($donor->name), $donor->id]) }}"
                                                        class="custom-btn">View Details <i
                                                            class="fa fa-angle-double-right"></i></a></span></div>
                                            <div class="col-5" style="text-align: right;"><i class="las la-eye"></i>
                                                {{ __($donor->click) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <h3 class="text-center">{{ $emptyMessage }}</h3>
                        @endforelse
                    </div>
                    <nav class="mt-4 pagination-md">
                    </nav>
                </div>
                <div class="col-xl-2 d-xl-block d-none">
                    @php
                        echo advertisements('All_Donor_Right');
                    @endphp

                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#division-dropdown').on('change', function() {
                var idDivision = this.value;
                $("#city-dropdown").html('');
                $.ajax({
                    url: "{{ url('api/fetch-cities') }}",
                    type: "POST",
                    data: {
                        division_id: idDivision,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#city-dropdown').html(
                            '<option value="">-- জেলা সিলেক্ট করুন --</option>');
                        $.each(result.cities, function(key, value) {
                            $("#city-dropdown").append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                        $('#location-dropdown').html(
                            '<option value="">-- Select City --</option>');
                    }
                })
            });

            $('#city-dropdown').on('change', function() {
                var idCity = this.value;
                $("#location-dropdown").html('');
                $.ajax({
                    url: "{{ url('api/fetch-locations') }}",
                    type: "POST",
                    data: {
                        city_id: idCity,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#location-dropdown').html(
                            '<option value="">-- উপজেলা সিলেক্ট করুন --</option>');
                        $.each(result.locations, function(key, value) {
                            $("#location-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                })
            });
        });
    </script>
@endpush
