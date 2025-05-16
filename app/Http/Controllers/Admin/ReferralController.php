<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferralHistory;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function referralSetting()
    {
        $data['pageTitle'] = "Referral Setting";
        $data['subNavReferralSettingActiveClass'] = "active";
        $data['showReferral'] = 'show';
        return view('admin.referral.setting')->with($data);
    }

    public function referralHistory(Request $request)
    {
        $data['pageTitle'] = "Referral History";
        $data['subNavReferralHistoryActiveClass'] = "active";
        $data['showReferral'] = 'show';
        $data['referralHistories'] = ReferralHistory::where(function ($q) use ($request){
            if ($request->search_string) {
                $q->where('transaction_no','LIKE', '%' . $request->search_string . '%')->orWhere('plan_name','LIKE', '%' . $request->search_string . '%');
            }

            if ($request->search_status) {
                $q->where('status', $request->search_status);
            }
        })->get();

        if ($request->ajax()) {
            return view('admin.referral.partial.render-history')->with($data);
        }

        return view('admin.referral.history')->with($data);
    }
}
