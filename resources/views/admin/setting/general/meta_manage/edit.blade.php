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
                    <div class="pb-30 d-flex justify-content-between align-items-start flex-wrap g-10">
                        <div>
                            <h2 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ @$pageTitle . ' - ' . $meta->page_name }}</h2>
                            <h3 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Meta Type') . ' - ' . getPageType($meta->page_type) }}</h3>
                        </div>
                        <a href="{{ route('admin.setting.meta.index') }}" class="border-0 bd-ra-12 bg-para-text py-13 px-25 fs-16 fw-600 lh-19 text-white"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <form class="ajax" action="{{ route('admin.setting.meta.update', [$meta->uuid]) }}" method="post"
                        data-handler="getShowMessage">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="row rg-24 pb-24">
                            <div class="col-12">
                                <label for="meta_title" class="zForm-label">{{ __('Meta Title') }} <span class="text-danger">*</span></label>
                                <textarea name="meta_title" id="meta_title" class="zForm-control" rows="5">{{ $meta->meta_title }}</textarea>
                            </div>

                            <div class="col-12">
                                <label for="meta_description" class="zForm-label">{{ __('Meta Description') }} <span class="text-danger">*</span></label>
                                <textarea name="meta_description" id="meta_description" rows="5" class="zForm-control">{{ $meta->meta_description }}</textarea>
                            </div>

                            <div class="col-12">
                                <label for="meta_keyword" class="zForm-label">{{ __('Meta Keywords') }} ({{ __('Separate with commas') }}) <span class="text-danger">*</span></label>
                                <textarea name="meta_keyword" id="meta_keyword" rows="5" class="zForm-control">{{ $meta->meta_keyword }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center pt-15 bd-t-one bd-c-stroke">
                            <button type="submit"
                                    class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection
