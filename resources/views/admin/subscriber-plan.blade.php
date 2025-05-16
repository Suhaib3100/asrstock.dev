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
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __(@$pageTitle) }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
            <table class="table zTable zTable-last-item-right commonDataTable">
                <thead>
                <tr>
                    <th>
                        <div>{{ __('Sl') }}</div>
                    </th>
                    <th>
                        <div>{{ __('Subscriber') }}</div>
                    </th>
                    <th>
                        <div>{{ __('Plan') }}</div>
                    </th>
                    <th>
                        <div class="text-nowrap">{{ __('Duration Type') }}</div>
                    </th>
                    <th>
                        <div class="text-nowrap">{{ __('Start Date') }}</div>
                    </th>
                    <th>
                        <div class="text-nowrap">{{ __('End Date') }}</div>
                    </th>
                    <th>
                        <div>{{ __('Status') }}</div>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($customerPlans as $customerPlan)
                    <tr class="removable-item">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ @$customerPlan->customer->name }}</td>
                        <td>{{ @$customerPlan->plan->name }}</td>
                        <td>{{ @$customerPlan->plan->duration_type == ORDER_PLAN_DURATION_TYPE_YEAR ? 'Yearly':'Monthly' }}</td>
                        <td>{{ date('d M, Y', strtotime($customerPlan->start_date)) }}</td>
                        <td>{{ date('d M, Y', strtotime($customerPlan->end_date)) }}</td>
                        <td>
                            @if($customerPlan->cancelled_by)
                                <span class="zBadge zBadge-cancel">{{ __('Cancelled') }}</span>
                            @else
                                @if ($customerPlan->end_date >= \Carbon\Carbon::today())
                                    <span class="zBadge zBadge-active">{{ __('Active') }}</span>
                                @else
                                    <span class="zBadge zBadge-expired">{{ __('Expired') }}</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Page content area end -->

@endsection

@push('script')
    <script src="{{ asset('admin/js/custom/mail-type.js') }}"></script>
@endpush
