<div class="d-flex justify-content-between align-items-center g-10 pb-20 mb-20 bd-b-one bd-c-stroke">
    <h5 class="fs-18 fw-500 lh-28 text-primary-dark-text">{{ __('Update Gateway') }}</h5>
    <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<form class="ajax" data-handler="commonResponseWithPageLoad" action="{{ route('admin.setting.gateway.store') }}"
      method="post">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ $gateway->id }}">
    <input type="hidden" name="gateway_slug" value="{{ $gateway->gateway_slug }}">
    <div class="pb-24">
        <div class="row rg-24">
            <div class="col-md-4">
                <label class="zForm-label" for="gateway_name">{{ __('Gateway Name') }}</label>
                <input class="zForm-control" type="text" name="gateway_name" id="gateway_name" placeholder="Type gateway name" value="{{ $gateway->gateway_name }}">
            </div>
            @if($gateway->gateway_slug == 'wallet')
                <div class="col-md-4">
                    <label class="zForm-label" for="mode">{{ __('Status') }} <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select">
                        <option value="1" {{ @$gateway->status == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option
                            value="0" {{ @$gateway->status != 1 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                    </select>
                </div>
            @else
                @if(($gateway->gateway_slug != 'bank') && ($gateway->gateway_slug != 'cash'))
                    <div class="col-md-4">
                        <label class="zForm-label" for="mode">{{ __('Mode') }} <span class="text-danger">*</span></label>
                        <select name="mode" id="mode" class="form-select">
                            <option
                                value="sandbox" {{ @$gateway->gateway_parameters->mode == 'sandbox' ? 'selected' : '' }}>{{ __('Sandbox') }}</option>
                            <option
                                value="live" {{ @$gateway->gateway_parameters->mode == 'live' ? 'selected' : '' }}>{{ __('Live') }}</option>
                        </select>
                    </div>
                @endif
                <div class="col-md-4">
                    <label class="zForm-label" for="mode">{{ __('Status') }} <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select">
                        <option value="1" {{ @$gateway->status == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option
                            value="0" {{ @$gateway->status != 1 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="zForm-label" for="gateway_currency">{{ __('Gateway Currency') }} <span class="text-danger">*</span></label>
                            <select name="gateway_currency" class="form-select gateway_currency">
                                @foreach(getCurrency() as $code => $currency)
                                    <option
                                        value="{{$code}}" {{ $gateway->gateway_currency == $code ? 'selected' : '' }}>{{$currency}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="zForm-label">{{ __('Conversion Rate') }} </label>
                                <div class="input-group">
                                                <span class="input-group-text">{{ '1 ' . getCurrencySymbol() . ' = ' }}</span>
                                    <input type="number" step="any" min="0" name="conversion_rate"
                                           value="{{ @$gateway->conversion_rate }}" class="form-control"
                                           required>
                                    <span class="input-group-text gateway_append_currency"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-25">
                                <label class="zForm-label" for="mode">{{ __('Wallet Gateway Status') }} <span
                                        class="text-danger">*</span></label>
                                <select name="wallet_gateway_status" id="wallet_gateway_status" class="form-select">
                                    <option
                                        value="1" {{ @$gateway->wallet_gateway_status == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option
                                        value="0" {{ @$gateway->wallet_gateway_status != 1 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @if ($gatewaySettings)
                        <div class="col-md-12">
                            <div class="row rg-20">
                                @foreach ($gatewaySettings as $gatewaySetting)
                                    @if ($gatewaySetting['name'] == 'url' && $gatewaySetting['is_show'] == 1)
                                        <div class="col-md-6">
                                            <label for="addPaymentClientID"
                                                   class="zForm-label">{{ __($gatewaySetting['label']) }}</label>
                                            <input type="text" name="url" value="{{ $gateway->url }}"
                                                   class="form-control zForm-control" id="addPaymentClientID"
                                                   placeholder="{{ __($gatewaySetting['label']) }}"/>
                                        </div>
                                    @endif
                                    @if ($gatewaySetting['name'] == 'key' && $gatewaySetting['is_show'] == 1)
                                        <div class="col-md-6">
                                            <label for="addPaymentClientID"
                                                   class="zForm-label">{{ __($gatewaySetting['label']) }}</label>
                                            <input type="text" name="key" value="{{ $gateway->key }}"
                                                   class="form-control zForm-control" id="addPaymentClientID"
                                                   placeholder="{{ __($gatewaySetting['label']) }}"/>
                                            <small
                                                class="d-none small">{{ __('Client id, Public Key, Key, Store id, Api Key') }}</small>
                                        </div>
                                    @endif
                                    @if ($gatewaySetting['name'] == 'secret' && $gatewaySetting['is_show'] == 1)
                                        <div class="col-md-6">
                                            <label for="addPaymentSecret"
                                                   class="zForm-label">{{ __($gatewaySetting['label']) }}</label>
                                            <input type="text" name="secret" value="{{ $gateway->secret }}"
                                                   class="form-control zForm-control" id="addPaymentSecret"
                                                   placeholder="{{ __($gatewaySetting['label']) }}"/>
                                            <small
                                                class="d-none small">{{ __('Client Secret, Secret, Store Password, Auth Token') }}</small>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                @if ($gateway->gateway_slug == 'bank')
                    <div class="row rg-20">
                        <div class="col-md-12 mt-20">
                            <div class="d-flex justify-content-between align-items-center g-10 pb-8">
                                <h4 class="fs-14 fw-500 lh-20 text-primary-dark-text">{{ __('Bank Details') }}</h4>
                                <button type="button"
                                        class="btn btn-purple addBankBtn">+
                                </button>
                            </div>
                            <ul class="zList-pb-16 bankItemLists">
                                @foreach ($gatewayBanks as $bank)
                                    <li class="d-flex justify-content-between align-items-center g-10">
                                        <input type="hidden" name="bank[id][]" value="{{ $bank->id }}">
                                        <div class="d-flex flex-grow-1 gap-2 pt-3 left">
                                            <div class="flex-grow-1">
                                                <input type="text" class="form-control zForm-control"
                                                       placeholder="Name" name="bank[name][]"
                                                       value="{{ $bank->name }}">
                                            </div>
                                            <div class="flex-grow-1">
                                                <textarea name="bank[details][]" class="form-control zForm-control"
                                                          placeholder="Details">{{ $bank->details }}</textarea>
                                            </div>
                                        </div>
                                        <button type="button"
                                                class="flex-shrink-0 bd-one bd-c-stroke rounded-circle w-25 h-25 d-flex justify-content-center align-items-center bg-transparent text-danger removedBankBtn">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

            @endif
        </div>
    </div>
    <div class="bd-c-stroke bd-t-one d-flex justify-content-end align-items-center pt-15">
        <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Save') }}</button>
    </div>
</form>
