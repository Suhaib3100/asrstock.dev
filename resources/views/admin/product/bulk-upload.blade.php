@extends('admin.layouts.app')

@section('content')
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __($pageTitle) }}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __($pageTitle) }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documentation Section -->
        <div class="bg-info-light-varient customers__area mb-30 bd-ra-10 p-sm-30 p-15">
            <h2 class="mb-10">{{ __("Bulk Upload Guide") }}:</h2>
            <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-3">{{ __("Quick Start Guide") }}:</h4>
                    <ol class="ps-3">
                        <li class="mb-2">{{ __("Prepare your files:") }}
                            <ul class="ps-3 mt-1">
                                <li>{{ __("Create a CSV file with required columns") }}</li>
                                <li>{{ __("Place all media files in a folder") }}</li>
                                <li>{{ __("Zip the CSV and media files together") }}</li>
                            </ul>
                        </li>
                        <li class="mb-2">{{ __("Upload the ZIP file") }}</li>
                        <li class="mb-2">{{ __("Monitor the upload progress") }}</li>
                        <li class="mb-2">{{ __("Review and confirm the upload") }}</li>
                    </ol>
                </div>
                <div class="col-md-6">
                    <h4 class="mb-3">{{ __("CSV Format") }}:</h4>
                    <div class="bg-white p-3 rounded">
                        <h5 class="mb-2">{{ __("Required Columns") }}:</h5>
                        <ul class="ps-3 mb-3">
                            <li><code>filename</code> - {{ __("Name of the media file in the ZIP") }}</li>
                            <li><code>title</code> - {{ __("Product title") }}</li>
                            <li><code>category_id</code> - {{ __("Category ID") }}</li>
                            <li><code>price</code> - {{ __("Product price (0 for free)") }}</li>
                            <li><code>accessibility</code> - {{ __("Paid/Free") }}</li>
                            <li><code>tags</code> - {{ __("Comma-separated tag names") }}</li>
                        </ul>

                        <h5 class="mb-2">{{ __("File Requirements") }}:</h5>
                        <ul class="ps-3 mb-3">
                            <li>{{ __("Maximum ZIP size: 500MB") }}</li>
                            <li>{{ __("Supported media formats: Images, Videos, Audio") }}</li>
                            <li>{{ __("CSV must be UTF-8 encoded") }}</li>
                        </ul>

                        <h5 class="mb-2">{{ __("Tips") }}:</h5>
                        <ul class="ps-3">
                            <li>{{ __("Use descriptive filenames") }}</li>
                            <li>{{ __("Verify all media files are valid") }}</li>
                            <li>{{ __("Check CSV format before uploading") }}</li>
                            <li>{{ __("Download the template for reference") }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
            <form action="{{ route('admin.product.bulk-upload.file') }}" method="post" class="form-horizontal" enctype="multipart/form-data" id="bulkUploadForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">{{ __('ZIP File') }} <span class="text-danger">*</span></label>
                            <input type="file" name="zip_file" class="form-control" required accept=".zip">
                            <small class="text-muted">{{ __('Max size: 500MB') }}</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">{{ __('Category') }} <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control" required>
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach($productTypes as $type)
                                    <optgroup label="{{ $type->name }}">
                                        @foreach($type->categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="progress d-none" id="uploadProgress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="mt-3 d-none" id="uploadStatus"></div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" id="uploadButton">
                            <i class="fa fa-upload"></i> {{ __('Upload Products') }}
                        </button>
                        <a href="{{ route('admin.product.bulk-upload.template') }}" class="btn btn-info">
                            <i class="fa fa-download"></i> {{ __('Download Template') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#bulkUploadForm').on('submit', function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            var $progress = $('#uploadProgress');
            var $progressBar = $progress.find('.progress-bar');
            var $status = $('#uploadStatus');
            var $button = $('#uploadButton');
            
            $progress.removeClass('d-none');
            $status.removeClass('d-none');
            $button.prop('disabled', true);
            
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            var percent = Math.round((e.loaded / e.total) * 100);
                            $progressBar.css('width', percent + '%');
                            $status.html('{{ __("Uploading") }}: ' + percent + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    if (response.success) {
                        $status.html('<div class="alert alert-success">' + response.message + '</div>');
                        if (response.redirect) {
                            setTimeout(function() {
                                window.location.href = response.redirect;
                            }, 2000);
                        }
                    } else {
                        $status.html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function(xhr) {
                    var message = '{{ __("Upload failed") }}';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    $status.html('<div class="alert alert-danger">' + message + '</div>');
                },
                complete: function() {
                    $button.prop('disabled', false);
                }
            });
        });
    });
</script>
@endpush
