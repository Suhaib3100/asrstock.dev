<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\WalletMoney;
use App\Models\Withdraw;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['pageTitle'] = 'Dashboard';
        $data['navDashboard'] = 'active';

        $data['color'] = ['#BE63F9', '#4CBF4C', '#F96363', '#FF964B', '#5991FF', '#4CBF4C', '#CE63F9'];

        $data['totalUser']['Admin'] = User::count();
        $data['totalUser']['Customer'] = Customer::where('role', '!=', CUSTOMER_ROLE_CONTRIBUTOR)->count();
        $data['totalUser']['Contributor'] = Customer::contributor()->count();

        $data['product']['Total Item'] = Product::count();
        $data['product']['Published Item'] = Product::published()->count();
        $data['product']['Pending Item'] = Product::pending()->count();
        $data['product']['Contributor Item'] = Product::uploadedByContributor()->count();
        $data['product']['Admin Item'] = Product::uploadedByAdmin()->count();
        $data['product']['Paid Item'] = Product::paid()->count();
        $data['product']['Free Item'] = Product::free()->count();

        $data['withdrawal']['Request Withdraw'] = Withdraw::pending()->sum('amount');
        $data['withdrawal']['Completed Withdraw'] = Withdraw::completed()->sum('amount');

        $data['wallet'] = WalletMoney::paid()->sum('amount');

        $data['accounting']['Total Earning'] = Order::paid()->whereNotNull('product_id')->sum('subtotal');
        $data['accounting']['Admin Earning'] = Order::paid()->whereNotNull('product_id')->sum('admin_commission');
        $data['accounting']['Contributor Earning'] = Order::paid()->whereNotNull('product_id')->sum('contributor_commission');

        $data['topFiveProducts'] = Product::withCount([
            'orders as totalOrder' => function ($q) {
                $q->select(DB::raw("COUNT(product_id)"))->where(['payment_status' => ORDER_PAYMENT_STATUS_PAID]);
            }
        ])
            ->whereHas('orders')
            ->orderBy('total_watch', 'desc')
            ->take(5)
            ->get();

        $data['requestFiveWithdraws'] = Withdraw::with('beneficiary')->pending()->take(5)->get();

        $dailySale = array();
        for ($i = 0; $i < 15; $i++)
            $dailySale[date("d M", strtotime('-' . $i . ' days'))] = [0, 0];

        $orders = Order::whereNotNull('product_id')->paid()->where('created_at', '>', now()->subDays(15)->endOfDay())
            ->select(DB::raw('COUNT(id) as total_id'), DB::raw('SUM(subtotal) as total'), DB::raw('DATE_FORMAT(created_at, "%d %b %y") date'))
            ->orderby('date', 'asc')
            ->groupby('date')
            ->get();
        foreach ($orders as $q) {
            $dailySale[$q->date] = [$q->total_id, $q->total];
        }
        $data['dailySale'] = $dailySale;
        return view('admin.dashboard', $data);
    }
}
