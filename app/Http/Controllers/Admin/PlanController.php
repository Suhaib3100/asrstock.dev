<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlanRequest;
use App\Http\Services\Payment\Payment;
use App\Models\CustomerPlan;
use App\Models\FileManager;
use App\Models\Gateway;
use App\Models\Plan;
use App\Models\PlanBenefit;
use App\Models\Tax;
use App\Tools\Repositories\Crud;
use App\Traits\ApiStatusTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    use ApiStatusTrait;

    protected $planModel, $planBenefitModel;

    public function __construct(Plan $plan, PlanBenefit $plan_benefit)
    {
        $this->planModel = new crud($plan);
        $this->planBenefitModel = new crud($plan_benefit);
    }

    public function index(Request $request)
    {
        if (!Auth::user()->can('all_plan')) {
            abort('403');
        } // end permission checking

        $data['pageTitle'] = 'Plan';
        $data['subNavPlanIndexActiveClass'] = 'active';
        $data['showPlan'] = 'show';
        $data['plans'] = Plan::where(function ($q) use ($request) {
            if ($request->search_string) {
                $q->where('name', 'like', "%{$request->search_string}%");
            }
            if ($request->search_status == 1) {
                $q->active();
            } elseif ($request->search_status == 2) {
                $q->disable();
            }
        })->latest()->get();

        if ($request->ajax()) {
            return view('admin.plan.render-plan-list')->with($data);
        };
        return view('admin.plan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->can('add_plan')) {
            abort('403');
        } // end permission checking

        $data['pageTitle'] = 'Create Plan';
        $data['subNavPlanCreateActiveClass'] = 'active';
        $data['showPlan'] = 'show';
        $data['taxes'] = Tax::all();
        return view('admin.plan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(PlanRequest $request)
    {
        if (env('APP_DEMO') == 'active') {
            return redirect()->back()->with('error', 'This is a demo version! You can get full access after purchasing the application.');
        }
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'subtitle' => $request->subtitle,
                'description' => $request->description,
                'slug' => Str::slug($request->name),
                'monthly_price' => $request->monthly_price,
                'yearly_price' => $request->yearly_price,
                'device_limit' => $request->device_limit,
                'download_limit' => $request->download_limit,
                'download_limit_type' => $request->download_limit_type,
                'tax_id' => $request->tax_id,
                'status' => $request->status ?? 1,
            ];

            $plan = $this->planModel->create($data);

            $gateways = RECURRING_GATEWAY;  // Add more gateways here

            foreach ($gateways as $gatewaySlug) {
                $gateway = Gateway::where(['gateway_slug' => $gatewaySlug, 'status' => ACTIVE])->first();
                if (!is_null($gateway)) {
                    $subscriptionPrice = $plan->subscriptionPrice->where('gateway_id', $gateway->id)->first();

                    $object = [
                        'webhook_url' => route('payment.subscription.webhook', ['payment_method' => $gatewaySlug]),
                        'currency' => $gateway->gateway_currency,
                        'type' => 'plan'
                    ];

                    $paymentService = new Payment($gatewaySlug, $object);

                    $monthlyPrice = $plan->monthly_price;
                    $yearlyPrice = $plan->yearly_price;
                    if ($plan->tax) {
                        $tax_amount = $monthlyPrice * ($plan->tax->percentage / 100);
                        $monthlyPrice += $tax_amount;

                        $tax_amount = $yearlyPrice * ($plan->tax->percentage / 100);
                        $yearlyPrice += $tax_amount;
                    }

                    // Prepare price data
                    $priceData = [
                        'monthly_price' => $monthlyPrice,
                        'yearly_price' => $yearlyPrice,
                        'monthlyPriceId' => $subscriptionPrice ? $subscriptionPrice->monthly_price_id : null,
                        'yearlyPriceId' => $subscriptionPrice ? $subscriptionPrice->yearly_price_id : null,
                        'name' => $plan->name,
                        'description' => $plan->description,
                    ];

                    // Save or update prices
                    $priceResponse = $paymentService->saveProductSaas($priceData);

                    if ($priceResponse['success']) {
                        // Save subscription price details in the database for the gateway
                        $plan->subscriptionPrice()->updateOrCreate(
                            ['gateway_id' => $gateway->id],
                            [
                                'gateway' => $gatewaySlug,
                                'monthly_price_id' => $priceResponse['data']['monthly_price_id'],
                                'yearly_price_id' => $priceResponse['data']['yearly_price_id'],
                            ]
                        );
                    } else {
                        return redirect()->back()->with(['error' => __('Could not save the product for ' . ucfirst($gatewaySlug).'. Please check your credentials or configure them correctly.')]);
                    }
                }
            }

            /*File Manager Call upload*/
            if ($request->logo) {
                $new_file = new FileManager();
                $upload = $new_file->upload('Plan', $request->logo);

                if ($upload['status']) {
                    $upload['file']->origin_id = $plan->id;
                    $upload['file']->origin_type = "App\Models\Plan";
                    $upload['file']->save();
                }
            }
            /*End*/

            if ($request['plan_benefits']) {
                if (count(@$request['plan_benefits']) > 0) {
                    foreach ($request['plan_benefits'] as $plan_benefit) {
                        if (@$plan_benefit['point']) {
                            $data = [
                                'point' => $plan_benefit['point'],
                                'plan_id' => $plan->id
                            ];
                            $this->planBenefitModel->create($data);
                        }
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
        return redirect()->route('admin.plan.index')->with('success', __('Created Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit($uuid)
    {
        $data['pageTitle'] = 'Edit Plan';
        $data['subNavPlanIndexActiveClass'] = 'active';
        $data['showPlan'] = 'show';
        $data['plan'] = $this->planModel->getRecordByUuid($uuid);
        $data['planBenefits'] = PlanBenefit::where('plan_id', $data['plan']->id)->get();
        $data['taxes'] = Tax::all();
        return view('admin.plan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function update(PlanRequest $request, $uuid)
    {
        if (env('APP_DEMO') == 'active') {
            return redirect()->back()->with('error', 'This is a demo version! You can get full access after purchasing the application.');
        }

        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'subtitle' => $request->subtitle,
                'description' => $request->description,
                'slug' => Str::slug($request->name),
                'monthly_price' => $request->monthly_price,
                'yearly_price' => $request->yearly_price,
                'device_limit' => $request->device_limit,
                'download_limit' => $request->download_limit,
                'download_limit_type' => $request->download_limit_type,
                'tax_id' => $request->tax_id,
                'status' => $request->status ?? 1,
            ];

            $plan = $this->planModel->updateByUuid($data, $uuid);

            $gateways = RECURRING_GATEWAY;  // Add more gateways here

            foreach ($gateways as $gatewaySlug) {
                $gateway = Gateway::where(['gateway_slug' => $gatewaySlug, 'status' => ACTIVE])->first();
                if (!is_null($gateway)) {
                    $subscriptionPrice = $plan->subscriptionPrice->where('gateway_id', $gateway->id)->first();

                    $object = [
                        'webhook_url' => route('payment.subscription.webhook', ['payment_method' => $gatewaySlug]),
                        'currency' => $gateway->gateway_currency,
                        'type' => 'plan'
                    ];

                    $paymentService = new Payment($gatewaySlug, $object);

                    $monthlyPrice = $plan->monthly_price;
                    $yearlyPrice = $plan->yearly_price;
                    if ($plan->tax) {
                        $tax_amount = $monthlyPrice * ($plan->tax->percentage / 100);
                        $monthlyPrice += $tax_amount;

                        $tax_amount = $yearlyPrice * ($plan->tax->percentage / 100);
                        $yearlyPrice += $tax_amount;
                    }

                    // Prepare price data
                    $priceData = [
                        'monthly_price' => $monthlyPrice,
                        'yearly_price' => $yearlyPrice,
                        'monthlyPriceId' => $subscriptionPrice ? $subscriptionPrice->monthly_price_id : null,
                        'yearlyPriceId' => $subscriptionPrice ? $subscriptionPrice->yearly_price_id : null,
                        'name' => $plan->name,
                        'description' => $plan->description,
                    ];

                    // Save or update prices
                    $priceResponse = $paymentService->saveProductSaas($priceData);

                    if ($priceResponse['success']) {
                        // Save subscription price details in the database for the gateway
                        $plan->subscriptionPrice()->updateOrCreate(
                            ['gateway_id' => $gateway->id],
                            [
                                'gateway' => $gatewaySlug,
                                'monthly_price_id' => $priceResponse['data']['monthly_price_id'],
                                'yearly_price_id' => $priceResponse['data']['yearly_price_id'],
                            ]
                        );
                    } else {
                        return redirect()->back()->with(['error' => __('Could not update the product for ' . ucfirst($gatewaySlug) . '. Please check your credentials or configure them correctly.')]);
                    }
                }
            }

            /*File Manager Call upload*/
            if ($request->logo) {
                $new_file = FileManager::where('origin_type', 'App\Models\Plan')->where('origin_id', $plan->id)->first();

                if ($new_file) {
                    $new_file->removeFile();
                    $upload = $new_file->upload( 'Plan', $request->logo, null, $new_file->id);
                } else {
                    $new_file = new FileManager();
                    $upload = $new_file->upload('Plan', $request->logo);
                }
                if ($upload['status']) {
                    $upload['file']->origin_id = $plan->id;
                    $upload['file']->origin_type = "App\Models\Plan";
                    $upload['file']->save();
                }
            }
            /*End*/

            $now = now();
            if ($request['plan_benefits']) {
                if (count(@$request['plan_benefits']) > 0) {
                    foreach ($request['plan_benefits'] as $plan_benefit) {
                        if (@$plan_benefit['point']) {
                            $data = [
                                'point' => $plan_benefit['point'],
                                'plan_id' => $plan->id,
                                'updated_at' => $now
                            ];
                            if (@$plan_benefit['id']) {
                                $this->planBenefitModel->update($data, $plan_benefit['id']);
                            } else {
                                $this->planBenefitModel->create($data);
                            }
                        }
                    }
                }
            }

            PlanBenefit::where('plan_id', $plan->id)->where('updated_at', '!=', $now)->get()->map(function ($q) {
                $q->delete();
            });

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage(), $e->getFile(), $e->getLine());
            return redirect()->route('admin.plan.index')->with('error', __(SOMETHING_WENT_WRONG));
        }

        return redirect()->route('admin.plan.index')->with('success', __('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        if (env('APP_DEMO') == 'active') {
            return redirect()->back()->with('error', 'This is a demo version! You can get full access after purchasing the application.');
        }

        $plan = $this->planModel->getRecordByUuid($uuid);
        if ($plan) {
            PlanBenefit::where('plan_id', $plan->id)->delete();
        }

        $file = FileManager::where('origin_type', 'App\Models\Plan')->where('origin_id', $plan->id)->first();
        if ($file) {
            $file->removeFile();
            $file->delete();
        }
        $this->planModel->deleteByUuid($uuid);
        return redirect()->back()->with('success', __('Deleted Successfully'));
    }

    public function changePlanStatus(Request $request)
    {
        if (env('APP_DEMO') == 'active') {
            $response['message'] = 'This is a demo version! You can get full access after purchasing the application.';
            return $this->notAllowedApiResponse($response);
        }

        $plan = Plan::findOrFail($request->id);
        $plan->status = $request->status;
        $plan->save();

        $response['message'] = 'Success';
        return $this->successApiResponse($response);
    }

    public function subscriptionPlan(Request $request)
    {
        $data['pageTitle'] = __('Subscription Plan List');
        $data['navSubscriptionPlan'] = 'active';
        $data['customerPlans'] = CustomerPlan::whereHas('order', function ($q) {
            $q->wherePaymentStatus(ORDER_PAYMENT_STATUS_PAID);
        })->latest()->get();
        return view('admin.subscriber-plan')->with($data);
    }
}
