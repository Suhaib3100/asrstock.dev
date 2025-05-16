<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Services\Payment\Payment;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\CustomerCoupon;
use App\Models\CustomerPlan;
use App\Models\FileManager;
use App\Models\Gateway;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Referral;
use App\Models\ReferralHistory;
use App\Models\UserPurchase;
use App\Models\WalletMoney;
use App\Traits\ApiStatusTrait;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Exceptions\Exception;

class OrderController extends Controller
{
    use ApiStatusTrait;

    /**
     * @throws Exception
     */
    public function myOrderList(Request $request)
    {
        $data['pageTitle'] = __('My Order List');
        $data['orderActive'] = 'active';
        if ($request->wantsJson()) {
            $orders = Order::with('gateway')->orderBy('id', 'desc')->where('customer_id', auth()->id());

            return datatables($orders)
                ->addIndexColumn()
                ->addColumn('amount', function ($data) {
                    return showPrice($data->total);
                })
                ->addColumn('order_no', function ($data) {
                    return '#'.substr($data->order_number, 0,6);
                })
                ->addColumn('gateway', function ($data) {
                    return $data->gateway?->gateway_name;
                })
                ->editColumn('type', function ($data) {
                    return getOrderType($data->type);
                })
                ->addColumn('date', function ($data) {
                    return '<span class="text-nowrap">'.formatDate($data->creatd_at, 'Y-m-d').'</span>';
                })
                ->addColumn('status', function ($data) {
                    return getOrderStatus($data->payment_status);
                })
                ->addColumn('invoice', function ($data) {
                    return "<div class='d-flex justify-content-end'><a target='_blank' href='".route('customer.orders.invoice_download', $data->id)."' class='invoiceDownload'><img src='".asset('assets/images/icon/invoice-download.svg')."' alt=''></a></div>";
                })
                ->rawColumns(['invoice', 'status', 'date'])
                ->make(true);
        }

        return view('customer.orders.my_order_list', $data);
    }

    public function invoiceDownload($order_id)
    {
        $data['order'] = Order::find($order_id);
        $pdf = PDF::loadView('invoice', $data);
        return $pdf->download('invoice.pdf');
    }

    public function planPricing()
    {
        $response['pageTitle'] = 'Plan Pricing';
        $response['plans'] = Plan::with('planBenefits')->active()->get();
        $settingArray = array(
            'plan_title' => getOption('plan_title'),
            'plan_subtitle' => getOption('plan_subtitle'),
        );
        $response['settings'] = $settingArray;
        return $this->success($response);
    }

    public function paymentGateways(Request $request)
    {
        $response['gateways'] = Gateway::select('id', 'gateway_name', 'gateway_currency')->active()->get();
        return $this->success($response['gateways']);
    }

    /* $plan_duration_type must be (1/2)
     * 1 means yearly, 2 means monthly */
    public function paymentNow(Request $request)
    {
        $type = $request->get('type', '');
        $gateway_name = $request->get('gateway_name', '');
        $result = '';
        if ($type == 'plan') {
            $planId = $request->get('id', '');
            $plan_duration_type = $request->get('duration', '');
            $result = $this->placeOrderPlan($gateway_name, $planId, $plan_duration_type);
        } elseif ($type == 'wallet') {
            $amount = $request->get('amount', 0);
            $result = $this->placeOrderWallet($gateway_name, $amount);
        } elseif ($type == 'product') {
            $productId = $request->get('id', '');
            $variationId = $request->get('variation_id', '');
            $result = $this->placeOrderProduct($gateway_name, $productId, $variationId);
        } elseif ($type == 'donation') {
            $product_id = $request->get('id', '');
            $amount = $request->get('amount', '0');
            $result = $this->placeOrderDonation($gateway_name, $product_id, $amount);
        }

        return $result;
    }

