@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __('Gateways') }}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('Gateways') }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row rg-24">
            <div class="col-xl-3">
                @include('admin.setting.setting-sidebar')
            </div>
            <div class="col-xl-9">
                <div class="pb-25 d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="fs-18 fw-600 lh-22 text-primary-dark-text">{{ __(@$pageTitle) }}</h4>
                    @if(isAddonInstalled('PIXELGATEWAY'))
                        <a href="{{route('admin.setting.gateway.syncs')}}"
                           class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"><i
                                class="fas fa-sync"></i> {{ __('Syncs Gateway') }}</a>
                    @endif
                </div>
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <table class="table zTable zTable-last-item-right commonDataTable">
                        <thead>
                        <tr>
                            <th>
                                <div>{{ __('SL') }}</div>
                            </th>
                            <th>
                                <div>{{ __('Icon') }}</div>
                            </th>
                            <th>
                                <div>{{ __('Name') }}</div>
                            </th>
                            <th>
                                <div>{{ __('Status') }}</div>
                            </th>
                            <th>
                                <div>{{ __('Mode') }}</div>
                            </th>
                            <th>
                                <div>{{ __('Action') }}</div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($gateways as $gateway)
                            <tr class="removable-item">
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <div class="admin-dashboard-blog-list-img">
                                        <a class="d-inline-block test-popup-link" href="{{ asset($gateway->image) }}">
                                            <img src="{{ asset($gateway->image) }}" alt="img"
                                                 class="h-40">
                                        </a>
                                    </div>
                                </td>
                                <td>{{ $gateway->gateway_name }}</td>
                                <td>
                                    @if ($gateway->status == ACTIVE)
                                        <p class="zBadge zBadge-active">{{ __('Active') }}</p>
                                    @else
                                        <p class="zBadge zBadge-inactive">{{ __('Deactivate') }}</p>
                                    @endif
                                </td>
                                <td>
                                    @if ($gateway->mode == GATEWAY_MODE_LIVE)
                                        <p class="zBadge zBadge-active">{{ __('Live') }}</p>
                                    @elseif(($gateway->gateway_slug != 'bank') && ($gateway->gateway_slug != 'cash') && ($gateway->gateway_slug != 'wallet'))
                                        <p class="zBadge zBadge-inactive">{{ __('Sandbox') }}</p>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <a class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-stroke bg-white edit"
                                           onclick="getEditModal('{{ route('admin.setting.gateway.edit', $gateway->id) }}', '#edit-modal')"
                                           title="Edit">
                                            <svg width="12" height="13" viewBox="0 0 12 13" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.8067 3.19354C12.0667 2.93354 12.0667 2.5002 11.8067 2.25354L10.2467 0.693535C10 0.433535 9.56667 0.433535 9.30667 0.693535L8.08 1.91354L10.58 4.41354M0 10.0002V12.5002H2.5L9.87333 5.1202L7.37333 2.6202L0 10.0002Z"
                                                    fill="#5D697A"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->

    <!-- Edit Modal section start -->
    <div class="modal fade" id="edit-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 bd-ra-4 p-sm-25 p-15">

            </div>
        </div>
    </div>
    <input type="hidden" id="getCurrencySymbol" value="{{ getCurrencySymbol() }}">
    <input type="hidden" id="allCurrency" value="{{ json_encode(getCurrency()) }}">
@endsection
@push('script')
    <script src="{{ asset('admin/js/custom/gateway.js') }}"></script>
@endpush
