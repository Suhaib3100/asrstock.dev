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
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <form action="{{route('admin.setting.home.why-us.update')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="pb-24">
                            <div class="row rg-24">
                                <div class="col-md-6">
                                    <label for="why_us_title" class="zForm-label"> {{ __('Why Us Title') }} </label>
                                    <input type="text" name="why_us_title" id="why_us_title"
                                           value="{{ getOption('why_us_title') }}" class="zForm-control"
                                           placeholder="Type why us title" required>
                                    @if ($errors->has('why_us_title'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('why_us_title') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="why_us_subtitle"
                                           class="zForm-label"> {{ __('Why Us Subtitle') }} </label>
                                    <textarea name="why_us_subtitle" class="zForm-control" rows="5" id="why_us_subtitle"
                                              placeholder="Type why us subtitle"
                                              required>{{ getOption('why_us_subtitle') }}</textarea>
                                    @if ($errors->has('why_us_subtitle'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('why_us_subtitle') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="pb-24">
                            <div class="row rg-24">
                                <div id="add_repeater" class="">
                                    <div data-repeater-list="why_us_points" class="col-12 row rg-24">
                                            @if($points->count() > 0)
                                                @foreach($points as $point)
                                                    <div data-repeater-item="" class="">
                                                        <input type="hidden" name="id" value="{{ @$point['id'] }}"/>
                                                        <div class="row rg-24">
                                                            <div class="col-md-4">
                                                                <label for="image_{{ @$point['id'] }}" class="zForm-label"> {{ __('Image') }} </label>
                                                                <div class="upload-img-box overflow-hidden">
                                                                    <img src="{{$point->image}}">
                                                                    <input type="file" name="image"
                                                                           id="image_{{ $point['id'] }}" accept="image/*"
                                                                           onchange="preview35DimensionsFile(this)">
                                                                    <div class="upload-img-box-icon">
                                                                        <i class="fa fa-camera"></i>
                                                                    </div>
                                                                </div>
                                                                <p class="fs-14 fw-400 lh-20 text-para-text pt-8"><span class="fw-500 text-primary-dark-text">{{ __('Recommend size') }}:</span>
                                                                    35 x 35</p>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <label for="title_{{ $point['id'] }}"
                                                                       class="zForm-label"> {{ __('Title') }} </label>
                                                                <input type="text" name="title" id="title_{{ $point['id'] }}"
                                                                       value="{{ $point->title }}" class="zForm-control"
                                                                       placeholder="Type title" required>
                                                            </div>
                                                            <div class="col-md-1">
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
                                                <div data-repeater-item="" class="">
                                                    <div class="row rg-24">
                                                        <div class="col-md-4">
                                                            <label for="image"
                                                                   class="zForm-label"> {{ __('Image') }} </label>
                                                            <div class="upload-img-box overflow-hidden">
                                                                <img src="{{ getDefaultImage() }}">
                                                                <input type="file" name="image" id="image" accept="image/*"
                                                                       onchange="preview35DimensionsFile(this)">
                                                                <div class="upload-img-box-icon">
                                                                    <i class="fa fa-camera"></i>
                                                                </div>
                                                            </div>
                                                            <p class="fs-14 fw-400 lh-20 text-para-text pt-8"><span class="fw-500 text-primary-dark-text">{{ __('Recommend size') }}:</span> 35 x
                                                                35</p>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <label for="title"
                                                                   class="zForm-label"> {{ __('Title') }} </label>
                                                            <input type="text" name="title" id="title" value=""
                                                                   class="form-control" placeholder="Type title" required>
                                                        </div>
                                                        <div class="col-md-1">
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
                                            @endif

                                    </div>

                                    <div class="col-12">
                                        <a id="add" href="javascript:;" data-repeater-create=""
                                           class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white d-inline-flex align-items-center g-10 mt-24">
                                            <i class="fas fa-plus"></i> {{ __('Add') }}
                                        </a>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="bd-c-stroke bd-t-one d-flex justify-content-end align-items-center pt-15">
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
