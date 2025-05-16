@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __($pageTitle) }}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __($pageTitle) }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-danger-light-varient customers__area mb-30 bd-ra-10 p-sm-30 p-15">
            <h2 class="mb-10">{{ __("Note") }}:</h2>
            <p class="fw-bold mb-1">{{ __("Please backup the database and storage folder from root to avoid any invalid data mitchmatch") }}</p>
            <p class="mb-1">{{ __("If main file is not matched with selected type then it will mark as not uploadable. Please change the product type currectly in mapping csv") }}</p>
            <p class="mb-1">{{ __("If main file is not found or invalid then it will mark as not uploadable.") }}</p>
            <p class="mb-1">{{ __("If any items has invalid item then it will not upload as mark as not uploadable.") }}</p>
            <div class="bg-black p-2">
                <p class="mb-1 text-white">{{ __("Download the sample zip file and prepare the file with your data.") }} <a class="text-link" download href="{{ asset('bulk-upload/sample.zip') }}"> {{ __("Download") }} </a></p>
                <p class="mb-1 text-white">CSV file sequence, [Product Title, Thumbnail, Variation Name, Price (0 if free product), Main File, Product Type, Category, Tags with comma separate]</p>
            </div>
        </div>

        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
            <form action="{{ route('admin.product.bulk-upload.file') }}" method="post" class="form-horizontal"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group row pb-20">
                    <div class="col-md-12">
                        <label for="bulk_upload_file"
                            class="text-lg-right text-black">{{ __('Product File') }}</label>
                        <div class="input-group mb-3">
                            <input type="file" name="bulk_upload_file" id="bulk_upload_file"
                                class="form-control">
                            <div class="input-group-text mt-0">{{ __('Upload CSV File') }}</div>
                        </div>
                        @error('bulk_upload_file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="bd-c-stroke bd-t-one justify-content-between align-items-center text-end pt-15">
                    <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Check') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
