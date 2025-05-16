@extends('layouts.app')
@push('title')
    {{ __('Reset Password') }}
@endpush

@section('content')
    <section class="admin-section">
        <div class="container">
            <div class="authContent-wrap zaiStock-shadow-one">
                <div class="titleWrap">
                    <h4 class="title">{{__('Reset Password')}}</h4>
                    <p class="info">{{__('Enter your new password below to reset your password.')}}</p>
                </div>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <!-- Email -->
                    <div class="d-flex flex-column rg-20 pb-md-35 pb-20">
                        <div class="">
                            <label for="authEmail" class="zForm-label">{{__('Email Address')}}<span
                                    class="text-primary">*</span></label>
                            <input type="email" class="zForm-control" name="email" id="authEmail"
                                   placeholder="{{__('Enter Your Email')}}" value="{{ old('email', $email) }}"/>
                            @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- New Password -->
                        <div class="">
                            <label for="authPassword" class="zForm-label">{{__('New Password')}}<span
                                    class="text-primary">*</span></label>
                            <input type="password" name="password" class="zForm-control" id="authPassword"
                                   placeholder="{{__('Enter new password')}}"/>
                            @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Confirm New Password -->
                        <div class="">
                            <label for="password-confirm" class="zForm-label">{{__('Confirm Password')}}<span
                                    class="text-primary">*</span></label>
                            <input type="password" name="password_confirmation" class="zForm-control"
                                   id="password-confirm" placeholder="{{__('Confirm new password')}}"/>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-100 zaiStock-btn d-flex justify-content-center">{{__('Reset Password')}}</button>
                </form>
                <div class="pb-sm-30 pb-20"></div>
                <p class="text-center fs-14 fw-400 lh-24 text-primary-dark-text">{{__('Remember your password?')}}
                    <a href="{{ route('login') }}" class="text-primary linkDefault-hover">{{__('Sign In')}}</a>
                </p>
            </div>
        </div>
    </section>
@endsection
