<div class="d-flex justify-content-between align-items-center g-10 pb-20 mb-20 bd-b-one bd-c-stroke">
    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Mail Configuration') }}</h5>
    <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<form class="ajax" action="{{ route('admin.setting.settings_env.update') }}" method="POST"
       data-handler="commonResponseWithPageLoad">
    @csrf
    <div class="row rg-24 pb-24">
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
            <label class="zForm-label">{{ __('MAIL MAILER') }} <span class="text-danger">*</span></label>
            <input type="text" name="MAIL_MAILER" value="{{ env('MAIL_MAILER') }}"
                   class="form-control zForm-control">
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
            <label class="zForm-label">{{ __('MAIL HOST') }} <span class="text-danger">*</span></label>
            <input type="text" name="MAIL_HOST" value="{{ env('MAIL_HOST') }}"
                   class="form-control zForm-control">
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
            <label class="zForm-label">{{ __('MAIL PORT') }} <span class="text-danger">*</span></label>
            <input type="text" name="MAIL_PORT" value="{{ env('MAIL_PORT') }}"
                   class="form-control zForm-control">
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
            <label class="zForm-label">{{ __('MAIL USERNAME') }} <span class="text-danger">*</span></label>
            <input type="text" name="MAIL_USERNAME" value="{{ env('MAIL_USERNAME') }}"
                   class="form-control zForm-control">
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
            <label class="zForm-label">{{ __('MAIL PASSWORD') }} <span class="text-danger">*</span></label>
            <input type="password" name="MAIL_PASSWORD" value="{{ env('MAIL_PASSWORD') }}"
                   class="form-control zForm-control">
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
            <label for="MAIL_ENCRYPTION" class="zForm-label">{{ __('MAIL ENCRYPTION') }}<span
                    class="text-danger">*</span></label>
            <select name="MAIL_ENCRYPTION" class="form-control zForm-control sf-select-edit-modal">
                <option value="tls" {{ env('MAIL_ENCRYPTION') == 'tls' ? 'selected' : '' }}>
                    {{ __('tls') }}
                </option>
                <option value="ssl" {{ env('MAIL_ENCRYPTION') == 'ssl' ? 'selected' : '' }}>
                    {{ __('ssl') }}
                </option>
            </select>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
            <label class="zForm-label">{{ __('MAIL FROM ADDRESS') }} <span class="text-danger">*</span></label>
            <input type="text" name="MAIL_FROM_ADDRESS" value="{{ env('MAIL_FROM_ADDRESS') }}"
                   class="form-control zForm-control">
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
            <label class="zForm-label">{{ __('MAIL FROM NAME') }} <span class="text-danger">*</span></label>
            <input type="text" name="MAIL_FROM_NAME" value="{{ env('MAIL_FROM_NAME') }}"
                   class="form-control zForm-control">
        </div>
    </div>
    <div class="bd-c-stroke bd-t-one justify-content-between align-items-center text-end pt-15">
        <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Submit') }}</button>
    </div>
</form>
