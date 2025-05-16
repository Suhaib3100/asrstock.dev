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
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
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
                        <div class="item-top mb-30">
                            <h2>{{ __(@$pageTitle) }}</h2>
                        </div>
                        <form action="{{ route('admin.setting.general-settings.update') }}" method="post"
                            class="form-horizontal">
                            @csrf
                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Google Analytics Status') }}<span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <select name="google_analytics_status" class="form-control">
                                        <option value="1" {{ getOption('google_analytics_status') == ACTIVE ? 'selected' : '' }}>{{ __('Enable') }}</option>
                                        <option value="0" {{ getOption('google_analytics_status') == DISABLE ? 'selected' : '' }}>{{ __('Disable') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Google Analytics Measurement ID') }}<span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="google_analytics_api_key"
                                        value="{{ getOption('google_analytics_api_key') }}" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-blue float-right">{{ __('Update') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
