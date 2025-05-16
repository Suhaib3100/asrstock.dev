@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{__('Frontend Settings')}}</h2>
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
                @include('admin.setting.sidebar')
            </div>
            <div class="col-xl-9">
                <h2 class="fs-18 fw-600 lh-20 text-primary-dark-text pb-24">{{ @$pageTitle }}</h2>
                <div class="email-inbox__area bg-style">
                    <form action="{{route('admin.setting.about.gallery-area.update')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row rg-24 bd-b-one bd-c-stroke pb-24 mb-24">
                            <div class="col-md-6">
                                <label for="top_area_title" class="zForm-label"> {{ __('Top Area Title') }} </label>
                                <input type="text" name="top_area_title" id="top_area_title"
                                       value="{{ getOption('top_area_title') }}" class="zForm-control"
                                       placeholder="{{__('Top area title')}}">
                                @if ($errors->has('top_area_title'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('top_area_title') }}</span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="top_area_subtitle"
                                       class="zForm-label"> {{ __('Top Area Subtitle') }} </label>
                                <textarea name="top_area_subtitle" class="zForm-control" rows="5"
                                          id="top_area_subtitle"
                                          placeholder="{{__('Top area subtitle')}}">{{ getOption('top_area_subtitle') }}</textarea>
                                @if ($errors->has('top_area_subtitle'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('top_area_subtitle') }}</span>
                                @endif
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <label class="zForm-label">{{ __('First Image') }}</label>
                                <div class="">
                                    <div class="upload-img-box overflow-hidden">
                                        <img src="{{getSettingImage('gallery_first_image')}}">
                                        <input type="file" name="gallery_first_image" id="gallery_first_image"
                                               accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('gallery_first_image'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('gallery_first_image') }}</span>
                                    @endif
                                    <p class="fs-14 fw-400 lh-20 text-para-text pt-8"><span
                                            class="fw-500 text-primary-dark-text">{{ __('Accepted Files') }}:</span> JPG
                                    </p>
                                    <p class="fs-14 fw-400 lh-20 text-para-text pt-8"><span
                                            class="fw-500 text-primary-dark-text">{{ __('Recommend Size') }}:</span> 312
                                        x 348 (1MB)</p>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <label class="zForm-label">{{ __('Second Image') }}</label>
                                <div class="">
                                    <div class="upload-img-box overflow-hidden">
                                        <img src="{{getSettingImage('gallery_second_image')}}">
                                        <input type="file" name="gallery_second_image" id="gallery_second_image"
                                               accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('gallery_second_image'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('gallery_second_image') }}</span>
                                    @endif
                                    <p class="fs-14 fw-400 lh-20 text-para-text pt-8"><span
                                            class="fw-500 text-primary-dark-text">{{ __('Accepted Files') }}:</span> JPG
                                    </p>
                                    <p class="fs-14 fw-400 lh-20 text-para-text pt-8"><span
                                            class="fw-500 text-primary-dark-text">{{ __('Recommend Size') }}:</span> 312
                                        x 348 (1MB)</p>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <label class="zForm-label">{{ __('Third Image') }}</label>
                                <div class="">
                                    <div class="upload-img-box overflow-hidden">
                                        <img src="{{getSettingImage('gallery_third_image')}}">
                                        <input type="file" name="gallery_third_image" id="gallery_third_image"
                                               accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('gallery_third_image'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('gallery_third_image') }}</span>
                                    @endif
                                    <p class="fs-14 fw-400 lh-20 text-para-text pt-8"><span
                                            class="fw-500 text-primary-dark-text">{{ __('Accepted Files') }}:</span> JPG
                                    </p>
                                    <p class="fs-14 fw-400 lh-20 text-para-text pt-8"><span
                                            class="fw-500 text-primary-dark-text">{{ __('Recommend Size') }}:</span> 312
                                        x 348 (1MB)</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <label class="zForm-label">{{ __('Fourth Image') }}</label>
                                <div class="">
                                    <div class="upload-img-box overflow-hidden">
                                        <img src="{{getSettingImage('gallery_fourth_image')}}">
                                        <input type="file" name="gallery_fourth_image" id="gallery_fourth_image"
                                               accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('gallery_fourth_image'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('gallery_fourth_image') }}</span>
                                    @endif
                                    <p class="fs-14 fw-400 lh-20 text-para-text pt-8"><span
                                            class="fw-500 text-primary-dark-text">{{ __('Accepted Files') }}:</span> JPG
                                    </p>
                                    <p class="fs-14 fw-400 lh-20 text-para-text pt-8"><span
                                            class="fw-500 text-primary-dark-text">{{ __('Recommend Size') }}:</span> 312
                                        x 348 (1MB)</p>
                                </div>
                            </div>
                        </div>
                        <div class="row rg-24 bd-b-one bd-c-stroke pb-24 mb-24">
                            <div class="col-md-3">
                                <label for="about_us_image" class="zForm-label"> {{ __('About Us Image') }} </label>
                                <div class="upload-img-box overflow-hidden">
                                    <img src="{{getSettingImage('about_us_image')}}">
                                    <input type="file" name="about_us_image" id="about_us_image"
                                           accept="image/*"
                                           onchange="previewFile(this)">
                                    <div class="upload-img-box-icon">
                                        <i class="fa fa-camera"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <label for="about_us_description"
                                       class="zForm-label"> {{ __('About Us Description') }} </label>
                                <input type="text" name="about_us_description" id="about_us_description"
                                       value="{{ getOption('about_us_description') }}" class="zForm-control"
                                       placeholder="{{__('Type Description')}}" required>
                            </div>
                        </div>
                        <div class="row rg-24 bd-b-one bd-c-stroke pb-24 mb-24">
                            <div class="col-md-6">
                                <label for="about_us_point1_title"
                                       class="zForm-label"> {{ __('About Us Point 1 Title') }} </label>
                                <input type="text" name="about_us_point1_title" id="about_us_point1_title"
                                       value="{{ getOption('about_us_point1_title') }}" class="zForm-control"
                                       placeholder="{{__('About Us Point 1 Title')}}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="about_us_point1_description"
                                       class="zForm-label"> {{ __('About Us Point 1 Description') }} </label>
                                <input type="text" name="about_us_point1_description" id="about_us_point1_description"
                                       value="{{ getOption('about_us_point1_description') }}" class="zForm-control"
                                       placeholder="{{__('About Us Point 1 Description')}}" required>
                            </div>
                        </div>
                        <div class="row rg-24 bd-b-one bd-c-stroke pb-24 mb-24">
                            <div class="col-md-6">
                                <label for="about_us_point2_title"
                                       class="zForm-label"> {{ __('About Us Point 2 Title') }} </label>
                                <input type="text" name="about_us_point2_title" id="about_us_point2_title"
                                       value="{{ getOption('about_us_point2_title') }}" class="zForm-control"
                                       placeholder="{{__('About Us Point 2 Title')}}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="about_us_point2_description"
                                       class="zForm-label"> {{ __('About Us Point 2 Description') }} </label>
                                <input type="text" name="about_us_point2_description" id="about_us_point2_description"
                                       value="{{ getOption('about_us_point2_description') }}" class="zForm-control"
                                       placeholder="{{__('About Us Point 2 Description')}}" required>
                            </div>
                        </div>

                        <div class="row rg-24 bd-b-one bd-c-stroke pb-24 mb-24">
                            <div class="col-md-6">
                                <label for="trusted_section_title"
                                       class="zForm-label"> {{ __('Trusted Section Title') }} </label>
                                <input type="text" name="trusted_section_title" id="trusted_section_title"
                                       value="{{ getOption('trusted_section_title') }}" class="zForm-control"
                                       placeholder="{{__('Trusted Section Title')}}" required>
                            </div>
                        </div>

                        <div class="bd-b-one bd-c-stroke pb-24 mb-24">
                            <div id="add_repeater" class="row rg-24">
                                <div data-repeater-list="trusted_brands" class="row rg-24">
                                    @if($trustedBrands->count() > 0)
                                        @foreach($trustedBrands as $brand)
                                            <div data-repeater-item="" class="col-12">
                                                <input type="hidden" name="id" value="{{ @$brand['id'] }}"/>
                                                <div class="row rg-24">
                                                    <div class="col-md-4">
                                                        <label for="image_{{ @$brand['id'] }}"
                                                               class="zForm-label"> {{ __('Logo') }} </label>
                                                        <div class="upload-img-box overflow-hidden">
                                                            <img src="{{getFileUrl($brand->image)}}">
                                                            <input type="file" name="logo" id="image_{{ $brand['id'] }}"
                                                                   accept="image/*"
                                                                   onchange="previewFile(this)">
                                                            <div class="upload-img-box-icon">
                                                                <i class="fa fa-camera"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <label for="name_{{ $brand['id'] }}"
                                                               class="zForm-label"> {{ __('Name') }} </label>
                                                        <input type="text" name="name" id="name_{{ $brand['id'] }}"
                                                               value="{{ $brand->title }}" class="zForm-control"
                                                               placeholder="{{__('Type name')}}" required>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <div class="pt-md-30">
                                                            <a href="javascript:;" data-repeater-delete=""
                                                               class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-stroke bg-white">
                                                                <img src="{{asset('admin/images/icons/trash-2.svg')}}"
                                                                     alt="trash" class="onlyForProductRules">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div data-repeater-item="" class="col-12">
                                            <div class="custom-form-group mb-3 col-md-3 col-lg-3 col-xl-3 col-xxl-2">
                                                <label for="image" class="zForm-label"> {{ __('Logo') }} </label>
                                                <div class="upload-img-box overflow-hidden">
                                                    <img src="{{ getDefaultImage() }}">
                                                    <input type="file" name="logo" id="image" accept="image/*"
                                                           onchange="preview44DimensionsFile(this)">
                                                    <div class="upload-img-box-icon">
                                                        <i class="fa fa-camera"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="custom-form-group mb-3 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                                <label for="name" class="zForm-label"> {{ __('Name') }} </label>
                                                <input type="text" name="name" id="name" value="" class="zForm-control"
                                                       placeholder="{{__('Type name')}}" required>
                                            </div>

                                            <div class="col-lg-1">
                                                <div class="pt-md-30">
                                                    <a href="javascript:;" data-repeater-delete=""
                                                       class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-stroke bg-white">
                                                        <img src="{{asset('admin/images/icons/trash-2.svg')}}"
                                                             alt="trash"
                                                             class="onlyForProductRules">
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                </div>

                                <div class="col-12">
                                    <a id="add" href="javascript:;" data-repeater-create=""
                                       class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white d-inline-flex align-items-center g-10">
                                        <i class="fas fa-plus"></i> {{ __('Add') }}
                                    </a>
                                </div>

                            </div>
                        </div>

                        <div class="row rg-24">
                            <div class="col-md-6">
                                <label for="about_us_total_assets"
                                       class="zForm-label"> {{ __('Total Assets') }} </label>
                                <input type="text" name="about_us_total_assets" id="about_us_total_assets"
                                       value="{{ getOption('about_us_total_assets') }}" class="zForm-control"
                                       placeholder="{{__('Total Assets')}}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="about_us_downloads" class="zForm-label"> {{ __('Downloads') }} </label>
                                <input type="text" name="about_us_downloads" id="about_us_downloads"
                                       value="{{ getOption('about_us_downloads') }}" class="zForm-control"
                                       placeholder="{{__('Downloads')}}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="about_us_creators" class="zForm-label"> {{ __('Creators') }} </label>
                                <input type="text" name="about_us_creators" id="about_us_creators"
                                       value="{{ getOption('about_us_creators') }}" class="zForm-control"
                                       placeholder="{{__('Creators')}}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="about_us_countries" class="zForm-label"> {{ __('Countries') }} </label>
                                <input type="text" name="about_us_countries" id="about_us_countries"
                                       value="{{ getOption('about_us_countries') }}" class="zForm-control"
                                       placeholder="{{__('Countries')}}" required>
                            </div>
                        </div>

                        <div class="bd-c-stroke bd-t-one d-flex justify-content-end align-items-center pt-15 mt-24">
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
    <script src="{{ asset('common/js/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('common/js/add-repeater.js') }}"></script>
@endpush
