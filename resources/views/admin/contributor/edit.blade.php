<div class="d-flex justify-content-between align-items-center g-10 pb-20 mb-20 bd-b-one bd-c-stroke">
    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Update Status') }}</h5>
    <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<form class="ajax" data-handler="commonResponseWithPageLoad" action="{{ route('admin.contributor.status.update', [$contributor->id]) }}" method="post">
    @csrf
    <div class="pb-20">
        <div class="input__group">
            <label for="currency_placement" class="zForm-label">{{ __('Contributor Status Change') }}</label>
            <select name="contributor_status" id="">
                <option value="{{CONTRIBUTOR_STATUS_APPROVED}}" @if($contributor->contributor_status == CONTRIBUTOR_STATUS_APPROVED) selected @endif>{{__('Active')}}</option>
                <option value="{{CONTRIBUTOR_STATUS_PENDING}}" @if($contributor->contributor_status == CONTRIBUTOR_STATUS_PENDING) selected @endif>{{__('Pending')}}</option>
                <option value="{{CONTRIBUTOR_STATUS_HOLD}}" @if($contributor->contributor_status == CONTRIBUTOR_STATUS_HOLD) selected @endif>{{__('Hold')}}</option>
                <option value="{{CONTRIBUTOR_STATUS_CANCELLED}}" @if($contributor->contributor_status == CONTRIBUTOR_STATUS_CANCELLED) selected @endif>{{__('Cancel')}}</option>
            </select>
        </div>
    </div>
    <div class="bd-c-stroke bd-t-one justify-content-between align-items-center text-end pt-15">
        <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Save') }}</button>
    </div>
</form>
