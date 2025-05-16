@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __('Privacy Policy') }}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('Privacy Policy') }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row rg-24">
            <div class="col-xl-3">
                @include('admin.setting.sidebar')
            </div>
            <div class="col-xl-9">
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <form action="{{route('admin.privacy-policy.store')}}" method="post" class="form-horizontal">
                        @csrf
                        <div class="row rg-24 pb-24">
                            <div class="col-12">
                                <label class="zForm-label">Description <span class="text-danger">*</span></label>
                                <textarea name="description" id="summernote"
                                          class="summernoteOne">{{ @$policy->description ?? old('description') }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('description') }}</span>
                                @endif

                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-center flex-wrap g-10">
                            <button class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white" type="submit">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('script')
    <script src="{{asset('admin/js/custom/slug.js')}}"></script>
    <script src="{{asset('admin/js/custom/form-editor.js')}}"></script>
    <script src="{{ asset('admin/js/custom/summernote-editor.js') }}"></script>
@endpush

