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
                                <li class="breadcrumb-item active" aria-current="page">{{ @$pageTitle }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row rg-24">
            <div class="col-xl-3">
                @include('admin.setting.sidebar')
            </div>
            <div class="col-xl-9">
                <h2 class="fs-18 fw-500 lh-28 text-primary-dark-text pb-24">{{ @$pageTitle }}</h2>
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <form action="{{route('admin.setting.general-settings.update')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row rg-24 pb-24">
                            <div class="col-12">
                                <label for="why_us_title" class="zForm-label"> {{ __('First Portion Icon Title') }} </label>
                                <input type="text" name="contributor_first_portion_icon_title"
                                       value="{{ getOption('contributor_first_portion_icon_title') }}"
                                       class="zForm-control"
                                       placeholder="Type title" required>
                            </div>
                            <div class="col-12">
                                <label for="why_us_title" class="zForm-label"> {{ __('First Portion First Para Title') }} </label>
                                <input type="text" name="contributor_first_portion_first_para_title"
                                       value="{{ getOption('contributor_first_portion_first_para_title') }}"
                                       class="zForm-control"
                                       placeholder="Type title" required>
                            </div>
                            <div class="col-12">
                                <label for="why_us_subtitle" class="zForm-label"> {{ __('First Portion First Para Subtitle') }} </label>
                                <textarea name="contributor_first_portion_first_para_subtitle" class="form-control"
                                           placeholder="Type subtitle"
                                          required>{{ getOption('contributor_first_portion_first_para_subtitle') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="why_us_title" class="zForm-label"> {{ __('First Portion Second Para Title') }} </label>
                                <input type="text" name="contributor_first_portion_second_para_title"
                                       value="{{ getOption('contributor_first_portion_second_para_title') }}"
                                       class="zForm-control"
                                       placeholder="Type title" required>
                            </div>
                            <div class="col-12">
                                <label for="why_us_subtitle" class="zForm-label"> {{ __('First Portion Second Para Subtitle') }} </label>
                                <textarea name="contributor_first_portion_second_para_subtitle" class="form-control"
                                          placeholder="Type subtitle"
                                          required>{{ getOption('contributor_first_portion_second_para_subtitle') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="why_us_image" class="zForm-label"> {{ __('Second Portion Image') }} </label>
                                <div class="col-lg-3">
                                    <div class="upload-img-box w-100">
                                        <img src="{{ getSettingImage('contributor_second_portion_image') }}">
                                        <input type="file" name="contributor_second_portion_image" id="image"
                                               accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="why_us_title" class="zForm-label"> {{ __('Second Portion Title') }} </label>
                                <input type="text" name="contributor_second_portion_title"
                                       value="{{ getOption('contributor_second_portion_title') }}"
                                       class="zForm-control"
                                       placeholder="Type title" required>
                            </div>
                            <div class="col-12">
                                <label for="why_us_subtitle" class="zForm-label"> {{ __('Second Portion Subtitle') }} </label>
                                <textarea name="contributor_second_portion_subtitle" class="form-control"
                                          placeholder="Type subtitle"
                                          required>{{ getOption('contributor_second_portion_subtitle') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label for="why_us_title" class="zForm-label"> {{ __('Third Portion Title') }} </label>
                                <input type="text" name="contributor_third_portion_title"
                                       value="{{ getOption('contributor_third_portion_title') }}"
                                       class="zForm-control"
                                       placeholder="Type title" required>
                            </div>
                            <div class="col-12">
                                <label for="why_us_subtitle" class="zForm-label"> {{ __('Third Portion Subtitle') }} </label>
                                <textarea name="contributor_third_portion_subtitle" class="form-control"
                                          placeholder="Type subtitle"
                                          required>{{ getOption('contributor_third_portion_subtitle') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="why_us_image" class="zForm-label"> {{ __('Third Portion Image') }} </label>
                                <div class="col-lg-3">
                                    <div class="upload-img-box w-100">
                                        <img src="{{ getSettingImage('contributor_third_portion_image') }}">
                                        <input type="file" name="contributor_third_portion_image" id="image"
                                               accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="why_us_image" class="zForm-label"> {{ __('Fourth Portion Image') }} </label>
                                <div class="col-lg-3">
                                    <div class="upload-img-box w-100">
                                        <img src="{{ getSettingImage('contributor_fourth_portion_image') }}">
                                        <input type="file" name="contributor_fourth_portion_image" id="image"
                                               accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="why_us_title" class="zForm-label"> {{ __('Fourth Portion Title') }} </label>
                                <input type="text" name="contributor_fourth_portion_title"
                                       value="{{ getOption('contributor_fourth_portion_title') }}"
                                       class="zForm-control"
                                       placeholder="Type title" required>
                            </div>
                            <div class="col-12">
                                <label for="why_us_subtitle" class="zForm-label"> {{ __('Fourth Portion Subtitle') }} </label>
                                <textarea name="contributor_fourth_portion_subtitle" class="form-control"
                                          placeholder="Type subtitle"
                                          required>{{ getOption('contributor_fourth_portion_subtitle') }}</textarea>
                            </div>
                        </div>
                        <div class="bd-t-one bd-c-stroke d-flex justify-content-end align-items-center g-10 pt-15">
                            <button class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
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
    <script src="{{ asset('common/js/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('common/js/add-repeater.js') }}"></script>
@endpush
