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
                                <li class="breadcrumb-item"><a href="#">{{__('Referral ')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{__(@$pageTitle)}}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
            <form action="{{ route('admin.setting.general-settings.update') }}" method="post" class="form-horizontal">
                @csrf
                <div class="row rg-24">
                    <div class="col-xl-6">
                        <label class="zForm-label">{{__('Referral Commission From Plan Purchase')}} <span class="text-danger">*</span></label>
                        <div class="input-group flex-nowrap">
                            <input type="number" min="0" max="100" step="any" name="referral_commission" value="{{getOption('referral_commission')}}" placeholder="{{__('Referral commission')}}" class="zForm-control" required>
                            <span class="input-group-text">%</span>
                            @if ($errors->has('referral_commission'))
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('referral_commission') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <label class="zForm-label">{{__('Allow Referral System')}} <span class="text-danger">*</span></label>
                            <select name="referral_status" id="" class="form-select">
                                <option value="1" {{ getOption('referral_status') == 1 ? 'selected':'' }}>{{ __('On') }}</option>
                                <option value="0" {{ getOption('referral_status') != 1 ? 'selected':'' }}>{{ __('Off') }}</option>
                            </select>
                            @if ($errors->has('referral_status'))
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('referral_status') }}</span>
                            @endif
                    </div>
                </div>
                <div class="d-flex justify-content-end g-10 pt-24">
                    <button class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white" type="submit">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Page content area end -->
@endsection
