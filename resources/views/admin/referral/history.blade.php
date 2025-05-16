@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{__(@$pageTitle)}}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{__(@$pageTitle)}}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15" id="appendList">
            @include('admin.referral.partial.render-history')
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('script')
    <script>
        'use strict'
        const currentUrl = "{{ url()->current() }}";
    </script>
    <script src="{{ asset('admin/js/custom/referral.js') }}"></script>
@endpush
