@extends('layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush

@section('content')
    <!-- Main content -->
    <section class="admin-section">
        <div class="container">
            <div class="row rg-20">
                <div class="col-xl-3 col-lg-4 col-md-4">
                    @include('customer.layouts.sidebar')
                </div>
                <!--  -->
                <div class="col-xl-9 col-lg-8 col-md-8">
                    <div class="admin-section-right">
                        <div class="uploadProduct-content">
                            <form class="ajax" action="{{route('customer.products.update', $product->uuid)}}" method="POST"
                                  data-handler="commonResponseRedirect"
                                  data-redirect-url="{{route('customer.products.index')}}">
                                @csrf
                                @include('customer.products.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="variation-item-html" class="d-none">
        <li>
            <div class="licensePaid-item zaiStock-shadow-one">
                <div class="variationFields">
                    <div class="left">
                        <div>
                            <input type="text" name="variations[]"
                                   placeholder="{{__('Variation')}}"
                                   class="variations zForm-control"/>
                        </div>
                        <div>
                            <input type="text" name="prices[]"
                                   placeholder="{{__('Price')}}"
                                   class="prices zForm-control"/>
                        </div>
                    </div>
                    <button type="button" class="right remove-variation">
                        <img
                            src="{{asset('assets/images/icon/variationFields-delete.svg')}}"
                            alt=""/>
                    </button>
                </div>
                <div>
                    <label class="zForm-label">{{__('Upload File')}}
                        <span
                            class="text-primary">*</span></label>
                    <div class="file-upload-one">
                        <label for="mAttachment-1">
                            <p class="fileName fs-14 fw-400 lh-24 text-para-text bd-c-stroke-2">
                                {{__('Choose Image to upload')}}</p>
                            <p class="fs-14 fw-600 lh-24 text-white">{{__('Browse File')}}</p>
                        </label>
                        <input type="file" name="main_files[]"
                               id="mAttachment-1"
                               class="main_files fileUploadInput invisible position-absolute top-0 w-100 h-100"/>
                    </div>
                </div>
            </div>
        </li>
    </div>
    <input type="hidden" id="fetch_product_type_category_route" value="{{route('customer.products.fetch_product_type_category', 'PRODUCT_TYPE_ID')}}">
@endsection
@push('script')
    <script src="{{ asset('assets/js/products.js') }}"></script>
@endpush
