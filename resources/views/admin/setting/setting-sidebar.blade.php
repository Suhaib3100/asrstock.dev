<div class="bg-white p-sm-25 p-15 bd-one bd-c-stroke bd-ra-8 mb-24">
    <ul class="settings-sidebar zList-three">
        <li>
            <a href="{{ route('admin.setting.application-settings') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{@$subApplicationSettingsActiveClass}}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Application Setting') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.logo-settings') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{@$subLogoSettingsActiveClass}}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Logo Setting') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.storage.index') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{@$subStorageSettingsActiveClass}}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Storage Settings') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.currency.index') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$subCurrencyActiveClass }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Currency ') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.maintenance') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$subMaintenanceModeActiveClass }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Maintenance Mode') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.meta.index') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$subMetaIndexActiveClass }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Meta Management') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a class="d-flex justify-content-between align-items-center cg-10 {{ @$subSourceActiveClass }}"
               href="{{ route('admin.setting.source.index') }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Source') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a class="d-flex justify-content-between align-items-center cg-10 {{ @$subTaxActiveClass }}"
               href="{{ route('admin.setting.tax.index') }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Tax') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a class="d-flex justify-content-between align-items-center cg-10 {{ @$subGoogleAdsenseSettingActiveClass }}"
               href="{{ route('admin.setting.google.adsense') }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Google Adsense Setting') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a class="d-flex justify-content-between align-items-center cg-10 {{ @$subColorSettingActiveClass }}"
               href="{{ route('admin.setting.color-settings') }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Color Setting') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a class="d-flex justify-content-between align-items-center cg-10 {{ @$navGatewaySettingsActiveClass }}"
               href="{{ route('admin.setting.gateway.index') }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Gateway Setting') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a class="d-flex justify-content-between align-items-center cg-10 {{ @$navLanguageActiveClass }}"
               href="{{ route('admin.setting.language.index') }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Language Setting') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        @if(isAddonInstalled('PIXELDONATION'))
            <li>
                <a class="d-flex justify-content-between align-items-center cg-10 {{ @$navMarketPlaceSetUpActiveClass }}"
                   href="{{ route('admin.setting.marketplace.setup') }}">
                    <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Donation Setup') }}</span>
                    <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
                </a>
            </li>
        @endif
        <li>
            <a class="d-flex justify-content-between align-items-center cg-10 {{ @$subCacheActiveClass }}"
               href="{{ route('admin.setting.cache-settings') }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Cache Settings') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
    </ul>
</div>

