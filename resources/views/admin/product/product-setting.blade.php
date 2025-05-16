@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{__(@$pageTitle)}}</h2>
            <div class="breadcrumb__content p-0">
                <div class="breadcrumb__content__right">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb sf-breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                            <li class="breadcrumb-item"><a href="#">{{__('Product')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__(@$pageTitle)}}</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
            <form action="{{ route('admin.setting.general-settings.update') }}" method="post" class="form-horizontal">
                @csrf
                <div class="row rg-24">
                    <div class="col-md-6 col-xl-4">
                        <label class="zForm-label">{{__('Product Min Price Limit')}} <span class="text-danger">*</span></label>
                        <div class="input-group flex-nowrap">
                            <input type="number" min="1" step="any" name="product_price_min_limit" value="{{getOption('product_price_min_limit')}}" placeholder="{{__('Product Minimum Price Limit')}}" class="zForm-control">
                            <span class="input-group-text">{{ getCurrencySymbol() }}</span>
                            @if ($errors->has('product_price_min_limit'))
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('product_price_min_limit') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <label class="zForm-label">{{__('Product Max Price Limit')}} <span class="text-danger">*</span></label>
                        <div class="input-group flex-nowrap">
                            <input type="number" min="1" step="any" name="product_price_max_limit" value="{{getOption('product_price_max_limit')}}" placeholder="{{__('Product Maximum Price Limit')}}" class="zForm-control">
                            <span class="input-group-text">{{ getCurrencySymbol() }}</span>
                            @if ($errors->has('product_price_max_limit'))
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('product_price_max_limit') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 text-end">
                        <button class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white" type="submit">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Page content area end -->
@endsection
