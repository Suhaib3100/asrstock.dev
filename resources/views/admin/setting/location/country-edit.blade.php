@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{__('Frontend Settings')}}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ @$pageTitle }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row rg-24">
            <div class="col-xl-3">
                @include('admin.setting.sidebar')
            </div>
            <div class="col-xl-9">
                    <div class="d-flex flex-wrap justify-content-between align-items-center g-10 pb-24">
                        <h2 class="fs-18 fw-600 lh-20 text-primary-dark-text">{{__('Edit Country')}}</h2>
                        <a href="{{ route('admin.setting.location.country.index') }}" class="border-0 bg-para-text py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                    <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                        <form action="{{route('admin.setting.location.country.update', [$country->id])}}" method="post" class="form-horizontal">
                            @csrf
                            @method('patch')
                            <div class="pb-24">
                                <div class="row rg-24">
                                    <div class="col-md-6">
                                            <label class="zForm-label" for="country_name">Name</label>
                                            <input class="zForm-control" type="text" name="country_name" id="country_name" placeholder="Type country name" value="{{ $country->country_name }}" required>
                                            @if ($errors->has('country_name'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('country_name') }}</span>
                                            @endif
                                    </div>
                                    <div class="col-md-6">
                                            <label class="zForm-label" for="country_name">Short name</label>
                                            <input class="zForm-control" type="text" name="short_name" id="short_name" placeholder="Type short name" value="{{ $country->short_name }}" required>
                                            @if ($errors->has('short_name'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('short_name') }}</span>
                                            @endif
                                    </div>
                                    <div class="col-md-6">
                                            <label class="zForm-label" for="phonecode">Phone Code</label>
                                            <input class="zForm-control" type="text" name="phonecode" id="phonecode" placeholder="Type phone code" value="{{ $country->phonecode }}" required>
                                            @if ($errors->has('phonecode'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('phonecode') }}</span>
                                            @endif
                                    </div>
                                    <div class="col-md-6">
                                            <label class="zForm-label" for="continent">Continent</label>
                                            <input class="zForm-control" type="text" name="continent" id="continent" placeholder="Type continent" value="{{ $country->continent }}" required>
                                            @if ($errors->has('continent'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('continent') }}</span>
                                            @endif
                                    </div>
                                </div>
                            </div>

                            <div class="bd-c-stroke bd-t-one d-flex justify-content-end align-items-center pt-15">
                                <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                            </div>

                        </form>
                    </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection
