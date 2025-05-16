@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __('Product Category') }}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('Product Category') }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-reverse flex-sm-row justify-content-center justify-content-md-end align-items-center flex-wrap g-10 pb-18">
            <button class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white" type="button" data-bs-toggle="modal"
                    data-bs-target="#add-todo-modal">
                <i class="fa fa-plus"></i> {{ __('Add Category') }}
            </button>
        </div>

        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15" id="appendList">
            @include('admin.product.partial.render-category-list')
        </div>
    </div>
    <!-- Page content area end -->

    <!-- Add Modal section start -->
    <div class="modal fade" id="add-todo-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <div class="d-flex justify-content-between align-items-center g-10 pb-20 mb-20 bd-b-one bd-c-stroke">
                    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Add Category') }}</h5>
                    <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                </div>
                <form action="{{ route('admin.product.category.store') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="pb-20">
                        <div class="input__group mb-30">
                            <label for="product_type_id" class="text-lg-right text-black"> {{ __('Product Type') }} </label>
                            <select name="product_type_id" id="product_type_id" class="form-select">
                                <option value="">--{{ __('Select Option') }}--</option>
                                @foreach($productTypes as $productType)
                                    <option value="{{ $productType->id }}">{{ $productType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input__group mb-30">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" name="name" id="name" placeholder="Name" value="" required>
                            @if ($errors->has('name'))
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                    {{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="input__group mb-30">
                            <label for="status" class="text-lg-right text-black"> {{ __('status') }} </label>
                            <select name="status" id="status" class="form-select">
                                <option value="">--{{ __('Select Option') }}--</option>
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Disable') }}</option>
                            </select>
                        </div>

                    </div>
                    <div class="bd-c-stroke bd-t-one justify-content-between align-items-center text-end pt-15">
                        <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Modal section end -->

    <!-- Edit Modal section start -->
    <div class="modal fade edit_modal" id="add-todo-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <div class="d-flex justify-content-between align-items-center g-10 pb-20 mb-20 bd-b-one bd-c-stroke">
                    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Edit Category') }}</h5>
                    <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                </div>
                <form action="" id="updateEditModal" method="post">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="pb-20">
                        <div class="input__group mb-30">
                            <label for="product_type_id" class="text-lg-right text-black"> {{ __('Product Type') }} </label>
                            <select name="product_type_id" id="product_type_id" class="form-select">
                                <option value="">--{{ __('Select Option') }}--</option>
                                @foreach($productTypes as $productType)
                                    <option value="{{ $productType->id }}">{{ $productType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input__group mb-30">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" name="name" id="name" placeholder="Type name" value=""
                                   required>
                            @if ($errors->has('name'))
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                    {{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="input__group mb-30">
                            <label for="status" class="text-lg-right text-black"> {{ __('status') }} </label>
                            <select name="status" id="status" class="form-select">
                                <option value="">{{ __('Select Option') }}</option>
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Disable') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="bd-c-stroke bd-t-one justify-content-between align-items-center text-end pt-15">
                        <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal section end -->
@endsection

@push('script')
    <script>
        'use strict'
        const productCategoryStatusChangeRoute = "{{ route('admin.product.category.changeStatus') }}";
        const csrfToken = "{{ csrf_token() }}";
        const currentUrl = "{{ url()->current() }}";
    </script>
    <script src="{{ asset('admin/js/custom/product-category.js') }}"></script>
@endpush
