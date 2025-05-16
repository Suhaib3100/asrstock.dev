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
                                <li class="breadcrumb-item"><a href="#">{{__('Earning')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{__(@$pageTitle)}}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
            <form action="{{ route('admin.setting.general-settings.update') }}" method="post" class="form-horizontal">
                @csrf
                <div class="row rg-24">
                    <div class="col-md-6 col-xl-4">
                        <label class="zForm-label">{{__('Admin Commission For')}} <b>{{ __('Single Product') }}</b> <span class="text-danger">*</span></label>
                        <div class="input-group flex-nowrap">
                            <input type="number" min="0" max="100" step="any" name="admin_product_commission" value="{{getOption('admin_product_commission')}}" placeholder="{{__('Admin product commission')}}" class="zForm-control">
                            <span class="input-group-text">%</span>
                            @if ($errors->has('admin_product_commission'))
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('admin_product_commission') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <label class="zForm-label">{{__('Admin Commission For')}} <b>{{ __('Download Product') }}</b> <span class="text-danger">*</span></label>
                        <div class="input-group flex-nowrap">
                            <input type="number" min="0" max="100" step="any" name="admin_download_commission" value="{{getOption('admin_download_commission')}}" placeholder="{{__('Admin download commission')}}" class="zForm-control">
                            <span class="input-group-text">%</span>
                            @if ($errors->has('admin_download_commission'))
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('admin_download_commission') }}</span>
                            @endif
                        </div>
                    </div>
                    @if(isAddonInstalled('PIXELDONATION'))
                        <div class="col-md-6 col-xl-4">
                            <label class="zForm-label">{{__('Admin Commission for')}} <b>{{ __('Donate Product') }}</b> <span class="text-danger">*</span></label>
                            <div class="input-group flex-nowrap">
                                <input type="number" min="0" max="100" step="any" name="admin_donate_commission" value="{{getOption('admin_donate_commission')}}" placeholder="{{__('Admin donate commission')}}" class="zForm-control">
                                <span class="input-group-text">%</span>
                                @if ($errors->has('admin_donate_commission'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('admin_donate_commission') }}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <div class="d-flex justify-content-end g-10 pt-24">
                    <button class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white" type="submit">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Page content area end -->
@endsection
