<div class="p-sm-30 p-15 bg-white bd-one bd-c-stroke bd-ra-10 zaiStock-shadow-one mb-20">
    <div class="border-0 mb-0 packageInfo pb-0">
        <h4 class="name">{{__('Product Name')}} : <span>{{$product->title}}</span></h4>
        <p class="duration">{{__('Variation')}} :
            <span>{{$product->variation}}</span>
        </p>
    </div>
</div>
<div class="p-sm-30 p-15 bg-white bd-one bd-c-stroke bd-ra-10 zaiStock-shadow-one">
    <div class="packagePaymentDetails">
        <h4 class="title">{{__('Payment Details')}}</h4>
        <form method="GET" action="{{ route('customer.checkout.page') }}">
            <div class="paymentCouponWrap">
                <input type="hidden" name="type" value="product">
                <input type="hidden" name="slug" value="{{ $product->slug }}">
                <input type="hidden" name="variation" value="{{ $product->variation_id }}">
                <input type="hidden" name="applied_coupon" value="1">
                <input required type="text" class="zForm-control" name="coupon_name"
                       value="{{ $coupon_name ?? '' }}"
                       placeholder="{{__('Enter your coupon code')}}"/>
                <button type="submit">{{__('Apply Now')}}</button>
            </div>
        </form>
        <form action="{{route('customer.checkout.pay')}}" enctype="multipart/form-data"
              method="POST">
            @csrf
            <input type="hidden" name="type" value="{{ ORDER_TYPE_PRODUCT  }}">
            <input type="hidden" name="id" value="{{ $product->id }}">
            <input type="hidden" name="variation" value="{{ $product->variation_id }}">
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
