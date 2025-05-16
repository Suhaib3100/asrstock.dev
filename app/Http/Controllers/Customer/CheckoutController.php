<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Services\Payment\Payment;
use App\Models\Bank;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    use ApiStatusTrait;

    public function checkout(Request $request)
    {
        $data['pageTitle'] = __('Checkout');
        $data['searchDisable'] = true;
        $data['banks'] = Bank::where('status', ACTIVE)->get();

        // Initialize the checkout data based on the type
        $this->initializeCheckoutData($request, $data);

        // If the total amount is not set, there's an error
        if (!isset($data['total'])) {
            return $this->redirectToErrorPage();
        }

        if ($request->has('applied_coupon')) {
            $queryParams = $request->query();
            unset($queryParams['applied_coupon']); // Remove 'applied_coupon' from the query

            return redirect()->route('customer.checkout.page', $queryParams);
        }

        if(isset($data['coupon_status']) && $data['coupon_status'] == false){
            $queryParams = $request->query();
            unset($queryParams['coupon_name']); // Remove 'applied_coupon' from the query

            return redirect()->route('customer.checkout.page', $queryParams);
        }


        return view('customer.checkout', $data);
    }

    private function initializeCheckoutData(Request $request, &$data)
    {
        // Handle different checkout types
        switch ($request->type) {
            case 'plan':
                $this->handlePlanCheckout($request, $data);
                break;
            case 'wallet':
                $this->handleWalletCheckout($request, $data);
                break;
            case 'product':
                $this->handleProductCheckout($request, $data);
                break;
            case 'donation':
                $this->handleDonationCheckout($request, $data);
                break;
            default:
                $this->redirectToErrorPage();
                break;
        }
    }

    private function handlePlanCheckout(Request $request, &$data)
    {
        $data['plan'] = Plan::where('slug', $request->slug)->with('planBenefits')->first();
        if (is_null($data['plan']) || is_null($request->duration)) {
            return $this->redirectToErrorPage();
        }

        $data['gateways'] = $this->getActiveGateways();
        $data['duration'] = $request->duration;
        $data['coupon_name'] = $request->coupon_name;
        $data['subtotal'] = $request->duration == ORDER_PLAN_DURATION_TYPE_MONTH ? $data['plan']->monthly_price : $data['plan']->yearly_price;

        // Apply coupon if available
        $this->applyCoupon($request, $data);

        // Calculate tax and total
        $this->calculateTaxAndTotal($data, $data['plan']->tax);
    }

    private function handleWalletCheckout(Request $request, &$data)
    {
        $request->validate([
            'amount' => 'required|numeric|min:' . (empty(getOption('min_wallet_amount')) ? 1 : getOption('min_wallet_amount')) . '|max:' . (empty(getOption('max_wallet_amount')) ? 1 : getOption('max_wallet_amount')),
        ]);

        $data['gateways'] = $this->getActiveWalletGateways();
        $data['total'] = $request->amount;
    }

    private function handleProductCheckout(Request $request, &$data)
    {
        $data['product'] = Product::where(['products.slug' => $request->slug, 'products.status' => PRODUCT_STATUS_PUBLISHED, 'product_variations.id' => $request->variation])
            ->join('product_variations', 'product_variations.product_id', '=', 'products.id')
            ->select('products.id', 'products.tax_id', 'products.slug', 'products.title', 'product_variations.price', 'product_variations.variation', 'product_variations.id as variation_id')
            ->first();

        if (is_null($data['product'])) {
            return $this->redirectToErrorPage();
        }

        $data['gateways'] = $this->getActiveGateways();
        $data['coupon_name'] = $request->coupon_name;
        $data['subtotal'] = $data['product']->price;

        // Apply coupon if available
        $this->applyCoupon($request, $data);

        // Calculate tax and total
        $this->calculateTaxAndTotal($data, $data['product']->tax);
    }

    private function handleDonationCheckout(Request $request, &$data)
    {
        $data['product'] = Product::where(['products.slug' => $request->slug, 'products.status' => PRODUCT_STATUS_PUBLISHED])->first();

        $request->validate([
            'amount' => 'required|numeric|min:' . (empty(getOption('min_wallet_amount')) ? 1 : getOption('min_wallet_amount')) . '|max:' . (empty(getOption('max_wallet_amount')) ? 1 : getOption('max_wallet_amount')),
        ]);

        if (is_null($data['product'])) {
            return $this->redirectToErrorPage();
        }

        $data['gateways'] = $this->getActiveGateways();
        $data['total'] = $request->amount;
    }

    private function applyCoupon(Request $request, &$data)
    {
        $data['discount'] = 0;

        if ($request->coupon_name) {
            $couponResponse = $this->validateCoupon($request->coupon_name, $data['subtotal']);
            if ($couponResponse['status']) {
                $data['discount'] = $couponResponse['discount'];
                if ($request->applied_coupon) {
                    Session::flash('success', __('Coupon applied successfully'));
                    $data['coupon_status'] = true;
                }
            } else {
                Session::flash('error', $couponResponse['message']);
                $data['coupon_status'] = false;
            }
        }
    }

    private function calculateTaxAndTotal(&$data, $tax)
    {
        $data['tax'] = 0;

        if ($tax) {
            $data['tax'] = ($data['subtotal'] - $data['discount']) * ($tax->percentage / 100);
        }

        $data['total'] = $data['subtotal'] - $data['discount'] + $data['tax'];
    }

    private function getActiveGateways()
    {
        return Gateway::select('id', 'image', 'gateway_name', 'gateway_slug', 'gateway_currency', 'gateway_name', 'conversion_rate')->active()->get();
    }

    private function getActiveWalletGateways()
    {
        return Gateway::select('id', 'gateway_name', 'image', 'gateway_slug', 'gateway_currency', 'gateway_name', 'conversion_rate')->where('wallet_gateway_status', ACTIVE)->active()->get();
    }

    private function redirectToErrorPage()
    {
        return redirect(route('frontend.index'))->with(['error' => __(SOMETHING_WENT_WRONG)]);
    }

    private function validateCoupon($coupon_name, $subtotal)
    {
        try {
            // Fetch the coupon from the database
            $coupon = Coupon::whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->where('name', $coupon_name)
                ->active()
                ->first();

            if ($coupon) {
                $discount = 0;

                // Check if the coupon has already been used by the customer
                $customerCouponUsedCount = CustomerCoupon::where('customer_id', auth()->id())
                    ->where('coupon_id', $coupon->id)
                    ->whereHas('order', function ($q) {
                        $q->wherePaymentStatus(ORDER_PAYMENT_STATUS_PAID);
                    })->count();

                if ($coupon->use_type == DISCOUNT_USE_TYPE_MULTIPLE) {
                    if ($coupon->maximum_use_limit > $customerCouponUsedCount) {
                        $discount = $this->calculateDiscount($coupon, $subtotal);
                    } else {
                        return [
                            'status' => false,
                            'message' => __('Sorry! You\'ve already reached the coupon\'s upper limit.')
                        ];
                    }
                } elseif ($coupon->use_type == DISCOUNT_USE_TYPE_SINGLE) {
                    // Validate multiple-use coupon
                    if (!$customerCouponUsedCount) {
                        $discount = $this->calculateDiscount($coupon, $subtotal);
                    } else {
                        return [
                            'status' => false,
                            'message' => __('Sorry! You\'ve already reached the coupon\'s upper limit.')
                        ];
                    }
                }

                return [
                    'status' => true,
                    'discount' => $discount,
                    'coupon' => $coupon,
                ];
            }

            return [
                'status' => false,
                'message' => __('Coupon not found or invalid.'),
            ];

        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    private function calculateDiscount($coupon, $subtotal)
    {
        if ($coupon->discount_type == DISCOUNT_TYPE_PERCENTAGE) {
            return $subtotal * ($coupon->discount_value / 100);
        } elseif ($coupon->discount_type == DISCOUNT_TYPE_AMOUNT && $subtotal >= $coupon->minimum_amount) {
            return $coupon->discount_value;
        }
        return 0;
    }

    public function pay(Request $request)
    {
        $type = $request->type;
        $gateway = Gateway::where('id', $request->gateway_id)->active()->first();

        if (is_null($gateway)) {
            return back()->with(['error' => __('Gateway Not Found')]);
        }

        $paymentData = $this->preparePaymentData($request, $type);

        if (isset($paymentData['error'])) {
            return back()->with(['error' => $paymentData['error']]);
        }

        if ($gateway->gateway_slug === 'bank') {
            $request->validate([
                'bank_id' => 'required',
                'bank_slip' => 'required|mimes:jpg,jpeg,png,pdf',
            ]);
        }

        switch ($gateway->gateway_slug) {
            case 'bank':
                return $this->handleBankPayment($type, $request, $paymentData, $gateway);
            case 'cash':
                return $this->handleCashPayment($type, $paymentData, $gateway);
            case 'wallet':
                return $this->handleWalletPay($type, $paymentData, $gateway);
            default:
                return $this->handleNonBankPayment($type, $paymentData, $gateway);
        }
    }

    private function preparePaymentData(Request $request, $type)
    {
        switch ($type) {
            case ORDER_TYPE_PLAN:
                return $this->preparePlanPaymentData($request);

            case ORDER_TYPE_WALLET:
                return $this->prepareWalletPaymentData($request);

            case ORDER_TYPE_PRODUCT:
                return $this->prepareProductPaymentData($request);

            case ORDER_TYPE_DONATE:
                return $this->prepareDonationPaymentData($request);

            default:
                return ['error' => __('Invalid Order Type')];
        }
    }

    private function preparePlanPaymentData(Request $request)
    {
        $plan = Plan::where(['id' => $request->id])->active()->first();

        if (is_null($plan)) {
            return ['error' => __('Plan Not Found')];
        }

        $plan_duration_type = $request->duration;
        $plan_price = ($plan_duration_type == ORDER_PLAN_DURATION_TYPE_YEAR) ? $plan->yearly_price : $plan->monthly_price;

        $couponResponse = $this->validateCoupon($request->coupon_name, $plan_price);
        $discount = $couponResponse['status'] ? $couponResponse['discount'] : 0;

        if (customerPlanExit(auth()->id())) {
            return ['error' => __('You already have a plan. You can buy again after the current plan ends.')];
        }

        return [
            'plan' => $plan,
            'plan_duration_type' => $plan_duration_type,
            'plan_price' => $plan_price,
            'discount' => $discount,
        ];
    }

    private function prepareWalletPaymentData(Request $request)
    {
        $amount = $request->get('amount', 0);

        if ($amount < getOption('min_wallet_amount', 1)) {
            return ['error' => __('This amount is not allowed. Please check again.')];
        }

        return [
            'amount' => $amount,
        ];
    }

    private function prepareProductPaymentData(Request $request)
    {
        $product = Product::where(['products.id' => $request->id, 'products.status' => PRODUCT_STATUS_PUBLISHED, 'product_variations.id' => $request->variation])
            ->join('product_variations', 'product_variations.product_id', '=', 'products.id')
            ->select('products.id', 'products.tax_id', 'products.slug', 'products.title', 'product_variations.price', 'product_variations.variation', 'product_variations.id as variation_id')
            ->first();

        if (is_null($product)) {
            return back()->with(['error' => __('Product Not Found')]);
        }

        $discount = 0;
        $coupon_id = null;

        $couponResponse = $this->validateCoupon($request->coupon_name, $product->price);
        if ($couponResponse['status']) {
            $discount = $couponResponse['discount'];
            $coupon_id = $couponResponse['coupon']->id;
        }

        return [
            'product' => $product,
            'price' => $product->price,
            'discount' => $discount,
            'coupon_id' => $coupon_id,
        ];
    }

    private function prepareDonationPaymentData(Request $request)
    {
        $product = Product::where(['products.slug' => $request->slug, 'products.status' => PRODUCT_STATUS_PUBLISHED])->first();

        $request->validate([
            'amount' => 'required|numeric|min:' . (empty(getOption('min_wallet_amount')) ? 1 : getOption('min_wallet_amount')) . '|max:' . (empty(getOption('max_wallet_amount')) ? 1 : getOption('max_wallet_amount')),
        ]);

        if (is_null($product)) {
            return ['error' => __('Product Not Found')];
        }

        return [
            'product' => $product,
            'total' => $request->amount,
        ];
    }

    public function handleBankPayment($type, $request, $paymentData, $gateway)
    {
        DB::beginTransaction();
        try {
            $bank = Bank::where(['gateway_id' => $gateway->id, 'id' => $request->bank_id])->firstOrFail();
            $bank_id = $bank->id;
            $deposit_slip_id = null;

            // If deposit slip exists, upload it
            if ($request->hasFile('bank_slip')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('payments', $request->bank_slip);
                $deposit_slip_id = $uploaded['file']->id;
            }

            $this->placeOrder(
                $type,
                $paymentData,
                $gateway,
                $bank_id,
                $deposit_slip_id
            );

            DB::commit();
            return redirect()->route('customer.checkout.success', ['success' => true, 'message' => __('Bank details sent successfully! Wait for approval')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('customer.checkout.success')->with(['error' => __('Your payment has failed!')]);
        }
    }

    public function handleWalletPay($type, $paymentData, $gateway)
    {
        DB::beginTransaction();
        try {

            $order = $this->placeOrder(
                $type,
                $paymentData,
                $gateway,
            );

            if (auth()->user()->wallet_balance < $order->grand_total) {
                DB::rollBack();
                return back()->with(['error' => __('Sorry! Your wallet balance less than order amount.')]);
            }

            $order->gateway_transaction = randomString();
            $order->payment_status = ORDER_PAYMENT_STATUS_PAID;
            $order->save();

            auth()->user()->decrement('wallet_balance', $order->grand_total);
            $order->payment_status = ORDER_PAYMENT_STATUS_PAID;
            $order->save();

            if (($order->type == ORDER_TYPE_PRODUCT || $order->type == ORDER_TYPE_DONATE) && @$order->product->customer_id) {
                Customer::find(@$order->product->customer_id)->increment('earning_balance', $order->contributor_commission);
            }

            if ($order->type == ORDER_TYPE_PRODUCT) {
                $this->userPurchase($order);
            }

            if ($order->type == ORDER_TYPE_PLAN) {
                $this->createCustomerPlan($order);
            }

            DB::commit();
            return redirect()->route('customer.checkout.success', ['success' => true, 'message' => __('Your payment has been successfully!')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('customer.checkout.success')->with(['error' => __('Your payment has failed!')]);
        }
    }

    public function handleCashPayment($type, $paymentData, $gateway)
    {
        DB::beginTransaction();
        try {
            $this->placeOrder(
                $type,
                $paymentData,
                $gateway,
            );

            DB::commit();
            return redirect()->route('customer.checkout.success', ['success' => true, 'message' => __('Cash payment initiated! Wait for approval')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('customer.checkout.success')->with(['error' => __('Your payment has failed!')]);
        }
    }

    // Handle non-bank payments (e.g., credit card, PayPal, etc.)
    private function handleNonBankPayment($type, $paymentData, $gateway)
    {
        // Place the order
        $entity = $this->placeOrder($type, $paymentData, $gateway);
        $total = $entity->grand_total;

        // Prepare the object for the external payment gateway
        $object = [
            'id' => $entity->id,
            'callback_url' => route('payment.verify', $type),
            'cancel_url' => route('customer.checkout.success', ['success' => false, 'message' => __('Your payment has failed')]),
            'currency' => $gateway->gateway_currency
        ];

        if ($entity instanceof Order && $entity->type == ORDER_TYPE_PLAN) {
            $productPrice = $entity->plan->subscriptionPrice->where('gateway_id', $gateway->id)->first();
            if ($productPrice) {
                $object['callback_url'] = route('payment.verify', ['type' => $type, 'subscription_success' => true]);
                $payment = new Payment($gateway->gateway_slug, $object);
                $planId = $entity->plan_duration_type == ORDER_PLAN_DURATION_TYPE_MONTH ? $productPrice->monthly_price_id : $productPrice->yearly_price_id;
                $responseData = $payment->subscribeSaas($planId, ['plan_id' => $entity->plan_id, 'plan_gateway_price_id' => $productPrice->id, 'duration_type' => $entity->plan_duration_type, 'customer_id' => auth()->id()]);
            } else {
                // Create a new Payment instance and process the payment
                $payment = new Payment($gateway->gateway_slug, $object);
                $responseData = $payment->makePayment($total);
            }
        } else {
            // Create a new Payment instance and process the payment
            $payment = new Payment($gateway->gateway_slug, $object);
            $responseData = $payment->makePayment($total);
        }

        if ($responseData['success']) {
            $entity->payment_id = $responseData['payment_id'];
            $entity->save();
            return redirect($responseData['redirect_url']);
        } else {
            return redirect()->back()->with(['error' => $responseData['message']]);
        }
    }

    public function placeOrder($type, $paymentData, $gateway, $bank_id = null, $deposit_slip_id = null)
    {
        if ($type == ORDER_TYPE_PLAN || $type == ORDER_TYPE_PRODUCT || $type == ORDER_TYPE_DONATE) {
            $order = new Order();
            $order->customer_id = auth()->id();
            $order->gateway_id = $gateway->id;
            $order->gateway_currency = $gateway->gateway_currency;
            $order->conversion_rate = $gateway->conversion_rate;
            $order->current_currency = getCurrencyCode();
        }

        // Handle order specific details (plan, product, wallet)
        if ($type == ORDER_TYPE_PLAN) {
            return $this->createPlanOrder($order, $paymentData, $gateway, $bank_id, $deposit_slip_id);
        } elseif ($type == ORDER_TYPE_PRODUCT) {
            return $this->createProductOrder($order, $paymentData, $gateway, $bank_id, $deposit_slip_id);
        } elseif ($type == ORDER_TYPE_DONATE) {
            return $this->createDonationOrder($order, $paymentData, $gateway, $bank_id, $deposit_slip_id);
        } elseif ($type == ORDER_TYPE_WALLET) {
            return $this->createWalletOrder($paymentData, $gateway, $bank_id, $deposit_slip_id);
        }
    }

    protected function createPlanOrder($order, $paymentData, $gateway, $bank_id, $deposit_slip_id)
    {
        $order->plan_id = $paymentData['plan']->id;
        $order->plan_price = $paymentData['plan_price'];
        $order->plan_duration_type = $paymentData['plan_duration_type'];
        $order->subtotal = $paymentData['plan_price'];
        $order->discount = $paymentData['discount'];

        $total = $this->calculateTotalWithTax($paymentData['plan_price'], $paymentData['discount'], $paymentData['plan']->tax, $order);
        $order->total = $total;
        $order->grand_total = $total * $gateway->conversion_rate;

        $order->payment_status = ORDER_PAYMENT_STATUS_PENDING;
        $order->payment_type = $this->determinePaymentType($gateway);
        $order->bank_id = $bank_id;
        $order->bank_deposit_slip = $deposit_slip_id;
        $order->type = ORDER_TYPE_PLAN;
        $order->save();

        return $order;
    }

    protected function createProductOrder($order, $paymentData, $gateway, $bank_id, $deposit_slip_id)
    {
        $order->product_id = $paymentData['product']->id;
        $order->variation_id = $paymentData['product']->variation_id;
        $order->product_price = $paymentData['product']->price;
        $order->subtotal = $paymentData['product']->price;
        $order->discount = $paymentData['discount'];

        $total = $this->calculateTotalWithTax($paymentData['product']->price, $paymentData['discount'], $paymentData['product']->tax, $order);
        $order->total = $total;
        $order->grand_total = $total * $gateway->conversion_rate;

        $adminProductCommission = empty(getOption('admin_product_commission')) ? 0 : getOption('admin_product_commission');
        $calculateAdminProductCommission = $paymentData['product']->price * ($adminProductCommission / 100);
        $order->admin_commission = $calculateAdminProductCommission;
        $order->contributor_commission = $paymentData['product']->price - $calculateAdminProductCommission;
        $order->payment_status = ORDER_PAYMENT_STATUS_PENDING;
        $order->payment_type = $this->determinePaymentType($gateway);
        $order->bank_id = $bank_id;
        $order->bank_deposit_slip = $deposit_slip_id;
        $order->type = ORDER_TYPE_PRODUCT;
        $order->save();

        $coupon = Coupon::where('id', $paymentData['coupon_id'])->first();
        if ($coupon) {
            $customerCoupon = new CustomerCoupon();
            $customerCoupon->customer_id = $order->customer_id;
            $customerCoupon->coupon_id = $coupon->id;
            $customerCoupon->order_id = $order->id;
            $customerCoupon->save();

            $order->coupon_id = $coupon->id;
            $order->coupon_discount_type = $coupon->discount_type;
            $order->coupon_discount_value = $coupon->discount_value;
            $order->save();
        }

        return $order;
    }

    protected function createDonationOrder($order, $paymentData, $gateway, $bank_id, $deposit_slip_id)
    {
        $order->product_id = $paymentData['product']->id;
        $order->donate_price = $paymentData['total'];
        $order->subtotal = $paymentData['total'];
        $order->total = $paymentData['total'];
        $order->grand_total = $paymentData['total'] * $gateway->conversion_rate;
        $adminDonateCommission = empty(getOption('admin_donate_commission')) ? 0 : getOption('admin_donate_commission');
        $calculateAdminDonateCommission = $paymentData['total'] * ($adminDonateCommission / 100);
        $order->admin_commission = $calculateAdminDonateCommission;
        $order->contributor_commission = $paymentData['total'] - $calculateAdminDonateCommission;
        $order->payment_status = ORDER_PAYMENT_STATUS_PENDING;
        $order->payment_type = $this->determinePaymentType($gateway);
        $order->bank_id = $bank_id;
        $order->bank_deposit_slip = $deposit_slip_id;
        $order->type = ORDER_TYPE_DONATE;
        $order->save();

        return $order;

    }

    protected function createWalletOrder($paymentData, $gateway, $bank_id, $deposit_slip_id)
    {
        $wallet = new WalletMoney();
        $wallet->customer_id = auth()->id();
        $wallet->gateway_name = $gateway->gateway_slug;
        $wallet->gateway_currency = $gateway->gateway_currency;
        $wallet->conversion_rate = $gateway->conversion_rate;
        $wallet->amount = $paymentData['amount'];

        $grand_total = $paymentData['amount'] * $wallet->conversion_rate;
        $wallet->grand_total = number_parser($grand_total);
        $wallet->status = WALLET_MONEY_STATUS_PENDING;
        $wallet->bank_id = $bank_id;
        $wallet->bank_deposit_slip = $deposit_slip_id;
        $wallet->save();

        return $wallet;
    }

    protected function calculateTotalWithTax($price, $discount, $tax, &$order)
    {
        $total = ($price - $discount);
        $tax_amount = 0;
        if ($tax) {
            $tax_amount = $price * ($tax->percentage / 100);
            $total += $tax_amount;
            $order->tax_id = $tax->id;
            $order->tax_percentage = $tax->percentage;
        }
        $order->tax_amount = $tax_amount;
        return $total;
    }

    protected function determinePaymentType($gateway)
    {
        if ($gateway->gateway_slug == 'bank') {
            return ORDER_PAYMENT_TYPE_BANK;
        } elseif ($gateway->gateway_slug == 'cash') {
            return ORDER_PAYMENT_TYPE_CASH;
        }
        return ORDER_PAYMENT_TYPE_ONLINE;
    }

    public function successOrFail(Request $request)
    {
        $data['pageTitle'] = __('Payment Confirmation');
        $data['searchDisable'] = true;
        $data['success'] = $request->success;
        $data['message'] = $request->message;
        return view('customer.checkout-success', $data);
    }

    public function verify($type, Request $request)
    {
        if ($request->subscription_success) {
            return redirect()->route('customer.checkout.success', ['success' => true, 'message' => __('Your payment has been successful! Please wait for processing.')]);
        }

        $order_id = $request->get('id', '');
        $payerId = $request->get('PayerID', null);
        $payment_id = $request->get('paymentId', null);

        // Handle the payment verification based on order type
        if ($type == ORDER_TYPE_WALLET) {
            return $this->handleWalletPayment($order_id, $payment_id, $payerId);
        }

        if ($type == ORDER_TYPE_PRODUCT || $type == ORDER_TYPE_DONATE || $type == ORDER_TYPE_PLAN) {
            return $this->handleOrderPayment($order_id, $payment_id, $payerId);
        }

        // Default case for invalid type
        return redirect(route('frontend.index'))->with(['error' => __('Invalid payment type!')]);
    }

    private function handleWalletPayment($order_id, $payment_id, $payerId)
    {
        $wallet = WalletMoney::findOrFail($order_id);

        if (is_null($wallet) || $wallet->status == WALLET_MONEY_STATUS_PAID) {
            return redirect()->route('customer.wallets.index')->with(['error' => __('Your payment does not exist or has already been paid!')]);
        }

        $gateway = Gateway::where('gateway_slug', $wallet->gateway_name)->first();

        return $this->processPayment($gateway, $payment_id, $payerId, $wallet);
    }

    private function handleOrderPayment($order_id, $payment_id, $payerId)
    {
        $order = Order::with('plan')->find($order_id);
        if (is_null($order) || $order->payment_status == ORDER_PAYMENT_STATUS_PAID) {
            return redirect()->route('frontend.pricing')->with(['error' => __('Your order does not exist or has already been paid!')]);
        }

        $gateway = Gateway::find($order->gateway_id);

        return $this->processPayment($gateway, $payment_id, $payerId, $order);
    }

    private function processPayment($gateway, $payment_id, $payerId, $entity)
    {
        DB::beginTransaction();

        try {
            if ($gateway->gateway_slug == MERCADOPAGO) {
                $entity->payment_id = $payment_id;
                $entity->save();
            }

            $payment_data = $this->confirmPayment($gateway, $payment_id, $payerId);

            if ($payment_data['success'] && $payment_data['data']['payment_status'] == 'success') {
                return $this->onPaymentSuccess($entity);
            }

            return $this->onPaymentFailure();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->onPaymentFailure();
        }
    }

    private function confirmPayment($gateway, $payment_id, $payerId)
    {
        $gatewayBasePayment = new Payment($gateway->gateway_slug, ['currency' => $gateway->gateway_currency]);
        return $gatewayBasePayment->paymentConfirmation($payment_id, $payerId);
    }

    private function onPaymentSuccess($entity)
    {
        // For wallet payment
        if ($entity instanceof WalletMoney) {
            $entity->status = WALLET_MONEY_STATUS_PAID;
            $entity->save();

            if ($entity->customer_id) {
                Customer::find($entity->customer_id)->increment('wallet_balance', $entity->amount);
            }
        }

        // For order payment
        if ($entity instanceof Order) {
            $entity->payment_status = ORDER_PAYMENT_STATUS_PAID;
            $entity->save();

            if (($entity->type == ORDER_TYPE_PRODUCT || $entity->type == ORDER_TYPE_DONATE) && @$entity->product->customer_id) {
                Customer::find(@$entity->product->customer_id)->increment('earning_balance', $entity->contributor_commission);
            }

            if ($entity->type == ORDER_TYPE_PRODUCT) {
                $this->userPurchase($entity);
            }

            if ($entity->type == ORDER_TYPE_PLAN) {
                $this->createCustomerPlan($entity);
            }
        }

        DB::commit();
        return redirect()->route('customer.checkout.success', ['success' => true, 'message' => __('Your payment has been successful!')]);
    }

    private function onPaymentFailure()
    {
        return redirect()->route('customer.checkout.success', ['success' => false, 'message' => __('Your payment has failed!')]);
    }

    private function createCustomerPlan($order)
    {
        // Start:: New Plan Created
        $customerPlan = new CustomerPlan();
        $customerPlan->order_id = $order->id;
        $customerPlan->plan_type = $order->plan_duration_type;
        $customerPlan->plan_id = $order->plan_id;
        $customerPlan->customer_id = $order->customer_id;
        $customerPlan->start_date = now();
        $customerPlan->end_date = ($order->plan_duration_type == ORDER_PLAN_DURATION_TYPE_YEAR) ? now()->addYear() : now()->addMonth();

        $plan_details = array(
            "name" => $order->plan->name,
            "price" => $order->plan_price,
            "duration_type" => $order->plan_duration_type,
            "device_limit" => $order->plan->device_limit,
            "download_limit_type" => $order->plan->download_limit_type,
            "download_limit" => $order->plan->download_limit
        );
        $customerPlan->plan_details = $plan_details;
        $customerPlan->save();
        // End:: New Plan Created

        // Start:: Referral Logic
        if (getOption('referral_status') == 1 && isAddonInstalled('PIXELAFFILIATE')) {
            $referral = Referral::where(['child_customer_id' => $order->customer_id, 'status' => REFERRAL_HISTORY_STATUS_DUE])->first();
            if ($referral) {
                $this->processReferral($referral, $order);
            }
        }
    }

    public static function userPurchase($order)
    {
        $userPurchase = new UserPurchase();
        $userPurchase->order_id = $order->id;
        $userPurchase->product_id = $order->product->id;
        $userPurchase->variations_id = $order->variation_id;
        $userPurchase->customer_id = $order->customer_id;
        $userPurchase->owner_id = $order->product->uploded_by == 1 ? $order->product->user_id : $order->product->customer_id;
        $userPurchase->owner_type = $order->product->uploded_by;
        $userPurchase->licence = str_replace("-", "", uuid_create());
        $userPurchase->price = $order->total;
        $userPurchase->save();
    }

    private function processReferral($referral, $order)
    {
        $referredParentCustomer = Customer::find($referral->parent_customer_id);
        $referral_commission = empty(getOption('referral_commission')) ? 0 : getOption('referral_commission');
        if ($referredParentCustomer) {
            $referralHistory = new ReferralHistory();
            $referralHistory->transaction_no = Str::uuid()->getHex();
            $referralHistory->referred_customer_id = $referredParentCustomer->id;
            $referralHistory->buyer_customer_id = $order->customer_id;
            $referralHistory->order_id = $order->id;
            $referralHistory->plan_name = $order->plan->name;
            $referralHistory->plan_price = $order->plan_price;
            $referralHistory->actual_amount = $order->plan_price;
            $referralHistory->commission_percentage = $referral_commission;
            $referralHistory->earned_amount = $order->plan_price * ($referral_commission / 100);
            $referralHistory->status = REFERRAL_STATUS_PAID;
            $referralHistory->referral_id = $referral->id;
            $referralHistory->save();

            $referredParentCustomer->increment('earning_balance', $referralHistory->earned_amount);

            $referral->update(['status' => REFERRAL_STATUS_PAID]);
        }
    }


    public function webhook(Request $request)
    {
        // Retrieve the gateway based on the payment method (Stripe or PayPal)
        $gateway = Gateway::where(['gateway_slug' => $request->payment_method])->first();
        Log::info('Start Webhook');
        if (!$gateway) {
            Log::info('Gateway not found');
        }

        // Define the payment service object dynamically
        $object = [
            'type' => 'subscription',
            'currency' => $gateway->gateway_currency,
        ];

        $paymentService = new Payment($request->payment_method, $object);

        // Handle the webhook request using the respective service (Stripe or PayPal)
        $response = $paymentService->handleWebhook($request);
        Log::info($response);
        if ($response['success']) {
            // Determine whether the event is from Stripe or PayPal and handle it accordingly
            $event = $response['event'];

            Log::info($event);

            if ($request->payment_method === 'stripe') {
                // Call Stripe specific webhook handler
                $this->stripeWebhook($event);
            } elseif ($request->payment_method === 'paypal') {
                // Call PayPal specific webhook handler
                $this->paypalWebhook($event);
            }

            return response()->json(['success' => true, 'message' => 'Webhook handled successfully']);
        } else {
            return response()->json(['success' => false, 'message' => $response['message']]);
        }
    }

    function stripeWebhook($event)
    {
        try {
            DB::beginTransaction();
            // Process the event based on its type
            switch ($event->type) {
                case 'invoice.created':
                    $response = $event->data->object;
                    $metaData = $response->subscription_details->metadata;
                    $planData = $response->lines->data[0]->plan;

                    $planType = $planData->interval == 'month' ? ORDER_PLAN_DURATION_TYPE_MONTH : ORDER_PLAN_DURATION_TYPE_YEAR;
                    $plan = Plan::where('id', $metaData->plan_id)->first();

                    $price = $planData->interval == 'month' ? $plan->monthly_price : $plan->yearly_price;

                    if ($price * 100 <= $response->total) {
                        $payment = Order::where(['payment_id' => $response->id])->first();
                        if (is_null($payment)) {
                            $gateway = Gateway::where(['gateway_slug' => STRIPE, 'status' => ACTIVE])->firstOrFail();
                            $order = $this->placeOrderWebhook($plan, $planType, $gateway, $gateway->gateway_currency, $metaData->customer_id);
                            $order->payment_id = $response->id;
                            $order->save();
                        } else {
                            Log::info('--------***Already order found***------');
                            Log::info('--------***Check if invoice order already exist END***------');
                        }
                    } else {
                        Log::info('--------***Amount mismatch***------');
                        Log::info('--------***Webhook END***------');
                    }
                    DB::commit();
                    break;
                case 'invoice.payment_succeeded':
                    $response = $event->data->object;
                    $metaData = $response->subscription_details->metadata;
                    //check if the payment is there and in processing
                    Log::info('--------***Check if order exist or order status in processing START***------');
                    $order = Order::where('payment_id', $response->id)->first();
                    if (!is_null($order) && $order->payment_status == ORDER_PAYMENT_STATUS_PENDING) {
                        Log::info('--------***Order found***------');
                        Log::info('--------***Order invoice verify START***------');
                        $order->payment_status = ORDER_PAYMENT_STATUS_PAID;
                        $order->save();

                        // Start:: New Plan Created
                        $customerPlan = new CustomerPlan();
                        $customerPlan->order_id = $order->id;
                        $customerPlan->plan_type = $order->plan_duration_type;
                        $customerPlan->plan_id = $order->plan_id;
                        $customerPlan->customer_id = $order->customer_id;
                        $customerPlan->start_date = now();
                        $customerPlan->end_date = ($order->plan_duration_type == ORDER_PLAN_DURATION_TYPE_YEAR) ? now()->addYear() : now()->addMonth();

                        $plan_details = array(
                            "name" => $order->plan->name,
                            "price" => $order->plan_price,
                            "duration_type" => $order->plan_duration_type,
                            "device_limit" => $order->plan->device_limit,
                            "download_limit_type" => $order->plan->download_limit_type,
                            "download_limit" => $order->plan->download_limit
                        );
                        $customerPlan->plan_details = $plan_details;
                        $customerPlan->save();
                        // End:: New Plan Created

                        // Start:: Referral Logic
                        if (getOption('referral_status') == 1 && isAddonInstalled('PIXELAFFILIATE')) {
                            $referral = Referral::where(['child_customer_id' => $order->customer_id, 'status' => REFERRAL_HISTORY_STATUS_DUE])->first();
                            if ($referral) {
                                $referredParentCustomer = Customer::find($referral->parent_customer_id);
                                $referral_commission = empty(getOption('referral_commission')) ? 0 : getOption('referral_commission');
                                if ($referredParentCustomer) {
                                    $referralHistory = new ReferralHistory();
                                    $referralHistory->transaction_no = Str::uuid()->getHex();
                                    $referralHistory->referred_customer_id = $referredParentCustomer->id;
                                    $referralHistory->buyer_customer_id = $order->customer_id;
                                    $referralHistory->order_id = $order->id;
                                    $referralHistory->plan_name = $order->plan->name;
                                    $referralHistory->plan_price = $order->plan_price;
                                    $referralHistory->actual_amount = $order->plan_price;
                                    $referralHistory->commission_percentage = $referral_commission;
                                    $referralHistory->earned_amount = $order->plan_price * ($referral_commission / 100);
                                    $referralHistory->status = REFERRAL_STATUS_PAID;
                                    $referralHistory->referral_id = $referral->id;
                                    $referralHistory->save();

                                    $referredParentCustomer->increment('earning_balance', $referralHistory->earned_amount);
                                }

                                $referral->update(['status' => REFERRAL_STATUS_PAID]);
                            }
                        }

                        DB::commit();
                        Log::info('--------***Order invoice verify END***------');
                    } else {
                        Log::info('--------***Order not found with that criteria***------');
                        Log::info('--------***Check if order exist or order status in processing END***------');
                    }
                    DB::commit();
                    break;
                // Add more cases for other event types as needed
                default:
                    // Handle unknown event types
                    break;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Invalid payload
            Log::info('Stripe webhook error: ' . $e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            Log::info('--------***Webhook Failed -- END***------');
        }

    }

    public function placeOrderWebhook($plan, $plan_type, $gateway, $gatewayCurrency, $customer_id)
    {
        $order = new Order();
        $order->customer_id = $customer_id;
        $order->gateway_id = $gateway->id;
        $order->gateway_currency = $gatewayCurrency;
        $order->conversion_rate = $gateway->conversion_rate;
        $order->current_currency = getCurrencyCode();
        $order->plan_id = $plan->id;
        $order->plan_price = ($plan_type == ORDER_PLAN_DURATION_TYPE_YEAR) ? $plan->yearly_price : $plan->monthly_price;
        $order->plan_duration_type = $plan_type;
        $order->subtotal = $order->plan_price;
        $order->discount = 0;
        $total = $this->calculateTotalWithTax($order->subtotal, 0, $plan->tax, $order);
        $order->total = $total;
        $order->grand_total = $total * $gateway->conversion_rate;
        $order->payment_status = ORDER_PAYMENT_STATUS_PENDING;
        $order->payment_type = $this->determinePaymentType($gateway);
        $order->type = ORDER_TYPE_PLAN;
        $order->save();

        return $order;
    }

    public function paypalWebhook($event)
    {
        // Handle PayPal specific events
        switch ($event['event_type']) {
            case 'PAYMENT.SALE.COMPLETED':
                $resource = $event['resource'];
                Log::info('Handling PayPal Payment Completed:', $resource);

                // Extract payment information from the webhook
                $paymentId = $resource['id'];
                $metaData = json_decode($resource['custom'], true); // Assuming 'custom_id' stores plan_id and user_id

                // Find the subscription order using the payment ID or transaction ID
                $order = Order::where('payment_id', $paymentId)->first();

                if (is_null($order)) {
                    // No order found, create a new one
                    $customer_id = $metaData['customer_id'] ?? null;
                    $planId = $metaData['plan_id'] ?? null;
                    $plan = Plan::find($planId);

                    if (is_null($plan) || is_null($customer_id)) {
                        Log::error("Invalid metadata for PayPal event: " . json_encode($metaData));
                        return;
                    }

                    $planType = $metaData['duration_type'] === ORDER_PLAN_DURATION_TYPE_MONTH ? ORDER_PLAN_DURATION_TYPE_MONTH : ORDER_PLAN_DURATION_TYPE_YEAR;
                    $gateway = Gateway::where(['gateway_slug' => 'paypal', 'status' => ACTIVE])->firstOrFail();

                    // Create new order
                    $order = $this->placeOrderWebhook($plan, $planType, $gateway, $gateway->gateway_currency, $customer_id);
                    $order->payment_id = $paymentId;
                    $order->save();
                }

                // If order exists and payment is pending, mark it as paid
                if ($order && $order->payment_status == ORDER_PAYMENT_STATUS_PENDING) {
                    $order->payment_status = ORDER_PAYMENT_STATUS_PAID;
                    $order->save();

                    // Start:: New Plan Created
                    $customerPlan = new CustomerPlan();
                    $customerPlan->order_id = $order->id;
                    $customerPlan->plan_type = $order->plan_duration_type;
                    $customerPlan->plan_id = $order->plan_id;
                    $customerPlan->customer_id = $order->customer_id;
                    $customerPlan->start_date = now();
                    $customerPlan->end_date = ($order->plan_duration_type == ORDER_PLAN_DURATION_TYPE_YEAR) ? now()->addYear() : now()->addMonth();

                    $plan_details = array(
                        "name" => $order->plan->name,
                        "price" => $order->plan_price,
                        "duration_type" => $order->plan_duration_type,
                        "device_limit" => $order->plan->device_limit,
                        "download_limit_type" => $order->plan->download_limit_type,
                        "download_limit" => $order->plan->download_limit
                    );
                    $customerPlan->plan_details = $plan_details;
                    $customerPlan->save();
                    // End:: New Plan Created

                    // Start:: Referral Logic
                    if (getOption('referral_status') == 1 && isAddonInstalled('PIXELAFFILIATE')) {
                        $referral = Referral::where(['child_customer_id' => $order->customer_id, 'status' => REFERRAL_HISTORY_STATUS_DUE])->first();
                        if ($referral) {
                            $referredParentCustomer = Customer::find($referral->parent_customer_id);
                            $referral_commission = empty(getOption('referral_commission')) ? 0 : getOption('referral_commission');
                            if ($referredParentCustomer) {
                                $referralHistory = new ReferralHistory();
                                $referralHistory->transaction_no = Str::uuid()->getHex();
                                $referralHistory->referred_customer_id = $referredParentCustomer->id;
                                $referralHistory->buyer_customer_id = $order->customer_id;
                                $referralHistory->order_id = $order->id;
                                $referralHistory->plan_name = $order->plan->name;
                                $referralHistory->plan_price = $order->plan_price;
                                $referralHistory->actual_amount = $order->plan_price;
                                $referralHistory->commission_percentage = $referral_commission;
                                $referralHistory->earned_amount = $order->plan_price * ($referral_commission / 100);
                                $referralHistory->status = REFERRAL_STATUS_PAID;
                                $referralHistory->referral_id = $referral->id;
                                $referralHistory->save();

                                $referredParentCustomer->increment('earning_balance', $referralHistory->earned_amount);
                            }

                            $referral->update(['status' => REFERRAL_STATUS_PAID]);
                        }
                    }

                    Log::info('Payment successfully completed for order ID: ' . $order->id);
                } else {
                    Log::warning('Order not found or already processed for payment ID: ' . $paymentId);
                }
                break;
            default:
                // Handle unknown event types
                break;
        }
    }
}
