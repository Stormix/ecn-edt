@extends('layouts.auth')
@section('header')

<!--begin::Page Custom Styles(used by this page) -->
<link href="/css/login-1.css" rel="stylesheet" type="text/css" />

<!--end::Page Custom Styles -->
@endsection
@section('content')
<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v1" id="kt_login">
        <div
            class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">

            <!--begin::Aside-->
            <div class="kt-grid__item kt-grid__item--order-tablet-and-mobile-2 kt-grid kt-grid--hor kt-login__aside"
                style="background-image: url(/assets/media/bg/bg-4.jpg);">
                <div class="kt-grid__item">
                    <a href="#" class="kt-login__logo">
                        <img src="/assets/media/logos/LogoCN_Icon.png" width="40px">
                    </a>
                </div>
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver">
                    <div class="kt-grid__item kt-grid__item--middle">
                        <h3 class="kt-login__title">EDT ECN</h3>
                        <h4 class="kt-login__subtitle">OnBoard planning made better</h4>
                    </div>
                </div>
                <div class="kt-grid__item">
                    <div class="kt-login__info">
                        <div class="kt-login__copyright">
                            &copy {{ date('Y') }} Stormix
                        </div>
                        <div class="kt-login__menu">
                            <a href="#" class="kt-link">Privacy</a>
                            <a href="#" class="kt-link">Legal</a>
                            <a href="#" class="kt-link">Contact</a>
                        </div>
                    </div>
                </div>
            </div>

            <!--begin::Aside-->

            <!--begin::Content-->
            <div
                class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">

                <!--begin::Head-->
                <div class="kt-login__head">
                    <span class="kt-login__signup-label">Don't have an account yet?</span>&nbsp;&nbsp;
                    <a href="/register" class="kt-link kt-login__signup-link">Sign Up!</a>
                </div>

                <!--end::Head-->

                <!--begin::Body-->
                <div class="kt-login__body">

                    <!--begin::Signin-->
                    <div class="kt-login__form">
                        <div class="kt-login__title">
                            <h3>{{ __('Reset Password') }}</h3>
                        </div>

                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <!--begin::Form-->
                        <form class="kt-form" novalidate="novalidate" id="kt_login_form" method="POST"
                            action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group">
                                <input class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required type="email"
                                    placeholder="{{ __('E-Mail Address') }}" name="email" required autocomplete="email"
                                    autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <!--begin::Action-->
                            <div class="kt-login__actions">
                                <a class="kt-link kt-login__link-forgot" href="{{ route('login') }}">
                                    I remember my password!
                                </a>
                                <button id="kt_login_signin_submit"
                                    class="btn btn-primary btn-elevate kt-login__btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>

                            <!--end::Action-->
                        </form>

                        <!--end::Form-->

                    </div>

                    <!--end::Signin-->
                </div>

                <!--end::Body-->
            </div>

            <!--end::Content-->
        </div>
    </div>
</div>

<!-- end:: Page -->
@endsection
