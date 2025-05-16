<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gateway;
use App\Models\Plan;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function pricing()
    {
        $data['pageTitle'] = __('Pricing');
        $data['searchDisable'] = true;

        $data['plans'] = Plan::with('planBenefits')->active()->get();
        $settingArray = array(
            'plan_title' => getOption('plan_title'),
            'plan_subtitle' => getOption('plan_subtitle'),
        );
        $data['settings'] = $settingArray;

        return view('frontend.pricing', $data);
    }
}
