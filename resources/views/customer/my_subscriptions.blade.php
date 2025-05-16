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
                        <div class="bd-one bd-c-stroke bd-ra-10 bg-white zaiStock-shadow-one subscriptionItems-wrap">
                            <div class="item">
                                <h4 class="title">{{__('Current Plan')}}</h4>
                                @if($subscriptionPlan)
                                    <div class="subTitle-wrap pb-23">
                                        <h5 class="sub-title">{{$subscriptionPlan->plan->name}}</h5>
                                        <p class="info">{{$subscriptionPlan->plan_type == ORDER_PLAN_DURATION_TYPE_YEAR ? __('Annual Plan') : __('Monthly Plan')}}</p>
                                    </div>
                                    <div
                                        class="d-flex justify-content-between align-items-start align-items-xl-center flex-column flex-xl-row g-10">
                                        <p class="fs-18 fw-400 lh-28 text-para-text max-w-634">{{__('Your package price')}}
                                            <span
                                                class="text-primary">{{showPrice($subscriptionPlan->order->plan_price)}}</span>,
                                            {{__('duration')}} <span class="text-primary">
                                                {{$subscriptionPlan->plan_type == ORDER_PLAN_DURATION_TYPE_YEAR ? __('Yearly') : __('Monthly')}}
                                            </span>,
                                            {{__('device limit')}} <span
                                                class="text-primary">{{$subscriptionPlan->plan->device_limit}}</span>,
                                            {{__('download limit')}}
                                            <span class="text-primary">
                                                {{$subscriptionPlan->plan->download_limit_type == PLAN_DOWNLOAD_LIMIT_TYPE_UNLIMITED ? __('Unlimited') : $subscriptionPlan->plan->download_limit }}
                                            </span>.
                                            {{__('Your subscription plan will expire on')}} {{formatDate($subscriptionPlan->end_date, 'F j, Y')}}
                                            .</p>
                                        <button type="button"
                                                onclick="cancelSubscription('{{route('customer.subscriptions.cancel', $subscriptionPlan->id)}}')"
                                                class="zaiStock-btn-cancel text-nowrap">{{__('Cancel Subscription')}}</button>
                                    </div>
                                @else
                                    <div
                                        class="d-flex justify-content-between align-items-start align-items-xl-center flex-column flex-xl-row g-10">
                                        <p class="fs-18 fw-400 lh-28 text-para-text max-w-634">{{__('Currently you do not have any active plan')}}</p>
                                        <a href="{{route('frontend.pricing')}}"
                                           class="zaiStock-btn text-nowrap">{{__('Buy Plan')}}</a>
                                    </div>
                                @endif
                            </div>
                            @if($subscriptionPlan)
                                <div class="item">
                                    <h4 class="title">{{__('Download Limits')}}</h4>
                                    <div class="subTitle-wrap">
                                        <h5 class="sub-title">{{__('Downloads')}} ({{$totalDownload}}
                                            / {{$subscriptionPlan->plan->download_limit_type == PLAN_DOWNLOAD_LIMIT_TYPE_UNLIMITED ? __('Unlimited') : $subscriptionPlan->plan->download_limit }}
                                            )</h5>
                                        <p class="info">{{__('Limit reset every')}} {{$subscriptionPlan->plan_type == ORDER_PLAN_DURATION_TYPE_YEAR ? __('year') : __('month')}}</p>
                                    </div>
                                </div>
                            @endif
                            <div class="item">
                                <h4 class="pb-20 title">{{__('Billing History')}}</h4>
                                <table class="table zTable zTable-last-item-border zTable-last-item-right" id="billingHistoryTable">
                                    <thead>
                                    <tr>
                                        <td>
                                            <div class="text-nowrap">{{__('Order Number')}}</div>
                                        </td>
                                        <td>
                                            <div>{{__('Package')}}</div>
                                        </td>
                                        <td>
                                            <div>{{__('Total')}}</div>
                                        </td>
                                        <td>
                                            <div class="text-nowrap">{{__('Start Date')}}</div>
                                        </td>
                                        <td>
                                            <div class="text-nowrap">{{__('End Date')}}</div>
                                        </td>
                                        <td>
                                            <div>{{__('Gateway')}}</div>
                                        </td>
                                        <td>
                                            <div>{{__('Status')}}</div>
                                        </td>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <input type="hidden" id="datatable-route" value="{{ route('customer.subscriptions.my_subscription') }}">
@endsection
@push('script')
    <script src="{{ asset('assets/js/subscriptions.js') }}"></script>
@endpush
