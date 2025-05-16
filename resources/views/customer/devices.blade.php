@extends('layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush

@section('content')
    <!-- Main content -->
    <section class="admin-section">
        <div class="container">
            <div class="row rg-20">
                <div class="col-xl-3 col-lg-4 col-md-4">
                    @include('customer.layouts.sidebar')
                </div>
                <!--  -->
                <div class="col-xl-9 col-lg-8 col-md-8">
                    <div class="admin-section-right">
                        <div class="bd-one bd-c-stroke bd-ra-10 bg-white zaiStock-shadow-one p-sm-25 p-15">
                            <div class="pb-md-35 pb-20">
                                <h4 class="fs-20 fw-500 lh-30 text-primary-dark-text pb-7">{{__('Device Manager')}}</h4>
                                <p class="fs-16 fw-400 lh-26 text-para-text">{{__('List of all devices where you are currently logged in.')}}</p>
                            </div>
                            <!--  -->
                            <div class="pb-sm-25 pb-20 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center g-8">
                                    <div class="flex-shrink-0 max-w-30 d-flex">
                                        <img src="{{asset('assets/images/icon/my-device-icon.svg')}}" alt=""/>
                                    </div>
                                    <p class="fs-18 fw-400 lh-28 text-primary-dark-text">{{__('My Device')}}</p>
                                </div>
                                <p class="fs-18 fw-400 lh-28 text-para-text">{{$used_device}}
                                    /{{$device_limit}} {{__('Device')}}</p>
                            </div>
                            <!--  -->
                            <table class="table zTable zTable-last-item-border zTable-last-item-right" id="devicesTable">
                                <thead>
                                <tr>
                                    <td>
                                        <div>{{__('SL')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('OS')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Browse')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('IP')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Status')}}</div>
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <input type="hidden" id="datatable-route" value="{{ route('customer.devices.index') }}">
@endsection
@push('script')
    <script src="{{ asset('assets/js/devices.js') }}"></script>
@endpush
