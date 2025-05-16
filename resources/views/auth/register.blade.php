@extends('layouts.app')
@push('title')
    {{ __('Login') }}
@endpush

@section('content')
    <section class="admin-section">
        <div class="container">
            <div class="authContent-wrap zaiStock-shadow-one">
                <div class="titleWrap">
                    <h4 class="title">{{__('Create a free account')}}</h4>
                    <p class="info">{{__('Please create using the form below.')}}</p>
                </div>
                <!--  -->
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="d-flex flex-column rg-20 pb-md-35 pb-20">
                        <input type="hidden" name="referred_by"
                               value="{{ old('referred_by', request()->get('referred_by')) }}">

                        <div class="">
                            <label for="firstName" class="zForm-label">First Name<span
                                        class="text-primary">*</span></label>
                            <input type="text" class="zForm-control" id="firstName" name="first_name"
                                   placeholder="{{__('First Name')}}" value="{{ old('first_name') }}"/>
                            @error('first_name')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="">
                            <label for="lastName" class="zForm-label">Last Name<span
                                        class="text-primary">*</span></label>
                            <input type="text" class="zForm-control" id="lastName" name="last_name"
                                   placeholder="Anderson" value="{{ old('last_name') }}"/>
                            @error('last_name')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="">
                            <label for="userName" class="zForm-label">User Name<span
                                        class="text-primary">*</span></label>
                            <input type="text" class="zForm-control" id="userName" name="user_name"
                                   placeholder="Anderson" value="{{ old('user_name') }}"/>
                            @error('user_name')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="">
                            <label for="phoneNumber" class="zForm-label">Phone Number<span
                                        class="text-primary">*</span></label>
                            <input type="text" class="zForm-control" id="phoneNumber" name="contact_number"
                                   placeholder="(+880) 5444 96588" value="{{ old('contact_number') }}"/>
                            @error('contact_number')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="">
                            <label for="authEmail" class="zForm-label">Email Address<span
                                        class="text-primary">*</span></label>
                            <input type="email" class="zForm-control" id="authEmail" name="email"
                                   placeholder="alexanderson@gmail.com" value="{{ old('email') }}"/>
                            @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="">
                            <div class="passShowHide">
                                <label for="authPassword" class="zForm-label">Password<span
                                            class="text-primary">*</span></label>
                                <input type="password" class="form-control zForm-control passShowHideInput"
                                       id="authPassword" name="password" placeholder="Enter your password"/>
                                @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="">
                            <div class="passShowHide">
                                <label for="authPasswordConfirmation" class="zForm-label">Confirm Password<span
                                            class="text-primary">*</span></label>
                                <input type="password" class="form-control zForm-control passShowHideInput"
                                       id="authPasswordConfirmation" name="password_confirmation"
                                       placeholder="Confirm your password"/>
                                @error('password_confirmation')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="">
                            <div class="zForm-wrap-checkbox">
                                <input type="checkbox" required class="form-check-input" name="agree_policy"
                                       id="termsPrivacy" {{ old('agree_policy') ? 'checked' : '' }}/>
                                <label for="termsPrivacy">
                                    {{__('By clicking create account, I agree that I have read and accepted the')}}
                                    <a href="{{route('frontend.page', 'terms-of-use')}}"
                                       target="__blank">{{__('Terms of Use')}}</a> {{__('and')}} <a
                                            href="{{route('frontend.page', 'privacy-policy')}}"
                                            target="__blank">{{__('Privacy Policy')}}</a>.
                                </label>
                            </div>
                        </div>
                    </div>
                    <!--  -->
                    <button type="submit"
                            class="w-100 zaiStock-btn d-flex justify-content-center">{{__('Sign Up')}}</button>
                </form>

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

                <p class="text-center fs-14 fw-400 lh-24 text-primary-dark-text">{{__('Already have an account?')}}
                    <a href="{{route('login')}}" class="text-primary linkDefault-hover">{{__('Sign In')}}</a>
                </p>

            </div>
        </div>
    </section>
@endsection
