<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPlan;
use App\Models\DownloadProduct;
use App\Models\MonthlyEarningHistory;
use App\Models\Order;
use App\Models\Product;
use App\Traits\ApiStatusTrait;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EarningManagementController extends Controller
{
    use ApiStatusTrait;

    public function downloadProducts(Request $request)
    {
        $data['pageTitle'] = __("Download Products");
        $data['subNavDownloadProductsActiveClass'] = "active";
        $data['showEarning'] = 'show';
        $data['downloadProducts'] = DownloadProduct::query();

        if ($request->ajax()) {
            $data['downloadProducts'] = $data['downloadProducts']->when($request->key, function ($query) use ($request) {
                if ($request->key === 'Today') {
                    $query->whereDate('created_at', now());
                } elseif ($request->key === 'Yesterday') {
                    $query->whereDate('created_at', now()->subDay());
                } elseif ($request->key === 'Last 7 Days') {
                    $query->whereDate('created_at', '>=', now()->subDays(7));
                } elseif ($request->key === 'Last 30 Days') {
                    $query->whereDate('created_at', '>=', now()->subDays(30));
                } elseif ($request->key === 'This Month') {
                    $query->whereMonth('created_at', now());
                } else {
                    $start_date = Carbon::parse($request->start_date);
                    $end_date = Carbon::parse($request->end_date);
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                }
            })->latest()->with('product')->get();
            return view('admin.earning.partial.render-download-products')->with($data);
        } else {
            $data['downloadProducts'] = $data['downloadProducts']->get();
        }

        return view('admin.earning.download-products')->with($data);
    }

    public function productEarningHistory(Request $request)
    {
        $data['pageTitle'] = __("Product Earning History");
        $data['subNavProductEarningHistoryActiveClass'] = "active";
        $data['showEarning'] = 'show';
        $downloadProductIds = DownloadProduct::pluck('product_id')->toArray();
        $orderProductIds = Order::where('payment_status', ORDER_PAYMENT_STATUS_PAID)->pluck('product_id')->toArray();
        $productIDs = array_merge($downloadProductIds, $orderProductIds);
        $data['products'] = Product::whereIn('id', $productIDs)->where(function ($q) use ($request) {
            if ($request->search_string) {
                $q->where('title', 'like', '%' . $request->search_string . '%');
            }
        })->get();

        if ($request->ajax()) {
            return view('admin.earning.partial.render-product-earning-history')->with($data);
        }

        return view('admin.earning.product-earning-history')->with($data);
    }

    public function commissionSetting()
    {
        $data['pageTitle'] = __("Commission Setting");
        $data['subNavCommissionSettingActiveClass'] = "active";
        $data['showEarning'] = 'show';
        return view('admin.earning.commission-setting')->with($data);
    }

    public function earningManagement(Request $request)
    {
        $data['pageTitle'] = __("Commission Distribution");
        $data['subNavEarningManagementActiveClass'] = "active";
        $data['showEarning'] = 'show';
        $data['monthYears'] = MonthlyEarningHistory::select('id','month_year')->get();
        $data['monthlyEarningHistories'] = MonthlyEarningHistory::where(function ($q) use ($request){
            if ($request->search_string){
                $q->where('month_year', $request->search_string);
            }
        })->get();
        if ($request->ajax()) {
            return view('admin.earning.partial.render-earning-histories')->with($data);
        }
        return view('admin.earning.earning-management')->with($data);
    }

    public function earningInfoViaMonthYear(Request $request)
    {
        $response = $this->earningManagementCalculation($request);
        return $this->successApiResponse($response);
    }

    public function sendMoneyStore(Request $request)
    {
        $request->validate([
            'month_year' => 'required|unique:monthly_earning_histories,month_year',
            'total_download' => 'required',
            'total_income_from_plan' => 'required',
            'admin_commission_percentage' => 'required',
            'contributor_commission_percentage' => 'required',
            'get_commission_per_download' => 'required',
        ], [
            'month_year.unique' => 'Already paid of this month. '
        ]);

        $month_year = date(DateTime::createFromFormat("F-Y", $request->month_year)->format('Y-m'));
        $now_month_year = date('Y-m', strtotime(now()));

        if ($now_month_year <= $month_year) {
            return redirect()->back()->with('error', 'Month Year should be less than Present Month Year');
        }

        $totalDownloads = DownloadProduct::whereYear('created_at', date('Y', strtotime($month_year)))
            ->whereMonth('created_at', date('m', strtotime($month_year)))->where('download_accessibility_type', DOWNLOAD_ACCESSIBILITY_TYPE_PAID)->get();

        $response = $this->earningManagementCalculation($request);
        DB::beginTransaction();
        try {
            $earning = new MonthlyEarningHistory();
            $earning->month_year = $request->month_year;
            $earning->total_download = $response['total_download'];
            $earning->total_income_from_plan = $response['total_income_from_plan'];
            $earning->get_commission_per_download = $response['get_commission_per_download'];
            $earning->admin_commission_percentage = $response['admin_commission_percentage'];
            $earning->admin_commission = number_parser($response['get_admin_commission']);
            $earning->contributor_commission_percentage = $response['contributor_commission_percentage'];
            $earning->contributor_commission = number_parser($response['get_contributor_commission']);
            $earning->save();

            foreach ($totalDownloads as $totalDownload)
            {
                $totalDownload->monthly_earning_history_id = $earning->id;
                $totalDownload->earn_money = $earning->get_commission_per_download;
                $totalDownload->save();
                if ($totalDownload->customer_id){
                    Customer::find($totalDownload->customer_id)->increment('earning_balance', $earning->get_commission_per_download);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', SOMETHING_WENT_WRONG);
        }

        return redirect()->back()->with('success', 'Send Money Successfully');
    }

    protected function earningManagementCalculation($request)
    {
        $response['admin_commission_percentage'] = empty(getOption('admin_download_commission')) ? 0 : getOption('admin_download_commission');
        $response['contributor_commission_percentage'] = empty(getOption('admin_download_commission')) ? 100 : (100 - getOption('admin_download_commission'));

        $month_year = date(DateTime::createFromFormat("F-Y", $request->month_year)->format('Y-m'));
        $response['total_download'] = DownloadProduct::whereYear('created_at', date('Y', strtotime($month_year)))
            ->whereMonth('created_at', date('m', strtotime($month_year)))->where('download_accessibility_type', DOWNLOAD_ACCESSIBILITY_TYPE_PAID)->count();

        $customerPlans = CustomerPlan::select("*")
            ->where(DB::raw("DATE_FORMAT(start_date, '%Y-%m')"), '<=', $month_year)
            ->where(DB::raw("DATE_FORMAT(end_date, '%Y-%m')"), '>=', $month_year)->whereHas('order', function ($q) {
                $q->wherePaymentStatus(ORDER_PAYMENT_STATUS_PAID);
            })->get();

        $response['total_income_from_plan'] = 0;
        foreach ($customerPlans as $customerPlan) {
            $total_day = 31;
            if ($customerPlan->plan_type == ORDER_PLAN_DURATION_TYPE_YEAR) {
                $single_day_price = ($customerPlan->order->plan_price) / 365;
            } elseif ($customerPlan->plan_type == ORDER_PLAN_DURATION_TYPE_MONTH) {
                $single_day_price = ($customerPlan->order->plan_price) / 31;
            }
            if (date('Y-m', strtotime($customerPlan->start_date)) == $month_year) {
                $days = date('d', strtotime($customerPlan->start_date));
                $total_day = 31 - $days;
            } elseif (date('Y-m', strtotime($customerPlan->end_date)) == $month_year) {
                $total_day = date('d', strtotime($customerPlan->end_date));
            }

            $total_price = $single_day_price * $total_day;
            $response['total_income_from_plan'] += $total_price;
        }

        if ($response['total_download'] > 0) {
            $response['get_admin_commission'] = $response['total_income_from_plan'] - ($response['total_income_from_plan'] * ($response['admin_commission_percentage'] / 100));
            $response['get_contributor_commission'] = $response['total_income_from_plan'] - ($response['total_income_from_plan'] * ($response['contributor_commission_percentage'] / 100));
            $response['get_commission_per_download'] = number_parser($response['get_contributor_commission'] / $response['total_download']);
        } else {
            $response['get_admin_commission'] = 0;
            $response['get_contributor_commission'] = 0;
            $response['get_commission_per_download'] = 0;
        }
        $response['total_income_from_plan'] = number_parser($response['total_income_from_plan']);

        return $response;
    }
}
