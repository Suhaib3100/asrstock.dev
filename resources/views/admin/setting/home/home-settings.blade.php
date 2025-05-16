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
                                <li class="breadcrumb-item active" aria-current="page">{{ __(@$pageTitle) }}</li>
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
                <h2 class="fs-18 fw-600 lh-20 text-primary-dark-text pb-24">{{ __(@$pageTitle) }}</h2>
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <form action="{{route('admin.setting.general-settings.update')}}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="pb-24">
                            <div class="row rg-24">
                                <div class="col-md-6">
                                    <label class="zForm-label" for="banner_title">{{ __('Banner Title') }} </label>
                                    <input type="text" name="banner_title" id="banner_title"
                                           value="{{ getOption('banner_title') }}" class="zForm-control"
                                           placeholder="Type banner title">
                                </div>
                                <div class="col-md-6">
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
                                            <label for="banner_image"
                                                   class="form-label">{{ __('Banner Image') }}</label>
                                            <div class="upload-img-box w-100">
                                                @if (getOption('banner_image'))
                                                    <img src="{{ getSettingImage('banner_image') }}"/>
                                                @else
                                                    <img src=""/>
                                                @endif
                                                <input type="file" name="banner_image" id="banner_image"
                                                       accept="image/*,video/*" onchange="previewFile(this)"/>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('banner_image'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                            {{ $errors->first('banner_image') }}</span>
                                    @endif
                                    <p>
                                        <span class="text-black">
                                            <span class="text-black">{{ __('Recommend Size') }}:</span>
                                            140 x 40
                                        </span>
                                    </p>
                                </div>

                                <div class="col-md-6">
                                    <label class="zForm-label"
                                           for="featured_gallery_title">{{ __("Editor's Choice Title") }} </label>
                                    <input type="text" name="editor_choice_title" id="editor_choice_title"
                                           value="{{ getOption('editor_choice_title') }}" class="zForm-control"
                                           placeholder="Type editor's choice  title">
                                </div>
                                <div class="col-md-6">
                                    <label class="zForm-label"
                                           for="editor_choice_description">{{ __("Editor's Choice Description") }} </label>
                                    <input type="text" name="editor_choice_description" id="editor_choice_description"
                                           value="{{ getOption('editor_choice_description') }}" class="zForm-control"
                                           placeholder="Type editor's choice description">
                                </div>
                                <div class="col-md-6">
                                    <label class="zForm-label"
                                           for="trending_collection_title">{{ __('Trending Collections Title') }} </label>
                                    <input type="text" name="trending_collection_title" id="trending_collection_title"
                                           value="{{ getOption('trending_collection_title') }}" class="zForm-control"
                                           placeholder="Type trending collections title">
                                </div>
                                <div class="col-md-6">
                                    <label class="zForm-label"
                                           for="trending_collection_description">{{ __('Trending Collections Description') }} </label>
                                    <input type="text" name="trending_collection_description"
                                           id="trending_collection_description"
                                           value="{{ getOption('trending_collection_description') }}"
                                           class="zForm-control" placeholder="Type trending collections description">
                                </div>
                                <div class="col-md-6">
                                    <label class="zForm-label"
                                           for="latest_collections_title">{{ __('Latest Collections Title') }} </label>
                                    <input type="text" name="latest_collections_title" id="latest_collections_title"
                                           value="{{ getOption('latest_collections_title') }}" class="zForm-control"
                                           placeholder="Type latest collections title">
                                </div>
                                <div class="col-md-6">
                                    <label class="zForm-label"
                                           for="latest_collections_description">{{ __('Latest Collections Description') }} </label>
                                    <input type="text" name="latest_collections_description"
                                           id="latest_collections_description"
                                           value="{{ getOption('latest_collections_description') }}"
                                           class="zForm-control" placeholder="Type latest collections description">
                                </div>
                                <div class="col-md-6">
                                    <label class="zForm-label"
                                           for="contributor_title">{{ __('Be A Contributor Title') }} </label>
                                    <input type="text" name="contributor_title" id="contributor_title"
                                           value="{{ getOption('contributor_title') }}" class="zForm-control"
                                           placeholder="Type be a contributor title">
                                </div>
                                <div class="col-md-6">
                                    <label class="zForm-label"
                                           for="contributor_description">{{ __('Be A Contributor Description') }} </label>
                                    <input type="text" name="contributor_description" id="contributor_description"
                                           value="{{ getOption('contributor_description') }}" class="zForm-control"
                                           placeholder="Type be a contributor description">
                                </div>
                                <div class="col-md-6">
                                    <label for="assets_type_title"
                                           class="zForm-label">{{ __('Assets Type Section') }} </label>
                                    <input type="text" name="assets_type_title" id="assets_type_title"
                                           value="{{ getOption('assets_type_title') }}" class="zForm-control"
                                           placeholder="Type assets type title">
                                </div>

                                <div class="col-md-6">
                                    <label class="zForm-label" for="banner_section">{{__('Banner Area')}} <span
                                            class="text-danger">*</span></label>

                                    <select name="banner_section" class="form-select select2">
                                        <option
                                            value="1" {{ getOption('banner_section') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option
                                            value="0" {{ getOption('banner_section') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="zForm-label" for="product_type_section">{{__('Product Type Area')}}
                                        <span class="text-danger">*</span></label>

                                    <select name="product_type_section" class="form-select select2">
                                        <option
                                            value="1" {{ getOption('product_type_section') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option
                                            value="0" {{ getOption('product_type_section') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="zForm-label"
                                           for="editor_choice_section">{{__("Editor's Choice Section")}} <span
                                            class="text-danger">*</span></label>

                                    <select name="editor_choice_section" class="form-select select2">
                                        <option
                                            value="1" {{ getOption('editor_choice_section') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option
                                            value="0" {{ getOption('editor_choice_section') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="zForm-label"
                                           for="trending_collections_section">{{__('Trending Collections Section')}}
                                        <span class="text-danger">*</span></label>

                                    <select name="trending_collections_section" class="form-select select2">
                                        <option
                                            value="1" {{ getOption('trending_collections_section') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option
                                            value="0" {{ getOption('trending_collections_section') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="zForm-label"
                                           for="latest_collections_section">{{__('Latest Collections Section')}} <span
                                            class="text-danger">*</span></label>

                                    <select name="latest_collections_section" class="form-select select2">
                                        <option
                                            value="1" {{ getOption('latest_collections_section') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option
                                            value="0" {{ getOption('latest_collections_section') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="zForm-label" for="why_us_section">{{__('Why Us Section')}} <span
                                            class="text-danger">*</span></label>

                                    <select name="why_us_section" class="form-select select2">
                                        <option
                                            value="1" {{ getOption('why_us_section') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option
                                            value="0" {{ getOption('why_us_section') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="zForm-label" for="why_us_section">{{__('Be a Contributor Section')}}
                                        <span class="text-danger">*</span></label>

                                    <select name="contributor_section" class="form-select select2">
                                        <option
                                            value="1" {{ getOption('contributor_section') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option
                                            value="0" {{ getOption('contributor_section') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="zForm-label" for="testimonial_section">{{__('Testimonial Section')}}
                                        <span class="text-danger">*</span></label>

                                    <select name="testimonial_section" class="form-select select2">
                                        <option
                                            value="1" {{ getOption('testimonial_section') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option
                                            value="0" {{ getOption('testimonial_section') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="zForm-label" for="blog_section">{{__('Blog / Article Section')}} <span
                                            class="text-danger">*</span></label>

                                    <select name="blog_section" class="form-select select2">
                                        <option
                                            value="1" {{ getOption('blog_section') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option
                                            value="0" {{ getOption('blog_section') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="assets_type_status" class="zForm-label">{{__('Assets Type Section')}} <span class="text-danger">*</span></label>
                                    <select name="assets_type_status" class="form-select select2">
                                        <option value="1" {{ getOption('assets_type_status') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option value="0" {{ getOption('assets_type_status') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
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
