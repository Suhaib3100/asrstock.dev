<div class="bg-white bottom-0 cookie-consent fixed inset-x-0 js-cookie-consent pb-2 text-light w-100">
    <div class="max-w-7xl mx-auto px-6">
        <div class="p-2 rounded-lg bg-yellow-100">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 items-center hidden md:inline pt-2">
                    <p class="ml-3 text-black cookie-consent__message">
                        @if (!empty(getOption('cookie_consent_text')))
                            {{ __(getOption('cookie_consent_text')) }}
                        @else
                            {!! trans('cookie-consent::texts.message') !!}
                        @endif
                    </p>
                </div>
                <div class="mt-2 flex-shrink-0 w-full sm:mt-0 sm:w-auto">
                    <button
                        class="js-cookie-consent-agree fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one border-0">
                        {{ trans('cookie-consent::texts.agree') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
