@extends('layouts.app')
@push('title')
    {{ __('Login') }}
@endpush

@section('content')
    <section class="admin-section">
        <div class="container">
            <div class="authContent-wrap zaiStock-shadow-one">
                <div class="titleWrap">
                    <h4 class="title">{{__('Sign In')}}</h4>
                    <p class="info">{{__('Please sign in using the form below.')}}</p>
                </div>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <!-- Email -->
                    <div class="d-flex flex-column rg-20 pb-md-35 pb-20">
                        <div class="">
                            <label for="authEmail" class="zForm-label">{{__('Email Address')}}<span
                                    class="text-primary">*</span></label>
                            <input type="email" class="zForm-control" name="email" id="authEmail"
                                   placeholder="{{__('Enter Your Email')}}" value="{{ old('email') }}"/>
                            @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Password -->
                        <div class="">
                            <div class="d-flex justify-content-between align-items-center pb-8">
                                <label for="authPassword" class="zForm-label mb-0">{{__('Password')}}<span
                                        class="text-primary">*</span></label>
                                <a href="{{ route('password.request') }}"
                                   class="fs-14 fw-400 lh-24 text-primary text-decoration-underline">{{__('Forgot Password?')}}</a>
                            </div>
                            <div class="passShowHide">
                                <input type="password" name="password"
                                       class="form-control zForm-control passShowHideInput"
                                       id="authPassword" placeholder="{{__('Enter your password')}}"/>
                                <button type="button" toggle=".passShowHideInput"
                                        class="toggle-password fa-solid fa-eye"></button>
                            </div>
                            @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-100 zaiStock-btn d-flex justify-content-center">{{__('Sign In')}}</button>
                </form>
                @if(env('DEMO_SITE', false))
                    <div class="bg-light border d-flex flex-column gap-2 mt-20 p-10 rounded text-center text-info">
                        <span id="customerCredentialShow" class="bd-b-one bd-c-stroke login-info pb-6"><b>Customer:</b> customer@gmail.com | 123456</span>
                        <span id="contributorCredentialShow" class="bd-b-one bd-c-stroke login-info pb-6"><b>Contributor:</b> contributor@gmail.com | 123456</span>
                        <a class="login-info text-info" href="{{route('admin.login')}}">Admin Login</a>
                    </div>
                @endif
                <!-- Alternative Auth Options -->
                @if(getOption('google_login_status') || getOption('facebook_login_status'))
                    <div class="otherAuthWrap">
                        <p class="text"><span>{{__('Or continue with')}}</span></p>
                        <div class="authList">
                            @if(getOption('google_login_status'))
                                <a href="{{ route('social.login', ['provider' => 'google']) }}" class="item">
                                <span class="icon"><img src="{{ asset('assets/images/icon/auth-google-icon.svg') }}"
                                                        alt=""/></span>
                                    <p class="authName">{{__('Google')}}</p>
                                </a>
                            @endif
                            @if(getOption('facebook_login_status'))
                                <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="item">
                            <span class="icon">
                                <img src="{{ asset('assets/images/icon/auth-fb-icon.svg') }}" alt=""/></span>
                                    <p class="authName">{{__('Facebook')}}</p>
                                </a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="pb-sm-30 pb-20"></div>
                @endif
                <!-- Sign Up Link -->
                <p class="text-center fs-14 fw-400 lh-24 text-primary-dark-text">{{__('Do not have an account?')}}
                    <a href="{{ route('register') }}" class="text-primary linkDefault-hover">{{__('Sign Up')}}</a>
                </p>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        'use strict'
        $('#customerCredentialShow').on('click', function () {
            $('#authEmail').val('customer@gmail.com');
            $('#authPassword').val('123456');
        });
        $('#contributorCredentialShow').on('click', function () {
            $('#authEmail').val('contributor@gmail.com');
            $('#authPassword').val('123456');
        });
    </script>
@endpush
