@extends($activeTemplate . 'layouts.frontend')
@section('content')
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
            position: relative;
            right: 12px;
            z-index: 1;
            top: 10px;
            margin-bottom: -15px;
        }

        /* .avatar-upload .avatar-edit input {
                                            display: none;
                                        } */

        /* .avatar-upload .avatar-edit input+label {
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
                                        } */
        .custom-file-button {
            input[type="file"] {
                margin-left: -2px !important;

                &::-webkit-file-upload-button {
                    display: none;
                }

                &::file-selector-button {
                    display: none;
                }
            }

            &:hover {
                label {
                    background-color: #dde0e3;
                    cursor: pointer;
                }
            }
        }

        .avatar-upload .avatar-edit input+label:hover {
            background: #f1f1f1;
            border-color: #d6d6d6;
        }

        /* .avatar-upload .avatar-edit input+label:after {
                                            content: "\f040";
                                            font-family: 'FontAwesome';
                                            color: #757575;
                                            position: absolute;
                                            top: 10px;
                                            left: 0;
                                            right: 0;
                                            text-align: center;
                                            margin: auto;
                                        } */

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
    </style>

    @include($activeTemplate . 'partials.breadcrumb')
    <section class="pb-100 position-relative z-index section--bg" style="background-color: #FDE7EF">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" id="basic-form" enctype="multipart/form-data" action="{{ route('apply.donor.store') }}"
                        class="contact-form bg-white p-sm-5 p-3 rounded-3 position-relative" enctype="multipart/form-data">
                        @csrf
                        <h5 class="mb-3">@lang('Personal Information')</h5>
                        <div class="row mb-4">
                            <!-- নাম ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="name">@lang('Name') <sup class="text--danger">*</sup></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    placeholder="@lang('Full name')" class="form--control" maxlength="80" required="">
                            </div>
                            <!-- লিঙ্গ ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="gender">@lang('Gender') <sup class="text--danger">*</sup></label>
                                <select name="gender" id="gender" class="select" required="" class="form--control">
                                    <option value="{{ old('gender') }}" selected="" disabled="">{{ old('gender') }}
                                    </option>
                                    <option value="1">@lang('Male')</option>
                                    <option value="2">@lang('Female')</option>
                                    <option value="3">@lang('Other')</option>
                                </select>
                            </div>
                            <!-- রেফারার ----------------------------------->

                            <div class="form-group col-lg-4">
                                <label for="referer">@lang('RefererID') <sup class="text--warning">(Optional)</sup></label>
                                @if (app('request')->input('ref'))
                                    <input type="referer" name="referer" id="referer" readonly
                                        value="{{ app('request')->input('ref') }}" placeholder="@lang('Enter Referer ID')"
                                        class="form--control" maxlength="80" style="background-color: gainsboro;">
                                @else
                                    <input type="referer" name="referer" id="referer"
                                        value="{{ app('request')->input('ref') }}" placeholder="@lang('Enter Referer ID')"
                                        class="form--control" maxlength="80">
                                @endif
                            </div>
                            <!-- বিভাগ ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="division">@lang('Division') <sup class="text--danger">*</sup></label>
                                <select name="division" id="division-dropdown" class="select" required="">
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
                                <select name="city" id="city-dropdown" class="select" required="">
                                </select>
                            </div>

                            <!-- উপজেলা ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="location">@lang('Upazila') <sup class="text--danger">*</sup></label>
                                <select name="location" id="location-dropdown" class="select" required="">
                                </select>
                            </div>

                            <!-- ধর্ম ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="religion">@lang('Religion') <sup class="text--danger">*</sup></label>
                                <select name="religion" id="religion" class="select" required="">
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
                                <select name="blood" id="blood_id" class="select" required="">
                                    <option value="{{ old('blood') }}" selected="" disabled="">
                                        {{ old('blood') }}</option>
                                    @foreach ($bloods as $blood)
                                        <option value="{{ $blood->id }}">{{ __($blood->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- শেষ রক্ত দানের তারিখ ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="date_birth">@lang('Last Blood Donate') <sup
                                        class="text--warning">(Optional)</sup></label>
                                <div class="row">
                                    <div class="col"><select name="bday" class="select">
                                            <option disabled selected>Day</option>
                                            @php
                                                $i = 00;
                                                for ($i = 01; $i <= 31; $i++) {
                                                    $day_value = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                    echo "<option value=$day_value>$day_value</option>";
                                                }
                                            @endphp
                                        </select></div>
                                    <div class="col"><select name="bmonth" class="select">
                                            <option disabled selected>Month</option>
                                            <option value="01">Jan</option>
                                            <option value="02">Feb</option>
                                            <option value="03">Mar</option>
                                            <option value="04">Apr</option>
                                            <option value="05">May</option>
                                            <option value="06">Jun</option>
                                            <option value="07">Jul</option>
                                            <option value="08">Aug</option>
                                            <option value="09">Sep</option>
                                            <option value="10">Oct</option>
                                            <option value="11">Nov</option>
                                            <option value="12">Dec</option>
                                        </select></div>
                                    <div class="col"><input type="number" name="byear"
                                            value="{{ old('year') }}" placeholder="@lang('Year')"
                                            class="form--control"></div>
                                </div>
                            </div>
                            {{-- <div class="form-group col-lg-4">
                                <label for="last_donate">@lang('Last Blood Donate') <sup
                                        class="text--warning">(Optional)</sup></label>
                                <input type="date" name="last_donate" id="last_donate"
                                    value="{{ old('last_donate') }}" placeholder="@lang('DD-MM-YYYY')"
                                    class="form--control">
                            </div> --}}

                            <!-- জন্ম তারিখ ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="date_birth">@lang('Date Of Birth') <sup class="text--danger">*</sup></label>
                                <div class="row">
                                    <div class="col"><select name="day" class="select" required="">
                                            <option disabled selected>Day</option>
                                            @php
                                                $i = 00;
                                                for ($i = 01; $i <= 31; $i++) {
                                                    $day_value = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                    echo "<option value=$day_value>$day_value</option>";
                                                }
                                            @endphp
                                        </select></div>
                                    <div class="col"><select name="month" class="select" required="">
                                            <option disabled selected>Month</option>
                                            <option value="01">Jan</option>
                                            <option value="02">Feb</option>
                                            <option value="03">Mar</option>
                                            <option value="04">Apr</option>
                                            <option value="05">May</option>
                                            <option value="06">Jun</option>
                                            <option value="07">Jul</option>
                                            <option value="08">Aug</option>
                                            <option value="09">Sep</option>
                                            <option value="10">Oct</option>
                                            <option value="11">Nov</option>
                                            <option value="12">Dec</option>
                                        </select></div>
                                    <div class="col"><input type="number" name="year"
                                            value="{{ old('year') }}" placeholder="@lang('Year')"
                                            class="form--control" required=""></div>
                                </div>
                            </div>
                            {{-- <div class="form-group col-lg-4">
                                <label for="date_birth">@lang('Date Of Birth') <sup class="text--danger">*</sup></label>
                                <input type="date" id="date_birth" name="birth_date" value="{{ old('birth_date') }}"
                                    placeholder="@lang('DD-MM-YYYY')" class="form--control" maxlength="255"
                                    required="">
                            </div> --}}

                            <!-- ইমেইল ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="email">@lang('Email') <sup
                                        class="text--warning">(Optional)</sup></label>
                                <input type="email"
                                    pattern="/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/"
                                    name="email" id="email" value="{{ old('email') }}"
                                    placeholder="@lang('Enter Email')" class="form--control" maxlength="60">
                            </div>

                            <!-- ফেসবুক আইডি ----------------------------------->
                            <div class="form-group col-lg-4">
                                <label for="facebook">@lang('Facebook Url') <sup
                                        class="text--warning">(Optional)</sup></label>
                                <div class="custom-icon-field">
                                    <i class="lab la-facebook-f"></i>
                                    <input type="text" name="facebook" id="facebook" value="{{ old('facebook') }}"
                                        placeholder="@lang('Example: https://facebook.com/xxxxx')" class="form--control">
                                </div>
                            </div>

                            <!-- প্রাইমারী মোবাইল নং ----------------------------------->
                            <div class="form-group col-lg-6">
                                <label for="phone">@lang('Phone') <sup class="text--danger">*</sup></label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                    placeholder="@lang('Enter Phone')" class="form--control" maxlength="11"
                                    required="">
                            </div>

                            <!-- সেকেন্ডারী মোবাইল নং ----------------------------------->
                            <div class="form-group col-lg-6">
                                <label for="phone2">@lang('Secondary Phone') <sup
                                        class="text--warning">(Optional)</sup></label>
                                <input type="text" name="phone2" id="phone2" value="{{ old('phone2') }}"
                                    placeholder="@lang('Enter Phone')" class="form--control" maxlength="11">
                            </div>
                            <!-- পাসওয়ার্ড ----------------------------------->
                            <div class="form-group col-lg-6">
                                <label for="password">@lang('Password') <sup class="text--danger">*</sup></label>
                                <input type="password" name="password" id="password" value="{{ old('password') }}"
                                    placeholder="@lang('Enter Password')" class="form--control" maxlength="10"
                                    required="">
                                <p id="passcheck" style="color: red;">**Please Fill the password</p>
                            </div>

                            <!-- কনফার্ম পাসওয়ার্ড ----------------------------------->
                            <div class="form-group col-lg-6">
                                <label for="password_confirmation">@lang('Confirm Password') <sup
                                        class="text--danger">*</sup></label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    value="{{ old('password_confirmation') }}" placeholder="@lang('Enter Confirm Password')"
                                    class="form--control" maxlength="10" required="">
                                <p id="conpasscheck" style="color: red;">**Password didn't match</p>
                            </div>
                            <!-- About Donor ----------------------------------->
                            <div class="form-group col-lg-12">
                                <label for="password_confirmation">@lang('About Donor')<sup
                                    class="text--warning">(Optional)</sup></label>
                                <textarea class="form-control" name="about_me" maxlength="200"></textarea>
                            </div>
                            <!-- ছবি আপলোড ---------------------------------------->
                            <div>
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <span style="color: #00B074; font-weight:bold">Upload Image:</span><input
                                            type='file' id="imageUpload" accept=".png, .jpg, .jpeg"
                                            name="imageUpload" class="imageUpload" required />
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
                            <!-- Accept Terms and Conditions ----------------------------------->
                            <div class="form-group checkbox required col-lg-6">
                                <label class="checkbox" style="color:#00B074;">
                                    <input type="checkbox" required value="1" id="rememberMe" name="term">Accept
                                    <a target="_blank" href="../menu/terms-of-service/43"> Terms and Conditions.
                                    </a>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn--base w-100">@lang('Apply Now')</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div id="model" class="modal fade imagecrop" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
    </section>

    {{-- @include($activeTemplate . 'sections.faq') --}}
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/datepicker.min.css') }}">
@endpush
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/datepicker.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/datepicker.en.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
@endpush
@push('script')
    <script>
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
            if (passwordValue.length < 6 || passwordValue.length > 10) {
                $("#passcheck").show();
                $("#passcheck").html(
                    "**length of your password must be between 6 and 10"
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