    public function checkout(Request $request)
    {
        $type = $request->get('type', '');
        $callback_url = $request->get('callback_url', '');
        $id = $request->get('id', '');
        if ($type == 'wallet') {
            return $this->walletDepositCheckout($request);
        }
        $order = Order::where('id', $id)->firstOrFail();
        $gateway = Gateway::where(['id' => $order->gateway_id, 'status' => 1])->first();
        if ($gateway->gateway_name == BANK) {
            return $this->processBankCheckout($request, $order);
        } elseif ($gateway->gateway_name == WALLET) {
            return $this->processWalletCheckout($request, $order);
        } else {
            return $this->processGatewayCheckout($order, $callback_url);
        }
    }

    public function processWalletCheckout($request, $order)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return $this->failed([], $response['message']);
        }

        $gateway = Gateway::where(['gateway_name' => 'wallet', 'status' => ACTIVE])->first();

        if ($order->payment_status == ORDER_PAYMENT_STATUS_PAID) {
            $response['message'] = 'Your order has been already paid!';
            return $this->failed([], $response['message']);
        }

        if (Auth::user()->wallet_balance < $order->grand_total) {
            $response['message'] = 'Sorry! Your wallet balance less than order amount.';
            return $this->failed([], $response['message']);
        }

        if ($gateway && $order) {
            DB::beginTransaction();
            try {
                $order->gateway_transaction = randomString();
                $order->payment_status = ORDER_PAYMENT_STATUS_PAID;
                $order->save();
                /*Start:: Buy Customer wallet balance decrement*/
                Customer::find(Auth::id())->decrement('wallet_balance', $order->grand_total);
                /*Start:: Buy Customer wallet balance decrement*/
                /*Start:: Product owner earning balance increase*/
                if (($order->type == ORDER_TYPE_PRODUCT || $order->type == ORDER_TYPE_DONATE) && @$order->product->customer_id) {
                    /*Start:: Product owner earning balance increase*/
                    Customer::find(@$order->product->customer_id)->increment('earning_balance', $order->contributor_commission);
                }
                /*End:: Product owner earning balance increase*/

                if ($order->type == ORDER_TYPE_PRODUCT) {
                    $this->userPurchase($order->id);
                }

                $this->referralHistory($order->id);
                DB::commit();
                $response['self_redirect'] = true;
                $response['message'] = 'Congratulations! Your order has been successfully done';
                return $this->success($response, $response['message']);
            } catch (\Exception $e) {
                DB::rollBack();
                $response['message'] = SOMETHING_WENT_WRONG;
                return $this->failed([], $response['message']);
            }
        } else {
            $response['message'] = SOMETHING_WENT_WRONG;
            return $this->failed([], $response['message']);
        }
    }

    public function processBankCheckout($request, $model, $type = NULL)
    {
        $validator = Validator::make($request->all(), [
            'deposit_by' => 'required',
            'bank_deposit_slip' => 'required|file',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return $this->failed([], $response['message']);
        }
        if ($model) {
            DB::beginTransaction();
            try {
                $model->deposit_by = $request->deposit_by;

                /*File Manager Call upload*/
                if ($request->hasFile('bank_deposit_slip')) {
                    $new_file = new FileManager();
                    if ($type == 'wallet') {
                        $upload = $new_file->upload('WalletMoney', $request->bank_deposit_slip);
                        if ($upload['status']) {
                            $upload['file']->origin_id = $model->id;
                            $upload['file']->origin_type = "App\Models\WalletMoney";
                            $upload['file']->save();
                        }
                    } else {
                        $upload = $new_file->upload('Order', $request->bank_deposit_slip);
                        if ($upload['status']) {
                            $upload['file']->origin_id = $model->id;
                            $upload['file']->origin_type = "App\Models\Order";
                            $upload['file']->save();
                        }
                    }
                }
                /*End*/
                $model->bank_deposit_slip = $upload['file']->id;
                $model->save();

                DB::commit();
                $response['self_redirect'] = true;
                $response['message'] = 'Congratulations! Your payment request sent successfully and payment status has been pending';
                return $this->success($response, $response['message']);
            } catch (\Exception $e) {
                DB::rollBack();
                $response['message'] = SOMETHING_WENT_WRONG;
                return $this->failed([], $response['message']);
            }

        } else {
            $response['message'] = 'Order not found! Please try again';
            return $this->failed([], $response['message']);
        }
    }

    public function processGatewayCheckout($order, $callback_url)
    {
        $gateway = Gateway::where(['id' => $order->gateway_id, 'status' => 1])->first();
        $object = [
            'id' => $order->id,
            'currency' => $gateway->gateway_currency,
            'callback_url' => $callback_url
        ];

        $payment = new Payment($gateway->gateway_name, $object);
        $responseData = $payment->makePayment($order->grand_total);

        if ($responseData['success']) {
            $order->gateway_transaction = $responseData['payment_id'];
            $order->payment_id = $responseData['payment_id'];
            $order->save();
            $response['checkout_url'] = $responseData['redirect_url'];
            return $this->success($response);
        }
    }

    public function walletDepositCheckout($request)
    {
        $type = $request->get('type', '');
        $callback_url = $request->get('callback_url', '');
        $id = $request->get('id', '');
        $walletMoney = WalletMoney::where('id', $id)->firstOrFail();
        $gateway = Gateway::where(['gateway_name' => $walletMoney->gateway_name, 'status' => 1])->first();

        if ($gateway->gateway_name == BANK) {
            return $this->processBankCheckout($request, $walletMoney, 'wallet');
        } else {
            $object = [
                'id' => $walletMoney->id,
                'type' => $type,
                'currency' => $gateway->gateway_currency,
                'callback_url' => $callback_url
            ];

            $payment = new Payment($gateway->gateway_name, $object);

            $responseData = $payment->makePayment($walletMoney->grand_total);

            if ($responseData['success']) {
                $walletMoney->payment_id = $responseData['payment_id'];
                $walletMoney->save();
                $response['checkout_url'] = $responseData['redirect_url'];
                return $this->success($response);
            }

            $response['message'] = SOMETHING_WENT_WRONG;
            return $this->failed([], $responseData['message']);
        }
    }

    protected function placeOrderPlan($gateway_name, $plan_uuid, $plan_duration_type)
    {
        $gateway = Gateway::whereGatewayName($gateway_name)->active()->first();
        $plan = Plan::where(['id' => $plan_uuid])->active()->first();
        if ($gateway && $plan) {
            $response['plan_name'] = $plan->name;

            if ($plan_duration_type == 1) {
                $plan_price = $plan->yearly_price;
            } elseif ($plan_duration_type == 2) {
                $plan_price = $plan->monthly_price;
            }
            $response['plan_price'] = $plan_price;
            $response['subtotal'] = $plan_price;
            $response['discount'] = 0;
            $response['tax'] = 0;
            $response['total'] = $response['subtotal'] - $response['discount'];
            $response['message'] = '';
            $response['gateway_name'] = $gateway_name;
            $response['gateway_currency'] = $gateway->gateway_currency;
            if ($gateway_name == BANK) {
                $response['bank_name'] = $gateway->gateway_parameters->bank_name;
                $response['bank_account_number'] = $gateway->gateway_parameters->bank_account_number;
                $response['bank_routing_number'] = $gateway->gateway_parameters->bank_routing_number;
                $response['bank_branch_name'] = $gateway->gateway_parameters->bank_branch_name;
            }

            /*Start:: Tax*/
            if (@$plan->tax) {
                $response['tax'] = $response['total'] * (@$plan->tax->percentage / 100);
                $response['total'] = $response['subtotal'] - $response['discount'] + $response['tax']; //Calculation with subtotal, discount, tax
            }
            /*End:: Tax*/

            $response['conversion_rate'] = $gateway->conversion_rate;
            $grand_total = $response['total']; //Multiply with total and conversion_rate
            $response['grand_total'] = number_parser($grand_total) * $response['conversion_rate'];

            DB::beginTransaction();
            try {
                /*Customer Plan check, then Plan Order create with customer id, if coupon used, add customer coupon*/
                $customerPlan = customerPlanExit(Auth::id());
                if ($customerPlan) {
                    $response = [];
                    $response['message'] = 'You already have plan. You can buy again after the current plan ends';
                    return $this->failed([], $response['message']);
                }

                $order = new Order();
                $order->customer_id = auth()->id();
                $order->plan_id = $plan->id;
                $order->plan_price = $plan_price;
                $order->plan_duration_type = $plan_duration_type;

                if ($response['tax'] > 0) {
                    $order->tax_id = $plan->tax_id;
                    $order->tax_percentage = @$plan->tax->percentage;
                }

                $order->current_currency = getCurrencyCode();
                $order->gateway_id = $gateway->id;
                $order->gateway_currency = $gateway->gateway_currency;
                $order->conversion_rate = $gateway->conversion_rate;

                $order->subtotal = $response['subtotal'];
                $order->discount = $response['discount'];
                $order->tax_amount = $response['tax'];
                $order->total = $response['total'];
                $order->grand_total = $response['total'];
                $order->payment_status = ORDER_PAYMENT_STATUS_PENDING;
                $order->payment_type = ($gateway_name == 'bank') ? ORDER_PAYMENT_TYPE_BANK : ORDER_PAYMENT_TYPE_ONLINE;
                $order->type = ORDER_TYPE_PLAN;
                $order->save();

                $response['id'] = $order->id;
                //Start:: New Plan Created
                $customerPlan = new CustomerPlan();
                $customerPlan->order_id = $order->id;
                $customerPlan->plan_type = $order->plan_duration_type;
                $customerPlan->customer_id = Auth::id();
                $customerPlan->start_date = now();

                // Plan duration type 1 means yearly, 2 means monthly
                $customerPlan->end_date = ($plan_duration_type == ORDER_PLAN_DURATION_TYPE_YEAR) ? now()->addYear() : now()->addMonth();

                $plan_details = array(
                    "name" => $plan->name,
                    "price" => $plan_price,
                    "duration_type" => $plan_duration_type,
                    "device_limit" => $plan->device_limit,
                    "download_limit_type" => $plan->download_limit_type,
                    "download_limit" => $plan->download_limit
                );
                $customerPlan->plan_details = $plan_details;
                $customerPlan->save();
                //End:: New Plan Created

                //Start:: If referral allow status yes and eligible for this, then need to give referral bonus
                if (getOption('referral_status') == 1 && isAddonInstalled('PIXELAFFILIATE')) {
                    $referral = Referral::where(['child_customer_id' => Auth::id(), 'status' => REFERRAL_STATUS_DUE])->first();
                    if ($referral) {
                        $referredParentCustomer = Customer::find($referral->parent_customer_id);
                        $referral_commission = empty(getOption('referral_commission')) ? 0 : getOption('referral_commission');
                        if ($referredParentCustomer) {
                            $referralHistory = new ReferralHistory();
                            $referralHistory->transaction_no = Str::uuid()->getHex();
                            $referralHistory->referred_customer_id = $referredParentCustomer->id;
                            $referralHistory->buyer_customer_id = Auth::id();
                            $referralHistory->order_id = $order->id;
                            $referralHistory->plan_name = $plan->name;
                            $referralHistory->plan_price = $plan_price;
                            $referralHistory->actual_amount = $plan_price;
                            $referralHistory->commission_percentage = $referral_commission;
                            $referralHistory->earned_amount = $plan_price * ($referral_commission / 100);
                            $referralHistory->status = REFERRAL_HISTORY_STATUS_DUE;
                            $referralHistory->referral_id = $referral->id;
                            $referralHistory->save();
                        }
                    }
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $response['message'] = $e->getMessage();
                return $this->failed($response['message']);
            }

            return $this->success($response);
        }

        $response['message'] = SOMETHING_WENT_WRONG;
        return $this->failed([], $response['message']);
    }

    protected function placeOrderDonation($gateway_name, $product_id, $amount)
    {
        $gateway = Gateway::whereGatewayName($gateway_name)->active()->first();

        $product = Product::whereId($product_id)->published()->first();
        if ($gateway && $product) {
            $response['subtotal'] = $amount;

            $response['discount'] = 0;
            $response['tax'] = 0;
            $response['total'] = $response['subtotal'] - $response['discount'];
            $response['message'] = '';
            $response['gateway_name'] = $gateway_name;
            $response['gateway_currency'] = $gateway->gateway_currency;

            if ($gateway_name == BANK) {
                $response['bank_name'] = $gateway->gateway_parameters->bank_name;
                $response['bank_account_number'] = $gateway->gateway_parameters->bank_account_number;
                $response['bank_routing_number'] = $gateway->gateway_parameters->bank_routing_number;
                $response['bank_branch_name'] = $gateway->gateway_parameters->bank_branch_name;
            }

            $response['conversion_rate'] = $gateway->conversion_rate;
            $grand_total = $response['total'] * $response['conversion_rate']; //Multiply with total and conversion_rate
            $response['grand_total'] = number_parser($grand_total);

            DB::beginTransaction();
            try {
                $order = new Order();
                $order->customer_id = auth()->id();
                $order->product_id = $product_id;
                $order->donate_price = $amount;


                $order->current_currency = getCurrencyCode();
                $order->gateway_id = $gateway->id;
                $order->gateway_currency = $gateway->gateway_currency;
                $order->conversion_rate = $gateway->conversion_rate;


                $order->subtotal = $amount;
                $adminDonateCommission = empty(getOption('admin_donate_commission')) ? 0 : getOption('admin_donate_commission');
                $calculateAdminDonateCommission = $amount * ($adminDonateCommission / 100);
                $order->admin_commission = $calculateAdminDonateCommission;
                $order->contributor_commission = $amount - $calculateAdminDonateCommission;

                $order->discount = $response['discount'];
                $order->tax_amount = $response['tax'];
                $order->total = $response['total'];
                $order->grand_total = $response['grand_total'];
                $order->payment_status = ORDER_PAYMENT_STATUS_PENDING;
                $order->payment_type = ($gateway_name == 'bank') ? ORDER_PAYMENT_TYPE_BANK : ORDER_PAYMENT_TYPE_ONLINE;
                $order->type = ORDER_TYPE_DONATE;
                $order->save();

                $response['order'] = $order;
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $response['message'] = SOMETHING_WENT_WRONG;
                return $this->failed($response['message']);
            }

            return $this->success($response);
        }

        $response['message'] = SOMETHING_WENT_WRONG;
        return $this->failed($response['message']);
    }

    protected function placeOrderWallet($gateway_name, $amount)
    {
        $gateway = Gateway::whereGatewayName($gateway_name)->active()->first();
        $minAmount = (empty(getOption('min_wallet_amount')) ? 1 : getOption('min_wallet_amount'));
        $maxAmount = (empty(getOption('max_wallet_amount')) ? 1 : getOption('max_wallet_amount'));
        Log::info(json_encode($gateway));
        Log::info($minAmount);
        Log::info($maxAmount);
        Log::info($amount);
        if ($gateway && $amount <= $maxAmount && $amount >= $minAmount) {

            DB::beginTransaction();
            try {
                //Start:: wallet add money start
                $wallet = new WalletMoney();
                $wallet->customer_id = Auth::id();
                $wallet->gateway_name = $gateway_name;
                $wallet->gateway_currency = $gateway->gateway_currency;
                $wallet->conversion_rate = $gateway->conversion_rate;
                $wallet->amount = $amount;
                $grand_total = $amount * $gateway->conversion_rate; //Multiply with total amount and conversion_rate
                $wallet->grand_total = number_parser($grand_total);
                $wallet->status = WALLET_MONEY_STATUS_PENDING;
                $wallet->save();
                $response = $wallet;

                $response['amount'] = $amount;
                $response['subtotal'] = $amount;
                $response['discount'] = 0;
                $response['tax'] = 0;
                $response['total'] = $response['subtotal'] - $response['discount'];
                $response['message'] = '';
                $response['gateway_name'] = $gateway_name;
                $response['gateway_currency'] = $gateway->gateway_currency;
                if ($gateway_name == BANK) {
                    $response['bank_name'] = $gateway->gateway_parameters->bank_name;
                    $response['bank_account_number'] = $gateway->gateway_parameters->bank_account_number;
                    $response['bank_routing_number'] = $gateway->gateway_parameters->bank_routing_number;
                    $response['bank_branch_name'] = $gateway->gateway_parameters->bank_branch_name;
                }

                $response['conversion_rate'] = $gateway->conversion_rate;
                $grand_total = $response['total'];
                $response['grand_total'] = number_parser($grand_total) * $response['conversion_rate'];
                //End:: wallet add money start

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $response['message'] = $e->getMessage();
                return $this->failed($response['message']);
            }

            return $this->success($response);
        }

        $response['message'] = SOMETHING_WENT_WRONG;
        return $this->failed([], $response['message']);
    }

    protected function placeOrderProduct($gateway_name, $productId, $variationId)
    {
        $gateway = Gateway::whereGatewayName($gateway_name)->first();
        $product = Product::where(['products.id' => $productId, 'products.status' => PRODUCT_STATUS_PUBLISHED, 'product_variations.id' => $variationId])
            ->join('product_variations', 'product_variations.product_id', '=', 'products.id')
            ->select('products.id', 'products.title', 'product_variations.price')
            ->first();
        if ($gateway && $product) {
            $response['subtotal'] = $product->price;
            $response['title'] = $product->title;

            $response['discount'] = 0;
            $response['tax'] = 0;
            $response['total'] = $response['subtotal'] - $response['discount'];
            $response['message'] = '';
            $response['gateway_name'] = $gateway_name;
            $response['gateway_currency'] = $gateway->gateway_currency;

            $response['tax'] = $response['total'] * (@$product->tax->percentage / 100);
            $response['total'] = $response['subtotal'] - $response['discount'] + $response['tax']; //Calculation with subtotal, discount, tax

            $response['conversion_rate'] = $gateway->conversion_rate;
            $grand_total = $response['total'] * $response['conversion_rate']; //Multiply with total and conversion_rate
            $response['grand_total'] = number_parser($grand_total);

            DB::beginTransaction();
            try {
                $order = new Order();
                $order->customer_id = auth()->id();
                $order->product_id = $productId;
                $order->variation_id = $variationId;
                $order->donate_price = null;
                $order->product_price = $product->price;

                $order->current_currency = getCurrencyCode();
                $order->gateway_id = $gateway->id;
                $order->gateway_currency = $gateway->gateway_currency;
                $order->conversion_rate = $gateway->conversion_rate;

                $order->subtotal = $product->price;
                $adminProductCommission = empty(getOption('admin_product_commission')) ? 0 : getOption('admin_product_commission');
                $calculateAdminProductCommission = $product->price * ($adminProductCommission / 100);
                $order->admin_commission = $calculateAdminProductCommission;
                $order->contributor_commission = $product->price - $calculateAdminProductCommission;

                $order->discount = $response['discount'];
                $order->tax_amount = $response['tax'];
                $order->total = $response['total'];
                $order->grand_total = $response['grand_total'];
                $order->payment_status = ORDER_PAYMENT_STATUS_PENDING;
                $order->payment_type = ($gateway_name == 'bank') ? ORDER_PAYMENT_TYPE_BANK : ORDER_PAYMENT_TYPE_ONLINE;
                $order->type = ORDER_TYPE_PRODUCT;
                $order->save();

                $response['id'] = $order->id;
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $response['message'] = SOMETHING_WENT_WRONG;
                return $this->failed($response['message']);
            }

            return $this->success($response);
        }

        $response['message'] = SOMETHING_WENT_WRONG;
        return $this->failed($response['message']);
    }

    protected function applyCoupon(Request $request)
    {
        $id = $request->get('id', '');
        $coupon_name = $request->get('coupon_name', '');
        try {
            DB::beginTransaction();
            $order = Order::findOrFail($id);
            if ($coupon_name) {
                $coupon = Coupon::whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())->where('name', $coupon_name)->active()->first();
                /* Check coupon is valid or invalid*/
                if ($coupon) {
                    $customerCouponUsedCount = CustomerCoupon::where('customer_id', Auth::id())->where('coupon_id', $coupon->id)->whereHas('order', function ($q) {
                        $q->wherePaymentStatus(ORDER_PAYMENT_STATUS_PAID);
                    })->count();

                    if ($coupon->use_type == DISCOUNT_USE_TYPE_MULTIPLE) {
                        /* If you use_type 2(Multiple), check how many times can be use this coupon*/
                        if ($coupon->maximum_use_limit > $customerCouponUsedCount) {
                            if ($coupon->discount_type == DISCOUNT_TYPE_PERCENTAGE) {
                                $response['discount'] = $order->subtotal * ($coupon->discount_value / 100);
                            } elseif ($coupon->discount_type == DISCOUNT_TYPE_AMOUNT) {
                                if ($order->subtotal >= $coupon->minimum_amount) {
                                    $response['discount'] = $coupon->discount_value;
                                } else {
                                    $response['message'] = 'You must spend at least ' . getCurrencySymbol() . $coupon->minimum_amount . ' to use this coupon.';
                                }
                            }
                        } else {
                            $response['message'] = 'Sorry! You\'ve already reached the coupon\'s upper limit.';
                        }
                    } elseif ($coupon->use_type == DISCOUNT_USE_TYPE_SINGLE) {
                        if (!$customerCouponUsedCount) {
                            if ($coupon->discount_type == DISCOUNT_TYPE_PERCENTAGE) {
                                $response['discount'] = $order->subtotal * ($coupon->discount_value / 100);
                            } elseif ($coupon->discount_type == DISCOUNT_TYPE_AMOUNT) {
                                if ($order->subtotal >= $coupon->minimum_amount) {
                                    $response['discount'] = $coupon->discount_value;
                                } else {
                                    $response['message'] = 'You must spend at least ' . getCurrencySymbol() . $coupon->minimum_amount . ' to use this coupon.';
                                }
                            }
                        } else {
                            $response['message'] = 'Sorry! You\'ve already reached the coupon\'s upper limit.';
                        }
                    }
                    $customerCoupon = new CustomerCoupon();
                    $customerCoupon->customer_id = auth()->id();
                    $customerCoupon->coupon_id = $coupon->id;
                    $customerCoupon->order_id = $order->id;
                    $customerCoupon->save();
                    $order->coupon_id = $coupon->id;
                    $order->coupon_discount_type = $coupon->discount_type;
                    $order->coupon_discount_value = $coupon->discount_value;
                    $order->discount = $response['discount'];
                    $order->grand_total = $order->subtotal - $response['discount'];
                    $order->save();
                } else {
                    DB::rollBack();
                    return $this->failed([], __('Coupon not found'));
                }

                $response['total'] = $order->subtotal - $response['discount'];
                $response['grand_total'] = $response['total'] * $order->conversion_rate;
                DB::commit();
                return $this->success($response);
            }
            return $this->failed([], __('Coupon not found'));
        } catch (\Exception $e) {
            DB::rollBack();
            $response['message'] = $e->getMessage();
            return $this->failed([], $response['message']);
        }
    }

    public function paymentVerify(Request $request)
    {
        if ($request->type == 'wallet') {
            return $this->walletPaymentVerify($request);
        } else {
            $order_id = $request->get('id', '');
            $payerId = $request->get('payer_id', NULL);
            $payment_id = $request->get('payment_id', NULL);
            $order = Order::findOrFail($order_id);

            if ($order->payment_status == ORDER_PAYMENT_STATUS_PAID) {
                $response['message'] = 'Your order has been paid!';
                return $this->failed([], $response['message']);
            }

            if ($order->gateway->gateway_name == MERCADOPAGO) {
                $order->payment_id = $payment_id;
                $order->save();
            }

            $payment_id = $order->payment_id;

            $gatewayBasePayment = new Payment($order->gateway->gateway_name);
            $payment_data = $gatewayBasePayment->paymentConfirmation($payment_id, $payerId);

            if ($payment_data['success']) {
                if ($payment_data['data']['payment_status'] == 'success') {
                    DB::beginTransaction();
                    try {
                        $order->payment_status = ORDER_PAYMENT_STATUS_PAID;
                        $order->save();
                        if (($order->type == ORDER_TYPE_PRODUCT || $order->type == ORDER_TYPE_DONATE) && @$order->product->customer_id) {
                            Customer::find(@$order->product->customer_id)->increment('earning_balance', $order->contributor_commission);
                        }

                        if ($order->type == ORDER_TYPE_PRODUCT) {
                            $this->userPurchase($order->id);
                        }

                        $this->referralHistory($order->id);
                        DB::commit();

                        return $this->success([], __('Payment Successfully'));
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return $this->failed([], __('Payment Failed'));
                    }
                }
            }
            return $this->failed([], __('Payment Failed'));
        }

    }

    public function walletPaymentVerify($request)
    {
        $walletId = $request->get('id', '');
        $payerId = $request->get('payer_id', NULL);
        $payment_id = $request->get('payment_id', NULL);
        $wallet = WalletMoney::findOrFail($walletId);

        if ($wallet->payment_status == ORDER_PAYMENT_STATUS_PAID) {
            $response['message'] = 'Your payment has been paid!';
            return $this->failed([], $response['message']);
        }

        if ($wallet->gateway_name == MERCADOPAGO) {
            $wallet->payment_id = $payment_id;
            $wallet->save();
        }

        $payment_id = $wallet->payment_id;
        $gatewayBasePayment = new Payment($wallet->gateway_name);
        $payment_data = $gatewayBasePayment->paymentConfirmation($payment_id, $payerId);

        if ($payment_data['success']) {
            if ($payment_data['data']['payment_status'] == 'success') {
                DB::beginTransaction();
                try {
                    $wallet->status = WALLET_MONEY_STATUS_PAID;
                    $wallet->save();

                    if ($wallet->customer_id) {
                        Customer::find($wallet->customer_id)->increment('wallet_balance', $wallet->amount);
                    }
                    DB::commit();
                    $response['message'] = 'Congratulations! Your wallet amount has been added successfully';
                    return $this->success([], $response['message']);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return $this->failed([], __('Payment Failed'));
                }
            }
        }
        return $this->failed([], __('Payment Failed'));
    }

    public static function referralHistory($order_id)
    {
        $referralHistory = ReferralHistory::where('order_id', $order_id)->first();
        if ($referralHistory) {
            $referral = Referral::find($referralHistory->referral_id);
            if ($referral) {
                if ($referral->status != REFERRAL_STATUS_PAID) {
                    Referral::where('id', $referralHistory->referral_id)->update(['status' => REFERRAL_STATUS_PAID]);
                    $referralHistory->update(['status' => REFERRAL_HISTORY_STATUS_PAID]);
                    if ($referralHistory->referred_customer_id) {
                        Customer::find($referralHistory->referred_customer_id)->increment('earning_balance', $referralHistory->earned_amount);
                    }
                }
            }
        }
    }

    public static function userPurchase($order_id)
    {
        $order = Order::find($order_id);
        $userPurchase = new UserPurchase();
        $userPurchase->order_id = $order->id;
        $userPurchase->product_id = $order->product->id;
        $userPurchase->variations_id = $order->variation_id;
        $userPurchase->customer_id = Auth::id();
        $userPurchase->owner_id = $order->product->uploded_by == 1 ? $order->product->user_id : $order->product->customer_id;
        $userPurchase->owner_type = $order->product->uploded_by;
        $userPurchase->licence = str_replace("-", "", uuid_create());
        $userPurchase->price = $order->total;
        $userPurchase->save();
    }
}
