<table class="row-border table-style responsive" id="bank-pending-datatable">
    <thead>
        <tr>
            <th >{{ __('Sl.') }}</th>
            <th >{{ __('Order Number') }}</th>
            <th >{{ __('Customer') }}</th>
            <th >{{ __('Type') }}</th>
            <th >{{ __('Item') }}</th>
            <th class="text-end ">{{ __('Subtotal') }}</th>
            <th class="text-end ">{{ __('Discount') }}</th>
            <th class="text-end ">{{ __('Tax') }}</th>
            <th class="text-end ">{{ __('Referral') }}</th>
            <th class="text-end ">{{ __('Total') }}</th>
            <th >{{ __('Gateway') }}</th>
            <th >{{ __('Status') }}</th>
            <th width="130px" class="d-block">{{ __('Bank Slip') }}</th>
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
                    <div class="d-flex">
                        <div>
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
                        </div>
                        <div>
                            <ul class="action-list">
                                <li class="nav-item dropdown">
                                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ asset('admin/images/icons/ellipsis-v.svg') }}" alt="icon">
                                    </a>
                                    <span id="hidden_id" class="d-none">{{$order->id}}</span>
                                    <ul class="dropdown-menu">
                                        <li><a class="status-change dropdown-item" data-status="2" >{{ __('Paid') }}</a></li>
                                        <li><a class="status-change dropdown-item" data-status="3" >{{ __('Cancelled') }}</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
                <td width="130px" class="d-block">
                    <a target="_blank" href="{{ $order->bankDepositSlip }}" class="text-success">{{ __('Click for Bank Slip') }}</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
