@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __('Translate language') }}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.setting.language.index') }}">{{ __('Language Settings') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('Translate Language') }}
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row rg-24 admin-dashboard-translate-your-language-page">
            <div class="col-xl-3">
                @include('admin.setting.setting-sidebar')
            </div>
            <div class="col-xl-9">
                <button class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white" type="button" data-bs-toggle="modal"
                    data-bs-target="#add-todo-modal">
                    <i class="fa fa-plus"></i> {{ __('Import Keywords') }}
                </button>
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15 mt-24">
                    <form action="{{ route('admin.setting.language.update.translate', [$language->id]) }}" method="post"
                        enctype="multipart/form-data" data-parsley-validate>

                        <div class="d-flex justify-content-between flex-wrap g-10 bd-b-one bd-c-stroke pb-24 mb-24">
                            <h2 class="fs-18 fw-600 lh-22 text-primary-dark-text"> {{ __('Translate Your Language') }} (English => {{ $language->language }} ) </h2>
                            <button class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white addmore"> <i class="fa fa-plus"></i>{{ __('Add More') }}</button>
                        </div>
                        <div class="card-body">

                            @csrf
                            <div class="row">
                                <table class="table zTable zTable-last-item-right">
                                    <thead>
                                        <tr>
                                            <th><div>{{ __('Key') }}</div></th>
                                            <th><div>{{ __('Value') }}</div></th>
                                            <th><div>{{ __('Action') }}</div></th>
                                        </tr>
                                    </thead>
                                    <tbody id="append">
                                        @foreach ($translators as $key => $value)
                                            <tr>
                                                <td>
                                                    <textarea type="text" name="key" class="key zForm-control" readonly>{!! $key !!}</textarea>
                                                </td>
                                                <td>
                                                    <input type="hidden" value="0" class="is_new">
                                                    <textarea type="text" name="value" class="val zForm-control">{!! $value !!}</textarea>
                                                </td>
                                                <td class="text-end col-1">
                                                    <button type="button" disabled
                                                        class="language-update border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white">{{ __('Update') }}</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->

    <!-- Add Modal section start -->
    <div class="modal fade" id="add-todo-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <div class="d-flex justify-content-between align-items-center g-10 pb-20 mb-20 bd-b-one bd-c-stroke">
                    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Import Language') }}</h5>
                    <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                </div>
                <form action="{{ route('admin.setting.language.import') }}" method="post">
                    @csrf
                    <input type="hidden" name="current" value="{{ $language->iso_code }}">
                    <div class="pb-24">
                        <div class="mb-30">
                            <span class="text-danger text-center">{{ __('Note: If you import keywords, your current keywords will be deleted and replaced by the imported keywords.') }}</span>
                        </div>
                        <div class="pb-24">
                            <label for="status" class="zForm-label"> {{ __('Language') }} </label>
                            <select name="import" class="form-select export" id="inputGroupSelect02">
                                <option selected> {{ __('Select Option') }} </option>
                                @foreach ($languages as $la)
                                    <option value="{{ $la->iso_code }}">{{ __($la->language) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="bd-c-stroke bd-t-one d-flex justify-content-end align-items-center pt-15">
                            <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Import') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Modal section end -->

    <input type="hidden" id="updateLanguageRoute" value="{{ route('admin.setting.language.update-language', $language->id) }}">
@endsection

@push('script')
    <script src="{{ asset('admin/js/custom/translate.js') }}"></script>
@endpush
