<div class="p-sm-30 p-15 bg-white bd-one bd-c-stroke bd-ra-10 zaiStock-shadow-one mb-20">
    <div class="packageInfo">
        <h4 class="name">{{ __('Package Name') }} : <span>{{ $plan->name }}</span></h4>
        <p class="duration">{{ __('Duration') }}: <span>{{ getOrderPlanDuration($duration) }}</span></p>
    </div>
    <div class="packageInclude">
        <h4 class="title">{{ __('What\'s Included') }}</h4>
        <ul class="list">
            @foreach($plan->planBenefits ?? [] as $benefit)
                <li>
                    <div class="item">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                 fill="none">
                                <path d="M0.75 6.875C0.75 6.875 1.875 6.875 3.375 9.5C3.375 9.5 7.5441 2.625 11.25 1.25"
                                      stroke="#09A8F7" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <p class="text">{{ $benefit->point }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="p-sm-30 p-15 bg-white bd-one bd-c-stroke bd-ra-10 zaiStock-shadow-one">
    <div class="packagePaymentDetails">
        <h4 class="title">{{__('Payment Details')}}</h4>
        <form action="{{route('customer.checkout.pay')}}" enctype="multipart/form-data"
              method="POST">
            @csrf
            <input type="hidden" name="type" value="{{ ORDER_TYPE_PLAN  }}">
            <input type="hidden" name="id" value="{{ $plan->id }}">
            <input type="hidden" name="duration" value="{{ $duration }}">
            <input type="hidden" name="coupon_name" value="{{ $coupon_name ?? '' }}">
            <input type="hidden" name="gateway_id" id="gateway_id" value="">
            <!-- Add the total value as a data attribute here -->
            <div id="paymentData" data-total="{{ $total }}">
                <div class="pb-sm-30 pb-20">
                    <ul class="zList-pb-15">
                        <li class="d-flex justify-content-between align-items-center">
                            <p class="fs-16 fw-400 lh-26 text-primary-dark-text">{{__('Subtotal')}}
                                :</p>
                            <p class="fs-16 fw-400 lh-26 text-primary-dark-text">{{showPrice($subtotal)}}</p>
                        </li>
                        <li class="d-flex justify-content-between align-items-center">
                            <p class="fs-16 fw-400 lh-26 text-primary-dark-text">{{__('Discount')}}
                                :</p>
                            <p class="fs-16 fw-400 lh-26 text-primary-dark-text">{{showPrice($discount)}}</p>
                        </li>
                        <li class="d-flex justify-content-between align-items-center">
                            <p class="fs-16 fw-400 lh-26 text-primary-dark-text">{{__('Tax')}}
                                :</p>
                            <p class="fs-16 fw-400 lh-26 text-primary-dark-text">{{showPrice($tax)}}</p>
                        </li>
                        <li class="d-flex justify-content-between align-items-center">
                            <p class="fs-16 fw-400 lh-26 text-primary-dark-text">{{__('Total')}}
                                :</p>
                            <p class="fs-16 fw-400 lh-26 text-primary-dark-text">{{showPrice($total)}}</p>
                        </li>
                        <li class="d-flex justify-content-between align-items-center">
                            <p class="fs-16 fw-400 lh-26 text-primary-dark-text">{{__('Conversion Rate')}}
                                :</p>
                            <p class="fs-16 fw-400 lh-26 text-primary-dark-text">{{showPrice(1).'='}}
                                <span id="conversion_rate"></span></p>
                        </li>
                        <li class="d-flex justify-content-between align-items-center">
                            <p class="fs-16 fw-400 lh-26 text-primary-dark-text">{{__('Grand Total')}}
                                :</p>
                            <p class="fs-16 fw-400 lh-26 text-primary-dark-text"><span
                                    id="grand_total"></span></p>
                        </li>
                    </ul>
                </div>

                @include('customer.partials.bank-block')

                <button type="submit" class="zaiStock-btn w-100 d-flex justify-content-center">{{__('Pay')}}</button>
            </div>
        </form>
    </div>
</div>
