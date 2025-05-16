<table class="table zTable zTable-last-item-right commonDataTable">
    <thead>
        <tr>
            <th><div>{{ __('SL') }}</div></th>
            <th><div>{{ __('Contributor') }}</div></th>
            <th><div>{{ __('Amount') }}</div></th>
            <th><div>{{ __('Method') }}</div></th>
            <th><div>{{ __('Note') }}</div></th>
            <th><div>{{ __('Action') }}</div></th>
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
            <td>{{ $withdraw->customer_note }}</td>
            <td>
                <div class="d-flex justify-content-end align-items-center g-10">
                    <button class="status border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white" data-uuid="{{ $withdraw->uuid }}" data-status="{{ WITHDRAW_STATUS_COMPLETED }}">Completed</button>
                    <button class="cancelledStatus border-0 bd-ra-12 bg-para-text py-13 px-25 fs-16 fw-600 lh-19 text-white" data-uuid="{{ $withdraw->uuid }}" data-status="{{ WITHDRAW_STATUS_CANCELLED }}">Cancelled</button>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
