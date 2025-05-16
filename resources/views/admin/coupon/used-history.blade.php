@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __('Used History') }}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{__(@$pageTitle)}}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __($coupon->name) }}</h2>
            <a href="{{route('admin.coupon.index')}}" class="border-0 bg-main-color py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"> <i
                    class="fa fa-arrow-left"></i> {{ __('Back To Coupon List') }} </a>
        </div>
        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
            <table class="table zTable zTable-last-item-right">
                <thead>
                <tr>
                    <th>
                        <div>{{ __('SL') }}</div>
                    </th>
                    <th>
                        <div class="text-nowrap">{{ __('Order Number') }}</div>
                    </th>
                    <th>
                        <div class="text-nowrap">{{ __('Customer Name') }}</div>
                    </th>
                </tr>
                </thead>
                <tbody>
                @forelse($customerCoupons as $customerCoupon)
                    <tr class="removable-item">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$customerCoupon->order->order_number}}</td>
                        <td>{{$customerCoupon->customer->name}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">{{ __('No Record Found') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Page content area end -->
@endsection
