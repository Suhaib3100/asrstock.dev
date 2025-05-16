@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{__('Edit Plan')}}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                <li class="breadcrumb-item"><a href="{{route('admin.plan.index')}}">{{__('All Plan')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{__('Edit Plan')}}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="alert alert-warning" role="alert">
            {{__('You can create a plan, but make sure the Stripe/PayPal credentials are correct. Otherwise, keep the package status deactivated; otherwise, you won’t be able to create the package.')}}
        </div>
        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
            <form action="{{route('admin.plan.update', $plan->uuid)}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}

                <div class="row rg-24 bd-b-one bd-c-stroke pb-24 mb-24">
                    <div class="col-md-6">
                            <label class="zForm-label" for="name">{{__('Title')}} <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ $plan->name }}" placeholder="{{__('Type Title')}}" class="zForm-control" required>
                            @if ($errors->has('name'))
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('name') }}</span>
                            @endif
                    </div>
                    <div class="col-md-6">
                            <label class="zForm-label" for="subtitle">{{__('Subtitle')}} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="subtitle" value="{{ $plan->subtitle }}"
                                   placeholder="{{__('Type Subtitle')}}" class="zForm-control" required>
                            @if ($errors->has('subtitle'))
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('subtitle') }}</span>
                            @endif
                    </div>
                    <div class="col-md-6">
                            <label class="zForm-label" for="description">{{__('Description')}} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="description" value="{{ $plan->description }}"
                                   placeholder="{{__('Type Description')}}" class="zForm-control" required>
                            @if ($errors->has('description'))
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('description') }}</span>
                            @endif
                    </div>
                    <div class="col-md-6">
                            <label class="zForm-label" for="device_limit">{{__('Number of Device Limit')}}</label>
                            <input type="number" min="1" name="device_limit" value="{{ $plan->device_limit }}" placeholder="{{__('Type device access number')}}"
                                   class="zForm-control">
                            @if ($errors->has('duration'))
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('duration') }}</span>
                            @endif
                    </div>
                    <div class="col-md-6">
                            <label class="zForm-label" for="name">{{__('Monthly Price')}} <span class="text-danger">*</span></label>
                            <div class="input-group flex-nowrap">
                                <input type="number" min="0" name="monthly_price" value="{{ $plan->monthly_price }}" placeholder="{{__('Type monthly price')}}" class="zForm-control" required>
                                <span class="input-group-text">{{ getCurrencySymbol() }}</span>
                                @if ($errors->has('monthly_price'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('monthly_price') }}</span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-6">
                            <label class="zForm-label" for="name">{{__('Yearly Price')}} <span class="text-danger">*</span></label>
                            <div class="input-group flex-nowrap">
                                <input type="number" min="0" name="yearly_price" value="{{ $plan->yearly_price }}" placeholder="{{__('Type yearly price')}}" class="zForm-control" required>
                                <span class="input-group-text">{{ getCurrencySymbol() }}</span>
                                @if ($errors->has('yearly_price'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('yearly_price') }}</span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-6">
                            <label class="zForm-label" for="tax_id">{{ __('Tax') }}</label>
                            <select class="form-control" name="tax_id" id="tax_id">
                                <option value="">--{{ __('Select Option') }}--</option>
                                @foreach($taxes as $tax)
                                    <option value="{{ $tax->id }}" {{ ($tax->id == $plan->tax_id) ? 'selected' : null }}>{{ $tax->name }}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="col-md-6">
                        <label class="zForm-label" for="download_limit_type">{{ __('Download Limit Type') }} <span class="text-danger">*</span></label>
                        <select class="form-control" name="download_limit_type" id="download_limit_type" required>
                            <option value="">--{{ __('Select Option') }}--</option>
                            <option
                                value="1" {{ $plan->download_limit_type == PLAN_DOWNLOAD_LIMIT_TYPE_UNLIMITED ? 'selected' : null }}>{{ __('Unlimited') }}</option>
                            <option value="2" {{ $plan->download_limit_type == PLAN_DOWNLOAD_LIMIT_TYPE_LIMITED ? 'selected' : null }}>{{ __('Limited') }}</option>
                        </select>
                    </div>
                    <div class="col-md-6 durationLimitDiv d-none">
                        <label class="zForm-label" for="download_limit">{{__('Download Limit Per Day')}} </label>
                        <input type="number" min="1" name="download_limit" value="{{ $plan->download_limit }}" placeholder="{{__('Type device access limit')}}"
                               class="zForm-control">
                        @if ($errors->has('download_limit'))
                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('download_limit') }}</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="zForm-label" for="status">{{ __('Status') }} </label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="">--{{ __('Select Option') }}--</option>
                            <option value="1" {{ $plan->status == 1 ? 'selected' : null }}>{{ __('Active') }}</option>
                            <option value="0" {{ $plan->status == 1 ? null : 'selected' }}>{{ __('Disable') }}</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-none">
                        <label class="zForm-label" for="name">{{__('Logo')}} <span class="text-danger">*</span></label>
                        <div class="upload-img-box mb-25">
                            <img src="{{ $plan->logo }}">
                            <input type="file" name="logo" id="image" accept="image/*" onchange="previewFile(this)">
                            <div class="upload-img-box-icon">
                                <i class="fa fa-camera"></i>
                                <p class="m-0">{{__('Logo')}}</p>
                            </div>
                        </div>
                        @if ($errors->has('logo'))
                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('logo') }}</span>
                        @endif
                        <p>Accepted Image Files: PNG <br> Recommend Size: 80 x 80 (1MB)</p>
                    </div>
                </div>
                <h2 class="fs-24 fw-500 lh-28 text-primary-dark-text pb-24">{{__('Benefits')}}</h2>
                <div id="add_repeater" class="">
                    <div data-repeater-list="plan_benefits" class="row rg-24">
                        @if(count($planBenefits) > 0)
                            @foreach($planBenefits as $planBenefit)
                                <div data-repeater-item="" class="col-md-6">
                                    <input type="hidden" name="id" value="{{ $planBenefit['id'] }}"/>

                                    <div class="">
                                        <label for="point_{{ $planBenefit['id'] }}" class="zForm-label"> {{ __('Point') }} </label>

                                        <div class="input-group flex-nowrap">
                                            <input type="text" name="point" id="point_{{ $planBenefit['id'] }}" value="{{ $planBenefit['point'] }}" class="zForm-control"
                                                   placeholder="Type benefits" required>
                                            <div class="input-group-text removeClass mt-0">
                                                <a href="javascript:;" data-repeater-delete="" class="">
                                                    <img src="{{asset('admin/images/icons/trash-2.svg')}}" alt="trash" class="onlyForProductRules">
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        @else
                            <div data-repeater-item="" class="col-md-6">
                                <div class="">
                                    <label for="point" class="zForm-label"> {{ __('Point') }} </label>

                                    <div class="input-group flex-nowrap">
                                        <input type="text" name="point" id="point" value="" class="zForm-control" placeholder="Type benefits" required>
                                        <div class="input-group-text removeClass mt-0">
                                            <a href="javascript:;" data-repeater-delete="" class="">
                                                <img src="{{asset('admin/images/icons/trash-2.svg')}}" alt="trash" class="onlyForProductRules">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="pt-24">
                        <a id="add" href="javascript:;" data-repeater-create=""
                           class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white d-inline-flex align-items-center g-10">
                            <i class="fas fa-plus"></i> {{ __('Add') }}
                        </a>
                    </div>
                </div>
                <div class="d-flex justify-content-end align-items-center g-10 mt-24 pt-24 bd-t-one bd-c-stroke">
                    <a href="{{route('admin.plan.index')}}" class="border-0 bg-para-text py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"> <i class="fa fa-arrow-left"></i> {{__('back')}} </a>
                    <button class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white" type="submit">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('admin/css/custom/image-preview.css')}}">
@endpush

@push('script')
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
    <script src="{{ asset('common/js/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('common/js/add-repeater.js') }}"></script>

    <script src="{{ asset('admin/js/custom/plan.js') }}"></script>
@endpush
