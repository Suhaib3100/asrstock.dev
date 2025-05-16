<table class="table zTable zTable-last-item-right commonDataTable">
    <thead>
    <tr>
        <th>
            <div>{{__('Sl.')}}</div>
        </th>
        <th>
            <div class="text-nowrap">{{__('Transaction No')}}</div>
        </th>
        <th>
            <div class="text-nowrap">{{__('Referred Customer')}}</div>
        </th>
        <th>
            <div class="text-nowrap">{{__('Plan Name')}}</div>
        </th>
        <th>
            <div class="text-nowrap">{{__('Actual Amount')}}</div>
        </th>
        <th>
            <div class="text-nowrap">{{__('Earned Amount')}}</div>
        </th>
        <th>
            <div>{{__('Commission')}} %</div>
        </th>
        <th>
            <div>{{__('Status')}}</div>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($referralHistories as $referralHistory)
        <tr class="removable-item">
            <td>{{$loop->iteration}}</td>
            <td>{{ $referralHistory->transaction_no }}</td>
            <td>{{ @$referralHistory->referralCustomer->name }}</td>
            <td>{{ $referralHistory->plan_name }}</td>
            <td>{{ getAmountPlace($referralHistory->actual_amount) }}</td>
            <td>{{ getAmountPlace($referralHistory->earned_amount) }}</td>
            <td>{{ $referralHistory->commission_percentage .'%' }}</td>
            <td>
                @if($referralHistory->status == REFERRAL_HISTORY_STATUS_PAID)
                    <span class="zBadge zBadge-paid">{{ __('Paid') }}</span>
                @elseif($referralHistory->status == REFERRAL_HISTORY_STATUS_DUE)
                    <span class="zBadge zBadge-due">{{ __('Due') }}</span>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
