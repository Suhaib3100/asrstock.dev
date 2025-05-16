@extends('admin.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <div data-aos="fade-up" data-aos-duration="1000" class="p-sm-30 p-15">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __($pageTitle) }}</h4>
            <div class="row rg-20">
                <div class="col-xl-3">
                    <div class="bg-white p-sm-25 p-15 bd-one bd-c-stroke bd-ra-8">
                        @include('admin.setting.sidebar')
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="bg-white p-sm-25 p-15 bd-one bd-c-stroke bd-ra-8">
                        <h4 class="fs-18 fw-600 lh-22 text-title-text bd-b-one bd-c-stroke mb-25 pb-25">{{ $pageTitle }}
                        </h4>
                        <form class="ajax" action="{{ route('admin.setting.application-settings.update') }}"
                              method="POST" enctype="multipart/form-data" data-handler="settingCommonHandler">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap">
                                            <label for="app_color_design_type"
                                                   class="zForm-label-alt">{{ __('System Color') }}<span class="text-danger"> *</span></label>
                                            <select name="app_color_design_type" id="app_color_design_type"
                                                    class="zForm-label-alt  sf-select-without-search" required>
                                                <option value="{{ DEFAULT_COLOR }}"
                                                    {{ getOption('app_color_design_type', DEFAULT_COLOR) == DEFAULT_COLOR ? 'selected' : '' }}>
                                                    {{ __('Default') }}</option>
                                                <option value="{{ CUSTOM_COLOR }}"
                                                    {{ getOption('app_color_design_type', DEFAULT_COLOR) == CUSTOM_COLOR ? 'selected' : '' }}>
                                                    {{ __('Custom') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row rg-20 {{getOption('app_color_design_type', DEFAULT_COLOR) == DEFAULT_COLOR ? 'd-none' : ''}}" id="custom-color-block">
                                <div class="item-top">
                                    <hr>
                                </div>
                                <div class="col-xxl-4 col-lg-6">
                                    <label class="zForm-label-alt">{{ __('Primary Color') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="color" name="primary_color" value="{{ getOption('primary_color','#5525c9') ?? '#5525c9' }}"
                                           class="form-control zForm-control-alt p-8">
                                </div>
                                <div class="col-xxl-4 col-lg-6">
                                    <label class="zForm-label-alt">{{ __('Secondary Color') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="color" name="secondary_color" value="{{ getOption('secondary_color','#6afcef') ?? '#6afcef' }}"
                                           class="form-control zForm-control-alt p-8">
                                </div>
                                <div class="col-xxl-4 col-lg-6">
                                    <label class="zForm-label-alt">{{ __('Sidebar Color') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="color" name="sidebar_color" value="{{ getOption('sidebar_color','#5525c9') ?? '#5525c9' }}"
                                           class="form-control zForm-control-alt p-8">
                                </div>
                                <div class="col-xxl-4 col-lg-6">
                                    <label class="zForm-label-alt">{{ __('Button Primary Color') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="color" name="button_primary_color" value="{{ getOption('button_primary_color','#5525c9') ?? '#5525c9' }}"
                                           class="form-control zForm-control-alt p-8">
                                </div>
                                <div class="col-xxl-4 col-lg-6">
                                    <label class="zForm-label-alt">{{ __('Button Secondary Color') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="color" name="button_secondary_color" value="{{ getOption('button_secondary_color','#f5c000') ?? '#f5c000' }}"
                                           class="form-control zForm-control-alt p-8">
                                </div>
                                <div class="item-top">
                                    <hr>
                                </div>
                            </div>
                            <div class="bd-c-stroke-2 justify-content-between align-items-center text-end pt-12">
                                <button type="submit"
                                        class="flipBtn sf-flipBtn-primary">{{ __('Update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('admin/custom/js/color-settings.js') }}"></script>
@endpush
