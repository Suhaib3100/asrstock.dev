@extends('admin.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __(@$pageTitle) }}</h2>
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
                @include('admin.setting.setting-sidebar')
            </div>
            <div class="col-xl-9">
                <h4 class="fs-18 fw-600 lh-22 text-primary-dark-text pb-25">{{ __(@$pageTitle) }}</h4>
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <form class="ajax" action="{{ route('admin.setting.application-settings.update') }}"
                          method="POST" enctype="multipart/form-data" data-handler="commonResponseWithPageLoad">
                        @csrf
                        <div class="row rg-24">
                            <div class="col-xxl-4 col-lg-6">
                                <label class="zForm-label">{{ __('App Name') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="app_name" value="{{ getOption('app_name') }}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="col-xxl-4 col-lg-6">
                                <label class="zForm-label">{{ __('App Email') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="app_email" value="{{ getOption('app_email') }}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="col-xxl-4 col-lg-6">
                                <label class="zForm-label">{{ __('App Contact Number') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="app_contact_number"
                                       value="{{ getOption('app_contact_number') }}" class="form-control zForm-control">
                            </div>
                            <div class="col-xxl-4 col-lg-6 pt-3">
                                <label class="zForm-label">{{ __('App Location') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="app_location" value="{{ getOption('app_location') }}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="col-xxl-4 col-lg-6 pt-3">
                                <label class="zForm-label">{{ __('App Copyright') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="app_copyright" value="{{ getOption('app_copyright') }}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="col-xxl-4 col-lg-6 pt-3">
                                <label class="zForm-label">{{ __('Footer News Letter Title') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="footer_news_letter_title"
                                       value="{{ getOption('footer_news_letter_title') }}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="col-xxl-4 col-lg-6 pt-3">
                                <label class="zForm-label">{{ __('Footer News Letter Description') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="footer_news_letter_description"
                                       value="{{ getOption('footer_news_letter_description') }}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="col-xxl-4 col-lg-6 pt-3">
                                <label class="zForm-label">{{ __('Develop By') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="develop_by" value="{{ getOption('develop_by') }}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="col-xxl-4 col-lg-6 pt-3">
                                <label class="zForm-label">{{ __('Develop By Link') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="develop_by_link" value="{{ getOption('develop_by_link') }}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="col-xxl-4 col-lg-6 pt-3">
                                <label for="app_timezone" class="zForm-label">{{ __('Timezone') }} <span
                                        class="text-danger">*</span></label>
                                <select name="app_timezone" class="form-select sf-select">
                                    @foreach ($timezones as $timezone)
                                        <option value="{{ $timezone }}"
                                            {{ $timezone == getOption('app_timezone') ? 'selected' : '' }}>
                                            {{ $timezone }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xxl-4 col-lg-6 pt-3">
                                <label class="zForm-label">{{ __('Social Media Facebook') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="facebook_url" value="{{ getOption('facebook_url') }}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="col-xxl-4 col-lg-6 pt-3">
                                <label class="zForm-label">{{ __('Social Media Linkedin') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="linkedin_url" value="{{ getOption('linkedin_url') }}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="col-xxl-4 col-lg-6 pt-3 d-none">
                                <label class="zForm-label">{{ __('Social Media Twitter / X') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="twitter_url" value="{{ getOption('twitter_url') }}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="col-xxl-4 col-lg-6 pt-3">
                                <label class="zForm-label">{{ __('Social Media Instagram') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="instagram_url" value="{{ getOption('instagram_url') }}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="col-xxl-4 col-lg-6 pt-3">
                                <label class="zForm-label">{{ __('Social Media Pinterest') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="pinterest_url" value="{{ getOption('pinterest_url') }}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="col-xxl-4 col-lg-6 pt-3">
                                <label class="zForm-label">{{ __('Social Media Tiktok') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="tiktok_url" value="{{ getOption('tiktok_url') }}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="col-xxl-4 col-lg-6 pt-3">
                                <label for="app_timezone" class="zForm-label">{{ __('Registration Approval') }} <span
                                        class="text-danger">*</span></label>
                                <select name="registration_approval" class="form-select select2">
                                    <option
                                        value="1" {{ getOption('registration_approval') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                    <option
                                        value="0" {{ getOption('registration_approval') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                </select>
                            </div>
                            <div class="col-xxl-4 col-lg-6">
                                <label class="zForm-label">{{ __("Free download per day") }} <span class="text-danger">*</span></label>
                                <input type="number" name="free_download_per_day" value="{{getOption('free_download_per_day')}}" class="form-control zForm-control" required>
                            </div>
                            <div class="col-xxl-4 col-lg-6 pt-3">
                                <label for="app_timezone" class="zForm-label">{{ __('Watermark Status') }} <span class="text-danger">*</span></label>
                                <select name="watermark_status" class="form-select select2">
                                    <option value="1" {{ getOption('watermark_status') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                    <option value="0" {{ getOption('watermark_status') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                </select>
                            </div>
                            <div class="col-xxl-4 col-lg-6 pt-3">
                                <label for="app_timezone" class="zForm-label">{{ __('Blog Comment System') }} <span class="text-danger">*</span></label>
                                <select name="comment_status" class="form-select select2">
                                    <option value="1" {{ getOption('comment_status') == 1 ? 'selected':'' }}>{{ __('Active') }}</option>
                                    <option value="0" {{ getOption('comment_status') == 0 ? 'selected':'' }}>{{ __('Deactivate') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="bd-c-stroke bd-t-one d-flex justify-content-end align-items-center pt-24 mt-24">
                            <button type="submit"
                                    class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

