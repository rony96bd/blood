@extends('admin.layouts.master')
@section('content')
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if (Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close"
                        data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach
    </div>
    <div class="page-wrapper default-version">
        <div class="form-area" style="background: rgb(0,236,255); background: linear-gradient(117deg, rgba(0,236,255,1) 0%, rgba(173,0,255,1) 100%);">
            <div class="form-wrapper">
                <h4 class="logo-text mb-15">@lang('Welcome to') <strong>{{ __($general->sitename) }}</strong></h4>
                <p>{{ __($pageTitle) }} @lang('to') {{ __($general->sitename) }} @lang('dashboard')</p>
                <form action="{{ route('donor.login') }}" method="POST" class="cmn-form mt-30">
                    @csrf
                    <div class="form-group">
                        <label for="email">@lang('Email')</label>
                        <input type="text" name="email" class="form-control b-radius--capsule" id="email"
                            value="{{ old('email') }}" placeholder="@lang('Enter your email')">
                        <i class="las la-user input-icon"></i>
                    </div>
                    <div class="form-group">
                        <label for="pass">@lang('Password')</label>
                        <input type="password" name="password" class="form-control b-radius--capsule" id="pass"
                            placeholder="@lang('Enter your password')">
                        <i class="las la-lock input-icon"></i>
                    </div>
                    <div class="form-group d-flex justify-content-between align-items-center">
                        <a href="{{ route('donor.password.reset') }}" class="text-muted text--small"><i
                                class="las la-lock"></i>@lang('Forgot password?')</a>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="submit-btn mt-25 b-radius--capsule">@lang('Login') <i
                                class="las la-sign-in-alt"></i></button>
                    </div>
                </form>
            </div>
        </div><!-- login-area end -->
    </div>
@endsection
