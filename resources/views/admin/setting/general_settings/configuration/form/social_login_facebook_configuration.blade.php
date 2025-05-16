<div class="d-flex justify-content-between align-items-center g-10 pb-20 mb-20 bd-b-one bd-c-stroke">
    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Social Login (Facebook) Configuration') }}</h5>
    <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<form class="ajax" action="{{ route('admin.setting.settings_env.update') }}" method="POST"
      enctype="multipart/form-data" data-handler="commonResponseForModal">
    @csrf
    <div class="row rg-24">
        <div class="col-lg-12">
            <label class="zForm-label">{{ __('Facebook Client ID') }}</label>
            <input type="text" name="facebook_client_id" id="facebook_client_id"
                   value="{{ getOption('facebook_client_id') }}" class="form-control zForm-control">
        </div>
        <div class="col-lg-12">
            <label class="zForm-label">{{ __('Facebook Client Secret') }} </label>
            <input type="text" name="facebook_client_secret" id="facebook_client_secret" value="{{ getOption('facebook_client_secret') }}" class="form-control zForm-control">
        </div>
        <div class="col-lg-12">
            <label class="zForm-label">{{ __('Set callback URL') }} : <strong>{{ url('/auth/facebook/callback') }}</strong></label>
        </div>
    </div>
    <div class="bd-c-stroke bd-t-one d-flex justify-content-between align-items-center pt-15">
        <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Submit') }}</button>
    </div>
</form>
