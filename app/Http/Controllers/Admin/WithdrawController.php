<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Withdraw;
use App\Traits\ApiStatusTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawController extends Controller
{
    use ApiStatusTrait;
    public function pendingWithdraw(Request $request)
    {
        $data['pageTitle'] = 'Pending Withdraw';
        $data['subNavPendingWithdrawActiveClass'] = 'active';
        $data['showWithdraw'] = 'show';
        $data['withdraws'] = Withdraw::pending()->whereHas('customer', function ($q) use ($request){
            if ($request->search_customer_name) {
                $q->where('first_name', 'like', "%{$request->search_customer_name}%")->orWhere('last_name', 'like', "%{$request->search_customer_name}%");
            }
        })->get();

        return view('admin.withdraw.pending')->with($data);
    }

    public function completedWithdraw(Request $request)
    {
        $data['pageTitle'] = 'Completed Withdraw';
        $data['subNavCompletedWithdrawActiveClass'] = 'active';
        $data['showWithdraw'] = 'show';
        $data['withdraws'] = Withdraw::completed()->whereHas('customer', function ($q) use ($request){
            if ($request->search_customer_name) {
                $q->where('first_name', 'like', "%{$request->search_customer_name}%")->orWhere('last_name', 'like', "%{$request->search_customer_name}%");
            }
        })->get();

        return view('admin.withdraw.completed')->with($data);
    }

    public function cancelledWithdraw(Request $request)
    {
        $data['pageTitle'] = 'Cancelled Withdraw';
        $data['subNavCancelledWithdrawActiveClass'] = 'active';
        $data['showWithdraw'] = 'show';
        $data['withdraws'] = Withdraw::cancelled()->whereHas('customer', function ($q) use ($request){
            if ($request->search_customer_name) {
                $q->where('first_name', 'like', "%{$request->search_customer_name}%")->orWhere('last_name', 'like', "%{$request->search_customer_name}%");
            }
        })->get();

        return view('admin.withdraw.cancelled')->with($data);
    }

    public function completedStatus(Request $request)
    {
        if(env('APP_DEMO') == 'active'){
            $response['message'] = 'This is a demo version! You can get full access after purchasing the application.';
            return $this->notAllowedApiResponse($response);
        }

        $withdraw = Withdraw::where('uuid', $request->uuid)->firstOrfail();
        $withdraw->status = WITHDRAW_STATUS_COMPLETED;
        $withdraw->save();

        $response['message'] = 'Success';
        return $this->successApiResponse($response);
    }

    public function cancelledReason(Request $request)
    {
        if(env('APP_DEMO') == 'active'){
            return redirect()->back()->with('error', 'This is a demo version! You can get full access after purchasing the application.');
        }

        $request->validate([
            'cancel_reason' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $withdraw = Withdraw::where('uuid', $request->uuid)->firstOrfail();
            $withdraw->cancel_reason = $request->cancel_reason;
            $withdraw->status = WITHDRAW_STATUS_CANCELLED;
            $withdraw->save();
            if ($withdraw->customer_id) {
                Customer::find($withdraw->customer_id)->increment('earning_balance', $withdraw->amount);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __(SOMETHING_WENT_WRONG));
        }

        return redirect()->back()->with('success', __('Cancelled Successfully'));
    }
}
