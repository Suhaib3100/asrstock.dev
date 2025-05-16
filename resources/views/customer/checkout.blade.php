@extends('layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')

    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="breadcrumb-content bg-inner-bg">
            <h4 class="title">{{ $pageTitle }}</h4>
            <ol class="breadcrumb sf-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">{{ __('Home') }}</a></li>
                @if(request()->get('type') == 'plan')
                    <li class="breadcrumb-item"><a href="{{ route('frontend.pricing') }}">{{ __('Pricing') }}</a></li>
                @elseif(request()->get('type') == 'wallet')
                    <li class="breadcrumb-item"><a href="{{ route('customer.wallets.index') }}">{{ __('Wallet') }}</a></li>
                @else
                    <li class="breadcrumb-item"><a href="{{ route('customer.wallets.index') }}">{{ __('Product') }}</a></li>
                @endif
                <li class="breadcrumb-item"><a>{{ $pageTitle }}</a></li>
            </ol>
        </div>
    </section>

    <!-- Payment Section -->
    <section class="section-gap">
        <div class="container">
            <div class="row rg-20">
                <div class="col-md-6">
                    @if(request()->get('type') == 'plan')
                        @include('customer.partials.plan-details', ['plan' => $plan, 'duration' => $duration, 'total' => $total, 'banks' => $banks, 'coupon_name' => $coupon_name])
                    @elseif(request()->get('type') == 'product')
                        @include('customer.partials.product-details', ['product' => $product, 'total' => $total, 'banks' => $banks, 'coupon_name' => $coupon_name])
                    @elseif(request()->get('type') == 'donation')
                        @include('customer.partials.donation-details', ['product' => $product, 'total' => $total, 'banks' => $banks])
                    @elseif(request()->get('type') == 'wallet')
                        @include('customer.partials.wallet-details', ['total' => $total, 'banks' => $banks])
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="row rg-24">
                        @foreach($gateways as $gateway)
                            <div class="col-lg-6 col-md-12 col-sm-6">
                                <div class="payment-item">
                                    <input
                                        @if(old('gateway_id'))
                                            {{old('gateway_id') == $gateway->id ? 'checked' : ''}}
                                        @else
                                            {{$loop->first ? 'checked' : ''}}
                                        @endif data-conversion="{{$gateway->conversion_rate}}"
                                        data-gateway-slug="{{$gateway->gateway_slug}}"
                                        data-currency="{{$gateway->gateway_currency}}" type="radio" name="payment-item"
                                        id="{{$gateway->gateway_slug}}" data-gateway-id="{{$gateway->id}}"/>
                                    <label class="bd-one bd-c-stroke bd-ra-10 p-12 payment-item zaiStock-shadow-one"
                                           for="{{$gateway->gateway_slug}}">
                                        <h6 class="p-13 bd-ra-10 bg-bg-color-2 text-center fs-14 fw-400 lh-24 text-primary-dark-text payment-itemName">{{$gateway->gateway_name}}</h6>
                                        <div class="img">
                                            <img src="{{asset($gateway->image)}}" alt="{{$gateway->gateway_name}}"/>
                                        </div>
                                        <div class="paymentSelect">{{__('Select')}}</div>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('script')
    <script src="{{ asset('assets/js/checkout.js') }}"></script>
@endpush
