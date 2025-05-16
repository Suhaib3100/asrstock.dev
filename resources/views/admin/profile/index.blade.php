@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{__('Profile')}}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb sf-breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{__('Update Profile')}}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-title d-flex justify-content-between">
                            <h2>{{__('Update Profile')}}</h2>
                        </div>
                        <form action="{{route('admin.profile.update')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            @csrf

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="input__group mb-25">
                                        <label for="name">{{__('Name')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" value="{{Auth::user()->name}}" placeholder="{{__('Name')}}" class="form-control">
                                        @if ($errors->has('name'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input__group mb-25">
                                        <label for="contact_number">{{__('Contact Number')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="contact_number" id="contact_number" value="{{auth::user()->contact_number}}" placeholder="{{__('Contact Number')}}" class="form-control">
                                        @if ($errors->has('contact_number'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('contact_number') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input__group mb-25">
                                        <label for="email">{{__('Email')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="email" id="email" value="{{Auth::user()->email}}" placeholder="{{__('Email')}}" class="form-control">
                                        @if ($errors->has('email'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input__group mb-25">
                                        <label for="address">{{__('Address')}} <span class="text-danger">*</span></label>
                                        <textarea name="address" id="address" class="form-control" placeholder="{{__('Address')}}">{{Auth::user()->address}}</textarea>
                                        @if ($errors->has('address'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <label for="address">{{__('Profile Image')}} </label>
                                    <div class="upload-img-box mb-25 overflow-hidden">
                                        @if(auth()->user()->image)
                                            <img src="{{ auth()->user()->image }}" alt="img" class="img-fluid">
                                        @else
                                            <img src="{{ getDefaultImage() }}" alt="img">
                                        @endif
                                        <input type="file" name="profile_image" id="profile_image" accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                            <p class="m-0">{{__('Image')}}</p>
                                        </div>
                                    </div>
                                    <p>{{ __('Accepted Image Files') }}: JPEG, JPG, PNG <br> {{ __('Recommend Size') }}: 300 x 300 (1MB)</p>
                                </div>
                                <div class="col-md-6">
                                    <label for="address">{{__('Cover Image')}} </label>
                                    <div class="upload-img-box mb-25 overflow-hidden">
                                        @if(auth()->user()->cover_image)
                                            <img src="{{ auth()->user()->cover_image }}" alt="img" class="img-fluid">
                                        @else
                                            <img src="{{ getDefaultImage() }}" alt="img">
                                        @endif
                                        <input type="file" name="cover_image" id="cover_image" accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                            <p class="m-0">{{__('Image')}}</p>
                                        </div>
                                    </div>
                                    <p>{{ __('Accepted Image Files') }}: JPEG, JPG, PNG <br> {{ __('Recommend Size') }}: (1MB)</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <button class="btn btn-blue" type="submit">{{ __('Update') }}</button>
                                </div>
                            </div>

                        </form>
                    </div>
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
@endpush
