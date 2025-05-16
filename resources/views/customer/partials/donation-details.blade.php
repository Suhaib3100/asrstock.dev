<div class="p-sm-30 p-15 bg-white bd-one bd-c-stroke bd-ra-10 zaiStock-shadow-one mb-20">
    <div class="border-0 mb-0 packageInfo pb-0">
        <h4 class="name pb-0">{{__('Donation Product Name')}} : <span>{{$product->title}}</span></h4>
    </div>
</div>
<div class="p-sm-30 p-15 bg-white bd-one bd-c-stroke bd-ra-10 zaiStock-shadow-one">
    <div class="packagePaymentDetails">
        <h4 class="title">{{__('Payment Details')}}</h4>
        <form action="{{route('customer.checkout.pay')}}" enctype="multipart/form-data"
              method="POST">
            @csrf
            <input type="hidden" name="type" value="{{ ORDER_TYPE_DONATE  }}">
            <input type="hidden" name="slug" value="{{ $product->slug }}">
            <input type="hidden" name="amount" value="{{$total}}">
            <input type="hidden" name="gateway_id" id="gateway_id" value="">
            <!-- Add the total value as a data attribute here -->
            <div id="paymentData" data-total="{{ $total }}">
                <div class="pb-sm-30 pb-20">
                    <ul class="zList-pb-15">
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
