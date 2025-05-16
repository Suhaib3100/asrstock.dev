<table class="table zTable zTable-last-item-right" id="wallet-datatable">
    <thead>
        <tr>
            <th><div>{{ __('Sl.') }}</div></th>
            <th><div class="text-nowrap">{{ __('Payment ID') }}</div></th>
            <th><div>{{ __('Customer') }}</div></th>
            <th><div>{{ __('Gateway') }}</div></th>
            <th><div>{{ __('Rate') }}</div></th>
            <th><div>{{ __('Amount') }}</div></th>
            <th><div>{{ __('Total') }}</div></th>
            <th><div>{{ __('Status') }}</div></th>
        </tr>
    </thead>
</table>
<input type="hidden" value="{{ route('admin.wallet.all-wallet-list',$status) }}" id="wallet-route">
@push('script')
    <script src="{{ asset('admin/js/custom/wallet.js') }}"></script>
@endpush
