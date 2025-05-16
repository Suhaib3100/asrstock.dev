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
                        <li class="mb-2">{{ __("Click 'Add More' to add multiple product upload fields") }}</li>
                        <li class="mb-2">{{ __("For each product:") }}
                            <ul class="ps-3 mt-1">
                                <li>{{ __("Select the product file (max 100MB)") }}</li>
                                <li>{{ __("Enter a unique title") }}</li>
                                <li>{{ __("Choose the appropriate category") }}</li>
                                <li>{{ __("Set the price (0 for free products)") }}</li>
                                <li>{{ __("Select accessibility (Paid/Free)") }}</li>
                                <li>{{ __("Add relevant tags") }}</li>
                            </ul>
                        </li>
                        <li class="mb-2">{{ __("Click 'Upload Products' to process all items") }}</li>
                    </ol>
                </div>
                <div class="col-md-6">
                    <h4 class="mb-3">{{ __("Important Information") }}:</h4>
                    <div class="bg-white p-3 rounded">
                        <h5 class="mb-2">{{ __("File Requirements") }}:</h5>
                        <ul class="ps-3 mb-3">
                            <li>{{ __("Maximum file size: 100MB per file") }}</li>
                            <li>{{ __("Supported formats depend on category type") }}</li>
                            <li>{{ __("Files must be valid and not corrupted") }}</li>
                        </ul>

                        <h5 class="mb-2">{{ __("Product Information") }}:</h5>
                        <ul class="ps-3 mb-3">
                            <li>{{ __("Titles must be unique") }}</li>
                            <li>{{ __("Categories must match file type") }}</li>
                            <li>{{ __("Free products are marked as 'Use This Photo'") }}</li>
                        </ul>

                        <h5 class="mb-2">{{ __("Tips") }}:</h5>
                        <ul class="ps-3">
                            <li>{{ __("Use descriptive titles for better searchability") }}</li>
                            <li>{{ __("Add relevant tags to improve product visibility") }}</li>
                            <li>{{ __("Verify file compatibility before upload") }}</li>
                            <li>{{ __("Check category requirements for file types") }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
            <form action="{{ route('admin.product.bulk-upload.file') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div id="upload-container">
                    <div class="upload-item mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('File') }} <span class="text-danger">*</span></label>
                                    <input type="file" name="files[]" class="form-control" required accept="image/*,video/*,audio/*">
                                    <small class="text-muted">{{ __('Max size: 100MB') }}</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Title') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="titles[]" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Category') }} <span class="text-danger">*</span></label>
                                    <select name="categories[]" class="form-control" required>
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
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Price') }}</label>
                                    <input type="number" name="prices[]" class="form-control" min="0" step="0.01" value="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Accessibility') }}</label>
                                    <select name="accessibility[]" class="form-control">
                                        <option value="{{ PRODUCT_ACCESSIBILITY_PAID }}">{{ __('Paid') }}</option>
                                        <option value="{{ PRODUCT_ACCESSIBILITY_FREE }}">{{ __('Free') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Tags') }}</label>
                                    <select name="tags[][]" class="form-control select2" multiple>
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-info" id="add-more">
                            <i class="fa fa-plus"></i> {{ __('Add More') }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-upload"></i> {{ __('Upload Products') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('.select2').select2();
        
        $('#add-more').click(function() {
            var clone = $('.upload-item:first').clone();
            clone.find('input').val('');
            clone.find('select').val('').trigger('change');
            $('#upload-container').append(clone);
            clone.find('.select2').select2();
        });

        // Enhanced file validation
        $('input[type="file"]').on('change', function() {
            var file = this.files[0];
            var maxSize = 100 * 1024 * 1024; // 100MB in bytes
            var $this = $(this);
            var $parent = $this.closest('.upload-item');
            
            if (file) {
                if (file.size > maxSize) {
                    alert('{{ __("File size exceeds 100MB limit") }}');
                    this.value = '';
                    return;
                }

                // Auto-fill title from filename if empty
                var $titleInput = $parent.find('input[name="titles[]"]');
                if (!$titleInput.val()) {
                    var fileName = file.name.replace(/\.[^/.]+$/, ""); // Remove extension
                    $titleInput.val(fileName);
                }
            }
        });

        // Category change handler
        $('select[name="categories[]"]').on('change', function() {
            var $this = $(this);
            var $parent = $this.closest('.upload-item');
            var $fileInput = $parent.find('input[type="file"]');
            
            // Update accepted file types based on category
            var categoryId = $this.val();
            if (categoryId) {
                // You can add specific file type restrictions based on category here
                // For example:
                // if (categoryId === '1') {
                //     $fileInput.attr('accept', 'image/*');
                // } else if (categoryId === '2') {
                //     $fileInput.attr('accept', 'video/*');
                // }
            }
        });
    });
</script>
@endpush
