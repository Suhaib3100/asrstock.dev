@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __('Frontend Settings') }}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
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
        <div class="row rg-24">
            <div class="col-xl-3">
                @include('admin.setting.setting-sidebar')
            </div>
            <div class="col-xl-9">
                    <h2 class="fs-18 fw-500 lh-28 text-primary-dark-text pb-24">{{ __(@$pageTitle) }}</h2>
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <div class="custom-form-group mb-3 row align-items-center">
                        <label for="" class="col-lg-4 zForm-label">{{ __('Clear View Cache') }}</label>
                        <div class="col-lg-8">
                            <a href="{{ route('admin.setting.cache-update', 1) }}" class="btn btn-blue">{{ __('Click Here') }}</a>
                        </div>
                    </div>
                    <div class="custom-form-group mb-3 row align-items-center">
                        <label for="" class="col-lg-4 zForm-label">{{ __('Clear Route Cache') }} </label>
                        <div class="col-lg-8">
                            <a href="{{ route('admin.setting.cache-update', 2) }}" class="btn btn-blue">{{ __('Click Here') }}</a>
                        </div>
                    </div>
                    <div class="custom-form-group mb-3 row align-items-center">
                        <label for="" class="col-lg-4 zForm-label">{{ __('Clear Config Cache') }} </label>
                        <div class="col-lg-8">
                            <a href="{{ route('admin.setting.cache-update', 3) }}" class="btn btn-blue">{{ __('Click Here') }}</a>
                        </div>
                    </div>
                    <div class="custom-form-group mb-3 row align-items-center">
                        <label for="" class="col-lg-4 zForm-label">{{ __('Application Clear Cache') }} </label>
                        <div class="col-lg-8">
                            <a href="{{ route('admin.setting.cache-update', 4) }}" class="btn btn-blue">{{ __('Click Here') }}</a>
                        </div>
                    </div>
                    <div class="custom-form-group mb-3 row align-items-center">
                        <label for="" class="col-lg-4 zForm-label">{{ __('Storage Link') }} </label>
                        <div class="col-lg-8">
                            <a href="{{ route('admin.setting.cache-update', 5) }}" class="btn btn-blue">{{ __('Click Here') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection
