@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $breadcrumb = getContent('breadcrumb.content', true);
    @endphp
    @include($activeTemplate . 'partials.breadcrumb')
    <section class="pt-50 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-4 d-md-block d-none">
                    @php
                        echo advertisements('Single_Donor_Left');
                    @endphp
                </div>
                <div class="col-xl-6 col-lg-9 col-md-8 bg-light rounded-2">
                    <div class="row gy-4">
                        <div class="col-lg-12 col-md-12 col-sm-6 text-center">
                            <img class="img-ext shadow p-1 bg-white"
                                src="{{ getImage('assets/images/donor/' . $donor->image, imagePath()['donor']['size']) }}"
                                alt="@lang('image')"><br>
                            <span style="margin-top: 10px">
                                <h3 class="text-danger">{{ __($donor->name) }}</h3>
                            </span>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-6">
                            <ul class="caption-list-two mt-4"
                                style="background-color: #FFDADC;
                                        margin-left: 10px;
                                        margin-right: 10px;
                                        margin-bottom: 20px;">
                                <li>
                                    <span class="caption">Name</span>
                                    <span class="value">{{ __($donor->name) }}</span>
                                </li>
                                <li>
                                    <span class="caption">Blood Group</span>
                                    <span class="value">{{ __($donor->blood->name) }}</span>
                                </li>
                                <li>
                                    <span class="caption">Last Donate</span>
                                    <span class="value">{{ showDateTime($donor->last_donate, 'd M Y') }}</span>
                                </li>
                                <li>
                                    <span class="caption">Last Donate</span>
                                    <span class="value">{{ showDateTime($donor->last_donate, 'd M Y') }}</span>
                                </li>
                                <li>
                                    <span class="caption">Gender</span>
                                    <span class="value">
                                        @if ($donor->gender == 1)
                                            @lang('Male')
                                        @else
                                            @lang('Female')
                                        @endif
                                    </span>
                                </li>
                                <li>
                                    <span class="caption">Date of Birth</span>
                                    <span class="value">{{ showDateTime($donor->birth_date, 'd M Y') }}</span>
                                </li>
                                <li>
                                    <span class="caption">Age</span>
                                    <span class="value">{{ Carbon\Carbon::parse($donor->birth_date)->age }}
                                        @lang('Years')</span>
                                </li>
                                <li>
                                    <span class="caption">Religion</span>
                                    <span class="value">{{ __($donor->religion) }}</span>
                                </li>
                                <li>
                                    <span class="caption">Profession</span>
                                    <span class="value">{{ __($donor->profession) }}</span>
                                </li>
                                <li>
                                    <span class="caption">Division</span>
                                    <span class="value">{{ __($donor->division->name) }}</span>
                                </li>
                                <li>
                                    <span class="caption">District</span>
                                    <span class="value">{{ __($donor->city->name) }}</span>
                                </li>
                                <li>
                                    <span class="caption">Upazila</span>
                                    <span class="value">{{ __($donor->location->name) }}</span>
                                </li>
                            </ul>
                            <span style="padding-left: 20px; font-weight: bold;">Contact Details</span><br>
                            <span style="padding-left: 20px; color: #00B074;"><a href="{{ route('admin.login') }}">দেখার
                                    জন্য লগইন করুন</a></span>
                            <ul class="caption-list-two"
                                style="background-color: #FFDADC; margin-left: 10px; margin-right: 10px; margin-bottom: 20px;">
                                <li>
                                    <span class="caption">Email</span>
                                    @if (auth()->guard('admin')->check())
                                        <span class="value">{{ __($donor->email) }} <a href=""><i
                                                    class="fa-regular fa-envelope"></i> Email</a></span>
                                    @else
                                        <span class="value">xxxxxxxxxx@gmail.com <p class="popup" style="color: #00B074;"
                                                onclick="myFunction()"> <i class="fa-regular fa-envelope"></i></i> Email
                                                <span class="popuptext" id="myPopup">
                                                    ইমেইল দেখতে <a href="{{ route('apply.donor') }}"> Signup </a> করে <a
                                                        href="{{ route('donor.login') }}"> Login </a> করুন</a>
                                                </span>
                                            </p></span>
                                    @endif
                                </li>

                                <li>
                                    <span class="caption">Phone</span>
                                    @if (auth()->guard('admin')->check())
                                        <span class="value">{{ __($donor->phone) }} <a
                                                href="https://wa.me/+88{{ __($donor->phone) }}"> Click to chat on
                                                WhatsApp</a></span>
                                    @else
                                        <span class="value">01xxxxxxxxx  <p class="popup" style="color: #00B074;"
                                                onclick="myFunction2()"> <i class="fa fa-phone"></i> কল দিন
                                                <span class="popuptext" id="myPopup2">
                                                    মোবাইল নম্বর দেখতে <a href="{{ route('apply.donor') }}"> Signup </a>
                                                    করে <a href="{{ route('donor.login') }}"> Login </a> করুন</a>
                                                </span>
                                    @endif
                                </li>
                                <li>
                                    <span class="caption">Secondary Phone</span>
                                    @if (auth()->guard('admin')->check())
                                        <span class="value">{{ __($donor->phone2) }} <a
                                                href="https://wa.me/+88{{ __($donor->phone2) }}"> Click to chat on
                                                WhatsApp</a></span>
                                    @else
                                        <span class="value">01xxxxxxxxx <p class="popup" style="color: #00B074;"
                                                onclick="myFunction3()"> <i class="fa fa-phone"></i> কল দিন
                                                <span class="popuptext" id="myPopup3">
                                                    মোবাইল নম্বর দেখতে <a href="{{ route('apply.donor') }}"> Signup </a>
                                                    করে <a href="{{ route('admin.login') }}"> Login </a> করুন</a>
                                                </span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-xl-3 d-xl-block d-none">
                    @php
                        echo advertisements('Single_Donor_Right');
                    @endphp
                </div>
            </div>
        </div>
    </section>
@endsection
