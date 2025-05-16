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
    <section class="section-gap-alt">
        <div class="container">
            <div class="section-content-wrap text-center">
                <h4 class="title">{{__('Send Us a Message')}}</h4>
            </div>
            <div class="contactUs-content">
                <div class="pb-md-40 pb-20">
                    <div class="row rg-20 justify-content-center">
                        <div class="col-sm-4 col-6">
                            <div class="contactUs-item">
                                <div class="icon"><img src="{{ asset('assets/images/icon/contactUs-icon-1.svg') }}" alt="" /></div>
                                <p class="text">{{ getOption('app_email') }}</p>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="contactUs-item">
                                <div class="icon"><img src="{{ asset('assets/images/icon/contactUs-icon-2.svg') }}" alt="" /></div>
                                <p class="text">{{ getOption('app_contact_number') }}</p>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="contactUs-item">
                                <div class="icon"><img src="{{ asset('assets/images/icon/contactUs-icon-3.svg') }}" alt="" /></div>
                                <p class="text">{{ getOption('app_location') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="ajax" action="{{ route('frontend.contact-us-store') }}" method="POST" data-handler="commonResponseWithPageLoad" enctype="multipart/form-data">
                    @csrf
                    <div class="contactUs-formWrap zaiStock-shadow-one bg-white bd-one bd-c-stroke bd-ra-10">
                        <div class="row rg-20">
                            <div class="col-md-6">
                                <label for="name" class="zForm-label">{{__('Name')}} <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="zForm-control" placeholder="Enter name" />
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="zForm-label">{{__('Email')}} <span class="text-danger">*</span></label>
                                <input type="text" name="email" id="email" class="zForm-control" placeholder="Enter email" />
                            </div>
                            <div class="col-lg-12">
                                <label for="" class="zForm-label">{{__('Select Issue')}} <span class="text-danger">*</span></label>
                                <select class="sf-select-without-search" name="contact_us_topic_id">
                                    @foreach($contactUsTopic as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="messageField" class="zForm-label">{{__('Message')}} <span class="text-danger">*</span></label>
                                <textarea id="messageField" name="message" class="zForm-control contactUs-message" placeholder="Leave your message"></textarea>
                            </div>
                            <div class="col-12"><button type="submit" class="zaiStock-btn zaiStock-hover">{{__('Submit')}}</button></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
