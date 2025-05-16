@extends('admin.layouts.app')

@push('title')
{{ $pageTitle }}
@endpush
@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ @$pageTitle }}</h2>
        </div>
        <div class="">
            <div class="">
                <input type="hidden" id="statusChangeRoute"
                       value="{{ route('admin.setting.configuration-settings.update') }}">
                <input type="hidden" id="configureUrl"
                       value="{{ route('admin.setting.configuration-settings.configure') }}">
                <input type="hidden" id="helpUrl" value="{{ route('admin.setting.configuration-settings.help') }}">
                <form class="ajax" action="{{ route('admin.setting.configuration-settings.update') }}" method="POST"
                      enctype="multipart/form-data" data-handler="settingCommonHandler">
                    @csrf
                    <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                        <table class="table zTable zTable-last-item-right commonDataTableWithOutPagination">
                            <thead>
                                <tr>
                                    <th><div>{{ __('Extension') }}</div></th>
                                    <th><div>{{__('Status')}}</div></th>
                                    <th><div>{{__('Action')}}</div></th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <h6>{{ __('E-mail credentials status') }}</h6>
                                    <small class="fst-italic fw-normal text-para-text">({{ __('If you enable this. The system will
                                    enable for sending email') }}
                                        )</small>
                                </td>
                                <td class="text-center pt-17">
                                    <div class="zCheck form-switch">
                                        <input class="form-check-input mt-0"
                                               onchange="changeSettingStatus(this,'app_mail_status')" value="1" {{
                                        getOption('app_mail_status')==ACTIVE ? 'checked' : '' }}
                                               name="app_mail_status" type="checkbox" role="switch"
                                               id="app_mail_status">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end align-items-end g-10">
                                        <button type="button"
                                                class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"
                                                onclick="configureModal('app_mail_status')"
                                                title="{{ __('Configure') }}">
                                            {{ __('Configure') }}
                                        </button>
                                        <button type="button"
                                                class="border-0 bg-green py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"
                                                onclick="helpModal('app_mail_status')" title="{{ __('Help') }}">
                                            {{ __('Help') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="d-none">
                                <td>
                                    <h6>{{ __('SMS credentials status') }}</h6>
                                    <small class="fst-italic fw-normal text-para-text">({{ __('If you enable this. The system will
                                    enable for sending sms') }}
                                        )</small>
                                </td>
                                <td class="text-center pt-17">
                                    <div class="zCheck form-switch">
                                        <input class="form-check-input mt-0"
                                               onchange="changeSettingStatus(this,'app_sms_status')" value="1" {{
                                        getOption('app_sms_status')==ACTIVE ? 'checked' : '' }}
                                               name="app_sms_status" type="checkbox" role="switch" id="app_sms_status">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end align-items-end g-10">
                                        <button type="button"
                                                class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"
                                                onclick="configureModal('app_sms_status')"
                                                title="{{ __('Configure') }}">
                                            {{ __('Configure') }}
                                        </button>
                                        <button type="button"
                                                class="border-0 bg-green py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"
                                                onclick="helpModal('app_sms_status')" title="{{ __('Help') }}">
                                            {{ __('Help') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6>{{ __('Social Login (Google)') }}</h6>
                                    <small class="fst-italic fw-normal text-para-text">({{ __('If you enable this. The system will
                                    enable for Google. User can use our gmail account and sign in') }}
                                        )</small>
                                </td>
                                <td class="text-center pt-17">
                                    <div class="zCheck form-switch">
                                        <input class="form-check-input mt-0"
                                               onchange="changeSettingStatus(this,'google_login_status')" value="1" {{
                                        getOption('google_login_status')==ACTIVE ? 'checked' : '' }}
                                               name="google_login_status" type="checkbox" role="switch"
                                               id="google_login_status">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end align-items-end g-10">
                                        <button type="button"
                                                class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"
                                                onclick="configureModal('google_login_status')"
                                                title="{{ __('Configure') }}">
                                            {{ __('Configure') }}
                                        </button>
                                        <button type="button"
                                                class="border-0 bg-green py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"
                                                onclick="helpModal('google_login_status')" title="{{ __('Help') }}">
                                            {{ __('Help') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6>{{ __('Social Login (Facebook)') }}</h6>
                                    <small class="fst-italic fw-normal text-para-text">({{ __('If you enable this. The system will
                                    enable for Facebook. User can use our facebook account and sign in')
                                    }})</small>
                                </td>
                                <td class="text-center pt-17">
                                    <div class="zCheck form-switch">
                                        <input class="form-check-input mt-0"
                                               onchange="changeSettingStatus(this,'facebook_login_status')" value="1"
                                               {{ getOption('facebook_login_status')==ACTIVE ? 'checked' : '' }}
                                               name="facebook_login_status" type="checkbox" role="switch"
                                               id="facebook_login_status">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end align-items-end g-10">
                                        <button type="button"
                                                class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"
                                                onclick="configureModal('facebook_login_status')"
                                                title="{{ __('Configure') }}">
                                            {{ __('Configure') }}
                                        </button>
                                        <button type="button"
                                                class="border-0 bg-green py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"
                                                onclick="helpModal('facebook_login_status')" title="{{ __('Help') }}">
                                            {{ __('Help') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6>{{ __('Google Analytics') }}</h6>
                                    <small class="fst-italic fw-normal text-para-text">({{ __('If you enable this. The system will
                                    enable for google analytics. ') }}
                                        )</small>
                                </td>
                                <td class="text-center pt-17">
                                    <div class="zCheck form-switch">
                                        <input class="form-check-input mt-0"
                                               onchange="changeSettingStatus(this,'google_analytics_status')" value="1"
                                               {{ getOption('google_analytics_status')==ACTIVE ? 'checked' : ''
                                               }} name="google_analytics_status" type="checkbox" role="switch"
                                               id="google_analytics_status">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end align-items-end g-10">
                                        <button type="button"
                                                class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"
                                                onclick="configureModal('google_analytics_status')"
                                                title="{{ __('Configure') }}">
                                            {{ __('Configure') }}
                                        </button>
                                        <button type="button"
                                                class="border-0 bg-green py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"
                                                onclick="helpModal('google_analytics_status')" title="{{ __('Help') }}">
                                            {{ __('Help') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6>{{ __('Cookie Consent') }}</h6>
                                    <small class="fst-italic fw-normal text-para-text">({{ __('If you enable this. The system will
                                    enable for cookie consent settings. User Can manage cookie consent setting')
                                    }}
                                        )</small>
                                </td>
                                <td class="text-center pt-17">
                                    <div class="zCheck form-switch">
                                        <input class="form-check-input mt-0"
                                               onchange="changeSettingStatus(this,'cookie_status')" value="1" {{
                                        getOption('cookie_status')==ACTIVE ? 'checked' : '' }}
                                               name="cookie_status" type="checkbox" role="switch" id="cookie_status">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end align-items-end g-10">
                                        <button type="button"
                                                class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"
                                                onclick="configureModal('cookie_status')" title="{{ __('Configure') }}">
                                            {{ __('Configure') }}
                                        </button>
                                        <button type="button"
                                                class="border-0 bg-green py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"
                                                onclick="helpModal('cookie_status')" title="{{ __('Help') }}">
                                            {{ __('Help') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6>{{ __('Preloader') }}</h6>
                                    <small class="fst-italic fw-normal text-para-text">({{ __('If you enable preloader, the
                                    preloader will be show before load the content.') }}
                                        )</small>
                                </td>
                                <td class="text-center pt-17">
                                    <div class="zCheck form-switch">
                                        <input class="form-check-input mt-0"
                                               onchange="changeSettingStatus(this,'app_preloader_status')" value="1" {{
                                        getOption('app_preloader_status')==ACTIVE ? 'checked' : '' }}
                                               name="app_preloader_status" type="checkbox" role="switch"
                                               id="app_preloader_status">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end align-items-end g-10">
                                        <button type="button"
                                                class="border-0 bg-green py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"
                                                onclick="helpModal('app_preloader_status')" title="{{ __('Help') }}">
                                            {{ __('Help') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6>{{ __('Show Language Switcher') }}</h6>
                                    <small class="fst-italic fw-normal text-para-text">({{ __('If you enable this. The system will
                                    enable for show language switcher. By wearing it you will know how this
                                    setting works.') }}
                                        )</small>
                                </td>
                                <td class="text-center pt-17">
                                    <div class="zCheck form-switch">
                                        <input class="form-check-input mt-0"
                                               onchange="changeSettingStatus(this,'show_language_switcher')" value="1"
                                               {{ getOption('show_language_switcher')==ACTIVE ? 'checked' : ''
                                               }} name="show_language_switcher" type="checkbox" role="switch"
                                               id="show_language_switcher">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end align-items-end g-10">
                                        <button type="button"
                                                class="border-0 bg-green py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white"
                                                onclick="helpModal('show_language_switcher')" title="{{ __('Help') }}">
                                            {{ __('Help') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
<div class="modal fade main-modal" id="configureModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 bd-ra-4 p-sm-25 p-15">

        </div>
    </div>
</div>

<!-- Configuration section end -->
<!-- Help section start -->
<div class="modal fade main-modal" id="helpModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 bd-ra-4 p-sm-25 p-15">

        </div>
    </div>
</div>
<!-- Help section end -->

<!-- TEST SMS section end -->
@endsection
@push('script')
<script src="{{ asset('admin/js/custom/configuration.js') }}"></script>
@endpush
