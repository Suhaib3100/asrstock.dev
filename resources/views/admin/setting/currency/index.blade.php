@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __('Frontend Settings') }}</h2>
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
                <div class="d-flex justify-content-between align-items-center g-10 flex-wrap pb-24">
                    <h4 class="fs-18 fw-600 lh-22 text-primary-dark-text">{{ __(@$pageTitle) }}</h4>
                    <button class="fs-15 border-0 fw-500 lh-25 text-white py-10 px-26 bg-primary bd-ra-12" type="button" data-bs-toggle="modal" data-bs-target="#add-todo-modal">
                        <i class="fa fa-plus"></i> {{ __('Add Currency') }}
                    </button>
                </div>
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <table class="table zTable zTable-last-item-right" id="currencyDataTable">
                        <thead>
                        <tr>
                            <th>
                                <div>{{ __("SL#") }}</div>
                            </th>
                            <th>
                                <div>{{ __("Code") }}</div>
                            </th>
                            <th>
                                <div>{{ __("Symbol") }}</div>
                            </th>
                            <th>
                                <div>{{ __("Placement") }}</div>
                            </th>
                            <th class="text-end">
                                <div>{{ __("Action") }}</div>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->

    <!-- Add Modal section start -->
    <div class="modal fade" id="add-todo-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 bd-ra-4 p-sm-25 p-15">
                <div class="bd-b-one bd-c-stroke pb-25 mb-25 d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Add Currency') }}</h5>
                    <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                </div>
                <form class="ajax" action="{{ route('admin.setting.currency.store') }}" method="post"
                      data-handler="commonResponseWithPageLoad">
                    @csrf
                    <div class="pb-24">
                        <div class="row rg-24">
                            <div class="col-12">

                                    <label class="zForm-label" for="currency_code">{{ __('Currency ISO Code') }}</label>
                                    <select class="form-select"
                                            name="currency_code">
                                            @foreach (getCurrency() as $code => $currencyItem)
                                                <option value="{{ $code }}">{{ $currencyItem }}</option>
                                            @endforeach
                                    </select>

                            </div>
                            <div class="col-12">

                                    <label class="zForm-label" for="symbol">{{ __('Symbol') }}</label>
                                    <input class="zForm-control" type="text" name="symbol" id="symbol" placeholder="Type symbol" value="{{ old('symbol') }}">

                            </div>
                            <div class="col-12">

                                    <label class="zForm-label" for="currency_placement">{{ __('Currency Placement') }}</label>
                                    <select name="currency_placement" id="" class="form-select">
                                        <option value="">--{{ __('Select Option') }}--</option>
                                        <option value="before">{{ __('Before Amount') }}</option>
                                        <option value="after">{{ __('After Amount') }}</option>
                                    </select>

                            </div>
                            <div class="col-12">
                                <div class="d-flex form-check ps-0 g-10">
                                    <div class="zCheck form-check form-switch">
                                        <input class="form-check-input mt-0" value="1" name="current_currency" type="checkbox"
                                               id="flexCheckChecked">
                                    </div>
                                    <label class="form-check-label d-flex" for="flexCheckChecked">
                                        {{ __('Current Currency') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bd-c-stroke bd-t-one justify-content-end align-items-center text-end pt-15">
                        <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Modal section end -->
    <!-- Edit Modal section start -->
    <div class="modal fade" id="edit-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">

            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{asset('admin/js/custom/currencies.js')}}"></script>
@endpush
