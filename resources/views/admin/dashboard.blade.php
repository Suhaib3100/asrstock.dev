@extends('admin.layouts.app')

@section('content')
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __(@$pageTitle) }}</h2>
            <div class="breadcrumb__content p-0">
                <div class="breadcrumb__content__right">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb sf-breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __(@$pageTitle) }}</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row rg-24">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="p-25 bd-one bd-c-stroke bd-ra-10 bg-white dashboard-item h-100">
                    <div class="overlay">
                        <div class="dropdown">
                            <button class="btn btn-dropdown" type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('admin/images/icons/ellipsis-v.svg') }}" alt="icon">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                @foreach($accounting as $key => $val)
                                    <li><a class="dropdown-item" href="#">{{$key}}({{showPrice($val)}})</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="status__box__img">
                        <img src="{{ asset('admin/images/status-icon/revenue.png') }}" alt="icon">
                    </div>
                    <div class="status__box__text">
                        <h2 class="color-yellow">{{showPrice($accounting['Total Earning'])}}</h2>
                        <h3>{{__('Earning')}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="p-25 bd-one bd-c-stroke bd-ra-10 bg-white dashboard-item h-100">
                    <div class="overlay">

                    </div>
                    <div class="status__box__img">
                        <img src="{{ asset('admin/images/status-icon/revenue.png') }}" alt="icon">
                    </div>
                    <div class="status__box__text">
                        <h2 class="color-red">{{showPrice($wallet)}}</h2>
                        <h3>{{__('Wallet Balance')}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="p-25 bd-one bd-c-stroke bd-ra-10 bg-white dashboard-item h-100">
                    <div class="overlay">
                        <div class="dropdown">
                            <button class="btn btn-dropdown" type="button" id="dropdownMenuButton3"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('admin/images/icons/ellipsis-v.svg') }}" alt="icon">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                @foreach($withdrawal as $key => $val)
                                    <li><a class="dropdown-item" href="#">{{$key}}({{showPrice($val)}})</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="status__box__img">
                        <img src="{{ asset('admin/images/status-icon/expense.png') }}" alt="icon">
                    </div>
                    <div class="status__box__text">
                        <h2 class="color-blue">{{showPrice($withdrawal['Request Withdraw'])}}</h2>
                        <h3>{{__('Request Withdrawal')}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="p-25 bd-one bd-c-stroke bd-ra-10 bg-white dashboard-item h-100">
                    <div class="overlay">
                        <div class="dropdown">
                            <button class="btn btn-dropdown" type="button" id="dropdownMenuButton4"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('admin/images/icons/ellipsis-v.svg') }}" alt="icon">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                @php
                                    $total = 0;
                                @endphp
                                @foreach($totalUser as $key => $usr)
                                    <li><a class="dropdown-item" href="#">{{$key}}({{$usr}})</a></li>
                                    @php
                                        $total += $usr;
                                    @endphp
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="status__box__img">
                        <img src="{{ asset('admin/images/status-icon/visitor.png') }}" alt="icon">
                    </div>
                    <div class="status__box__text">
                        <h2 class="color-green">{{$total}}</h2>
                        <h3>{{__('User')}}</h3>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row rg-24">
                    <div class="col-xxl-3 col-xl-5 col-lg-6">
                        <div class="p-25 bd-one bd-c-stroke bd-ra-10 bg-white h-100">
                            <h2 class="fs-18 fw-500 lh-22 text-primary-dark-text pb-20">{{__('Product Statistics')}}</h2>
                            <div id="patient-statistics-chart"></div>
                        </div>
                    </div>
                    <div class="col-xxl-9 col-xl-7 col-lg-6">
                        <div class="p-25 bd-one bd-c-stroke bd-ra-10 bg-white h-100">
                            <h2 class="fs-18 fw-500 lh-22 text-primary-dark-text pb-20">{{ __('Last 15 Days Earning & Sale History') }}</h2>
                            <div class="sales-location__map">
                                <div id="saleChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row rg-24">
                    <div class="col-md-6">
                        <div class="p-sm-25 p-15 bd-one bd-c-stroke bd-ra-10 bg-white h-100">
                            <div class="d-flex justify-content-between align-items-center g-10 flex-wrap pb-20">
                                <h2 class="fs-18 fw-500 lh-22 text-primary-dark-text">{{ __('Top Trending Products') }}</h2>
                                @can('all_products')
                                    <a href="{{ route('admin.product.index') }}" title="View All Products"
                                       class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white">{{__('View All')}}</a>
                                @endif
                            </div>
                            <table class="table zTable zTable-last-item-right" id="topFiveProducts">
                                <thead>
                                <tr>
                                    <th>
                                        <div>{{__('Product')}}</div>
                                    </th>
                                    <th>
                                        <div>{{__('Owner')}}</div>
                                    </th>
                                    <th>
                                        <div>{{__('Watch')}}</div>
                                    </th>
                                    <th>
                                        <div class="text-nowrap">{{__('Total Order')}}</div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($topFiveProducts as $topFiveProduct)
                                    <tr>
                                        <td>{{ $topFiveProduct->title }}</td>
                                        <td>{{ $topFiveProduct->uploaded_by == PRODUCT_UPLOADED_BY_ADMIN ? @$topFiveProduct->user->name : @$topFiveProduct->customer->name }}</td>
                                        <td>{{ $topFiveProduct->total_watch }}</td>
                                        <td>{{ $topFiveProduct->totalOrder }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-sm-25 p-15 bd-one bd-c-stroke bd-ra-10 bg-white h-100">
                            <div class="d-flex justify-content-between align-items-center g-10 flex-wrap pb-20">
                                <h2 class="fs-18 fw-500 lh-22 text-primary-dark-text">{{__('Requested Withdrawal')}}</h2>
                                @can('pending_withdraw')
                                    <a href="{{ route('admin.withdraw.pending') }}"
                                       title="{{__('View All Withdrawal')}}"
                                       class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white">{{__('View All')}}</a>
                                @endif
                            </div>
                            <table class="table zTable zTable-last-item-right" id="dashboardWithdraw">
                                <thead>
                                <tr>
                                    <th>
                                        <div>{{__('Contributor')}}</div>
                                    </th>
                                    <th>
                                        <div class="text-nowrap">{{__('Method')}}</div>
                                    </th>
                                    <th>
                                        <div class="text-nowrap">{{__('Request Date')}}</div>
                                    </th>
                                    <th>
                                        <div>{{__('Amount')}}</div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($requestFiveWithdraws as $requestFiveWithdraw)
                                    <tr>
                                        <td>{{ @$requestFiveWithdraw->customer->name }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                {{getBeneficiary($requestFiveWithdraw->beneficiary?->type)}}
                                                <span class="ms-2" data-bs-toggle="tooltip"
                                                      title="{{htmlspecialchars($requestFiveWithdraw->beneficiary_details)}}">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                            </div>
                                        </td>
                                        <td>{{ date('M d, Y', strtotime($requestFiveWithdraw->created_at)) }}</td>
                                        <td>{{ getAmountPlace($requestFiveWithdraw->amount) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script>
        var patiSeris = [@foreach($product as $key => $usr) {{$usr}},@endforeach];
        var patiLab = [@foreach($product as $key => $usr) '{{$key}}',@endforeach];
        var customLegendItems = [@foreach($product as $key => $usr) '{{$key}}({{$usr}})',@endforeach];
        var dailyData1 = [@foreach($dailySale as $key => $s) {{$s[1]}},@endforeach];
        var dailyData2 = [@foreach($dailySale as $key => $s) {{$s[0]}},@endforeach];
        var currencySymble = "{{ getCurrencySymbol() }}";
        var categories = [@foreach($dailySale as $key => $s) '{{$key}}',@endforeach];


    </script>
    <script src="{{ asset('admin/js/custom/dashboard.js') }}"></script>
@endpush
