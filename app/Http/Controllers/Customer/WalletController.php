<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Services\Payment\Payment;
use App\Models\Customer;
use App\Models\FileManager;
use App\Models\Gateway;
use App\Models\WalletMoney;
use App\Traits\ApiStatusTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WalletController extends Controller
{
    use ApiStatusTrait;

    public function index()
    {
        $customer = auth()->user();
        $data['searchDisable'] = true;
        $data['pageTitle'] = __('Wallet');
        $data['activeWallet'] = 'active';
        $data['wallet_balance'] = $customer->wallet_balance;
        $data['walletGateways'] = Gateway::where(['status' => ACTIVE, 'wallet_gateway_status' => ACTIVE])->get();
        $data['min_wallet_amount'] = empty(getOption('min_wallet_amount')) ? 1 : getOption('min_wallet_amount');
        $data['max_wallet_amount'] = empty(getOption('max_wallet_amount')) ? 1 : getOption('max_wallet_amount');
        return view('customer.wallet', $data);
    }

    public function walletDepositHistory()
    {
        $walletMoney = WalletMoney::with(['customer', 'gateway'])->orderBy('id', 'desc')->where('customer_id', auth()->id());

        return datatables($walletMoney)
            ->addIndexColumn()
            ->addColumn('amount', function ($data) {
                return showPrice($data->amount);
            })
            ->addColumn('gateway', function ($data) {
                return $data->gateway?->gateway_name;
            })

            ->addColumn('date', function ($data) {
                return '<span class="text-nowrap">' . formatDate($data->creatd_at, 'Y-m-d') . '</span>';
            })
            ->addColumn('status', function ($data) {
                return getWalletMoneyStatus($data->status);
            })
            ->rawColumns(['status', 'date'])
            ->make(true);
    }

    public function addWalletMoney(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:' . (empty(getOption('min_wallet_amount')) ? 1 : getOption('min_wallet_amount')) . '|max:' . (empty(getOption('max_wallet_amount')) ? 1 : getOption('max_wallet_amount')),
            'gateway_name' => 'required'
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return $this->failed([], $response['message']);
        }

        $response['gateway'] = Gateway::whereGatewayName($request->gateway_name)->first();
        if (!$response['gateway']) {
            $response['message'] = 'Gateway name is incorrect!';
            return $this->failed([], $response['message']);
        }

        $response['amount'] = $request->amount;
        $grand_total = $request->amount * $response['gateway']->conversion_rate; //Multiply with total amount and conversion_rate
        $response['conversion_rate'] = 1 . ' ' . getCurrencyCode() . ' = ' . $response['gateway']->conversion_rate . ' ' . $response['gateway']->gateway_currency;
        $response['grand_total'] = number_parser($grand_total);
        return $this->success($response);
    }

    public function addWalletMoneyCheckout($gateway_name, $amount)
    {
        $response['gateway'] = Gateway::whereGatewayName($gateway_name)->first();
        if (!$response['gateway']) {
            $response['message'] = 'Gateway name is incorrect!';
            return $this->failed([], $response['message']);
        }

        $wallet = new WalletMoney();
        $wallet->customer_id = Auth::id();
        $wallet->gateway_name = $gateway_name;
        $wallet->gateway_currency = $response['gateway']->gateway_currency;
        $wallet->conversion_rate = $response['gateway']->conversion_rate;
        $wallet->amount = $amount;
        $grand_total = $amount * $response['gateway']->conversion_rate; //Multiply with total amount and conversion_rate
        $wallet->grand_total = number_parser($grand_total);
        $wallet->status = WALLET_MONEY_STATUS_PENDING;
        $wallet->save();
        $response['wallet'] = $wallet;
        return $this->success($response);
    }

    public function paypalWalletCreatePayment(Request $request)
    {
        $id = $request->get('wallet_id', 0);
        $callback_url = $request->get('callback_url', '');
        $wallet = WalletMoney::find($id);
        if (is_null($wallet)) {
            $response['message'] = 'Wallet Not Found';
            return $this->failed([], $response['message']);
        }
        $object = [
            'id' => $wallet->id,
            'payment_method' => PAYPAL,
            'currency' => $wallet->gateway_currency,
            'callback_url' => $callback_url
        ];
        $gatewayBasePayment = new Payment($object);
        $responseData = $gatewayBasePayment->makePayment($wallet->grand_total);
        $wallet->payment_id = $responseData['payment_id'];
        $wallet->save();

        if ($responseData['success']) {
            $response['checkout_url'] = $responseData['redirect_url'];
            $response['wallet_id'] = $responseData['payment_id'];
            $response['message'] = 'Your wallet has been Created';
            return $this->success($response);
        } else {
            $response['message'] = SOMETHING_WENT_WRONG;
            return $this->failed([], $response['message']);
        }
    }

    public function paypalWalletPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_id' => 'required',
            'payer_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return $this->failed([], $response['message']);
        }

        $gateway = Gateway::where('gateway_name', PAYPAL)->first();
        $wallet = WalletMoney::where('payment_id', $request->payment_id)->first();

        if (is_null($wallet)) {
            $response['message'] = 'Wallet id is incorrect!';
            return $this->failed([], $response['message']);
        }

        if ($wallet->status == WALLET_MONEY_STATUS_PAID) {
            $response['message'] = 'This wallet money request already has been paid';
            return $this->failed([], $response['message']);
        }

        if ($gateway && $wallet) {
            $object = [
                'id' => $wallet->id,
                'payment_method' => $gateway->gateway_name,
                'currency' => $gateway->gateway_currency
            ];

            $gatewayBasePayment = new Payment($object);
            $responseData = $gatewayBasePayment->paymentConfirmation($request->payment_id, $request->payer_id);
            if ($responseData['success']) {
                $wallet->status = WALLET_MONEY_STATUS_PAID;
                $wallet->save();

                if (@$wallet->customer_id) {
                    Customer::find(@$wallet->customer_id)->increment('wallet_balance', $wallet->amount);
                }
                $response['message'] = 'Congratulations! Your wallet amount has been added successfully';
                return $this->success([], $response['message']);
            }
            $response['message'] = 'Payment has been failed! Please try again';
            return $this->failed([], $response['message']);

        } else {
            $response['message'] = SOMETHING_WENT_WRONG;
            return $this->failed([], $response['message']);
        }
    }

    public function stripeWalletPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stripe_token' => 'required',
            'wallet_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return $this->failed([], $response['message']);
        }

        $gateway = Gateway::where(['gateway_name' => STRIPE, 'status' => ACTIVE])->first();
        $wallet = WalletMoney::find($request->wallet_id);

        if ($wallet->status == WALLET_MONEY_STATUS_PAID) {
            $response['message'] = 'This wallet money request already has been paid!';
            return $this->failed([], $response['message']);
        }

        if ($gateway && $wallet) {
            $object = [
                'id' => $wallet->id,
                'payment_method' => $gateway->gateway_name,
                'currency' => $gateway->gateway_currency,
                'token' => $request->stripe_token
            ];
            $gatewayBasePayment = new Payment($object);
            $responseData = $gatewayBasePayment->makePayment(number_parser($wallet->grand_total));
            if ($responseData['success']) {
                if ($responseData['data']['payment_status'] == 'success') {
                    DB::beginTransaction();
                    try {
                        $wallet->payment_id = $responseData['payment_id'];
                        $wallet->status = WALLET_MONEY_STATUS_PAID;
                        $wallet->save();
                        if (@$wallet->customer_id) {
                            Customer::find(@$wallet->customer_id)->increment('wallet_balance', $wallet->amount);
                        }
                        DB::commit();
                        $response['message'] = 'Congratulations! Your wallet amount has been added successfully';
                        return $this->success($response['message']);
                    } catch (\Exception $e) {
                        DB::rollBack();
                    }
                }
            }

            $response['message'] = 'Payment has been failed! Please try again';
            return $this->failed([], $response['message']);
        } else {
            $response['message'] = SOMETHING_WENT_WRONG;
            return $this->failed([], $response['message']);
        }
    }

    public function bankWalletPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank_name' => 'required',
            'bank_account_number' => 'required',
            'deposit_by' => 'required',
            'bank_deposit_slip' => 'required|file',
            'wallet_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return $this->failed([], $response['message']);
        }

        $gateway = Gateway::where(['gateway_name' => BANK])->first();
        $wallet = WalletMoney::find($request->wallet_id);

        if ($wallet->status == WALLET_MONEY_STATUS_PAID) {
            $response['message'] = 'This wallet money request already has been paid!';
            return $this->failed([], $response['message']);
        }

        if ($gateway && $wallet) {
            $wallet->payment_id = Str::uuid()->toString();
            $wallet->bank_name = $request->bank_name;
            $wallet->bank_account_number = $request->bank_account_number;
            $wallet->deposit_by = $request->deposit_by;

            /*File Manager Call upload*/
            if ($request->hasFile('bank_deposit_slip')) {
                $new_file = new FileManager();
                $upload = $new_file->upload('WalletMoney', $request->bank_deposit_slip);
                if ($upload['status']) {
                    $upload['file']->origin_id = $wallet->id;
                    $upload['file']->origin_type = "App\Models\WalletMoney";
                    $upload['file']->save();
                }
                $wallet->bank_deposit_slip = $upload['file']->id;
            }
            $wallet->save();


            $response['message'] = 'Congratulations! Your add funds request sent successfully and request status has been pending';
            return $this->success([], $response['message']);
        }

        $response['message'] = SOMETHING_WENT_WRONG;
        return $this->failed();
    }

}
