@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
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
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.setting.meta.index') }}">{{ __('Meta Management') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __($pageTitle) }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3">
                @include('admin.setting.setting-sidebar')
            </div>
            <div class="col-xl-9">
                <div class="d-flex justify-content-between align-items-center g-10 flex-wrap pb-24">
                    <h4 class="fs-18 fw-600 lh-22 text-primary-dark-text">{{ __(@$pageTitle) }}</h4>
                    <a href="{{ route('admin.setting.meta.index') }}"
                       class="border-0 bg-para-text py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"><i
                            class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                </div>
                <form class="ajax" action="{{ route('admin.setting.meta.store') }}" method="POST"
                      data-handler="getShowMessage">
                    <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                        <div class="row rg-24">
                            <div class="col-md-6">
                                <label class="zForm-label">{{__('Type')}} <span class="text-danger">*</span></label>
                                <select name="page_type" id="meta-type" class="form-select" required>
                                    @foreach (getPageType() as $index => $pageType)
                                        <option value="{{ $index }}">{{ $pageType }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="zForm-label">{{__('Page')}} <span class="text-danger">*</span></label>
                                <select name="page" id="page" class="form-select" required>

                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="meta_title" class="zForm-label">
                                    {{ __('Meta Title') }} <span class="text-danger">*</span></label>
                                <textarea name="meta_title" id="meta_title" class="zForm-control"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="meta_description" class="zForm-label">
                                    {{ __('Meta Description') }} <span class="text-danger">*</span></label>
                                <textarea name="meta_description" id="meta_description"
                                          class="zForm-control"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="meta_keyword" class="zForm-label">
                                    {{ __('Meta Keywords') }} ({{ __('Separate with commas') }}) <span
                                        class="text-danger">*</span></label>
                                <textarea name="meta_keyword" id="meta_keyword" class="zForm-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center pt-15">
                        <button type="submit"
                                class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('script')
    <script>
        var get_page_route = "{{ route('admin.setting.meta.get_page') }}";
    </script>
    <script src="{{asset('admin/js/custom/meta.js')}}"></script>
@endpush
