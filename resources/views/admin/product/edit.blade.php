@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{__(@$pageTitle)}}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                <li class="breadcrumb-item"><a href="{{route('admin.product.index')}}">{{__('Products')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{__(@$pageTitle)}}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
            <form action="{{route('admin.product.update', $product->uuid)}}" method="post" class="ajax form-horizontal" data-handler="commonResponseWithPageLoad" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row rg-24">
                    <div class="col-xl-5">
                        <div class="productEdit-thumb">
                            <label for="product_category_id" class="zForm-label"> {{ __('Thumbnail Image') }}</label>
                            <div class="upload-img-box w-100 h-100">
                                @if(file_exists($product->thumbnail_image_id))
                                @else
                                <img class="h-100" src="{{ getFileUrl($product->thumbnail_image_id) }}">
                                @endif
                                <input type="file" name="thumbnail_image" id="thumbnail_image" accept="image/*" onchange="previewFile(this)">
                                <div class="upload-img-box-icon">
                                    <i class="fa fa-camera"></i>
                                    <p class="m-0">{{__('Image')}}</p>
                                </div>
                            </div>
                            <p>{{ __('Accepted Image Files') }}: JPEG,JPG,PNG,GIF,TIF,BMP,ICO,PSD,Webp {{ __('Recommend Size') }}: 1MB</p>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <div class="row rg-24 pb-24">
                            <div class="col-md-6">
                                <label class="zForm-label">{{__('Title')}} <span class="text-danger">*</span></label>
                                <input type="text" name="title" value="{{old('title', $product->title)}}" placeholder="{{__('Title')}}" required class="zForm-control">
                            </div>

                            <div class="col-md-6">
                                <label class="zForm-label" for="product_type_id"> {{ __('Product Type') }} <span class="text-danger">*</span> </label>
                                <select class="zForm-control" name="product_type_id" id="product_type_id" required>
                                    <option value="">--{{ __('Select Option') }}--</option>
                                    @foreach($productTypes as $productType)
                                        <option data-product_type_category="{{ $productType->product_type_category }}" data-product_type_id="{{ $productType->id }}" {{ $product->product_type_id == $productType->id ? 'selected' : '' }} value="{{ $productType->id }}">{{ __($productType->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="zForm-label" for="product_category_id"> {{ __('Product Category') }} <span class="text-danger">*</span> </label>
                                <select name="product_category_id" id="" class="appendProductCategories zForm-control" required>
                                    <option value="">--{{ __('Select Option') }}--</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="zForm-label">{{__('File Types')}} <span class="text-danger">*</span></label>
                                <select class="zForm-control" name="file_types" id="product_type_extension" required>

                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="zForm-label">{{__('Accessibility')}} <span class="text-danger">*</span></label>
                                <select name="accessibility" id="accessibility" class="accessibility zForm-control" required>
                                    <option value="2" {{ $product->accessibility == PRODUCT_ACCESSIBILITY_FREE ? 'selected' : '' }}>{{ __('Free') }}</option>
                                    <option value="1" {{ $product->accessibility == PRODUCT_ACCESSIBILITY_PAID ? 'selected' : '' }}>{{ __('Paid') }}</option>
                                </select>
                            </div>

                            <div class="col-md-6 {{$product->accessibility == PRODUCT_ACCESSIBILITY_PAID ? 'd-none' : '' }}" id="use-this-photo-div">
                                <label class="zForm-label" for="use_this_photo"> {{ __('How They Can Use This File') }} <span class="text-danger">*</span></label>
                                <select class="zForm-control" name="use_this_photo" id="" class="use_this_photo" required>
                                    @foreach ($useOptions as $useOption)
                                        <option {{ $product->use_this_photo == $useOption->id ? 'selected' : '' }} value="{{ $useOption->id }}">{{ $useOption->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="variation-block" class="bg-style col-md-12 mb-20 p-15 {{ $product->accessibility == PRODUCT_ACCESSIBILITY_PAID ? '' : 'd-none'}}">
                            @forelse($product->variations as $variation)
                                @if($loop->first)
                                <div class="row rg-24">
                                @else
                                <div class="row child rg-24">
                                    <hr>
                                @endif
                                    <input type="hidden" name="variation_id[]" value="{{ $variation->id }}">
                                    <div class="col-md-6">
                                        <input type="text" name="variations[]" value="{{ $variation->variation }}" placeholder="{{__('Variation')}}" class="zForm-control variations">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group flex-nowrap">
                                            <input type="number" step="any" min="0.0" name="prices[]" value="{{ $variation->price }}" placeholder="{{__('Price')}}" class="zForm-control prices">
                                            <span class="input-group-text">{{ getCurrencySymbol() }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" name="main_files[]" value="" class="form-control main_files">
                                        <p>{{ __("Uploaded File") }}: <a target="__blank" href="{{ getFileFromManager($variation->file) }}" class="color-blue">{{ __('Main File') }}</a></p>
                                    </div>
                                    @if($loop->first)
                                    <div class="col-md-1">
                                        <button type="button" id="add-variation" class="btn btn-purple btn-sm">+</button>
                                    </div>
                                    @endif
                                </div>
                            @empty
                                <div class="row rg-24">
                                    <div class="col-md-6">
                                        <input type="text" name="variations[]" value="" placeholder="{{__('Variation')}}" class="zForm-control variations">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="number" step="any" min="0.0" name="prices[]" value="" placeholder="{{__('Price')}}" class="zForm-control prices">
                                            <span class="input-group-text">{{ getCurrencySymbol() }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" name="main_files[]" value="" class="form-control main_files">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" id="add-variation" class="btn btn-purple btn-sm">+</button>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <div class="row rg-24">
                            <div class="col-md-6  {{ $product->accessibility == PRODUCT_ACCESSIBILITY_PAID ? 'd-none' : ''}}" id="free-block">
                                <label class="zForm-label" for="File"> {{ __('Main File') }} <span class="text-danger">*</span></label>
                                <input type="file" name="main_file" value="" class="form-control">
                                <p>{{ __("Uploaded File") }}: <a target="__blank"  href="{{ getFileFromManager($product->variations->first()?->file) }}" class="color-blue">{{ __('Main File') }}</a></p>
                            </div>
                            <div class="col-md-6">
                                <label class="zForm-label" for="tags"> {{ __('Tags') }} <span class="text-danger">*</span></label>
                                <select name="tags[]" id="" class="sf-select-label tags"  multiple="multiple">
                                    @foreach($tags as $tag)
                                        <option {{ in_array($tag->id, $productTags) ? 'selected' : '' }} value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="zForm-label" for="tax_id"> {{ __('Tax') }} </label>
                                <select class="zForm-control" name="tax_id" >
                                    <option value="">--{{ __('Select Option') }}--</option>
                                    @foreach($taxes as $tax)
                                        <option {{ $tax->id == $product->tax_id ? 'selected' : '' }} value="{{ $tax->id }}">{{ $tax->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="zForm-label" for="status"> {{ __('Status') }} </label>
                                <select class="zForm-control" name="status"  required>
                                    <option value="{{ PRODUCT_STATUS_PUBLISHED }}">{{ __('Published') }}</option>
                                    <option value="{{ PRODUCT_STATUS_PENDING }}">{{ __('Pending') }}</option>
                                    <option value="{{ PRODUCT_STATUS_HOLD }}">{{ __('Hold') }}</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="zForm-label">{{__('Description')}} </label>
                                <textarea class="summernoteOne" rows=3 name="description">{{$product->description}}</textarea>
                            </div>

                            <div class="col-md-6" id="attribution-required-block">
                                <div class="zCheck form-switch">
                                    <input class="form-check-input" {{ $product->attribution_required == ACTIVE ? 'checked' : '' }} name="attribution_required" type="checkbox" role="switch" id="attribution_required" />
                                    <label class="form-check-label" for="attribution_required">Attribution required</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center g-10">
                    <a href="{{route('admin.product.index')}}" class="border-0 bg-para-text py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white d-inline-flex align-items-center g-10"> <i class="fa fa-arrow-left"></i> {{__('Back')}} </a>
                    <button class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white" type="submit">{{ __('Update') }}</button>
                </div>

            </form>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('admin/css/custom/image-preview.css')}}">
@endpush

@push('script')
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
    <script>
        'use strict'
        const productTypeCategoryRoute = "{{ route('admin.product.product-type.category') }}";
        const csrfToken = "{{ csrf_token() }}";
        const product_type_extension = "{{ $product->file_types }}";
        const product_category_id = "{{ $product->product_category_id }}";
        const productTypeExtensions = @json($productTypeExtensions);
        var value = "{{ $product->accessibility }}";
    </script>
    <script src="{{ asset('admin/js/custom/product-add.js') }}"></script>
@endpush
