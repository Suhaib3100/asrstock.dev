<table class="row-border table-style common-datatable responsive">
    <thead>
    <tr>
        <th>{{ __('Sl.') }}</th>
        <th>{{ __('Order Number') }}</th>
        <th>{{ __('Customer') }}</th>
        <th>{{ __('Type') }}</th>
        <th>{{ __('Item') }}</th>
        <th class="text-end ">{{ __('Subtotal') }}</th>
        <th class="text-end ">{{ __('Discount') }}</th>
        <th class="text-end ">{{ __('Tax') }}</th>
        <th class="text-end ">{{ __('Referral') }}</th>
        <th class="text-end ">{{ __('Total') }}</th>
        <th>{{ __('Gateway') }}</th>
        <th>{{ __('Status') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr class="removable-item">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $order->order_number }}</td>
            <td>{{ @$order->customer->email }}</td>
            <td>
                @if ($order->type == ORDER_TYPE_PLAN)
                    <span class="text-info">{{ __('Plan') }}</span>
                @elseif($order->type == ORDER_TYPE_PRODUCT)
                    <span class="text-primary">{{ __('Product') }}</span>
                @elseif($order->type == ORDER_TYPE_DONATE)
                    <span class="text-success">{{ __('Donate') }}</span>
                @endif
            </td>
            <td>
                @if ($order->type == ORDER_TYPE_PLAN)
                    {{ @$order->customerPlan->plan->name }}
                @elseif($order->type == ORDER_TYPE_PRODUCT)
                    {{ @$order->product->title }}
                @elseif($order->type == ORDER_TYPE_DONATE)
                    {{ __('Donation') }}
                @endif
            </td>
            <td class="text-end">{{ getAmountPlace($order->subtotal ?? 0) }}</td>
            <td class="text-end">
                {{ getAmountPlace($order->discount ?? 0) }}
                @if ($order->coupon_id)
                    ({{ $order->coupon->name }})
                @endif
            </td>
            <td class="text-end">
                {{ getAmountPlace($order->tax_amount ?? 0) }}
                ({{ $order->tax_percentage ?? 0 . '%' }})
            </td>
            <td class="text-end">{{ getAmountPlace(@$order->referralHistory->earned_amount ?? 0) }}</td>
            <td class="text-end">{{ getAmountPlace($order->total ?? 0) }}</td>
            <td>{{ @$order->gateway->gateway_name }}</td>
            <td>
                @if ($order->payment_status == ORDER_PAYMENT_STATUS_PENDING)
                    <span class="zBadge zBadge-pending">{{ __('Pending') }}</span>
                @elseif($order->payment_status == ORDER_PAYMENT_STATUS_PAID)
                    <div class="project-grid__status">
                        <span class="zBadge zBadge-paid">{{ __('Paid') }}</span>
                    </div>
                @elseif($order->payment_status == ORDER_PAYMENT_STATUS_CANCELLED)
                    <div class="project-grid__status">
                        <span class="zBadge zBadge-cancel">{{ __('Cancelled') }}</span>
                    </div>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
