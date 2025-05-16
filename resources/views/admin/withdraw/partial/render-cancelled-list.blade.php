<table class="table zTable zTable-last-item-right commonDataTable">
    <thead>
    <tr>
        <th><div>{{ __('SL') }}</div></th>
        <th><div class="text-nowrap">{{ __('Contributor Details') }}</div></th>
        <th><div>{{ __('Amount') }}</div></th>
        <th><div>{{ __('Method') }}</div></th>
        <th><div>{{ __('Note') }}</div></th>
        <th><div class="text-nowrap text-red">{{ __('Cancel Reason') }}</div></th>
    </tr>
    </thead>
    <tbody>
    @foreach($withdraws as $withdraw)
        <tr class="removable-item">
            <td>{{$loop->iteration}}</td>
            <td>{{@$withdraw->customer->email}}</td>
            <td>{{getAmountPlace(@$withdraw->amount)}}</td>
            <td>
                <div class="d-flex align-items-center">
                    {{getBeneficiary($withdraw->beneficiary?->type)}}
                    <span class="ms-2" data-bs-toggle="tooltip"
                          title="{{htmlspecialchars($withdraw->beneficiary_details)}}">
                            <i class="fas fa-info-circle"></i>
                        </span>
                </div>
            </td>
            <td>
                {{ $withdraw->customer_note }}
            </td>
            <td class="text-danger fw-bold">{{ $withdraw->cancel_reason }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
