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
                                        href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ @$pageTitle }}</li>
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
                <h2 class="fs-18 fw-500 lh-28 text-primary-dark-text pb-24">{{ @$pageTitle }}</h2>
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <form action="{{route('admin.setting.about.team-member.update')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row rg-24 pb-24">
                            <div class="col-md-6">
                                <label for="team_member_title" class="zForm-label">{{ __('Title') }} </label>
                                <input type="text" name="team_member_title" id="team_member_title"
                                       value="{{ getOption('team_member_title') }}" class="zForm-control"
                                       placeholder="Type title">
                                @if ($errors->has('team_member_title'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('team_member_title') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="team_member_subtitle" class="zForm-label">{{ __('Subtitle') }} </label>
                                <textarea name="team_member_subtitle" class="zForm-control" id="team_member_subtitle"
                                          required>{{ getOption('team_member_subtitle') }}</textarea>
                                @if ($errors->has('team_member_subtitle'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('team_member_subtitle') }}</span>
                                @endif
                            </div>
                            <div class="col-12">
                                <div id="add_repeater" class="">
                                    <div data-repeater-list="team_members" class="row rg-24 pb-24">
                                        @if(count($teamMembers) > 0)
                                            @foreach($teamMembers as $teamMember)
                                                <div data-repeater-item="" class="col-12">
                                                    <input type="hidden" name="id" value="{{ @$teamMember['id'] }}"/>
                                                    <div class="row rg-24">
                                                    <div class="col-12">
                                                        <label for="image_{{ $teamMember->id }}"
                                                               class="zForm-label"> {{ __('Member Image') }} </label>
                                                        <div class="col-sm-3">
                                                            <div class="upload-img-box w-100">
                                                                <img src="{{ $teamMember->image }}">
                                                                <input type="file" name="image"
                                                                       id="image_{{ $teamMember->id }}"
                                                                       accept="image/*"
                                                                       onchange="preview312369DimensionFile(this)">
                                                                <div class="upload-img-box-icon">
                                                                    <i class="fa fa-camera"></i>
                                                                </div>
                                                            </div>
                                                            <p><span
                                                                    class="text-black">{{ __('Accepted Files') }}: </span>JPG,
                                                                JPEG, PNG <br> <span
                                                                    class="text-black">{{ __('Accepted Size') }}:</span>
                                                                312
                                                                x 369
                                                                (1MB)</p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="name_{{ $teamMember->id }}"
                                                               class="zForm-label"> {{ __('Name') }} </label>
                                                        <input type="text" name="name" id="name_{{ $teamMember->id }}"
                                                               value="{{ $teamMember['name'] }}" class="zForm-control"
                                                               placeholder="Type name" required>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <label for="designation_{{ $teamMember->id }}"
                                                               class="zForm-label"> {{ __('Designation') }} </label>
                                                        <input type="text" name="designation"
                                                               id="designation_{{ $teamMember->id }}"
                                                               value="{{ $teamMember['designation'] }}"
                                                               class="zForm-control" placeholder="Type designation"
                                                               required>
                                                    </div>

                                                    <div class="col-lg-1">
                                                        <div class="pt-md-40">
                                                            <a href="javascript:;" data-repeater-delete=""
                                                               class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-stroke bg-white">
                                                            <span class="onlyForProductRules">
                                                        <svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg"><path
                                                                fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M5.76256 2.51256C6.09075 2.18437 6.53587 2 7 2C7.46413 2 7.90925 2.18437 8.23744 2.51256C8.4448 2.71993 8.59475 2.97397 8.67705 3.25H5.32295C5.40525 2.97397 5.5552 2.71993 5.76256 2.51256ZM3.78868 3.25C3.89405 2.57321 4.21153 1.94227 4.7019 1.4519C5.3114 0.84241 6.13805 0.5 7 0.5C7.86195 0.5 8.6886 0.84241 9.2981 1.4519C9.78847 1.94227 10.106 2.57321 10.2113 3.25H13C13.4142 3.25 13.75 3.58579 13.75 4C13.75 4.41422 13.4142 4.75 13 4.75H12V13C12 13.3978 11.842 13.7794 11.5607 14.0607C11.2794 14.342 10.8978 14.5 10.5 14.5H3.5C3.10217 14.5 2.72064 14.342 2.43934 14.0607C2.15804 13.7794 2 13.3978 2 13V4.75H1C0.585786 4.75 0.25 4.41422 0.25 4C0.25 3.58579 0.585786 3.25 1 3.25H3.78868ZM5 6.37646C5.34518 6.37646 5.625 6.65629 5.625 7.00146V11.003C5.625 11.3481 5.34518 11.628 5 11.628C4.65482 11.628 4.375 11.3481 4.375 11.003V7.00146C4.375 6.65629 4.65482 6.37646 5 6.37646ZM9.625 7.00146C9.625 6.65629 9.34518 6.37646 9 6.37646C8.65482 6.37646 8.375 6.65629 8.375 7.00146V11.003C8.375 11.3481 8.65482 11.628 9 11.628C9.34518 11.628 9.625 11.3481 9.625 11.003V7.00146Z"
                                                                fill="#5D697A"></path></svg>
                                                    </span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    </div>

                                                </div>
                                            @endforeach
                                        @else
                                            <div data-repeater-item="" class="form-group row ">
                                                <div class="custom-form-group mb-3 col-lg-3">
                                                    <label for="image"
                                                           class=" text-lg-right text-black"> {{ __('Member Image') }} </label>
                                                    <div class="upload-img-box">
                                                        <img src="{{ getDefaultImage() }}" alt="">
                                                        <input type="file" name="image" id="image" accept="image/*"
                                                               onchange="preview312369DimensionFile(this)">
                                                        <div class="upload-img-box-icon">
                                                            <i class="fa fa-camera"></i>
                                                        </div>
                                                    </div>
                                                    <p><span class="text-black">{{ __('Accepted Files') }}: </span>JPG,
                                                        JPEG,
                                                        PNG <br> <span
                                                            class="text-black">{{ __('Accepted Size') }}:</span> 312
                                                        x 369 (1MB)</p>
                                                </div>

                                                <div class="custom-form-group mb-3 col-lg-4">
                                                    <label for="name"
                                                           class="text-lg-right text-black"> {{ __('Name') }} </label>
                                                    <input type="text" name="name" id="name" value=""
                                                           class="form-control"
                                                           placeholder="Type name" required>
                                                </div>
                                                <div class="custom-form-group mb-3 col-lg-4">
                                                    <label for="designation"
                                                           class="text-lg-right text-black"> {{ __('Designation') }} </label>
                                                    <input type="text" name="designation" id="designation" value=""
                                                           class="form-control" placeholder="Type designation" required>
                                                </div>

                                                <div class="col-lg-1 mb-3 ">
                                                    <label
                                                        class="text-lg-right text-black opacity-0">{{ __('Remove') }}</label>
                                                    <a href="javascript:;" data-repeater-delete=""
                                                       class="btn btn-icon-remove">
                                                        <img src="{{asset('admin/images/icons/trash-2.svg')}}"
                                                             alt="trash"
                                                             class="onlyForProductRules">
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-12">
                                        <a id="add" href="javascript:;" data-repeater-create=""
                                           class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white d-inline-flex align-items-center g-10"><i
                                                class="fas fa-plus"></i> {{ __('Add') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bd-t-one bd-c-stroke d-flex justify-content-end align-items-center pt-15">
                            <button
                                class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection


@push('style')
    <link rel="stylesheet" href="{{asset('admin/css/custom/image-preview.css')}}">
@endpush

@push('script')
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
    <script src="{{ asset('common/js/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('common/js/add-repeater.js') }}"></script>
@endpush
