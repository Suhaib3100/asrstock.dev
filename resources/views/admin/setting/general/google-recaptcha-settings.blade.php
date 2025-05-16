@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{ __(@$pageTitle) }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb sf-breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __(@$pageTitle) }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    @include('admin.setting.sidebar')
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="email-inbox__area bg-style">
                        <form action="{{route('admin.setting.general-settings.update')}}" method="post" class="form-horizontal">
                            @csrf
                            <div class="item-top mb-30"><h6>{{ __('Google Recaptcha Credentials (V2)') }}</h6></div>
                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Google Recaptcha Status') }}</label>
                                <div class="col-lg-9">
                                    <select name="google_recaptcha_status" id="google_recaptcha_status" class="form-control">
                                        <option value="">--{{ __('Select option') }}--</option>
                                        <option value="1" @if(getOption('google_recaptcha_status') == ACTIVE) selected @endif>{{ __('Active') }}</option>
                                        <option value="0" @if(getOption('google_recaptcha_status') != ACTIVE) selected @endif>{{ __('Disable') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Google Recaptcha Site Key') }}</label>
                                <div class="col-lg-9">
                                    <input type="text" name="google_recaptcha_site_key" id="google_recaptcha_site_key" value="{{getOption('google_recaptcha_site_key')}}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Google Recaptcha Secret Key') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="google_recaptcha_secret_key" id="google_recaptcha_secret_key" value="{{getOption('google_recaptcha_secret_key')}}" class="form-control">
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-blue float-right">{{__('Update')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('script')
    <script>
        'use strict'
        var google_recaptcha_status = "{{ getOption('google_recaptcha_status') }}"
    </script>
    <script src="{{ asset('admin/js/custom/recaptcha-setting.js') }}"></script>
@endpush

