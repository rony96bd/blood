@extends('admin.layouts.app')
@section('panel')
    <style>
        h1 {
            font-size: 20px;
            text-align: center;
            margin: 20px 0 20px;
        }

        h1 small {
            display: block;
            font-size: 15px;
            padding-top: 8px;
            color: gray;
        }

        .avatar-upload {
            position: relative;
            max-width: 205px;
            margin: 5px auto;
        }

        .avatar-upload .avatar-edit {
            position: absolute;
            right: 12px;
            z-index: 1;
            top: 10px;
        }

        .avatar-upload .avatar-edit input {
            display: none;
        }

        .avatar-upload .avatar-edit input+label {
            display: inline-block;
            width: 34px;
            height: 34px;
            margin-bottom: 0;
            border-radius: 100%;
            background: #FFFFFF;
            border: 1px solid transparent;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            font-weight: normal;
            transition: all 0.2s ease-in-out;
        }

        .avatar-upload .avatar-edit input+label:hover {
            background: #f1f1f1;
            border-color: #d6d6d6;
        }

        .avatar-upload .avatar-edit input+label:after {
            content: "\f040";
            font-family: 'FontAwesome';
            color: #757575;
            position: absolute;
            top: 10px;
            left: 0;
            right: 0;
            text-align: center;
            margin: auto;
        }

        .avatar-upload .avatar-preview {
            width: 192px;
            height: 192px;
            position: relative;
            border-radius: 100%;
            border: 6px solid #F8F8F8;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
        }

        .avatar-upload .avatar-preview>div {
            width: 100%;
            height: 100%;
            border-radius: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .container2 .btn {
            position: absolute;
            top: 90%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);

            color: white;
            font-size: 16px;

            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-align: center;
        }

        #image {
            display: block;
            /* This rule is very important, please don't ignore this */
            max-width: 100%;
        }

        .error {
            color: red;
        }

        .cropper-container {
            right: 12px;
        }

        form label {
            color: #000;
            font-weight: bold;
        }
    </style>
    <div class="row mb-none-30">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form method="POST" id="basic-form" enctype="multipart/form-data" action="{{ route('admin.donor.store') }}"
                        class="contact-form bg-white p-sm-5 p-3 rounded-3 position-relative bnfont"
                        enctype="multipart/form-data">
                        @csrf
                        <h5 class="mb-3">@lang('Personal Information')</h5>
                        <div class="row mb-4">
                            <!-- নাম ----------------------------------->
                            <div class="form-group col-lg-6">
                                <label for="name">@lang('Name')<sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    placeholder="@lang('Full name')" class="form-control" maxlength="80" required="">
                            </div>
                            <!-- লিঙ্গ ----------------------------------->
                            <div class="form-group col-lg-6">
                                <label for="gender">@lang('Gender') <sup class="text-danger">*</sup></label>
                                <select name="gender" id="gender" class="select form-control" required="">
                                    <option value="" selected="" disabled=""></option>
                                    <option value="1">@lang('Male')</option>
                                    <option value="2">@lang('Female')</option>
                                    <option value="3">@lang('Other')</option>
                                </select>
                            </div>
                            <!-- বিভাগ ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="division">@lang('Division') <sup class="text-danger">*</sup></label>
                                <select name="division" id="division-dropdown" class="select form-control" required="">
                                    <option value="">-- বিভাগ সিলেক্ট করুন --</option>
                                    @foreach ($divisions as $data)
                                        <option value="{{ $data->id }}">
                                            {{ $data->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- জেলা ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="city">@lang('District') <sup class="text--danger">*</sup></label>
                                <select name="city" id="city-dropdown" class="select form-control" required="">
                                </select>
                            </div>

                            <!-- উপজেলা ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="location">@lang('Upazila') <sup class="text--danger">*</sup></label>
                                <select name="location" id="location-dropdown" class="select form-control" required="">
                                </select>
                            </div>

                            <!-- ধর্ম ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="religion">@lang('Religion') <sup class="text--danger">*</sup></label>
                                <select name="religion" id="religion" class="select form-control" required="">
                                    <option value="{{ old('religion') }}" selected="" disabled="">
                                        {{ old('religion') }}</option>
                                    <option value="Islam">@lang('Islam')</option>
                                    <option value="Hinduism">@lang('Hinduism')</option>
                                    <option value="Buddhism">@lang('Buddhism')</option>
                                    <option value="Christianity">@lang('Christianity')</option>
                                </select>
                            </div>

                            <!-- রক্তের গ্রুপ ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="blood_id">@lang('Blood Group') <sup class="text--danger">*</sup></label>
                                <select name="blood" id="blood_id" class="select form-control" required="">
                                    <option value="" selected="" disabled="">@lang('Select One')</option>
                                    @foreach ($bloods as $blood)
                                        <option value="{{ $blood->id }}">{{ __($blood->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- শেষ রক্ত দানের তারিখ ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="last_donate">@lang('Last Blood Donate') </label>
                                <input type="date" name="last_donate" id="last_donate" value="{{ old('donate') }}"
                                    placeholder="" class="form-control">
                            </div>


                            <!-- জন্ম তারিখ ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="date_birth">@lang('Date Of Birth') <sup class="text--danger">*</sup></label>
                                <input type="date" id="date_birth" name="birth_date" value="{{ old('birth_date') }}"
                                    placeholder="" class="form-control" maxlength="255" required="">

                            </div>

                            <!-- ইমেইল ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="email">@lang('Email')</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    placeholder="@lang('Enter Email')" class="form-control" maxlength="60">
                            </div>

                            <!-- ফেসবুক আইডি ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="facebook">@lang('Facebook Url')</label>
                                <div class="custom-icon-field">
                                    <i class="lab la-facebook-f" style="color: #1877F2"></i>
                                    <input type="text" name="facebook" id="facebook" value="{{ old('facebook') }}"
                                        placeholder="@lang('Enter Facebook Url')" class="form-control">
                                </div>
                            </div>

                            <!-- প্রাইমারী মোবাইল নং ----------------------------------->
                            <div class="form-group col-lg-6">
                                <label for="phone">@lang('Phone') <sup class="text--danger">*</sup></label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                    placeholder="@lang('Enter Phone')" class="form-control" maxlength="11" required="">
                                <span id="errorMsg" style="display:none; color: red;">Please Enter Valid Phone
                                    Number</span>
                            </div>

                            <!-- সেকেন্ডারী মোবাইল নং ----------------------------------->
                            <div class="form-group col-lg-6">
                                <label for="phone2">@lang('Secondary Phone')</label>
                                <input type="text" name="phone2" id="phone2" value="{{ old('phone2') }}"
                                    placeholder="@lang('Enter Phone')" class="form-control" maxlength="11">
                            </div>
                            <!-- পাসওয়ার্ড ----------------------------------->
                            <div class="form-group col-lg-6">
                                <label for="password">@lang('Password') <sup class="text--danger">*</sup></label>
                                <input type="password" name="password" id="password" value="{{ old('password') }}"
                                    placeholder="@lang('Enter Password')" class="form-control" maxlength="60" required="">
                                <p id="passcheck" style="color: red;">**Please Fill the password</p>
                            </div>

                            <!-- কনফার্ম পাসওয়ার্ড ----------------------------------->
                            <div class="form-group col-lg-6">
                                <label for="password_confirmation">@lang('Confirm Password') <sup
                                        class="text--danger">*</sup></label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    value="{{ old('password_confirmation') }}" placeholder="@lang('Enter Confirm Password')"
                                    class="form-control" maxlength="60" required="">
                                <p id="conpasscheck" style="color: red;">**Password didn't match</p>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="password_confirmation">@lang('About Donor')</label>
                                <textarea class="form-control" name="about_me" maxlength="200"></textarea>
                            </div>
                            <!-- ছবি আপলোড ---------------------------------------->
                            <div class="col-lg-12">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg"
                                            name="imageUpload" class="imageUpload" required="" />
                                        <input type="hidden" name="base64image" required="" name="base64image"
                                            id="base64image">
                                        <label for="imageUpload"></label>
                                    </div>
                                    <div class="avatar-preview container2">
                                        @php
                                            if (!empty($image->image) && $image->image != '' && file_exists(public_path('assets/images/donor' . $image->image))) {
                                                $image = $image->image;
                                            } else {
                                                $image = 'default.png';
                                            }
                                            $url = url('assets/images/' . $image);
                                            $imgs = "background-image:url($url)";

                                        @endphp
                                        <div id="imagePreview" style="{{ $imgs }};">
                                            <input type="hidden" required="" name="_token"
                                                value="{{ csrf_token() }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary w-100">@lang('Apply Now')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="model" class="modal imagecrop fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crop Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-11">
                                <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary crop" id="crop">Crop</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.donor.index') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i
            class="las la-angle-double-left"></i>@lang('Go Back')</a>
@endpush
@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/datepicker.min.css') }}">
@endpush
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/datepicker.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/datepicker.en.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
@endpush

@push('script')
    <script>
        // "use strict";

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

        $(document).ready(function() {
            $("#basic-form").validate();
        });
        // Cropper JS
        var $modal = $('.imagecrop');
        var image = document.getElementById('image');
        var cropper;
        $("body").on("change", ".imageUpload", function(e) {
            var files = e.target.files;
            var done = function(url) {
                image.src = url;
                $modal.modal('show');
            };
            var reader;
            var file;
            var url;
            if (files && files.length > 0) {
                file = files[0];
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 1.5 / 1.9,
                viewMode: 1,
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });
        $("body").on("click", "#crop", function() {
            canvas = cropper.getCroppedCanvas({
                width: 450,
                height: 570,
            });
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    $('#base64image').val(base64data);
                    document.getElementById('imagePreview').style.backgroundImage = "url(" +
                        base64data + ")";
                    $modal.modal('hide');
                }
            });
        });

        // Validate Password
        $("#passcheck").hide();
        let passwordError = true;
        $("#password").keyup(function() {
            validatePassword();
        });

        function validatePassword() {
            let passwordValue = $("#password").val();
            if (passwordValue.length == "") {
                $("#passcheck").show();
                passwordError = false;
                return false;
            }
            if (passwordValue.length < 3 || passwordValue.length > 10) {
                $("#passcheck").show();
                $("#passcheck").html(
                    "**length of your password must be between 3 and 10"
                );
                $("#passcheck").css("color", "red");
                passwordError = false;
                return false;
            } else {
                $("#passcheck").hide();
            }
        }

        // Validate Confirm Password
        $("#conpasscheck").hide();
        let confirmPasswordError = true;
        $("#password_confirmation").keyup(function() {
            validateConfirmPassword();
        });

        function validateConfirmPassword() {
            let confirmPasswordValue = $("#password_confirmation").val();
            let passwordValue = $("#password").val();
            if (passwordValue != confirmPasswordValue) {
                $("#conpasscheck").show();
                $("#conpasscheck").html("**Password didn't Match");
                $("#conpasscheck").css("color", "red");
                confirmPasswordError = false;
                return false;
            } else {
                $("#conpasscheck").hide();
            }
        }
    </script>
@endpush
