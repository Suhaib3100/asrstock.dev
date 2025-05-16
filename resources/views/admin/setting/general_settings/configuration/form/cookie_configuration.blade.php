<div class="d-flex justify-content-between align-items-center g-10 pb-20 mb-20 bd-b-one bd-c-stroke">
    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Cookie Configuration') }}</h5>
    <button type="button"
            class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
            data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<form class="ajax" action="{{ route('admin.setting.settings_env.update') }}" method="post"
      data-handler="commonResponseWithPageLoad">
    @csrf
    <div class="pb-24">
        <label class="zForm-label">{{ __('Cookie Consent Text 1') }} </label>
        <textarea class="zForm-control min-h-157"
                  name="cookie_consent_text">{{ getOption('cookie_consent_text') }}</textarea>
    </div>
    <div class="bd-c-stroke bd-t-one d-flex justify-content-center align-items-center pt-15">
        <button type="submit"
                class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Submit') }}</button>
    </div>
</form>
