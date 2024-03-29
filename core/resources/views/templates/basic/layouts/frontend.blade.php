<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="6pKQERTvX6kqmyMZpGXFRdPUdHMJjxzryM9Y_C1PlDs" />
    <title>{{ $general->sitename(__($pageTitle)) }}</title>
    @include('partials.seo')
    <link rel="icon" type="image/png" href="{{ getImage(imagePath()['logoIcon']['path'] . '/favicon.png') }}"
        sizes="16x16">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/lib/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/lib/bootstrap-drawer.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/lightcase.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/lib/slick.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
    <link href="https://fonts.maateen.me/bensen/font.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/swiper-bundle.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@300;400;500;600;700&family=Noto+Serif+Bengali:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    @stack('style-lib')
    @stack('style')
    <link
        href="{{ asset($activeTemplateTrue . 'frontend/css/color.php') }}?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}"
        rel="stylesheet" />
</head>

<body>
    @stack('fbComment')
    <div class="scroll-to-top">
        <span class="scroll-icon">
            <i class="las la-arrow-up"></i>
        </span>
    </div>
    <div class="preloader-holder">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div style="">
                <img src="{{ asset($activeTemplateTrue . 'loader_logo.png') }}" height="100px" width="100px"
                    alt="loader">
            </div>
        </div>
        <div class="preloader">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    @include($activeTemplate . 'partials.header')
    <div class="main-wrapper">
        @yield('content')
    </div>
    @include($activeTemplate . 'partials.footer')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/lib/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/lib/slick.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/lib/wow.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/lib/lightcase.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/app.js') }}"></script>
    <script src="https://kit.fontawesome.com/88197b63d0.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/share.js') }}"></script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NWD0M01R62"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-NWD0M01R62');
    </script>

    @stack('script-lib')
    @stack('script')
    @include('partials.plugins')
    @include('partials.notify')
    <script>
        (function($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });
        })(jQuery);

        // When the user clicks on div, open the popup
        function myFunction() {
            var popup = document.getElementById("myPopup");
            popup.classList.toggle("show");
        }

        function myFunction1() {
            var popup = document.getElementById("myPopup1");
            popup.classList.toggle("show");
        }

        function myFunction2() {
            var popup = document.getElementById("myPopup2");
            popup.classList.toggle("show");
        }

        function myFunction3() {
            var popup = document.getElementById("myPopup3");
            popup.classList.toggle("show");
        }
        document.addEventListener("DOMContentLoaded", function() {
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    document.getElementById('navbar_top').classList.add('fixed-top');
                    // add padding top to show content behind navbar
                    navbar_height = document.querySelector('.navbar').offsetHeight;
                    document.body.style.paddingTop = navbar_height + 'px';
                } else {
                    document.getElementById('navbar_top').classList.remove('fixed-top');
                    // remove padding top from body
                    document.body.style.paddingTop = '0';
                }
            });
        });

        $(document).ready(function() {
            $('#division-dropdown').on('change', function() {
                var idDivision = this.value;
                $("#city-dropdown").html('');
                $.ajax({
                    url: "{{ Route('fetchcity') }}",
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
                    url: "{{ Route('fetchlocation') }}",
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
    @yield('scripts')
</body>

</html>
