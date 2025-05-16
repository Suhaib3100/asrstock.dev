<table class="table zTable zTable-last-item-right commonDataTable">
    <thead>
    <tr>
        <th><div>{{__('Sl.')}}</div></th>
        <th><div class="text-nowrap">{{__('Month-Year')}}</div></th>
        <th><div class="text-nowrap">{{__('Total Download')}}</div></th>
        <th><div class="text-nowrap">{{__('Total Income From Plan')}}</div></th>
        <th><div class="text-nowrap">{{__('Admin Commission')}}</div></th>
        <th><div class="text-nowrap">{{__('Contributor Commission')}}</div></th>
        <th><div class="text-nowrap">{{__('Get Commission Per Download')}}</div></th>
    </tr>
    </thead>
    <tbody>
    @foreach($monthlyEarningHistories as $monthlyEarningHistory)
        <tr class="removable-item">
            <td>{{$loop->iteration}}</td>
            <td>{{ $monthlyEarningHistory->month_year }}</td>
            <td>{{ $monthlyEarningHistory->total_download }}</td>
            <td>{{ $monthlyEarningHistory->total_income_from_plan }}</td>
            <td>{{ $monthlyEarningHistory->admin_commission_percentage . ' %' }} ({{ getAmountPlace($monthlyEarningHistory->admin_commission) }})</td>
            <td>{{ $monthlyEarningHistory->contributor_commission_percentage . ' %' }} ({{ getAmountPlace($monthlyEarningHistory->contributor_commission) }})</td>
            <td>{{ $monthlyEarningHistory->get_commission_per_download }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
