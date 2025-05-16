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
                                <li class="breadcrumb-item"><a href="{{route('admin.coupon.index')}}">{{ __('Coupon') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __(@$pageTitle) }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            </div>
            <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                <form action="{{route('admin.coupon.update', $coupon->id)}}" method="post" class="form-horizontal">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="row rg-24">
                        <div class="col-md-6">
                            <div class="input__group text-black">
                                <label class="zForm-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ $coupon->name }}" placeholder="{{ __('Type coupon name') }}"
                                       class="zForm-control" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input__group text-black">
                                <label class="zForm-label">{{ __('Use Type') }} <span class="text-danger">*</span></label>
                                <select class="form-control" name="use_type" id="use_type"  required>
                                    <option value="">--{{ __('Select Option') }}--</option>
                                    <option value="1" {{ $coupon->use_type == DISCOUNT_USE_TYPE_SINGLE ? 'selected' : '' }}>Single</option>
                                    <option value="2" {{ $coupon->use_type == DISCOUNT_USE_TYPE_MULTIPLE ? 'selected' : '' }}>Multiple</option>
                                </select>
                                @if ($errors->has('use_type'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('use_type') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 d-none" id="maximumUseLimitDiv">
                            <div class="input__group text-black">
                                <label class="zForm-label">{{ __('Maximum Use Limit') }}<span class="text-danger">*</span></label>
                                <input type="number" min="1" name="maximum_use_limit" value="{{ $coupon->maximum_use_limit }}" placeholder="{{ __('Type maximum use limit') }}"
                                       class="zForm-control" id="maximum_use_limit" required>
                                @if ($errors->has('maximum_use_limit'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('minimum_amount') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input__group text-black">
                                <label class="zForm-label">{{ __('Discount Type') }} <span class="text-danger">*</span></label>
                                <select class="form-control" name="discount_type" id="discount_type" required>
                                    <option value="">--{{ __('Select Option') }}--</option>
                                    <option value="1" {{ $coupon->discount_type == DISCOUNT_TYPE_PERCENTAGE ? 'selected' : '' }}>Percentage</option>
                                    <option value="2" {{ $coupon->discount_type == DISCOUNT_TYPE_AMOUNT ? 'selected' : '' }}>Amount</option>
                                </select>
                                @if ($errors->has('discount_type'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('discount_type') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input__group text-black">
                                <label class="zForm-label"><span class="discountValueText"></span><span class="text-danger"> *</span></label>
                                <input type="number" min="0" step="any" name="discount_value" value="{{ $coupon->discount_value }}" placeholder="{{ __('Type discount value') }}"
                                       class="zForm-control" required>
                                @if ($errors->has('discount_value'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('discount_value') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input__group text-black">
                                <label class="zForm-label">{{ __('Minimum Amount Spend to Apply Coupon') }}<span class="text-danger">*</span></label>
                                <input type="number" min="1" name="minimum_amount" id="minimum_amount" value="{{ $coupon->minimum_amount }}" placeholder="{{ __('Type minimum amount') }}"
                                       class="zForm-control" required>
                                @if ($errors->has('minimum_amount'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('minimum_amount') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input__group text-black">
                                <label class="zForm-label">{{ __('Start Date') }} <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" value="{{ $coupon->start_date }}" class="zForm-control" required>
                                @if ($errors->has('start_date'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('start_date') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input__group text-black">
                                <label class="zForm-label">{{ __('End Date') }} <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" value="{{ $coupon->end_date }}" class="zForm-control" required>
                                @if ($errors->has('end_date'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('end_date') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input__group text-black">
                                <label class="zForm-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" id="status" >
                                    <option value="">--{{ __('Select Option') }}--</option>
                                    <option value="1" {{ $coupon->status == ACTIVE ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="0" {{ $coupon->status != ACTIVE ? 'selected' : '' }}>{{ __('Disable') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                        <div class="d-flex justify-content-end align-items-center g-10 pt-24">
                            <a href="{{route('admin.coupon.index')}}" class="border-0 bg-para-text py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white d-inline-flex align-items-center g-10"> <i class="fa fa-arrow-left"></i> {{__('Back')}} </a>
                            <button class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white" type="submit">{{ __('Update') }}</button>
                        </div>

                </form>
            </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('script')
    <script src="{{ asset('admin/js/custom/coupon.js') }}"></script>
@endpush
