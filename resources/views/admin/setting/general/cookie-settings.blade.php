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
                                <h2>{{ __('Frontend Settings') }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb sf-breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __(@$title) }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    @include('admin.application_settings.sidebar')
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="email-inbox__area bg-style">
                        <div class="item-top mb-30"><h2>{{ __(@$title) }}</h2></div>
                        <form action="{{route('admin.setting.general-settings.update')}}" method="post" class="form-horizontal">
                            @csrf
                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Cookie Message') }} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <textarea name="cookie_msg"  class="form-control" required>{{ get_option('cookie_msg') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Cookie Agree Button Name') }} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="cookie_button_name" value="{{ get_option('cookie_button_name') }}" class="form-control" required>
                                </div>
                            </div>


                            <div class="row justify-content-end">
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-blue float-right">{{ __('Update') }}</button>
                                </div>
                            </div>
                        </form>
                        <div class="item-top mb-30"><h2>{{ __('Cookies Status') }}</h2></div>
                        <form action="{{route('settings.cookie-settings.update')}}" method="post" class="form-horizontal">
                            @csrf
                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Cookie Status') }} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <select name="COOKIE_CONSENT_STATUS" id="" class="form-control">
                                        <option value="">--{{ __('Select Option') }}--</option>
                                        <option value="true" @if(env('COOKIE_CONSENT_STATUS') == true) selected @endif>{{ __('Active') }}</option>
                                        <option value="false" @if(env('COOKIE_CONSENT_STATUS') == false) selected @endif>{{ __('Deactivated') }}</option>
                                    </select>
                                </div>
                            </div>


                            <div class="row justify-content-end">
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-blue float-right">{{ __('Update') }}</button>
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
