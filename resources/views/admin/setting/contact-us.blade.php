@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __('Frontend Settings') }}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __(@$pageTitle) }}</li>
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
                <h2 class="fs-18 fw-500 lh-28 text-primary-dark-text pb-24">{{ __(@$pageTitle) }}</h2>
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <form action="{{route('admin.setting.general-settings.update')}}" method="post">
                        @csrf
                        <div class="row rg-24 pb-24">
                            <div class="col-md-6 col-lg-4">
                                <label for="app_location" class="zForm-label">{{ __('Location') }} </label>
                                <input type="text" name="app_location" id="app_location" value="{{ getOption('app_location') }}" class="zForm-control" placeholder="{{__('Type location')}}">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="app_email" class="zForm-label">{{__('Contact Email')}} </label>
                                <input type="email" name="app_email" id="app_email" value="{{ getOption('app_email') }}" class="zForm-control" placeholder="{{__('Type email')}}">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="app_contact_number" class="zForm-label">{{__('Contact Number')}} </label>
                                <input type="text" name="app_contact_number" id="app_contact_number" value="{{ getOption('app_contact_number') }}" class="zForm-control" placeholder="{{__('Type Number')}}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center g-10 flex-wrap bd-t-one bd-c-stroke pt-15">
                            <button type="submit"
                                    class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{__('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection
