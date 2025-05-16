@extends('admin.layouts.app')
@push('title')
    {{ __('Version Update') }}
@endpush
@section('content')
    <div class="p-30">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __($title) }}</h4>
            <div class="row gap-5">
                <div class="col-md-12">
                    <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                        <form action="{{ route('admin.store-script-file') }}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="gap-4 row">
                                <div class="col-md-12">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap">
                                            <label for="currentPassword" class="form-label">{{ __('File') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="file" class="primary-form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap">
                                            <label for="currentPassword" class="form-label">{{ __('Path') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="primary-form-control" name="path"
                                                   placeholder="{{ __('Path') }}">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit"
                                        class="py-10 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                        <form action="{{ route('admin.load-script-file') }}" enctype="multipart/form-data"
                              method="post">
                            @csrf
                            <div class="gap-4 row">
                                <div class="col-md-12">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap">
                                            <label for="currentPassword" class="form-label">{{ __('Path') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="primary-form-control" name="path" placeholder="{{ __('Path') }}">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="py-10 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{ __('Download') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection
