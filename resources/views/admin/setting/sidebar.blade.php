<div class="bg-white p-sm-25 p-15 bd-one bd-c-stroke bd-ra-8 mb-24">
    <ul class="settings-sidebar zList-three">
        <li>
            <a href="{{ route('admin.setting.location.country.index') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$subCountryActiveClass }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Country') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.location.state.index') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$subStateActiveClass }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('State') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.location.city.index') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$subCityActiveClass }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('City') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.setting.home.home-settings') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$subHomeActiveClass }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Home') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.home.why-us') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$subWhyUsActiveClass }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Why Us') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.home.testimonial') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$subTestimonialActiveClass }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Testimonial') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.setting.about.gallery-area') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$subGalleryAreaActiveClass }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Gallery Area') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.about.team-member') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$subTeamMemberActiveClass }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Team Member') }}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.setting.contactus.index') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$subContactUsCMSActiveClass }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{__('Contact Us')}}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>

        @can('terms_conditions')
            <li>
                <a href="{{ route('admin.terms-conditions') }}"
                   class="d-flex justify-content-between align-items-center cg-10 {{ @$subNavTermsConditionsActiveClass }}">
                    <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Terms & Conditions') }}</span>
                    <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
                </a>
            </li>
        @endcan
        @can('privacy_policy')
            <li>
                <a href="{{ route('admin.privacy-policy') }}"
                   class="d-flex justify-content-between align-items-center cg-10 {{ @$subNavPrivacyPolicyActiveClass }}">
                    <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Privacy Policy') }}</span>
                    <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
                </a>
            </li>
        @endcan
        @can('cookie_policy')
            <li>
                <a href="{{ route('admin.cookie-policy') }}"
                   class="d-flex justify-content-between align-items-center cg-10 {{ @$subNavCookiePolicyActiveClass }}">
                    <span class="fs-18 fw-600 lh-22 text-title-black">{{ __('Cookie Policy') }}</span>
                    <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
                </a>
            </li>
        @endcan

        <li>
            <a href="{{ route('admin.setting.be-a-contributor') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$subNavBeAContributorActiveClass }}">
                <span class="fs-18 fw-600 lh-22 text-title-black">{{__('Be A Contributor')}}</span>
                <div class="d-flex text-title-black"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
    </ul>
</div>
