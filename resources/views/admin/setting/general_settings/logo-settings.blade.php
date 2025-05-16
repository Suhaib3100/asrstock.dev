@extends('admin.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __(@$pageTitle) }}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ @$pageTitle }}</li>
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
                    <form class="ajax" action="{{ route('admin.setting.application-settings.update') }}"
                          method="POST" enctype="multipart/form-data" data-handler="settingCommonHandler">
                        @csrf
                        <div class="row rg-15">
                            <div class="col-xl col-md-4 col-sm-6">
                                <div class="primary-form-group">
                                    <div class="primary-form-group-wrap zImage-upload-details">
                                        <div class="zImage-inside">
                                            <div class="d-flex pb-12">
                                                <img src="{{ asset('assets/images/icon/upload-img-1.svg') }}"
                                                     alt=""/>
                                            </div>
                                            <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                                {{ __('Drag & drop file share') }}
                                            </p>
                                        </div>
                                        <label for="app_logo" class="zForm-label">{{ __('App Logo') }}</label>
                                        <div class="upload-img-box w-100">
                                            <img src="{{ getSettingImage('app_logo') }}"/>
                                            <input type="file" name="app_logo" id="app_logo"
                                                   accept="image/*,video/*" onchange="previewFile(this)"/>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->has('app_logo'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                            {{ $errors->first('app_logo') }}</span>
                                @endif
                                <p>
                                        <span class="text-black">
                                            <span class="text-black">{{ __('Recommend Size') }}:</span>
                                            140 x 40
                                        </span>
                                </p>
                            </div>

                            <div class="col-xl col-md-4 col-sm-6">
                                <div class="primary-form-group">
                                    <div class="primary-form-group-wrap zImage-upload-details">
                                        <div class="zImage-inside">
                                            <div class="d-flex pb-12">
                                                <img src="{{ asset('assets/images/icon/upload-img-1.svg') }}"
                                                     alt=""/>
                                            </div>
                                            <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                                {{ __('Drag & drop file share') }}
                                            </p>
                                        </div>
                                        <label for="app_logo_white"
                                               class="zForm-label">{{ __('App Logo (White)') }}</label>
                                        <div class="upload-img-box w-100">
                                            <img src="{{ getSettingImage('app_logo_white') }}"/>
                                            <input type="file" name="app_logo_white" id="app_logo_white"
                                                   accept="image/*,video/*" onchange="previewFile(this)"/>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->has('app_logo_white'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                            {{ $errors->first('app_logo_white') }}</span>
                                @endif
                                <p>
                                        <span class="text-black">
                                            <span class="text-black">{{ __('Recommend Size') }}:</span>
                                            140 x 40
                                        </span>
                                </p>
                            </div>

                            <div class="col-xl col-md-4 col-sm-6">
                                <div class="primary-form-group">
                                    <div class="primary-form-group-wrap zImage-upload-details">
                                        <div class="zImage-inside">
                                            <div class="d-flex pb-12">
                                                <img src="{{ asset('assets/images/icon/upload-img-1.svg') }}"
                                                     alt=""/>
                                            </div>
                                            <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                                {{ __('Drag & drop files here') }}
                                            </p>
                                        </div>
                                        <label for="app_fav_icon"
                                               class="zForm-label">{{ __('App Fav Icon') }}</label>
                                        <div class="upload-img-box w-100">
                                            <img src="{{ getSettingImage('app_fav_icon') }}"/>
                                            <input type="file" name="app_fav_icon" id="app_fav_icon"
                                                   accept="image/*,video/*" onchange="previewFile(this)"/>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->has('app_fav_icon'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                            {{ $errors->first('app_fav_icon') }}</span>
                                @endif
                                <p>
                                        <span class="text-black">
                                            <span class="text-black">{{ __('Recommend Size') }}:</span>
                                            16 x 16
                                        </span>
                                </p>
                            </div>
                            <div class="col-xl col-md-4 col-sm-6">
                                <div class="primary-form-group">
                                    <div class="primary-form-group-wrap zImage-upload-details">
                                        <div class="zImage-inside">
                                            <div class="d-flex pb-12">
                                                <img src="{{ asset('assets/images/icon/upload-img-1.svg') }}"
                                                     alt=""/>
                                            </div>
                                            <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                                {{ __('Drag & drop files here') }}
                                            </p>
                                        </div>
                                        <label for="app_preloader"
                                               class="zForm-label">{{ __('App Preloader') }}</label>
                                        <div class="upload-img-box w-100">
                                            <img src="{{ getSettingImage('app_preloader') }}"/>
                                            <input type="file" name="app_preloader" id="app_preloader"
                                                   accept="image/*,video/*" onchange="previewFile(this)"/>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->has('app_preloader'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                            {{ $errors->first('app_preloader') }}</span>
                                @endif
                                <p>
                                        <span class="text-black">
                                            <span class="text-black">{{ __('Recommend Size') }}:</span>
                                            140 x 40
                                        </span>
                                </p>
                            </div>
                            <div class="col-xl col-md-4 col-sm-6">
                                <div class="primary-form-group">
                                    <div class="primary-form-group-wrap zImage-upload-details">
                                        <div class="zImage-inside">
                                            <div class="d-flex pb-12">
                                                <img src="{{ asset('assets/images/icon/upload-img-1.svg') }}"
                                                     alt=""/>
                                            </div>
                                            <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                                {{ __('Drag & drop files here') }}
                                            </p>
                                        </div>
                                        <label for="water_mark_img"
                                               class="zForm-label">{{ __('Water Mark Image') }}</label>
                                        <div class="upload-img-box w-100">
                                            <img src="{{ getSettingImage('water_mark_img') }}"/>
                                            <input type="file" name="water_mark_img" id="water_mark_img"
                                                   accept="image/*,video/*" onchange="previewFile(this)"/>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->has('water_mark_img'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                            {{ $errors->first('water_mark_img') }}</span>
                                @endif
                                <p>
                                    <span class="text-black">
                                        <span class="text-black">{{ __('File Type') }}: jpg,jpeg,png</span>
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="bd-c-stroke bd-t-one d-flex justify-content-end align-items-center pt-24 mt-24">
                            <button type="submit"
                                    class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('admin/css/custom/image-preview.css')}}">
@endpush

@push('script')
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
@endpush

