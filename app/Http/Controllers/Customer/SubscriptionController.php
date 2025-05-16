<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerPlan;
use App\Models\DownloadProduct;
use App\Traits\ApiStatusTrait;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    use ApiStatusTrait;

    public function mySubscriptionPlan(Request $request)
    {
        if ($request->wantsJson()) {
            $customerPlans = CustomerPlan::with(['order.gateway', 'plan'])
                ->orderBy('id', 'desc')
                ->where('customer_id', auth()->id());

            return datatables($customerPlans)
                ->addIndexColumn()
                ->addColumn('amount', function ($data) {
                    return '<span class="text-nowrap">' . showPrice($data->order?->total) . '</span>';
                })
                ->addColumn('order_no', function ($data) {
                    return '#' . substr($data->order?->order_number, 0, 6);
                })
                ->addColumn('gateway', function ($data) {
                    return $data->order?->gateway?->gateway_name;
                })
                ->editColumn('plan', function ($data) {
                    return $data->plan?->name;
                })
                ->addColumn('start_date', function ($data) {
                    return '<span class="text-nowrap">' . formatDate($data->start_date, 'Y-m-d') . '</span>';
                })
                ->addColumn('end_date', function ($data) {
                    return '<span class="text-nowrap">' . formatDate($data->end_Date, 'Y-m-d') . '</span>';
                })
                ->addColumn('status', function ($data) {
                    if (!is_null($data->cancelled_by)) {
                        return '<div class="zBadge zBadge-cancel">' . __("Cancelled") . '</div>';;
                    } else {
                        if ($data->end_date < now()) {
                            return '<div class="zBadge zBadge-pending">' . __("Expired") . '</div>';;
                        } else {
                            return '<div class="zBadge zBadge-completed">' . __("Active") . '</div>';;
                        }
                    }
                })
                ->rawColumns(['status', 'start_date', 'end_date', 'amount'])
                ->make(true);
        }

        $data['pageTitle'] = __('My Subscription Plan');
        $data['mySubscriptionActive'] = 'active';
        $data['subscriptionPlan'] = customerPlanExit(auth()->id());
        if ($data['subscriptionPlan']) {
            $data['totalDownload'] = DownloadProduct::where('customer_id', auth()->id())
                ->whereBetween('created_at', [$data['subscriptionPlan']->start_date, $data['subscriptionPlan']->end_date])
                ->where('download_accessibility_type', PRODUCT_ACCESSIBILITY_PAID)
                ->count();
        }
        return view('customer.my_subscriptions', $data);
    }

    public function cancelSubscriptionPlan($id)
    {
        $customerPlan = CustomerPlan::where(['id' => $id, 'customer_id' => auth()->id()])->first();
        if ($customerPlan) {
            CustomerPlan::where('id', $id)->update(['end_date' => date('Y-m-d', strtotime(now())), 'cancelled_by' => CUSTOMER_PLAN_CANCELLED_BY_CUSTOMER]);
            $response['message'] = 'Subscription Cancelled successfully';
            return $this->success([], $response['message']);
        }
        $response['message'] = SOMETHING_WENT_WRONG;
        return $this->failed([], $response['message']);
    }
}
