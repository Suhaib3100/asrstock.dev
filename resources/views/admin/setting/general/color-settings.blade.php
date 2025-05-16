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
                                <li class="breadcrumb-item"><a
                                        href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
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
                <h4 class="fs-18 fw-600 lh-22 text-primary-dark-text pb-25">{{ __(@$pageTitle) }}</h4>
                <form action="{{route('admin.setting.general-settings.update')}}" method="post" class="form-horizontal">
                    @csrf
                    <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                        <div class="row rg-24">
                            <div class="col-12">
                                <label class="zForm-label">{{ __('Design') }} <span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center g-20">
                                    <div class="zForm-wrap-checkbox-2">
                                        <input class="form-check-input" type="radio" id="default"
                                               name="app_color_design_type" value="1"
                                               {{ (empty(getOption('app_color_design_type')) || getOption('app_color_design_type')) ? 'checked' : '' }} required>
                                        <label for="default">Default</label>
                                    </div>
                                    <div class="zForm-wrap-checkbox-2">
                                        <input class="form-check-input" type="radio" id="custom"
                                               name="app_color_design_type"
                                               value="2" {{ getOption('app_color_design_type') == 2 ? 'checked' : '' }}>
                                        <label for="custom">{{__('Custom')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="customDiv">
                            <div class="row rg-24">
                                <div class="col-xl-4 col-md-6">
                                    <label class="zForm-label">{{ __('Primary Color') }} <span class="text-danger">*</span></label>
                                    <div class="">
                                     <span class="color-picker">
                                        <label for="colorPicker1" class="mb-0">
                                            <input type="color" name="app_primary_color"
                                                   value="{{ empty(getOption('app_primary_color')) ? '#09a8f7' : getOption('app_primary_color') }}"
                                                   id="colorPicker1">
                                        </label>
                                    </span>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <label class="zForm-label">{{ __('Secondary Color') }} <span class="text-danger">*</span></label>
                                    <div class="">
                                     <span class="color-picker">
                                        <label for="colorPicker2" class="mb-0">
                                            <input type="color" name="app_secondary_color"
                                                   value="{{ empty(getOption('app_secondary_color')) ? '#e5f7ff' : getOption('app_secondary_color') }}"
                                                   id="colorPicker2">
                                        </label>
                                    </span>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <label class="zForm-label">{{ __('Text Color') }} <span class="text-danger">*</span></label>
                                    <div class="">
                                     <span class="color-picker">
                                        <label for="colorPicker3" class="mb-0">
                                            <input type="color" name="app_text_color"
                                                   value="{{ empty(getOption('app_text_color')) ? '#686b8b' : getOption('app_text_color') }}"
                                                   id="colorPicker3">
                                        </label>
                                    </span>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <label class="zForm-label">{{ __('Title Color') }} <span class="text-danger">*</span></label>
                                    <div class="">
                                     <span class="color-picker">
                                        <label for="colorPicker4" class="mb-0">
                                            <input type="color" name="app_title_color"
                                                   value="{{ empty(getOption('app_title_color')) ? '#1f2224' : getOption('app_title_color') }}"
                                                   id="colorPicker4">
                                        </label>
                                    </span>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <label class="zForm-label">{{ __('Section Background Color') }} <span class="text-danger">*</span></label>
                                    <div class="">
                                     <span class="color-picker">
                                        <label for="colorPicker5" class="mb-0">
                                            <input type="color" name="app_section_bg_color"
                                                   value="{{ empty(getOption('app_section_bg_color')) ? '#ebf8ff' : getOption('app_section_bg_color') }}"
                                                   id="colorPicker5">
                                        </label>
                                    </span>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <label class="zForm-label">{{ __('Hero Background Color') }}<span class="text-danger">*</span></label>
                                    <div class="">
                                    <span class="color-picker d-flex flex-wrap">
                                        <label for="colorPicker6" class="mb-0 me-3">
                                            <input type="color" name="app_hero_footer_bg_color"
                                                   value="{{ empty(getOption('app_hero_footer_bg_color')) ? '#040E17' : getOption('app_hero_footer_bg_color') }}"
                                                   id="colorPicker6">
                                        </label>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center pt-15">
                        <button type="submit"
                                class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('admin/css/for-certificate.css')}}">
@endpush

@push('script')
    <script>
        'use strict'
        const colorDesignType = "{{ empty(getOption('app_color_design_type')) ? 1 : getOption('app_color_design_type') }}";
    </script>
    <script src="{{ asset('admin/js/custom-color.js') }}"></script>
@endpush
