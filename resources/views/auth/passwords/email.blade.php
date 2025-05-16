@extends('layouts.app')
@push('title')
    {{ __('Forgot Password') }}
@endpush

@section('content')
    <section class="admin-section">
        <div class="container">
            <div class="authContent-wrap zaiStock-shadow-one">
                <div class="titleWrap">
                    <h4 class="title">{{__('Forgot Password')}}</h4>
                    <p class="info">{{__('Enter your email address and we will send you a link to reset your password.')}}</p>
                </div>
                <form method="POST" action="{{ route('password.email') }}">
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
                    </div>
                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-100 zaiStock-btn d-flex justify-content-center">{{__('Send Password Reset Link')}}</button>
                </form>
                <div class="pb-sm-30 pb-20"></div>
                <p class="text-center fs-14 fw-400 lh-24 text-primary-dark-text">{{__('Remember your password?')}}
                    <a href="{{ route('login') }}" class="text-primary linkDefault-hover">{{__('Sign In')}}</a>
                </p>
            </div>
        </div>
    </section>
@endsection
