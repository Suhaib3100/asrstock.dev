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
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
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
                <h2 class="fs-18 fw-600 lh-20 text-primary-dark-text pb-24">{{ @$pageTitle }}</h2>
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <form action="{{route('admin.setting.home.testimonial.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row rg-24 bd-b-one bd-c-stroke pb-24 mb-24">
                            <div class="col-md-6">
                                <label for="testimonial_title" class="zForm-label">{{ __('Title') }} </label>
                                <input type="text" name="testimonial_title" id="testimonial_title" value="{{ getOption('testimonial_title') }}"
                                       class="zForm-control" placeholder="Type title">
                                @if ($errors->has('testimonial_title'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('testimonial_title') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="testimonial_subtitle" class="zForm-label">{{ __('Subtitle') }} </label>
                                <textarea name="testimonial_subtitle" class="form-control" rows="5" id="testimonial_subtitle"
                                          required>{{ getOption('testimonial_subtitle') }}</textarea>
                                @if ($errors->has('testimonial_subtitle'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('testimonial_subtitle') }}</span>
                                @endif
                            </div>
                        </div>

                        <div id="add_repeater" class="row rg-24">
                            <div data-repeater-list="testimonials" class="row rg-24">
                                @if($testimonials->count() > 0)
                                    @foreach($testimonials as $testimonial)
                                        <div data-repeater-item="" class="col-12">
                                            <input type="hidden" name="id" value="{{ @$testimonial['id'] }}"/>
                                            <div class="row rg-24">
                                                <div class="col-md-4">
                                                    <label for="name_{{ @$testimonial['id'] }}" class="zForm-label"> {{ __('Name') }} </label>
                                                    <input type="text" name="name" id="name_{{ @$testimonial['id'] }}" value="{{ $testimonial->name }}" class="zForm-control" placeholder="Type name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="designation_{{ @$testimonial['id'] }}" class="zForm-label"> {{ __('Designation') }}</label>
                                                    <input type="text" name="designation" id="designation_{{ @$testimonial['id'] }}" value="{{ $testimonial->designation }}" class="zForm-control" placeholder="Type designation" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="rating_{{ @$testimonial['id'] }}" class="zForm-label"> {{ __('Rating') }}</label>
                                                    <select name="rating" id="rating_{{ @$testimonial['id'] }}" class="form-select">
                                                        <option value="1" @if($testimonial->rating == 1) selected @endif>1</option>
                                                        <option value="2" @if($testimonial->rating == 2) selected @endif>2</option>
                                                        <option value="3" @if($testimonial->rating == 3) selected @endif>3</option>
                                                        <option value="4" @if($testimonial->rating == 4) selected @endif>4</option>
                                                        <option value="5" @if($testimonial->rating == 5) selected @endif>5</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="image_{{ @$testimonial['id'] }}" class="zForm-label">{{ __('Image') }}</label>
                                                    <div class="upload-img-box overflow-hidden">
                                                        <img src="{{$testimonial->image}}">
                                                        <input type="file" name="image" id="image_{{ @$testimonial['id'] }}" accept="image/*" onchange="preview35DimensionsFile(this)">
                                                        <div class="upload-img-box-icon">
                                                            <i class="fa fa-camera"></i>
                                                        </div>
                                                    </div>
                                                    <p class="fs-14 fw-400 lh-20 text-para-text pt-8"><span class="fw-500 text-primary-dark-text">{{__('Recommend Size')}}:</span> 125 x 125</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="quote_{{ @$testimonial['id'] }}" class="zForm-label"> {{ __('Quote') }}</label>
                                                    <div class="">
                                                        <textarea name="quote" class="zForm-control" id="quote_{{ @$testimonial['id'] }}" rows="7" placeholder="Type quote"
                                                                  required>{{ $testimonial->quote }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="pt-md-30">
                                                        <a href="javascript:;" data-repeater-delete=""
                                                           class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-stroke bg-white">
                                                           <img src="{{asset('admin/images/icons/trash-2.svg')}}" alt="trash" class="onlyForProductRules">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div data-repeater-item="" class="col-12">
                                        <div class="row rg-24">
                                            <div class="col-md-4">
                                                <label for="name" class="zForm-label"> {{ __('Name') }}</label>
                                                <div class="">
                                                    <input type="text" name="name" id="name" value="" class="form-control" placeholder="Type name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="designation" class="zForm-label"> {{ __('Designation') }}</label>
                                                <div class="">
                                                    <input type="text" name="designation" id="designation" value="" class="form-control" placeholder="Type designation" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="rating" class="zForm-label"> {{ __('Rating') }}</label>
                                                <select name="rating" id="rating" class="form-select">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="image" class=" zForm-label"> {{ __('Image') }} </label>
                                                <div class="upload-img-box overflow-hidden">
                                                    <img src="{{ getDefaultImage() }}">
                                                    <input type="file" name="image" id="image" accept="image/*"  onchange="preview35DimensionsFile(this)" required>
                                                    <div class="upload-img-box-icon">
                                                        <i class="fa fa-camera"></i>
                                                    </div>
                                                </div>
                                                <p class="fs-14 fw-400 lh-20 text-para-text pt-8"><span class="fw-500 text-primary-dark-text">{{__('Recommend Size')}}:</span> 125 x 125</p>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="quote" class="zForm-label"> {{ __('Quote') }}</label>
                                                <div class="">
                                                    <textarea name="quote" class="zForm-control" id="quote" rows="7" placeholder="Type quote" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                <div class="pt-md-30">
                                                    <a href="javascript:;" data-repeater-delete=""
                                                       class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-stroke bg-white">
                                                       <img src="{{asset('admin/images/icons/trash-2.svg')}}" alt="trash" class="onlyForProductRules">
                                                    </a>
                                                </div>
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

                        <div class="bd-c-stroke bd-t-one d-flex justify-content-end align-items-center pt-15 mt-24">
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
    <link rel="stylesheet" href="{{asset('admin/css/custom/image-preview.css')}}">
@endpush

@push('script')
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
    <script src="{{ asset('common/js/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('common/js/add-repeater.js') }}"></script>
@endpush
