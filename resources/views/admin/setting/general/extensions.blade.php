@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb__content">
                    <div class="breadcrumb__content__left">
                        <div class="breadcrumb__title">
                            <h2>{{ __('Frontend Settings') }}</h2>
                        </div>
                    </div>
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard')
                                        }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __(@$pageTitle) }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4">
                @include('admin.setting.sidebar')
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="email-inbox__area bg-style">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>Extension</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ __("Google Analytics") }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                @if(getOption('google_analytics_status') == 1)
                                                    <span class="zBadge zBadge-active">{{ __('Active') }}</span>
                                                @else
                                                    <span class="zBadge zBadge-deactivated">{{ __('Deactivate') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div>
                                            <a href="{{ route("admin.setting.google-analytics") }}" class="btn btn-info">{{ __("Update") }}</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __("Google Recaptcha") }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                @if(getOption('google_recaptcha_status') == 1)
                                                    <span class="zBadge zBadge-active">{{ __('Active') }}</span>
                                                @else
                                                    <span class="zBadge zBadge-deactivated">{{ __('Deactivate') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div>
                                            <a href="{{ route("admin.setting.google-recaptcha") }}" class="btn btn-info">{{ __("Update") }}</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __("Google 2FA") }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                @if(getOption('google_2fa_status') == 1)
                                                    <span class="zBadge zBadge-active">{{ __('Active') }}</span>
                                                @else
                                                    <span class="zBadge zBadge-deactivated">{{ __('Deactivate') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div>
                                            <a href="{{ route("admin.setting.google.2fa") }}" class="btn btn-info">{{ __("Update") }}</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __("Google Adsense") }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                @if(getOption('google_adsense_enable') == 1)
                                                    <span class="zBadge zBadge-active">{{ __('Active') }}</span>
                                                @else
                                                    <span class="zBadge zBadge-deactivated">{{ __('Deactivate') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div>
                                            <a href="{{ route("admin.setting.google.adsense") }}" class="btn btn-info">{{ __("Update") }}</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
