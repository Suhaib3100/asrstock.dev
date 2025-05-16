<div class="d-flex justify-content-between align-items-center g-10 pb-20 mb-20 bd-b-one bd-c-stroke">
    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Update Status') }}</h5>
    <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<form method="post" class="ajax" data-handler="commonResponseWithPageLoad" action="{{ route('admin.order.bank.status.update', [$order->id]) }}">
    @csrf
    <div class="pb-24 row rg-24">
        <div class="col-12">
            <label class="zForm-label" for="currency_placement">{{ __('Status') }}</label>
            <select class="form-select" name="payment_status">
                <option value="{{ORDER_PAYMENT_STATUS_PAID}}" @if($order->payment_status == ORDER_PAYMENT_STATUS_PAID) selected @endif>{{__('Paid')}}</option>
                <option value="{{ORDER_PAYMENT_STATUS_CANCELLED}}" @if($order->payment_status == ORDER_PAYMENT_STATUS_CANCELLED) selected @endif>{{__('Cancel')}}</option>
            </select>
        </div>
    </div>
    <div class="bd-c-stroke bd-t-one justify-content-between align-items-center text-end pt-15">
        <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Save') }}</button>
    </div>
</form>
