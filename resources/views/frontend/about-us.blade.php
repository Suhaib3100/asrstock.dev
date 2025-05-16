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
    <section class="section-gap-alt">
        <div class="container">
            <div class="section-content-wrap text-center">
                <h4 class="title max-w-500 m-auto">{{$settings['top_area_title']}}</h4>
                <p class="info max-w-775 m-auto">{{nl2br($settings['top_area_subtitle'])}}</p>
            </div>
            <div class="discover-itemWrap">
                <div class="discover-imgWrap discover-imgWrap-1">
                    <img src="{{$settings['gallery_first_image']}}" alt=""/>
                </div>
                <div class="discover-imgWrap discover-imgWrap-2">
                    <img src="{{$settings['gallery_second_image']}}" alt=""/>
                </div>
                <div class="discover-imgWrap discover-imgWrap-3">
                    <img src="{{$settings['gallery_third_image']}}" alt=""/>
                </div>
                <div class="discover-imgWrap discover-imgWrap-4">
                    <img src="{{$settings['gallery_fourth_image']}}" alt=""/>
                </div>
            </div>
        </div>
    </section>

    @if(getOption('why_us_section') == ACTIVE)
        <section class="">
            <div class="container">
                <div class="section-content-wrap text-center">
                    <h4 class="title">{{ getOption('why_us_title') }}</h4>
                    <p class="info">{{ getOption('why_us_subtitle') }}</p>
                </div>
                <div class="chooseUs-itemWrap">
                    <div class="row justify-content-center">
                        @foreach($whyUs as $data)
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="chooseUs-item">
                                    <div class="icon"><img src="{{ $data->image }}" alt=""/></div>
                                    <h4 class="title">{{ $data->title }}</h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- About -->
    <section class="section-gap">
        <div class="container">
            <div class="aboutWrap">
                <div class="left">
                    <img src="{{$settings['about_us_image']}}" alt=""/>
                </div>
                <div class="right">
                    <p>{{$settings['about_us_description']}}</p>
                    <ul class="list">
                        <li class="item">
                            <div class="titleWrap">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                         fill="none">
                                        <path
                                            d="M0.75 6.875C0.75 6.875 1.875 6.875 3.375 9.5C3.375 9.5 7.5441 2.625 11.25 1.25"
                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <h4>{{$settings['about_us_point1_title']}}</h4>
                            </div>
                            <p>{{nl2br($settings['about_us_point1_description'])}}</p>
                        </li>
                        <li class="item">
                            <div class="titleWrap">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                         fill="none">
                                        <path
                                            d="M0.75 6.875C0.75 6.875 1.875 6.875 3.375 9.5C3.375 9.5 7.5441 2.625 11.25 1.25"
                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <h4>{{$settings['about_us_point2_title']}}</h4>
                            </div>
                            <p>{{nl2br($settings['about_us_point2_description'])}}</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted -->
    <section class="">
        <div class="container">
            <p class="fs-18 fw-400 lh-28 text-para-text text-center pb-md-40 pb-20">{{$settings['trusted_section_title']}}</p>
            <div class="brand-sliderWrap">
                <div class="swiper autoImageslider">
                    <div class="swiper-wrapper">
                        @foreach($trustedBrands as $trustedBrand)
                            <div class="swiper-slide">
                                <img src="{{getFileUrl($trustedBrand->image)}}" alt=""/>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row rg-20">
                <div class="col-md-3 col-6">
                    <div class="trusted-item">
                        <h4 class="title">{{$settings['about_us_total_assets']}}</h4>
                        <p class="info">{{__('Total Assets')}}</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="trusted-item">
                        <h4 class="title">{{$settings['about_us_downloads']}}</h4>
                        <p class="info">{{__('Downloads')}}</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="trusted-item">
                        <h4 class="title">{{$settings['about_us_creators']}}</h4>
                        <p class="info">{{__('Creators')}}</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="trusted-item">
                        <h4 class="title">{{$settings['about_us_countries']}}</h4>
                        <p class="info">{{__('Countries')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team members -->
    <section class="section-gap">
        <div class="container">
            <div class="section-content-wrap text-center">
                <h4 class="title">{{$settings['team_member_title']}}</h4>
                <p class="info">{{$settings['team_member_subtitle']}}</p>
            </div>
            <div class="row rg-20">
                @foreach($teamMembers as $team)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="team-member-item">
                            <div class="img">
                                <img src="{{$team->image}}" alt=""/>
                            </div>
                            <h4 class="name">{{$team->name}}</h4>
                            <p class="degi">{{$team->designation}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- People's Observation -->
    @if(getOption('testimonial_section') == ACTIVE)
        <section class="section-gap section-peopleObservation">
            <div class="container">
                <div class="section-content-wrap text-center">
                    <h4 class="title">{{ getOption('testimonial_title') }}</h4>
                    <p class="info">{{ getOption('testimonial_subtitle') }}</p>
                </div>
                <div class="swiper peopleObservationSlider">
                    <div class="swiper-wrapper">
                        @foreach($testimonialData as $data)
                            <div class="swiper-slide">
                                <div class="peopleObservation-item">
                                    <h4 class="title">{{ $data->name }}</h4>
                                    <p class="degi">{{ $data->designation }}</p>
                                    <div class="img"><img src="{{ $data->image }}" alt=""/></div>
                                    <p class="text">"{{ $data->quote }}"</p>
                                    <div class="sf-review-star" style="--rating: {{ ($data->rating*20)}}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
    @endif
@endsection
