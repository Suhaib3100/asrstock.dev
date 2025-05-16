@extends('admin.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __(@$pageTitle) }}</h2>
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
                @include('admin.setting.setting-sidebar')
            </div>
            <div class="col-xl-9">
                <h4 class="fs-18 fw-600 lh-22 text-primary-dark-text pb-25">{{ __(@$pageTitle) }}</h4>
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <form class="ajax" action="{{ route('admin.setting.application-settings.update') }}"
                          method="POST" enctype="multipart/form-data" data-handler="commonResponseWithPageLoad">
                        @csrf
                        <div class="row rg-20 pb-24">
                            <div class="col-xxl-6 col-lg-6">
                                <label class="zForm-label">{{ __("Donation Status") }} <span class="text-danger">*</span></label>
                                <select name="donation_status" class="form-select select2">
                                    <option value="1" {{ getOption('donation_status') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                    <option value="0" {{ getOption('donation_status') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                </select>
                            </div>
                            <div class="col-xxl-6 col-lg-6">
                                <label class="zForm-label">{{ __("Donate Price") }} <span class="text-danger">*</span></label>
                                <input type="number" name="donate_price" value="{{getOption('donate_price')}}" class="form-control zForm-control" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center pt-15 bd-t-one bd-c-stroke">
                            <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

