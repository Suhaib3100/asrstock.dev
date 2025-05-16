<div class="border-top d-flex flex-column pb-20 pb-sm-30 pt-20 rg-20 d-none" id="bankBlock">
    <div class="">
        <label for="bank_id" class="zForm-label">{{ __('Bank') }}<span class="text-primary">*</span></label>
        <select class="sf-select-without-search" name="bank_id" id="bank_id">
            <option value="">{{ __('Select Bank') }}</option>
            @foreach($banks as $bank)
                <option {{ old('bank_id') == $bank->id ? 'selected' : '' }} data-details="{{ $bank->details }}" value="{{ $bank->id }}">{{ $bank->name }}</option>
            @endforeach
        </select>
        @error('bank_id')
        <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>
    <div class="">
        <label class="zForm-label">{{ __('Bank Slip') }}<span class="text-primary">*</span></label>
        <div class="file-upload-one">
            <label for="mAttachment">
                <p class="fileName fs-14 fw-400 lh-24 text-para-text">{{ __('Choose File to upload') }}</p>
                <p class="fs-14 fw-600 lh-24 text-white">{{ __('Browse File') }}</p>
            </label>
            <input type="file" name="bank_slip" id="mAttachment" class="fileUploadInput invisible position-absolute top-0 w-100 h-100">
        </div>
        @error('bank_slip')
        <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>
</div>
