@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __(@$pageTitle) }}</h2>
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
        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15" id="appendList">
            @include('admin.withdraw.partial.render-pending-list')
        </div>
    </div>
    <!-- Page content area end -->

    <!-- Edit Modal section start -->
    <div class="modal fade cancelled_status_modal" id="add-todo-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <div class="d-flex justify-content-between align-items-center g-10 pb-20 mb-20 bd-b-one bd-c-stroke">
                    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Cancel Reason') }}</h5>
                    <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                </div>
                <form action="{{ route('admin.withdraw.cancelledReason') }}" method="post">
                    @csrf
                    <div class="pb-24">
                        <input type="hidden" name="uuid">
                        <input type="hidden" name="status">
                        <div class="">
                            <textarea class="zForm-control" name="cancel_reason" id="" cols="30" rows="10" required></textarea>
                        </div>
                    </div>
                    <div class="bd-c-stroke bd-t-one justify-content-between align-items-center text-end pt-15">
                        <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal section end -->
@endsection

@push('script')
    <script>
        'use strict'
        const currentUrl = "{{ url()->current() }}";
        const csrfToken = "{{ csrf_token() }}";
        const withdrawCompletedStatusRoute = "{{ route('admin.withdraw.completedStatus') }}";
    </script>
    <script src="{{ asset('admin/js/custom/withdraw-paginate.js') }}"></script>
    <script src="{{ asset('admin/js/custom/withdraw-pending.js') }}"></script>
@endpush
