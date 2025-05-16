@extends('layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="breadcrumb-content bg-inner-bg">
            <h4 class="title">{{$pageTitle}}</h4>
            <ol class="breadcrumb sf-breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('frontend.index')}}">{{__('Home')}}</a></li>
                <li class="breadcrumb-item"><a>{{$pageTitle}}</a></li>
            </ol>
        </div>
    </section>

    <!--  -->
    <section class="section-gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="section-content-wrap text-center">
                        <div class="icon mb-20">
                            <img src="{{asset('assets/images/icon/crown.svg')}}" alt=""/>
                        </div>
                        <h4 class="title pb-0">{{__('Affordable Plans, Infinite Creativity.')}}</h4>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="d-flex justify-content-center align-items-center g-10 pb-md-45 pb-30">
                <h4 class="fs-14 fw-400 lh-24 text-primary-dark-text">{{__('Monthly')}}</h4>
                <div class="price-plan-tab">
                    <div class="zCheck form-check form-switch zPrice-plan-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="zPrice-plan-switch"/>
                    </div>
                </div>
                <h4 class="fs-14 fw-400 lh-24 text-primary-dark-text">{{__('Yearly')}}</h4>
            </div>
            <div class="row rg-20">
                @foreach($plans as $plan)
                    <div class="col-lg-4 col-md-6">
                        <div class="price-plan-one">
                            <div class="price-head" data-background="{{asset('assets/images/price-bg.png')}}">
                                <h4 class="sub-title">{{$plan->name}}</h4>
                                <h4 class="plan-price zPrice-plan-monthly">
                                    <span>{{showPrice($plan->monthly_price)}}</span>/{{__('Monthly')}}
                                </h4>
                                <h4 class="d-none plan-price zPrice-plan-yearly">
                                    <span>{{showPrice($plan->yearly_price)}}</span>/{{__('Yearly')}}
                                </h4>
                            </div>
                            <div class="price-body zaiStock-shadow-one">
                                <div class="titleWrap">
                                    <h4 class="title">{{$plan->subtitle}}</h4>
                                    <p class="info">{{$plan->description}}</p>
                                </div>
                                <ul class="list">
                                    @foreach($plan->planBenefits ?? [] as $benefit)
                                        <li>
                                            <div class="item">
                                                <div class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11"
                                                         viewBox="0 0 12 11" fill="none">
                                                        <path
                                                            d="M0.75 6.875C0.75 6.875 1.875 6.875 3.375 9.5C3.375 9.5 7.5441 2.625 11.25 1.25"
                                                            stroke="#09A8F7" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                                <p class="text">{{$benefit->point}}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <a href="{{route('customer.checkout.page', ['type' => 'plan', 'slug' => $plan->slug, 'duration' => ORDER_PLAN_DURATION_TYPE_MONTH])}}"
                                   class="text-center zPrice-plan-monthly link">{{__('Get Start')}}</a>
                                <a href="{{route('customer.checkout.page', ['type' => 'plan', 'slug' => $plan->slug, 'duration' => ORDER_PLAN_DURATION_TYPE_YEAR])}}"
                                   class="d-none text-center zPrice-plan-yearly link">{{__('Get Start')}}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
