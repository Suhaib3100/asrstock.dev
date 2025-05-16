<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\WalletMoney;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    use ResponseTrait;

    public function allWalletList(Request $request, $status = null)
    {
        if ($status == null) {
            if (!Auth::user()->can('all_wallet_list')) {
                abort('403');
            }
            $data['pageTitle'] = 'All Wallet';
            $data['subNavAllWalletListActiveClass'] = 'active';
            $data['showWallet'] = 'show';
            $wallets = WalletMoney::where(function ($q) use ($request) {
                if ($request->search_string) {
                    $q->where('payment_id', 'like', "%{$request->search_string}%")
                        ->orWhereHas('customer', function ($query) use ($request) {
                            $query->where('email', 'like', "%{$request->search_string}%");
                        });
                }
            })->with(['bank', 'gateway'])->latest();
        } elseif ($status == WALLET_MONEY_STATUS_PAID) {
            if (!Auth::user()->can('paid_wallet_list')) {
                abort('403');
            }
            $data['pageTitle'] = 'Paid Wallet';
            $data['subNavPaidWalletListActiveClass'] = 'active';
            $data['showWallet'] = 'show';
            $wallets = WalletMoney::paid()->where(function ($q) use ($request) {
                if ($request->search_string) {
                    $q->where('payment_id', 'like', "%{$request->search_string}%")
                        ->orWhereHas('customer', function ($query) use ($request) {
                            $query->where('email', 'like', "%{$request->search_string}%");
                        });
                }
            })->with(['bank', 'gateway'])->latest();

        } elseif ($status == WALLET_MONEY_STATUS_PENDING) {
            if (!Auth::user()->can('pending_wallet_list')) {
                abort('403');
            }
            $data['pageTitle'] = 'Pending Wallet';
            $data['subNavPendingWalletListActiveClass'] = 'active';
            $data['showWallet'] = 'show';
            $wallets = WalletMoney::pending()->where(function ($q) use ($request) {
                if ($request->search_string) {
                    $q->where('payment_id', 'like', "%{$request->search_string}%")
                        ->orWhereHas('customer', function ($query) use ($request) {
                            $query->where('email', 'like', "%{$request->search_string}%");
                        });
                }
            })->with(['bank', 'gateway'])->latest();

        } elseif ($status == WALLET_MONEY_STATUS_CANCELLED) {
            if (!Auth::user()->can('cancelled_wallet_list')) {
                abort('403');
            }
            $data['pageTitle'] = 'Cancelled Wallet';
            $data['subNavCancelledWalletListActiveClass'] = 'active';
            $data['showWallet'] = 'show';
            $wallets = WalletMoney::cancelled()->where(function ($q) use ($request) {
                if ($request->search_string) {
                    $q->where('payment_id', 'like', "%{$request->search_string}%")
                        ->orWhereHas('customer', function ($query) use ($request) {
                            $query->where('email', 'like', "%{$request->search_string}%");
                        });
                }
            })->with(['bank', 'gateway'])->latest();
        }

        if ($request->ajax()) {
            return $this->walletDataTable($wallets);
        }
        $data['status'] = $status;
        return view('admin.wallet.all-wallet-list', $data);
    }

    public function walletSetting()
    {
        $data['pageTitle'] = "Wallet Setting";
        $data['subNavWalletSettingActiveClass'] = "active";
        $data['showWallet'] = 'show';
        return view('admin.wallet.wallet-setting')->with($data);
    }

    public function statusChangeModal($id)
    {
        $data['wallet'] = WalletMoney::findOrFail($id);
        return view('admin.wallet.status-change-modal')->with($data);
    }

    public function statusUpdate(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            if(env('APP_DEMO') == 'active'){
                throw new Exception('This is a demo version! You can get full access after purchasing the application.');
            }
            $wallet = WalletMoney::findOrFail($request->id);

            if($request->status == WALLET_MONEY_STATUS_PAID && $wallet->customer_id) {
                Customer::find($wallet->customer_id)->increment('wallet_balance', $wallet->amount);
            }

            $wallet->status = $request->status;
            $wallet->save();
            DB::commit();
            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function walletDataTable($wallet)
    {
        return datatables($wallet)
            ->addIndexColumn()
            ->addColumn('payment_id', function ($wallet) {
                return $wallet->payment_id;
            })
            ->addColumn('customer_email', function ($wallet) {
                return $wallet->customer->email ?? '-';
            })
            ->addColumn('gateway_name', function ($wallet) {
                if ($wallet->gateway_name == WITHDRAW_GATEWAY_NAME_BANK) {
                    return $wallet->gateway->gateway_name . ':' . ' ' . $wallet->bank->name . '<br>' .
                        'Download slip: <a target="_blank" href="' . getFileUrl($wallet->bank_deposit_slip) . '" class="test-popup-link text-decoration-underline text-success" title="Download Bank Slip">Slip</a>';
                }
                return $wallet->gateway->gateway_name;
            })
            ->addColumn('conversion_rate', function ($wallet) {
                return getAmountPlace($wallet->conversion_rate ?? 0);
            })
            ->addColumn('amount', function ($wallet) {
                return getAmountPlace($wallet->amount ?? 0);
            })
            ->addColumn('grand_total', function ($wallet) {
                return getAmountPlace($wallet->grand_total ?? 0);
            })
            ->addColumn('status', function ($wallet) {
                if($wallet->status == WALLET_MONEY_STATUS_PENDING || $wallet->status == null){
                    return
                        '<ul class="d-flex justify-content-end align-items-center cg-5">
                            <li class="align-items-center d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('admin.wallet.status-change-modal', $wallet->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-stroke bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                                    <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit" />
                                </button>
                            </li>
                        </ul>';
                }else {
                    if ($wallet->status == WALLET_MONEY_STATUS_PENDING) {
                        return '<span class="zBadge zBadge-pending">Pending</span>';
                    } elseif ($wallet->status == WALLET_MONEY_STATUS_PAID) {
                        return '<span class="zBadge zBadge-paid">Paid</span>';
                    } elseif ($wallet->status == WALLET_MONEY_STATUS_CANCELLED) {
                        return '<span class="zBadge zBadge-cancel">Cancelled</span>';
                    }
                }
            })
            ->rawColumns(['gateway_name', 'status'])
            ->make(true);
    }


}
