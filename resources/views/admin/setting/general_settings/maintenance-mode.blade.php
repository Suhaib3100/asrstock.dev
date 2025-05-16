@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __('Application Setting') }}</h2>
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

        <div class="row">
            <div class="col-xl-3">
                @include('admin.setting.setting-sidebar')
            </div>
            <div class="col-xl-9">
                    <h4 class="fs-18 fw-600 lh-22 text-primary-dark-text pb-25">{{ __(@$pageTitle) }}</h4>
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <div class="bg-dark-primary-soft-varient p-4 border-1">
                        <h2>{{ __('Instructions') }}: </h2>
                        <p>{{__('You need to follow some instruction after maintenance mode changes. Instruction list given below-')}}</p>
                        <div class="text-black">
                            <li>If you select maintenance mode <b>Maintenance On</b>,
                                you need to input secret key for maintenance work. Otherwise you can't work this website. And your created secret key helps you to work under
                                maintenance.
                            </li>
                            <li>After created maintenance key, you can use this website secretly through this url <span class="iconify"
                                                                                                                        data-icon="arcticons:url-forwarder"></span> <span
                                    class="text-primary">{{ url('/') }}/(Your created secret key)</span></li>
                            <li>Only one time url is browsing with secret key, and you can browse your site in maintenance mode. When maintenance mode on, any user can see
                                maintenance mode error message.
                            </li>
                            <li>Unfortunately you forget your secret key and try to connect with your website. <br> Then you go to your project folder location
                                <b>Main Files</b>(where your file in cpanel or your hosting)<span class="iconify" data-icon="arcticons:url-forwarder"></span><b>storage</b>
                                <span class="iconify" data-icon="arcticons:url-forwarder"></span><b>framework</b>. You can see 2 files and need to delete 2 files. Files are:
                                <br>
                                1. down <br>
                                2. maintenance.php
                            </li>
                        </div>
                    </div>
                    <br>
                    <form action="{{route('admin.setting.maintenance.change')}}" method="post" class="form-horizontal">
                        @csrf

                        <div class="row rg-24">
                            <div class="col-xl-4 col-md-6">
                                <label class="zForm-label">{{ __('Maintenance Mode') }} <span class="text-danger">*</span></label>
                                <select name="maintenance_mode" id="" class="form-select maintenance_mode">
                                    <option value="">--{{ __('Select Option') }}--</option>
                                    <option value="1" @if(getOption('maintenance_mode') == 1) selected @endif>{{ __('Maintenance On') }}</option>
                                    <option value="2" @if(getOption('maintenance_mode') != 1) selected @endif>{{ __('Live') }}</option>
                                </select>
                                @if ($errors->has('maintenance_mode'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('maintenance_mode') }}</span>
                                @endif
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <label class="zForm-label">{{ __('Maintenance Mode Secret Key') }}</label>
                                    <input type="text" name="maintenance_secret_key" value="{{ getOption('maintenance_secret_key') }}" minlength="6"
                                           class="zForm-control maintenance_secret_key">
                                    @if ($errors->has('maintenance_secret_key'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('maintenance_secret_key') }}</span>
                                    @endif
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <label class="zForm-label">{{ __('Maintenance Mode Url') }} </label>
                                    <input type="text" name="" value="" class="zForm-control maintenance_mode_url" disabled>
                            </div>
                        </div>

                        <div class="bd-c-stroke bd-t-one justify-content-end align-items-center text-end pt-15 mt-24">
                            <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('script')
    <script>
        'use strict'
        let getUrl = "{{ url('') }}";
        const maintenanceSecretKey = "{{ getOption('maintenance_secret_key') }}";
        const maintenanceModeConst = "{{ getOption('maintenance_mode') }}";
    </script>
    <script src="{{ asset('admin/js/custom/maintenance-mode.js') }}"></script>
@endpush
