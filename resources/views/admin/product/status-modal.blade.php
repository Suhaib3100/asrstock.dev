<div class="d-flex justify-content-between align-items-center g-10 pb-20 mb-20 bd-b-one bd-c-stroke">
    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Update Status') }}</h5>
    <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<form method="post" class="form-horizontal" action="{{ route('admin.product.status.update', [$product->id]) }}">
    @csrf
    <div class="pb-20">
        <div class="input__group">
            <label for="currency_placement" class="zForm-label">{{ __('Status') }}</label>
            <select name="status">
                <option value="{{PRODUCT_STATUS_PUBLISHED}}" @if($product->status == PRODUCT_STATUS_PUBLISHED) selected @endif>{{__('Publish')}}</option>
                <option value="{{PRODUCT_STATUS_PENDING}}" @if($product->status == PRODUCT_STATUS_PENDING) selected @endif>{{__('Pending')}}</option>
                <option value="{{PRODUCT_STATUS_HOLD}}" @if($product->status == PRODUCT_STATUS_HOLD) selected @endif>{{__('Hold')}}</option>
            </select>
        </div>
    </div>
    <div class="bd-c-stroke bd-t-one justify-content-between align-items-center text-end pt-15">
        <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Save') }}</button>
    </div>
</form>
