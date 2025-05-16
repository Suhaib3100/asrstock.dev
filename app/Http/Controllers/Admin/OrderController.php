<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderCancelledMail;
use App\Mail\OrderPaidMail;
use App\Models\Customer;
use App\Models\CustomerPlan;
use App\Models\Order;
use App\Models\Referral;
use App\Models\ReferralHistory;
use App\Models\UserPurchase;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    use ResponseTrait;

    public function allOrders(Request $request, $status = null)
    {
        $orders = Order::where(function ($q) use ($request) {
            if ($request->search_string) {
                $q->where('order_number', 'like', "%{$request->search_string}%")
                    ->orWhere('subtotal', 'like', "%{$request->search_string}%")
                    ->orWhere('total', 'like', "%{$request->search_string}%")
                    ->orWhereHas('customer', function ($query) use ($request) {
                        $query->where('email', 'like', "%{$request->search_string}%");
                    });
            }
        })->with(['gateway'])->latest();
        if ($status == null) {
            if (!Auth::user()->can('all_orders')) {
                abort('403');
            }
            $data['pageTitle'] = 'All Orders';
            $data['subNavAllOrdersActiveClass'] = 'active';
            $data['showOrders'] = 'show';
        } elseif ($status == ORDER_PAYMENT_STATUS_PAID) {
            if (!Auth::user()->can('paid_orders')) {
                abort('403');
            }
            $data['pageTitle'] = 'Paid Orders';
            $data['subNavPaidOrdersActiveClass'] = 'active';
            $data['showOrders'] = 'show';
            $orders = $orders->paid();

        } elseif ($status == ORDER_PAYMENT_STATUS_PENDING) {
            if (!Auth::user()->can('pending_orders')) {
                abort('403');
            }
            $data['pageTitle'] = 'Pending Orders';
            $data['subNavPendingOrdersActiveClass'] = 'active';
            $data['showOrders'] = 'show';
            $orders = $orders->pending();
        } elseif ($status == ORDER_PAYMENT_STATUS_CANCELLED) {
            if (!Auth::user()->can('cancelled_orders')) {
                abort('403');
            }
            $data['pageTitle'] = 'Cancelled Orders';
            $data['subNavCancelledOrdersActiveClass'] = 'active';
            $data['showOrders'] = 'show';
            $orders = $orders->cancelled();
        }

        if ($request->ajax()) {
            return $this->orderDataTable($orders);
        }
        $data['status'] = $status;
        return view('admin.orders.all-orders', $data);
    }

    public function bankPaymentOrders(Request $request, $status)
    {
        $orders = Order::where(function ($q) use ($request) {
            if ($request->search_string) {
                $q->where('order_number', 'like', "%{$request->search_string}%")
                    ->orWhere('subtotal', 'like', "%{$request->search_string}%")
                    ->orWhere('total', 'like', "%{$request->search_string}%")
                    ->orWhereHas('customer', function ($query) use ($request) {
                        $query->where('email', 'like', "%{$request->search_string}%");
                    });
            }
        })->with(['gateway'])->latest();

        if ($status == 5) {
            if (!Auth::user()->can('bank_payment_orders')) {
                abort('403');
            }
            $data['pageTitle'] = __('Bank Payment Orders');
            $data['subNavBankPaymentOrdersActiveClass'] = 'active';
            $data['showOrders'] = 'show';
            $orders = $orders->bank();
        } elseif ($status == 6) {
            if (!Auth::user()->can('bank_payment_pending_orders')) {
                abort('403');
            }
            $data['pageTitle'] = __('Payment Pending Orders');
            $data['subNavBankPaymentPendingOrdersActiveClass'] = 'active';
            $data['showOrders'] = 'show';
            $orders = $orders->where(function ($q) {
                $q->where('payment_type', ORDER_PAYMENT_TYPE_BANK)->orWhere('payment_type', ORDER_PAYMENT_TYPE_CASH);
            })->pending();
        }
        if ($request->ajax()) {
            return $this->orderDataTable($orders);
        }
        $data['status'] = $status;
        return view('admin.orders.bank-payment-orders', $data);
    }

    public function bankStatusUpdate(Request $request)
    {
        try {
            DB::beginTransaction();
            if (env('APP_DEMO') == 'active') {
                throw new Exception ('This is a demo version! You can get full access after purchasing the application.');
            }
            $order = Order::findOrFail($request->id);

            $order->payment_status = $request->payment_status;
            $order->save();

            if ($request->payment_status == ORDER_PAYMENT_STATUS_PAID) {
                if (($order->type == ORDER_TYPE_PRODUCT || $order->type == ORDER_TYPE_DONATE) && @$order->product->customer_id) {
                    Customer::find(@$order->product->customer_id)->increment('earning_balance', $order->contributor_commission);
                }

                if ($order->type == ORDER_TYPE_PRODUCT) {
                    $this->userPurchase($order);
                }

                if ($order->type == ORDER_TYPE_PLAN) {
                    $this->createCustomerPlan($order);
                }

                if (getOption('app_mail_status') == 1) {
                    try {
                        Mail::to(@$order->customer->email)->send(new OrderPaidMail($order->customer, $order->order_number));
                    } catch (\Exception $exception) {
                    }
                }

            } elseif ($request->payment_status == ORDER_PAYMENT_STATUS_CANCELLED) {
                if (getOption('app_mail_status') == 1) {
                    try {
                        Mail::to(@$order->customer->email)->send(new OrderCancelledMail($order->customer, $order->order_number));
                    } catch (\Exception $exception) {
                    }
                }
            }

            DB::commit();
            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
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

    public function orderDataTable($orders)
    {
        return datatables($orders)
            ->addIndexColumn()
            ->editColumn('order_number', function ($order) {
                return $order->order_number;
            })
            ->editColumn('customer_email', function ($order) {
                return $order->customer->email ?? '';
            })
            ->editColumn('type', function ($order) {
                if ($order->type == ORDER_TYPE_PLAN) {
                    return '<span class="text-info">' . __('Plan') . '</span>';
                } elseif ($order->type == ORDER_TYPE_PRODUCT) {
                    return '<span class="text-primary-emphasis">' . __('Product') . '</span>';
                } elseif ($order->type == ORDER_TYPE_DONATE) {
                    return '<span class="text-success">' . __('Donate') . '</span>';
                } else {
                    return '';
                }
            })
            ->editColumn('item', function ($order) {
                if ($order->type == ORDER_TYPE_PLAN) {
                    return $order->customerPlan->plan->name ?? '';
                } elseif ($order->type == ORDER_TYPE_PRODUCT) {
                    return $order->product->title ?? '';
                } elseif ($order->type == ORDER_TYPE_DONATE) {
                    return __('Donation');
                } else {
                    return '';
                }
            })
            ->editColumn('subtotal', function ($order) {
                return getAmountPlace($order->subtotal ?? 0);
            })
            ->editColumn('discount', function ($order) {
                $discount = getAmountPlace($order->discount ?? 0);
                if ($order->coupon_id) {
                    $discount .= ' (' . $order->coupon->name . ')';
                }
                return $discount;
            })
            ->editColumn('tax', function ($order) {
                return getAmountPlace($order->tax_amount ?? 0) . ' (' . ($order->tax_percentage ?? 0) . '%)';
            })
            ->editColumn('referral', function ($order) {
                return getAmountPlace($order->referralHistory->earned_amount ?? 0);
            })
            ->editColumn('total', function ($order) {
                return '<div class="text-nowrap">'. getAmountPlace($order->total ?? 0) .'</div>';
            })
            ->editColumn('gateway', function ($order) {
                return $order->gateway->gateway_name ?? '';
            })
            ->editColumn('payment_status', function ($order) {
                $statusHtml = '';

                if ($order->payment_status == ORDER_PAYMENT_STATUS_PENDING) {
                    $statusHtml = '
                        <div class="d-flex justify-content-end align-items-center g-10">
                            <span class="zBadge zBadge-pending">' . __('Pending') . '</span>';
                    if ($order->payment_type == ORDER_PAYMENT_TYPE_BANK || $order->payment_type == ORDER_PAYMENT_TYPE_CASH) {
                        $statusHtml .= '
                            <div>
                                <ul class="action-list">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link w-30 h-30 d-flex justify-content-center align-items-center bd-one bd-c-stroke rounded-circle" href="#" onclick="getEditModal(\'' . route('admin.order.bank-status-modal', $order->id) . '\', \'#status-modal\')" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <img src="' . asset('admin/images/icons/ellipsis-v.svg') . '" alt="icon">
                                        </a>
                                    </li>
                                </ul>
                            </div>';
                    }
                    $statusHtml .= '</div>';
                } elseif ($order->payment_status == ORDER_PAYMENT_STATUS_PAID) {
                    $statusHtml = '<span class="zBadge zBadge-paid">' . __('Paid') . '</span>';
                } elseif ($order->payment_status == ORDER_PAYMENT_STATUS_CANCELLED) {
                    $statusHtml = '<span class="zBadge zBadge-cancel">' . __('Cancelled') . '</span>';
                }

                return $statusHtml;
            })
            ->editColumn('bank_slip', function ($order) {
                if ($order->gateway->gateway_slug == 'bank') {
                    return '<a target="_blank" href="' . getFileUrl($order->bank_deposit_slip) . '" class="test-popup-link text-decoration-underline text-success" title="Download Bank Slip">'.__('Bank Slip').'</a>';
                }
                return __('N/A');
            })
            ->rawColumns(['payment_status', 'type', 'bank_slip','total'])
            ->make(true);
    }

    public function bankStatusModal($id)
    {
        $data['pageTitle'] = 'Edit Status';
        $data['order'] = Order::findOrFail($id);
        return view('admin.orders.bank-status-modal', $data);
    }

}
