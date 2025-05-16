@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __('Edit Language') }}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.setting.language.index') }}">{{ __('Language Settings') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('Edit Language') }}</li>
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
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <form action="{{ route('admin.setting.language.update', $language->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row rg-24 pb-24">
                            <div class="col-md-6">
                                <label class="zForm-label" for="language"> {{ __('Name') }} </label>
                                <input type="text" name="language" id="language" value="{{ $language->language }}" class="zForm-control" placeholder=" {{ __('Name') }} ">
                                @error('language')
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="zForm-label"> {{ __('ISO Code') }} </label>
                                <input type="text" value="{{ $language->iso_code }}" class="zForm-control" placeholder=" {{ __('ISO Code') }} " disabled>
                                @if ($errors->has('iso_code'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('iso_code') }}</span>
                                @endif
                            </div>
                            <div class="col-md-12 d-flex justify-content-start flex-column g-10">
                                <div class="zForm-wrap-checkbox">
                                    <input type="checkbox" name="rtl" {{ $language->rtl == 1 ? 'checked' : '' }} class="form-check-input" value="1" id="rtl">
                                    <label for="rtl">{{ __('RTL Support') }}</label>
                                </div>
                                <div class="zForm-wrap-checkbox">
                                    <input type="checkbox" name="default_language" {{ $language->default_language == ACTIVE ? 'checked' : '' }} class="form-check-input" value="{{ ACTIVE }}" id="default_language">
                                    <label for="default_language">{{ __('Default Language') }}</label>
                                </div>
                                <div class="zForm-wrap-checkbox">
                                    <input type="checkbox" name="status" {{ $language->status == ACTIVE ? 'checked' : '' }} class="form-check-input" value="{{ ACTIVE }}" id="status">
                                    <label for="status">{{ __('Status') }}</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="flag" class="zForm-label">{{ __('Flag') }}</label>
                                <div class="col-lg-3">
                                    <div class="upload-img-box">
                                        @if ($language->flag)
                                            <img src="{{ $language->flag }}" alt="">
                                        @else
                                            <img src="{{ getDefaultImage() }}">
                                        @endif
                                        <input type="file" name="flag" id="flag" accept="image/*"
                                            onchange="previewFile(this)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-center pt-15 bd-t-one bd-c-stroke">
                            <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/css/custom/image-preview.css') }}">
@endpush

@push('script')
    <script src="{{ asset('admin/js/custom/image-preview.js') }}"></script>
@endpush
