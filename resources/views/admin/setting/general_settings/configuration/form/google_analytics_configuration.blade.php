<div class="d-flex justify-content-between align-items-center g-10 pb-20 mb-20 bd-b-one bd-c-stroke">
    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Google analytics configuration') }}</h5>
    <button type="button"
            class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
            data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<form class="ajax" action="{{ route('admin.setting.settings_env.update') }}" method="post"
      class="form-horizontal" data-handler="commonResponseForModal">
    @csrf
    <div class="pb-24">
        <label class="zForm-label">{{ __('Google Analytics Tracking Id') }} </label>
        <input type="text" min="0" max="100" step="any" name="google_analytics_tracking_id"
               value="{{ getOption('google_analytics_tracking_id') }}" class="zForm-control">
    </div>
    <div class="bd-c-stroke bd-t-one d-flex justify-content-center align-items-center pt-15">
        <button type="submit"
                class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Submit') }}</button>
    </div>
</form>
