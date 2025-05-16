@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" href="{{asset('admin/css/custom/image-preview.css')}}">
@endpush
@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __('Product Type') }}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('Product Type') }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-reverse flex-sm-row justify-content-center justify-content-md-end align-items-center flex-wrap g-10 pb-18">
            <button class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white" type="button" data-bs-toggle="modal"
                    data-bs-target="#addModal">
                <i class="fa fa-plus"></i> {{ __('Add Product Type') }}
            </button>
        </div>

        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
            <table class="table zTable zTable-last-item-right commonDataTable">
                <thead>
                    <tr>
                        <th><div>{{ __('Sl.') }}</div></th>
                        <th><div>{{ __('Name') }}</div></th>
                        <th><div>{{ __('Type') }}</div></th>
                        <th><div>{{ __('Extensions') }}</div></th>
                        <th><div>{{ __('Status') }}</div></th>
                        <th><div>{{ __('Action') }}</div></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($productTypes as $type)
                    <tr class="removable-item">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $type->name }}</td>
                        <td>{{ getProductTypeCategory($type->product_type_category) }}</td>
                        <td>{{ implode(',', $type->product_type_extensions->pluck('name')->toArray()) }}</td>
                        <td>
                            <span id="hidden_id" class="d-none">{{ $type->id }}</span>
                            <div class="min-w-150 max-w-150">
                            <select name="status" class="status form-select">
                                <option value="1" {{ $type->status == ACTIVE ? 'selected' : '' }}>
                                    {{ __('Active') }}</option>
                                <option value="0"
                                    {{ $type->status == DISABLE ? 'selected' : '' }}>
                                    {{ __('Disable') }}</option>
                            </select>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center cg-5 justify-content-end">
                                <a class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-stroke bg-white edit" data-item="{{ $type }}"
                                   data-toggle="tooltip" title="Edit">
                                    <img src="{{ asset('admin/images/icons/edit-2.svg') }}"
                                         alt="edit">
                                </a>
                                <button class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-stroke bg-white deleteItem"
                                        data-formid="delete_row_form_{{ $type->uuid }}">
                                    <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.76256 2.51256C6.09075 2.18437 6.53587 2 7 2C7.46413 2 7.90925 2.18437 8.23744 2.51256C8.4448 2.71993 8.59475 2.97397 8.67705 3.25H5.32295C5.40525 2.97397 5.5552 2.71993 5.76256 2.51256ZM3.78868 3.25C3.89405 2.57321 4.21153 1.94227 4.7019 1.4519C5.3114 0.84241 6.13805 0.5 7 0.5C7.86195 0.5 8.6886 0.84241 9.2981 1.4519C9.78847 1.94227 10.106 2.57321 10.2113 3.25H13C13.4142 3.25 13.75 3.58579 13.75 4C13.75 4.41422 13.4142 4.75 13 4.75H12V13C12 13.3978 11.842 13.7794 11.5607 14.0607C11.2794 14.342 10.8978 14.5 10.5 14.5H3.5C3.10217 14.5 2.72064 14.342 2.43934 14.0607C2.15804 13.7794 2 13.3978 2 13V4.75H1C0.585786 4.75 0.25 4.41422 0.25 4C0.25 3.58579 0.585786 3.25 1 3.25H3.78868ZM5 6.37646C5.34518 6.37646 5.625 6.65629 5.625 7.00146V11.003C5.625 11.3481 5.34518 11.628 5 11.628C4.65482 11.628 4.375 11.3481 4.375 11.003V7.00146C4.375 6.65629 4.65482 6.37646 5 6.37646ZM9.625 7.00146C9.625 6.65629 9.34518 6.37646 9 6.37646C8.65482 6.37646 8.375 6.65629 8.375 7.00146V11.003C8.375 11.3481 8.65482 11.628 9 11.628C9.34518 11.628 9.625 11.3481 9.625 11.003V7.00146Z" fill="#5D697A"></path></svg>
                                </button>
                                <form
                                    action="{{ route('admin.product.product-type.delete', [$type->uuid]) }}"
                                    method="post" id="delete_row_form_{{ $type->uuid }}">
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Page content area end -->

    {{-- Modal --}}
    <div class="modal fade" id="addModal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <div class="d-flex justify-content-between align-items-center g-10 pb-20 mb-20 bd-b-one bd-c-stroke">
                    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Add Product Type') }}</h5>
                    <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                </div>
                <form class="ajax" action="{{ route('admin.product.product-type.store') }}" method="POST"
                      autocomplete="off" data-handler="commonResponseWithPageLoad">
                    <div class="row rg-24 pb-24">
                        <div class="col-12">
                            <label class="zForm-label" for="name">{{ __('Name') }}</label>
                            <input class="zForm-control" type="text" name="name" id="name" placeholder="Name">
                            @if ($errors->has('name'))
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                    {{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="col-12">
                            <label class="zForm-label" for="product_type_category"
                                   class="text-lg-right text-black"> {{ __('Type') }} </label>
                            <select name="product_type_category" class="form-control product_type_category">
                                <option value="">--{{ __('Select Option') }}--</option>
                                @foreach ($productTypeCategories as $index => $productTypeCategory)
                                    <option value="{{ $index }}">{{ $productTypeCategory }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="zForm-label" for="product_type_extension[]"
                                   class="text-lg-right text-black"> {{ __('Product Extension') }} </label>
                            <select name="product_type_extension[]" multiple
                                    class="form-control product_type_extension">

                            </select>
                        </div>
                        <div class="col-12">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap zImage-upload-details">
                                    <div class="zImage-inside">
                                        <div class="d-flex pb-12">
                                            <img src="{{ asset('assets/images/icon/upload-img-1.svg') }}"
                                                 alt=""/>
                                        </div>
                                        <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                            {{ __('Drag & drop files here') }}
                                        </p>
                                    </div>
                                    <label for="icon"
                                           class="form-label">{{ __('Icon') }}</label>
                                    <div class="upload-img-box w-100">
                                        <img src="{{getFileUrl(0)}}"/>
                                        <input type="file" name="icon" id="icon"
                                               accept="image/*,video/*" onchange="previewFile(this)"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="zForm-label" for="status" class="text-lg-right text-black"> {{ __('Status') }} </label>
                            <select name="status" id="status" class="form-control">
                                <option value="">--{{ __('Select Option') }}--</option>
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Disable') }}</option>
                            </select>
                        </div>

                    </div>
                    <div class="bd-c-stroke bd-t-one justify-content-between align-items-center text-end pt-15">
                        <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <div class="d-flex justify-content-between align-items-center g-10 pb-20 mb-20 bd-b-one bd-c-stroke">
                    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Edit Product Type') }}</h5>
                    <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                </div>
                <form class="ajax" action="{{ route('admin.product.product-type.store') }}" method="POST"
                      autocomplete="off" data-handler="commonResponseWithPageLoad">
                    <input type="hidden" name="uuid">
                    <div class="row rg-24 pb-24">
                        <div class="col-12">
                            <label class="zForm-label" for="name">{{ __('Name') }}</label>
                            <input class="zForm-control" type="text" name="name" id="name" placeholder="Name" value=""
                                   required>
                            @if ($errors->has('name'))
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                    {{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="col-12">
                            <label class="zForm-label" for="product_type_category"
                                   class="text-lg-right text-black"> {{ __('Type') }} </label>
                            <select name="product_type_category" class="form-control product_type_category">
                                <option value="">--{{ __('Select Option') }}--</option>
                                @foreach ($productTypeCategories as $index => $productTypeCategory)
                                    <option value="{{ $index }}">{{ $productTypeCategory }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="zForm-label" for="product_type_extension[]"
                                   class="text-lg-right text-black"> {{ __('Product Extension') }} </label>
                            <select name="product_type_extension[]" multiple
                                    class="form-control product_type_extension">

                            </select>
                        </div>
                        <div class="col-12">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap zImage-upload-details">
                                    <div class="zImage-inside">
                                        <div class="d-flex pb-12">
                                            <img src="{{ asset('assets/images/icon/upload-img-1.svg') }}"
                                                 alt=""/>
                                        </div>
                                        <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                            {{ __('Drag & drop files here') }}
                                        </p>
                                    </div>
                                    <label class="zForm-label" for="icon"
                                           class="form-label">{{ __('Icon') }}</label>
                                    <div class="upload-img-box w-100">
                                        <img id="edit-icon" src=""/>
                                        <input type="file" name="icon" id="icon"
                                               accept="image/*,video/*" onchange="previewFile(this)"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="zForm-label" for="status" class="text-lg-right text-black"> {{ __('Status') }} </label>
                            <select name="status" id="status" class="form-control">
                                <option value="">--{{ __('Select Option') }}--</option>
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Disable') }}</option>
                            </select>
                        </div>

                    </div>
                    <div class="bd-c-stroke bd-t-one justify-content-between align-items-center text-end pt-15">
                        <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
    <script>
        'use strict'
        const productTypeStatusChangeRoute = "{{ route('admin.product.product-type.changeStatus') }}";
        const csrfToken = "{{ csrf_token() }}";
        const productTypeExtensions = @json($productTypeExtensions);
    </script>
    <script src="{{ asset('admin/js/custom/product-type.js') }}"></script>
@endpush
