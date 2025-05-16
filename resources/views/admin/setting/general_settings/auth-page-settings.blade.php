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
                            <div class="row rg-15">
                                <div class="col-xxl-6 col-lg-6">
                                    <label class="zForm-label-alt">{{ __('Auth Page Title') }}</label>
                                    <textarea name="auth_page_title" class="form-control zForm-control-alt" cols="10" rows="5">{{ getOption('auth_page_title') }}</textarea>
                                </div>
                                <div class="col-xl col-md-4 col-sm-6">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap zImage-upload-details">
                                            <div class="zImage-inside">
                                                <div class="d-flex pb-12">
                                                    <img src="{{ asset('assets/images/icon/upload-img-1.svg') }}"
                                                        alt="" />
                                                </div>
                                                <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                                    {{ __('Drag & drop files here') }}
                                                </p>
                                            </div>
                                            <label for="login_right_image"
                                                class="zForm-label-alt">{{ __('Auth Page Image') }}</label>
                                            <div class="upload-img-box">
                                                @if (getOption('login_right_image'))
                                                    <img src="{{ getSettingImage('login_right_image') }}" />
                                                @else
                                                    <img src="" />
                                                @endif
                                                <input type="file" name="login_right_image" id="login_right_image"
                                                    accept="image/*,video/*" onchange="previewFile(this)" />
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('login_right_image'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                            {{ $errors->first('login_right_image') }}</span>
                                    @endif
                                    <p>
                                        <span class="text-black">
                                            <span class="text-black">{{ __('Recommend Size') }}:</span>
                                            979 × 1024 px
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex g-12 flex-wrap mt-25">
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
