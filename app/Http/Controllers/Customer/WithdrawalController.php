<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\DownloadProduct;
use App\Models\WalletMoney;
use App\Models\Withdraw;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    use ResponseTrait;

    public function my_earning(Request $request)
    {
        if ($request->wantsJson()) {
            $withDraw = Withdraw::with(['customer', 'beneficiary'])
                ->orderBy('id', 'desc')
                ->where('customer_id', auth()->id());

            return datatables($withDraw)
                ->addIndexColumn()
                ->addColumn('amount', function ($data) {
                    return showPrice($data->amount);
                })
                ->addColumn('type', function ($data) {
                    return '<div class="d-flex align-items-center">
                        ' . getBeneficiary($data->beneficiary?->type) . '
                        <span class="ms-2" data-bs-toggle="tooltip" title="' . htmlspecialchars($data->beneficiary_details) . '">
                            <i class="fas fa-info-circle"></i>
                        </span>
                    </div>';
                })
                ->addColumn('date', function ($data) {
                    return '<span class="text-nowrap">' . formatDate($data->created_at, 'Y-m-d') . '</span>';
                })
                ->addColumn('status', function ($data) {
                    return getWithdrawStatus($data->status, $data->cancel_reason);
                })
                ->rawColumns(['status', 'date', 'type'])
                ->make(true);
        }

        $data['pageTitle'] = __('My Earnings');
        $data['myEarningActive'] = 'active';
        $data['totalWithdrawCompletedAmount'] = Withdraw::where(['customer_id' => auth()->id(), 'status' => WITHDRAW_STATUS_COMPLETED])->sum('amount');
        $data['totalWithdrawPendingAmount'] = Withdraw::where(['customer_id' => auth()->id(), 'status' => WITHDRAW_STATUS_PENDING])->sum('amount');
        $total_withdraw = Withdraw::where('customer_id', auth()->id())->whereIn('status', [1, 2])->sum('amount');
        $data['totalEarningBalance'] = auth()->user()->earning_balance + ($total_withdraw ?? 0);
        $data['totalAvailableBalance'] = auth()->user()->earning_balance;
        $data['totalWalletBalance'] = auth()->user()->wallet_balance;
        $data['totalDownload'] = DownloadProduct::whereContributorId(auth()->id())->count();
        $data['beneficiaries'] = Beneficiary::where('customer_id', auth()->id())->where('status', ACTIVE)->get();
        return view('customer.earning.index', $data);
    }

    public function withdraw(Request $request)
    {

        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:1',
                'max:' . auth()->user()->earning_balance // Ensure amount is within the balance
            ],
            'beneficiary_id' => 'required|exists:beneficiaries,id',
            'note' => 'nullable|string|max:255'
        ], [
            'amount.required' => __('Amount is required.'),
            'amount.numeric' => __('Amount must be a valid number.'),
            'amount.min' => __('Amount must be at least :min.'),
            'amount.max' => __('Amount cannot exceed your available balance.'),
        ]);

        DB::beginTransaction();
        try {
            $beneficiary = Beneficiary::where([
                'customer_id' => auth()->id(),
                'id' => $request->beneficiary_id
            ])->firstOrFail(); // Ensures beneficiary exists

            $withdraw = Withdraw::create([
                'customer_id' => auth()->id(),
                'amount' => $request->amount,
                'beneficiary_id' => $request->beneficiary_id,
                'beneficiary_details' => $beneficiary->details,
                'customer_note' => $request->note,
                'status' => WITHDRAW_STATUS_PENDING
            ]);

            auth()->user()->decrement('earning_balance', $withdraw->amount);

            DB::commit();
            return $this->success([], __('Request created successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error([], __('Something went wrong, please try again.'));
        }
    }

}
