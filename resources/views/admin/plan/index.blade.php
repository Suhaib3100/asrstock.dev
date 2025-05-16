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
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{__(@$pageTitle)}}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15 mb-30">
            <form action="{{ route('admin.setting.general-settings.update') }}" method="post" class="form-horizontal">
                @csrf

                <div class="">
                    <label class="zForm-label" for="support_faq_title">Title <span class="text-danger">*</span></label>
                    <input type="text" name="plan_title" value="{{getOption('plan_title')}}" class="zForm-control" placeholder="Type your plan cms title" required>
                </div>

                <div class="d-flex justify-content-end align-items-center g-10 pt-24">
                    <button type="submit" class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white">{{__('Update')}}</button>
                </div>
            </form>
        </div>

        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15 admin-dashboard-blog-list-page">
            <div class="item-title d-flex justify-content-end">
                @can('add_plan')
                <div class="topbar-right-part">
                    <a href="{{route('admin.plan.create')}}" class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"> <i class="fa fa-plus"></i> {{__('Add Plan')}} </a>
                </div>
                @endcan
            </div>
            <div class="" id="appendList">
                @include('admin.plan.render-plan-list')
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('script')
    <script>
        'use strict'
        const planStatusChange = "{{ route('admin.plan.changePlanStatus') }}";
        const csrfToken = "{{ csrf_token() }}";
        const currentUrl = "{{ url()->current() }}";
    </script>
    <script src="{{ asset('admin/js/custom/plan.js') }}"></script>
@endpush
