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
                                <h2>{{ __(@$pageTitle) }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb sf-breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ @$pageTitle }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    @include('admin.setting.sidebar')
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="email-inbox__area bg-style form-horizontal__item bg-style admin-general-settings-page">
                        <div class="item-top mb-30"><h2>{{ @$pageTitle }}</h2></div>
                        <form action="{{route('admin.setting.general-settings.update')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            @csrf

                            <div class="row input__group mb-25">
                                <label class="col-lg-3">{{__('App Name')}} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="app_name" value="{{getOption('app_name')}}" class="form-control" required>
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label class="col-lg-3">App Email <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="app_email" value="{{getOption('app_email')}}" class="form-control" required>
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label class="col-lg-3">App Contact Number <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="app_contact_number" value="{{getOption('app_contact_number')}}" class="form-control" required>
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label class="col-lg-3">App Location <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="app_location" value="{{getOption('app_location')}}" class="form-control" required>
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label class="col-lg-3">App Copyright <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="app_copyright" value="{{getOption('app_copyright')}}" class="form-control" required>
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label class="col-lg-3">Asset License<span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="asset_license" value="{{getOption('asset_license')}}" class="form-control" required>
                                </div>
                            </div>

                            <div class="row input__group mb-25">
                                <label class="col-lg-3">{{ __("Frontend URL") }} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="app_frontend_url" value="{{getOption('app_frontend_url')}}" class="form-control" required>
                                </div>
                            </div>

                            <div class="row input__group mb-25">
                                <label class="col-lg-3">Developed By <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="app_developed" value="{{getOption('app_developed')}}" class="form-control" required>
                                </div>
                            </div>

                            <div class="row input__group mb-25">
                                <label for="app_date_format" class="col-lg-3">{{__('Default Currency')}} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <select name="currency_id" class="form-control select2">
                                        <option value="">Select option</option>
                                        @foreach($currencies as $currency)
                                        <option value="{{ $currency->id }}" {{$currency->id == @$current_currency->id ? 'selected' : ''}} > {{ $currency->symbol }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label for="app_date_format" class="col-lg-3">{{__('Default Language')}} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <select name="language_id" class="form-control select2">
                                        <option value="">Select option</option>
                                        @foreach($languages as $language)
                                        <option value="{{ $language->id }}" {{$language->id == @$default_language->id ? 'selected' : ''}} > {{ $language->language }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label for="app_date_format" class="col-lg-3">{{__('Donation Status')}} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <select name="donation_status" class="form-control select2">
                                        <option value="1" {{ getOption('donation_status') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option value="0" {{ getOption('donation_status') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label for="app_date_format" class="col-lg-3">{{__('Donate Price')}} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="number" step="any" min="1" name="donate_price" class="form-control" value="{{ getOption('donate_price') }}">
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label for="app_date_format" class="col-lg-3">{{__('Free Download Limit')}} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <select name="free_download_limit" class="form-control select2">
                                        <option value="1" {{ getOption('free_download_limit') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option value="0" {{ getOption('free_download_limit') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label for="free_download_per_day" class="col-lg-3">{{__('Free download per day')}} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="number" step="any" min="1" name="free_download_per_day" class="form-control" value="{{ getOption('free_download_per_day') }}">
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label for="app_date_format" class="col-lg-3">{{__('App Preloader Status (Admin Panel)')}} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <select name="app_preloader_status" class="form-control select2">
                                        <option value="">Select option</option>
                                        <option value="1" {{ getOption('app_preloader_status') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option value="0" {{ getOption('app_preloader_status') != 1 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label class="col-lg-3">{{__('App Preloader')}}</label>
                                <div class="col-lg-4">
                                    <div class="upload-img-box">
                                        <img src="{{ getSettingImage('app_preloader') }}">
                                        <input type="file" name="app_preloader" id="app_preloader" accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('app_logo'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('app_logo') }}</span>
                                    @endif
                                    <p><span class="text-black"><span class="text-black">Recommend Size:</span> 140 x 40</p>
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label class="col-lg-3">{{__('App Logo')}}</label>
                                <div class="col-lg-4">
                                    <div class="upload-img-box">
                                        <img src="{{ getSettingImage('app_logo') }}">
                                        <input type="file" name="app_logo" id="app_logo" accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('app_logo'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('app_logo') }}</span>
                                    @endif
                                    <p><span class="text-black"> <span class="text-black">Recommend Size:</span> 140 x 40 </span></p>
                                </div>
                            </div>

                            <div class="row input__group mb-25">
                                <label class="col-lg-3">{{__('PWA Logo')}}</label>
                                <div class="col-lg-4">
                                    <div class="upload-img-box">
                                        <img src="{{ getSettingImage('pwa_logo') }}">
                                        <input type="file" name="pwa_logo" id="pwa_logo" accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('pwa_logo'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('pwa_logo') }}</span>
                                    @endif
                                    <p><span class="text-black"> <span class="text-black">Size:</span> 512 x 512 </span></p>
                                </div>
                            </div>


                            <div class="row input__group mb-25">
                                <label class="col-lg-3">{{__('App Fav Icon')}} </label>
                                <div class="col-lg-4">
                                    <div class="upload-img-box">
                                        <img src="{{ getSettingImage('app_fav_icon') }}">
                                        <input type="file" name="app_fav_icon" id="app_fav_icon" accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('app_fav_icon'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('app_fav_icon') }}</span>
                                    @endif
                                    <p><span class="text-black"><span class="text-black">Recommend Size:</span> 16 x 16 </span></p>
                                </div>
                            </div>

                            <div class="row input__group mb-25">
                                <label class="col-lg-3">{{__('Admin Main Logo & Footer Logo')}}</label>
                                <div class="col-lg-4">
                                    <div class="upload-img-box">
                                        <img src="{{ getSettingImage('app_logo_white') }}">
                                        <input type="file" name="app_logo_white" id="app_logo_white" accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('app_logo'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('app_logo') }}</span>
                                    @endif
                                    <p><span class="text-black"><span class="text-black">Recommend Size:</span> 140 x 40 </span></p>
                                </div>
                            </div>

                            <div class="row input__group mb-25">
                                <label class="col-lg-3">{{__('Watermark Image')}}</label>
                                <div class="col-lg-4">
                                    <div class="upload-img-box">
                                        <img src="{{ getSettingImage('water_mark_img') }}" alt="water_mark_img">
                                        <input type="file" name="water_mark_img" id="water_mark_img" accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('app_logo'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('app_logo') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label for="app_date_format" class="col-lg-3">{{__('Watermark Status')}} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <select name="watermark_status" class="form-control select2">
                                        <option value="1" {{ getOption('watermark_status') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option value="0" {{ getOption('watermark_status') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row input__group mb-25">
                                <label for="app_date_format" class="col-lg-3">{{__('Comment System')}} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <select name="comment_status" class="form-control select2">
                                        <option value="1" {{ getOption('comment_status') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option value="0" {{ getOption('comment_status') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row input__group mb-25">
                                <label for="app_date_format" class="col-lg-3">{{__('All product show')}} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <select name="all_product_show" class="form-control select2">
                                        <option value="1" {{ getOption('all_product_show') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option value="0" {{ getOption('all_product_show') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label for="app_date_format" class="col-lg-3">{{__('Registration Approval')}} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <select name="registration_approval" class="form-control select2">
                                        <option value="1" {{ getOption('registration_approval') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                        <option value="0" {{ getOption('registration_approval') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row input__group mb-25">
                                <label class="col-lg-3">Sign up Left Text Title <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="sign_up_left_text_title" value="{{getOption('sign_up_left_text_title')}}" class="form-control" required>
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label class="col-lg-3">Sign up Left Text Subtitle <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="sign_up_left_text_subtitle" value="{{getOption('sign_up_left_text_subtitle')}}" class="form-control" required>
                                </div>
                            </div>

                            <div class="row input__group mb-25">
                                <label class="col-lg-3">Forgot Title <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="forgot_title" value="{{getOption('forgot_title')}}" class="form-control" required>
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label class="col-lg-3">Forgot Subtitle <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="forgot_subtitle" value="{{getOption('forgot_subtitle')}}" class="form-control" required>
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label class="col-lg-3">Forgot Button Name <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="forgot_btn_name" value="{{getOption('forgot_btn_name')}}" class="form-control" required>
                                </div>
                            </div>

                            <hr>

                            <div class="item-top mb-30"><h2>Social Media Profile Link</h2></div>
                            <div class="row input__group mb-25">
                                <label class="col-lg-3">Facebook URL </label>
                                <div class="col-lg-9">
                                    <input type="text" name="facebook_url" value="{{getOption('facebook_url')}}" class="form-control">
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label class="col-lg-3">Instagram URL </label>
                                <div class="col-lg-9">
                                    <input type="text" name="instagram_url" value="{{getOption('instagram_url')}}" class="form-control">
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label class="col-lg-3">LinkedIn URL</label>
                                <div class="col-lg-9">
                                    <input type="text" name="linkedin_url" value="{{getOption('linkedin_url')}}" class="form-control">
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label class="col-lg-3">Twitter URL</label>
                                <div class="col-lg-9">
                                    <input type="text" name="twitter_url" value="{{getOption('twitter_url')}}" class="form-control">
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label class="col-lg-3">Pinterest URL</label>
                                <div class="col-lg-9">
                                    <input type="text" name="pinterest_url" value="{{getOption('pinterest_url')}}" class="form-control">
                                </div>
                            </div>
                            <div class="row input__group mb-25">
                                <label class="col-lg-3">Tiktok URL</label>
                                <div class="col-lg-9">
                                    <input type="text" name="tiktok_url" value="{{getOption('tiktok_url')}}" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="input__group general-settings-btn">
                                        <button type="submit" class="btn btn-blue float-right">{{__('Update')}}</button>
                                    </div>
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
