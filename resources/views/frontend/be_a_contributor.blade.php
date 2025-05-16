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

    <!-- Section -->
    <section class="section-gap-alt">
        <div class="container">
            <div class="row rg-20">
                <div class="col-lg-6">
                    <div class="section-content-wrap">
                        <h4 class="title">{{$settings['contributor_first_portion_icon_title']}}</h4>
                    </div>
                    <button data-bs-toggle="modal" data-bs-target="#applyContributorModal"
                            class="zaiStock-btn">{{__('Apply Now')}}</button>
                </div>
                <div class="col-lg-6">
                    <ul class="contributor-infoList">
                        <li>
                            <h4 class="title">{{$settings['contributor_first_portion_first_para_title']}}</h4>
                            <p class="info">{{$settings['contributor_first_portion_first_para_subtitle']}}</p>
                        </li>
                        <li>
                            <h4 class="title">{{$settings['contributor_first_portion_second_para_title']}}</h4>
                            <p class="info">{{$settings['contributor_first_portion_second_para_subtitle']}}</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Contributor Benefits -->
    <section class="section-gap-bottom">
        <div class="container">
            <div class="contributor-benefitWrap">
                <div class="lineBar"></div>
                <div class="starIcon starIcon-top">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45" fill="none">
                        <path
                                d="M22.5 -1.96701e-06C22.0515 12.2358 12.2358 22.0515 1.84768e-06 22.5C12.2358 22.9485 22.0515 32.7642 22.5 45C22.9485 32.7642 32.7642 22.9485 45 22.5C32.7642 22.0515 22.9485 12.2358 22.5 -1.96701e-06Z"
                                fill="#1F2224"/>
                    </svg>
                </div>
                <div class="starIcon starIcon-bottom">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45" fill="none">
                        <path
                                d="M22.5 -1.96701e-06C22.0515 12.2358 12.2358 22.0515 1.84768e-06 22.5C12.2358 22.9485 22.0515 32.7642 22.5 45C22.9485 32.7642 32.7642 22.9485 45 22.5C32.7642 22.0515 22.9485 12.2358 22.5 -1.96701e-06Z"
                                fill="#1F2224"/>
                    </svg>
                </div>
                <div class="row rg-20">
                    <div class="col-md-6">
                        <div class="contributor-img">
                            <img src="{{$settings['contributor_second_portion_image']}}" alt=""/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contributor-content">
                            <p class="sub-title">{{__('(Be a contributor for)')}}</p>
                            <h4 class="title">{{$settings['contributor_second_portion_title']}}</h4>
                            <p class="info">{{$settings['contributor_second_portion_subtitle']}}</p>
                            <button data-bs-toggle="modal" data-bs-target="#applyContributorModal"
                                    class="zaiStock-btn">{{__('Apply Now')}}</button>
                        </div>
                    </div>
                </div>
                <div class="row rg-20">
                    <div class="col-md-6">
                        <div class="contributor-img">
                            <img src="{{$settings['contributor_third_portion_image']}}" alt=""/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contributor-content">
                            <p class="sub-title">{{__('(Be a contributor for)')}}</p>
                            <h4 class="title">{{$settings['contributor_third_portion_title']}}</h4>
                            <p class="info">{{$settings['contributor_third_portion_subtitle']}}</p>
                            <button data-bs-toggle="modal" data-bs-target="#applyContributorModal"
                                    class="zaiStock-btn">{{__('Apply Now')}}</button>
                        </div>
                    </div>
                </div>
                <div class="row rg-20">
                    <div class="col-md-6">
                        <div class="contributor-img">
                            <img src="{{$settings['contributor_fourth_portion_image']}}" alt=""/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contributor-content">
                            <p class="sub-title">{{__('(Be a contributor for)')}}</p>
                            <h4 class="title">{{$settings['contributor_fourth_portion_title']}}</h4>
                            <p class="info">{{$settings['contributor_fourth_portion_subtitle']}}</p>
                            <button data-bs-toggle="modal" data-bs-target="#applyContributorModal"
                                    class="zaiStock-btn">{{__('Apply Now')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="applyContributorModal" tabindex="-1" aria-labelledby="applyContributorModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0 bg-transparent">
                <div class="bd-one bd-c-stroke bd-ra-10 bg-white zaiStock-shadow-one p-sm-25 p-15">
                    <form method="POST" action="{{route('customer.store_contributor')}}"
                          data-handler="commonResponseForModal" class="ajax">
                        @csrf
                        <div class="rg-20 row">
                            <div class="col-12">
                                <h4 class="inner-sub-title-one pb-20">{{__('Please Share Some Basic Details About Yourself.')}}</h4>
                            </div>
                            <div class="col-md-6">
                                <label class="zForm-label">{{__('First Name')}}<span
                                            class="text-primary">*</span></label>
                                <input type="text" readonly id="first_name" value="{{auth()->user()->first_name}}"
                                       name="first_name" class="zForm-control pe-none"
                                       placeholder="{{__('Enter First Name')}}">
                            </div>
                            <div class="col-md-6">
                                <label class="zForm-label">{{__('Last Name')}}<span
                                            class="text-primary">*</span></label>
                                <input type="text" readonly id="last_name" value="{{auth()->user()->last_name}}"
                                       name="last_name"
                                       class="zForm-control pe-none"
                                       placeholder="{{__('Enter Last Name')}}">
                            </div>
                            <div class="col-md-6">
                                <label class="zForm-label">{{__('Email')}}<span
                                            class="text-primary">*</span></label>
                                <input type="email" readonly id="email" value="{{auth()->user()->email}}" name="email"
                                       class="zForm-control pe-none"
                                       placeholder="{{__('Enter Email')}}">
                            </div>
                            <div class="col-md-6">
                                <label for="contact_number" class="zForm-label">{{__('Phone')}}<span
                                            class="text-primary">*</span></label>
                                <input type="text" id="contact_number" value="{{auth()->user()->contact_number}}"
                                       name="contact_number" class="zForm-control"
                                       placeholder="{{__('Enter Phone')}}">
                            </div>
                            <div class="col-md-6">
                                <label for="portfolio_link" class="zForm-label">{{__('Portfolio Link')}}<span
                                            class="text-primary">*</span></label>
                                <input type="text" id="portfolio_link" value="{{auth()->user()->portfolio_link}}"
                                       name="portfolio_link" class="zForm-control"
                                       placeholder="{{__('Enter Portfolio Link')}}">
                            </div>
                            <div class="col-md-6">
                                <label for="source_id" class="zForm-label">{{__('Source')}}<span
                                            class="text-primary">*</span></label>
                                <select class="sf-select-without-search" name="source_id" id="source_id">
                                    <option value="">{{__('Select Source')}}</option>
                                    @foreach($sources as $source)
                                        <option
                                                {{auth()->user()->source_id == $source->id ? 'selected' : ''}} value="{{$source->id}}">{{$source->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="country_id" class="zForm-label">{{__('Country')}}<span
                                            class="text-primary">*</span></label>
                                <select class="sf-select-without-search" name="country_id" id="country_id">
                                    <option value="">{{__('Select Country')}}</option>
                                    @foreach($countries as $country)
                                        <option
                                                {{auth()->user()->country_id == $country->id ? 'selected' : ''}} value="{{$country->id}}">{{$country->country_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="state_id" class="zForm-label">{{__('State')}}<span
                                            class="text-primary">*</span></label>
                                <select class="sf-select-without-search" name="state_id" id="state_id">
                                    <option value="">{{__('Select State')}}</option>
                                    @if(auth()->user()->state)
                                        <option selected
                                                value="{{auth()->user()->state_id}}">{{auth()->user()->state->name}}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="city_id" class="zForm-label">{{__('City')}}<span
                                            class="text-primary">*</span></label>
                                <select class="sf-select-without-search" name="city_id" id="city_id">
                                    <option value="">{{__('Select City')}}</option>
                                    @if(auth()->user()->city)
                                        <option selected
                                                value="{{auth()->user()->city_id}}">{{auth()->user()->city->name}}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="zaiStock-btn">{{__('Apply Now')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="state_route" value="{{route('frontend.fetchCountryStates', 'COUNTRY_ID')}}">
    <input type="hidden" id="city_route" value="{{route('frontend.fetchStateCities', 'STATE_ID')}}">
@endsection
@push('script')
    <script src="{{ asset('assets/js/be_a_contributor.js') }}"></script>
@endpush
