@extends('admin.layouts.app')

@push('style')
<link rel="stylesheet" href="{{asset('admin/css/custom/image-preview.css')}}">
<style>
    .upload-img-box {
        height: 100px;
        width: 100px;
    }

    .upload-img-box-icon {
        background-color: unset;
    }
</style>
@endpush

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb__content">
                    <div class="breadcrumb__content__left">
                        <div class="breadcrumb__title">
                            <h2>{{ __($pageTitle) }}</h2>
                        </div>
                    </div>
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard')
                                        }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __($pageTitle) }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="customers__area bg-style mb-30 admin-dashboard-blog-list-page">
                    <form action="{{ route('admin.product.bulk-upload.confirm') }}" enctype="multipart/form-data" method="POST"
                        class="form-horizontal">
                        @csrf
                        <div class="row mb-3">
                            <div class="bg-danger-light-varient col-md-12 p-3">
                                <h2 class="mb-10">Note:</h2>
                                <p class="fw-bold mb-1">{{ __("Please backup the database and storage folder from root to avoid any invalid data mitchmatch") }}</p>
                                <p class="mb-1">{{ __("If main file is not matched with selected type then it will mark as not uploadable. Please change the product type currectly in mapping csv") }}</p>
                                <p class="mb-1">{{ __("If main file is not found or invalid then it will mark as not uploadable.") }}</p>
                                <p class="mb-1">{{ __("If any items has invalid item then it will not upload as mark as not uploadable.") }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="customers__table table-responsive">
                                <table class="row-border stripe table-style table-responsive">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Thumbnail') }}</th>
                                            <th>{{ __('Title') }}</th>
                                            <th>{{ __('Variation') }}</th>
                                            <th width=120>{{ __('Price') }}</th>
                                            <th>{{ __('File') }}</th>
                                            <th>{{ __('Category') }} / {{ __('Type') }}</th>
                                            <th>{{ __('File Type') }}</th>
                                            <th>{{ __('Tags') }}</th>
                                            <th>{{ __('Uploadable') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $key => $item)
                                        <tr class="bulk-items">
                                            <td>
                                                <div class="upload-img-box mb-25">
                                                    <img src="{{ $item['thumbnail'] }}">
                                                    <input type="file" name="items[{{ $key }}][thumbnail_image]" accept="image/*"
                                                        onchange="previewFile(this)">
                                                        <div class="upload-img-box-icon">
                                                            <i class="fa fa-camera"></i>
                                                        </div>
                                                </div>
                                                <input type="hidden" name="items[{{ $key }}][thumbnail_image_old]" value="{{ $item['thumbnail'] }}">
                                                <input type="hidden" name="items[{{ $key }}][thumbnail_image_path]" value="{{ $item['thumbnailName'] }}">
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="text" name="items[{{ $key }}][title]"
                                                        value="{{ $item['title'] }}" placeholder="{{ __('Title') }}"
                                                        class="form-control items-title">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="text" name="items[{{ $key }}][variation]"
                                                        value="{{ $item['variation'] }}"
                                                        placeholder="{{ __('Variation') }}"
                                                        class="form-control items-variation">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="number" min=0 name="items[{{ $key }}][price]"
                                                        value="{{ $item['price'] }}" placeholder="{{ __('Price') }}"
                                                        class="form-control items-price">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="file" class="form-control" name="items[{{ $key }}][file]"
                                                        value="{{ $item['file'] }}">
                                                    <a target="_blank" class="float-end text-link" href="{{ $item['file'] }}">View</a>
                                                    <input type="hidden" name="items[{{ $key }}][file_old]" value="{{ $item['file'] }}">
                                                    <input type="hidden" name="items[{{ $key }}][file_name]" value="{{ $item['fileName'] }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <select name="items[{{ $key }}][category]"
                                                        class="form-control items-category">
                                                        @foreach ($productTypes as $type)
                                                        <optgroup label="{{ $type->name }}">
                                                            @foreach ($type->categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                data-name="{{ $category->name }}" {{ $category->id ==
                                                                $item['category'] ? 'selected' : '' }}>
                                                                {{ $category->name }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <span>{{ $item['file_types'] ?? "" }}</span>
                                                <input type="hidden" name="items[{{ $key }}][file_types]" value="{{ $item['file_types'] ?? "" }}">
                                            </td>
                                            <td>
                                                <select name="items[{{ $key }}][tags][]" id=""
                                                    class="multiple-basic-single items-tags" multiple="multiple">
                                                    @foreach ($tags as $tag)
                                                    <option value="{{ $tag->id }}" @if (in_array($tag->id,
                                                        $item['tags'])) selected @endif>
                                                        {{ $tag->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                @if(isset($item['status']) && $item['status'] == ACTIVE)
                                                <input type="hidden" name="items[{{ $key }}][status]" value="{{ ACTIVE }}">
                                                <span class="was-success">YES</span>
                                                @else
                                                <input type="hidden" name="items[{{ $key }}][status]" value="{{ DISABLE }}">
                                                <span class="text-danger">NO</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-blue">{{ __('Confirm') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

<script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
<script src="{{ asset('admin/js/custom/product-bulk-upload.js') }}"></script>
@endpush
