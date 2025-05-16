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

        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15 mb-30">
            <div class="item-title d-flex justify-content-between">
                <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text pb-20">{{ __('Monthly Pay Commission To Contributor') }}</h2>
            </div>
            <form action="{{ route('admin.earning.send-money.store') }}" method="post" class="form-horizontal">
                @csrf
                <div class="row rg-24">
                    <div class="col-md-4">
                        <label class="zForm-label">{{__('Month-Year')}} <span class="text-danger">*</span></label>
                        <input type="text" id="datepickerMonthYear" name="month_year" value="" placeholder="{{__('Month-Year')}}"
                               class="zForm-control flex-nowrap datepickerMonthYear">
                    </div>
                    <div class="col-md-4">
                        <label class="zForm-label">{{__('Total Download')}} <b><span class="monthly_year_level"></span></b><span class="text-danger">*</span></label>
                        <div class="input-group flex-nowrap">
                            <input type="number" min="0" step="any" name="total_download" value=""
                                   placeholder="{{__('Total Download')}}" class="zForm-control total_download" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="zForm-label">{{__('Total Income From Plan')}} <b><span class="monthly_year_level"></span></b><span class="text-danger">*</span></label>
                        <div class="input-group flex-nowrap">
                            <input type="number" min="0" step="any" name="total_income_from_plan" value="" placeholder="{{__('Total Income From Plan')}}"
                                   class="zForm-control total_income_from_plan" readonly>
                            <span class="input-group-text">{{ getCurrencySymbol() }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="zForm-label">{{__('Admin Commission From Plan')}} <b><span class="monthly_year_level"></span></b><span class="text-danger">*</span></label>
                        <div class="input-group flex-nowrap">
                            <input type="number" min="0" max="100" step="any" name="admin_commission_percentage" value="{{ empty(getOption('admin_download_commission')) ? 0 : getOption('admin_download_commission') }}"
                                   placeholder="{{__('Admin Commission From Plan')}}"
                                   class="zForm-control admin_commission_percentage" readonly>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="zForm-label">{{__('Contributor Commission From Plan')}} <b><span class="monthly_year_level"></span></b><span class="text-danger">*</span></label>
                        <div class="input-group flex-nowrap">
                            <input type="number" min="0" max="100" step="any" name="contributor_commission_percentage" value="{{ empty(getOption('admin_download_commission')) ? 100 : (100 - getOption('admin_download_commission')) }}"
                                   placeholder="{{__('Contributor Commission From Plan')}}"
                                   class="zForm-control contributor_commission_percentage" readonly>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="zForm-label">{{__('Get Commission Per Download')}} <b><span class="monthly_year_level"></span></b><span class="text-danger">*</span></label>
                        <div class="input-group flex-nowrap">
                            <input type="number" min="0" step="any" name="get_commission_per_download" value="" placeholder="{{__('Get Commission Per Download')}}"
                                   class="zForm-control get_commission_per_download" readonly>
                            <span class="input-group-text">{{ getCurrencySymbol() }}</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end g-10 pt-24">
                    <button class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white" type="submit">{{ __('Send Money') }}</button>
                </div>
            </form>
        </div>

        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15 admin-dashboard-blog-list-page">
            <div class="item-title d-flex justify-content-between">
                <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text pb-20">{{ __('Earning History For Each Month') }}</h2>
                <form action="" class="d-flex">
                    <select name="search_string" id="search_string" class="form-control">
                        <option value="">{{ __('Filter Month Year') }}</option>
                        @foreach($monthYears as $monthYear)
                        <option value="{{ $monthYear->month_year }}" {{ app('request')->search_string == $monthYear->month_year }}>{{ $monthYear->month_year }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="customers__table " id="appendList">
                @include('admin.earning.partial.render-earning-histories')
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('style')
    <link href="{{ asset('admin/css/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css') }}" rel="stylesheet"/>
@endpush

@push('script')

    <script src="{{ asset('admin/js/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js') }}"></script>
    <script>
        'use strict'
       const earningInfoMonthYearRoute = "{{ route('admin.earning.earningInfoViaMonthYear') }}";
       const currentUrl = "{{ url()->current() }}";
    </script>
    <script src="{{ asset('admin/js/custom/earning-management.js') }}"></script>
@endpush
