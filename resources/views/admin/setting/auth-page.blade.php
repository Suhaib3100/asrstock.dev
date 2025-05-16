@extends('admin.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
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
                                    <li class="breadcrumb-item active" aria-current="page">{{ @$pageTitle }}</li>
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
                    <div class="email-inbox__area bg-style form-horizontal__item bg-style admin-general-settings-page">
                        <div class="item-top mb-30"><h2>{{ @$pageTitle }}</h2></div>
                        <form class="ajax" action="{{ route('admin.setting.application-settings.update') }}"
                              method="POST" enctype="multipart/form-data" data-handler="commonResponseWithPageLoad">
                            @csrf
                            <div class="row rg-20">
                                <div class="col-xxl-4 col-lg-6">
                                    <label class="zForm-label-alt">{{ __('Sign up Left Text Title') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="sign_up_left_text_title" value="{{ getOption('sign_up_left_text_title') }}"
                                           class="form-control zForm-control-alt">
                                </div>
                                <div class="col-xxl-4 col-lg-6">
                                    <label class="zForm-label-alt">{{ __('Sign up Left Text Subtitle') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="sign_up_left_text_subtitle" value="{{ getOption('sign_up_left_text_subtitle') }}"
                                           class="form-control zForm-control-alt">
                                </div>

                                <div class="col-xxl-4 col-lg-6">
                                    <label class="zForm-label-alt">{{ __('Forgot Title') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="forgot_title" value="{{ getOption('forgot_title') }}"
                                           class="form-control zForm-control-alt">
                                </div>
                                <div class="col-xxl-4 col-lg-6 pt-3">
                                    <label class="zForm-label-alt">{{ __('Forgot Subtitle') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="forgot_subtitle" value="{{ getOption('forgot_subtitle') }}"
                                           class="form-control zForm-control-alt">
                                </div>
                                <div class="col-xxl-4 col-lg-6 pt-3">
                                    <label class="zForm-label-alt">{{ __('Forgot Button Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="forgot_btn_name" value="{{ getOption('forgot_btn_name') }}"
                                           class="form-control zForm-control-alt">
                                </div>
                            </div>

                            <div class="input__group general-settings-btn pt-3">
                                <button type="submit" class="btn btn-blue float-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

