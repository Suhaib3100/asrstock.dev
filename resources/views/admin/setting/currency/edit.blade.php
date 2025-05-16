<div class="d-flex justify-content-between align-items-center g-10 pb-20 mb-20 bd-b-one bd-c-stroke">
    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Update Currency') }}</h5>
    <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<form class="ajax" data-handler="commonResponseWithPageLoad" action="{{ route('admin.setting.currency.update', [$currency->id]) }}" method="post">
    @csrf
    @method('PATCH')
    <div class="pb-24">
        <div class="row rg-24">
            <div class="col-12">

                    <label class="zForm-label" for="currency_code">{{ __('Currency ISO Code') }}</label>
                    <select class="form-select" id="currency_code"
                            name="currency_code">
                        @foreach(getCurrency() as $code => $currencyItem)
                            <option
                                value="{{$code}}" {{ $code == $currency->currency_code ? 'selected' : '' }}>{{$currencyItem}}</option>
                        @endforeach
                    </select>

            </div>
            <div class="col-12">

                    <label class="zForm-label" for="symbol">{{ __('Symbol') }}</label>
                    <input class="zForm-control" type="text" name="symbol" id="symbol" placeholder="Type symbol"  value="{{ $currency->symbol }}">


            </div>
            <div class="col-12">

                    <label class="zForm-label" for="currency_placement">{{ __('Currency Placement') }}</label>
                    <select class="form-select" name="currency_placement" id="">
                        <option value="before" @if($currency->currency_placement == 'before') selected @endif>Before Amount</option>
                        <option value="after" @if($currency->currency_placement == 'after') selected @endif>After Amount</option>
                    </select>


            </div>
            <div class="col-12">
                <div class="d-flex form-check g-10">
                    <div class="zCheck form-switch">
                        <input class="form-check-input mt-0" value="1" name="current_currency"
                               {{ $currency->current_currency == ACTIVE ? 'checked' : '' }}
                               type="checkbox" id="flexCheckChecked--{{$currency->id}}">
                    </div>
                    <label class="form-check-label d-flex" for="flexCheckChecked-{{ $currency->id }}">
                        {{ __('Current Currency') }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="bd-c-stroke bd-t-one justify-content-end align-items-center text-end pt-15">
        <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Save') }}</button>
    </div>
</form>
