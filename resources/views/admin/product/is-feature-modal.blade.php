<div class="d-flex justify-content-between align-items-center g-10 pb-20 mb-20 bd-b-one bd-c-stroke">
    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Update Is Feature') }}</h5>
    <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<form class="form-horizontal" action="{{ route('admin.product.is.feature.update', [$product->id]) }}" method="post">
    @csrf
    <div class="mb-20">
        <div class="input__group">
            <label for="currency_placement" class="zForm-label">{{ __("Update Editor's Choice") }}</label>
            <select name="is_featured">
                <option value="{{PRODUCT_IS_FEATURED_YES}}" @if($product->is_featured == PRODUCT_IS_FEATURED_YES) selected @endif>{{__('Yes')}}</option>
                <option value="{{PRODUCT_IS_FEATURED_NO}}" @if($product->is_featured == PRODUCT_IS_FEATURED_NO) selected @endif>{{__('No')}}</option>
            </select>
        </div>
    </div>
    <div class="bd-c-stroke bd-t-one justify-content-between align-items-center text-end pt-15">
        <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Save') }}</button>
    </div>
</form>
