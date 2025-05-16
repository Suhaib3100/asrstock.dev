<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ReferralHistory;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if (getOption('referral_status') != 1 || !isAddonInstalled('PIXELAFFILIATE')) {
            return back()->with('error', __('Referral system is off now'));
        }
        if ($request->wantsJson()) {

            $referralHistories = ReferralHistory::where(['referred_customer_id' => auth()->id(), 'status' => REFERRAL_HISTORY_STATUS_PAID])
                ->orderBy('id', 'DESC');

            return datatables($referralHistories)
                ->addIndexColumn()
                ->editColumn('transaction_no', function ($data) {
                    return '<div class="text-break">' . $data->transaction_no . '</div>';
                })
                ->editColumn('earned_amount', function ($data) {
                    return showPrice($data->earned_amount);
                })
                ->editColumn('actual_amount', function ($data) {
                    return showPrice($data->actual_amount);
                })
                ->editColumn('commission_percentage', function ($data) {
                    return $data->commission_percentage . '%';
                })
                ->addColumn('date', function ($data) {
                    return '<div class="text-nowrap">' . date('d M Y', strtotime($data->created_at)) . '</div>';
                })
                ->rawColumns(['transaction_no','date'])
                ->make(true);
        }

        $data['pageTitle'] = __('Referral');
        $data['referralActive'] = 'active';
        $data['totalNumberAffiliate'] = ReferralHistory::where(['referred_customer_id' => auth()->id(), 'status' => REFERRAL_HISTORY_STATUS_PAID])->count();
        $data['totalAffiliate'] = ReferralHistory::where(['referred_customer_id' => auth()->id(), 'status' => REFERRAL_HISTORY_STATUS_PAID])->sum('actual_amount');
        $data['totalCommissionEarning'] = ReferralHistory::where(['referred_customer_id' => auth()->id(), 'status' => REFERRAL_HISTORY_STATUS_PAID])->sum('earned_amount');

        return view('customer.referral', $data);
    }
}
