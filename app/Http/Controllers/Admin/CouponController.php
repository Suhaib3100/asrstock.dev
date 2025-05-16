<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponRequest;
use App\Models\Coupon;
use App\Models\CustomerCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('all_coupon')) {
            abort('403');
        } // end permission checking

        $data['pageTitle'] = 'Coupon';
        $data['subNavCouponIndexActiveClass'] = 'active';
        $data['showCoupon'] = 'show';
        $data['coupons'] = Coupon::where(function ($q) use ($request) {
            if ($request->search_string) {
                $q->where('name', 'like', "%{$request->search_string}%");
            }
            if ($request->search_status == 1) {
                $q->active();
            } elseif($request->search_status == 2) {
                $q->disable();
            }
        })->latest()->get();

        if ($request->ajax()) {
            return view('admin.coupon.render-coupon-list')->with($data);
        }

        return view('admin.coupon.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('add_coupon')) {
            abort('403');
        } // end permission checking

        $data['pageTitle'] = 'Add Coupon';
        $data['subNavAddCouponActiveClass'] = 'active';
        $data['showCoupon'] = 'show';
        return view('admin.coupon.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponRequest $request)
    {
        $coupon = new Coupon();
        $coupon->name = $request->name;
        $coupon->use_type = $request->use_type;
        $coupon->maximum_use_limit = $request->maximum_use_limit;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount_value = $request->discount_value;
        $coupon->minimum_amount = $request->minimum_amount;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->status = $request->status ?? 1;
        $coupon->save();
        return redirect()->route('admin.coupon.index')->with('success', __('Created Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $data['pageTitle'] = 'Edit Coupon';
        $data['subNavAddCouponActiveClass'] = 'active';
        $data['showCoupon'] = 'show';
        $data['coupon'] = Coupon::whereUuid($uuid)->firstOrFail();
        return view('admin.coupon.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouponRequest $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->name = $request->name;
        $coupon->use_type = $request->use_type;
        $coupon->maximum_use_limit = $request->maximum_use_limit;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount_value = $request->discount_value;
        $coupon->minimum_amount = $request->minimum_amount;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->status = $request->status ?? 1;
        $coupon->save();
        return redirect()->route('admin.coupon.index')->with('success', __('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $coupon = Coupon::whereUuid($uuid)->firstOrFail();
        $coupon->delete();
        return redirect()->back()->with('success', __('Deleted Successfully'));
    }

    public function usedCustomerCouponList($id)
    {
        $data['pageTitle'] = __('Coupon Used History');
        $data['coupon'] = Coupon::findOrFail($id);
        $data['subNavCouponIndexActiveClass'] = 'active';
        $data['showCoupon'] = 'show';
        $data['customerCoupons'] = CustomerCoupon::whereHas('order', function ($q){
            $q->wherePaymentStatus(ORDER_PAYMENT_STATUS_PAID);
        })->with(['order', 'customer'])->where('coupon_id', $id)->get();
        return view('admin.coupon.used-history')->with($data);
    }

    public function changeCouponStatus(Request $request)
    {
        $coupon = Coupon::findOrFail($request->id);
        $coupon->status = $request->status;
        $coupon->save();

        return response()->json([
            'data' => 'success',
        ]);
    }
}
