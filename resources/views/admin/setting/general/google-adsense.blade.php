@extends('admin.layouts.app')

@section('content')
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __('Frontend Settings') }}</h2>
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
        <div class="row rg-24">
            <div class="col-xl-3">
                @include('admin.setting.setting-sidebar')
            </div>
            <div class="col-xl-9">
                <h4 class="fs-18 fw-600 lh-22 text-primary-dark-text pb-24">{{ __(@$pageTitle) }}</h4>
                <form action="{{ route('admin.setting.general-settings.update') }}" method="post"
                        class="form-horizontal">
                        @csrf
                    <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                        <div class="row rg-24">
                            <div class="col-md-6">
                                <label for="app_date_format" class="zForm-label">{{__('Enable')}} <span class="text-danger">*</span></label>
                                <select name="google_adsense_enable" class="form-select select2">
                                    <option value="1" {{ getOption('google_adsense_enable') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                    <option value="0" {{ getOption('google_adsense_enable') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="zForm-label">{{ __('Google Adsense Client ID') }}<span class="text-danger">*</span></label>
                                <input type="text" name="google_adsense_client_id" value="{{ getOption('google_adsense_client_id') }}" class="zForm-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center pt-15">
                        <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                    </div>
                    </form>
            </div>
        </div>
    </div>
@endsection
