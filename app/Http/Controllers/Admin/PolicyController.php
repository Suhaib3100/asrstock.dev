<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function termsConditions()
    {
        $data['pageTitle'] = 'Terms & Conditions';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subNavTermsConditionsActiveClass'] = 'active';
        $data['policy'] = Policy::whereType(TERMS_AND_CONDITION)->first();

        return view('admin.policy.terms-conditions', $data);
    }

    public function termsConditionsStore(Request $request)
    {
        $policy = Policy::whereType(TERMS_AND_CONDITION)->first();
        if (!$policy)
        {
            $policy = new Policy();
        }

        $policy->type = TERMS_AND_CONDITION;
        $policy->description = $request->description;
        $policy->save();

        return redirect()->back()->with('success', __('Updated Successfully'));

    }

    public function privacyPolicy()
    {
        $data['pageTitle'] = 'Privacy Policy';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subNavPrivacyPolicyActiveClass'] = 'active';
        $data['policy'] = Policy::whereType(PRIVACY_POLICY)->first();

        return view('admin.policy.privacy-policy', $data);
    }

    public function privacyPolicyStore(Request $request)
    {
        $policy = Policy::whereType(PRIVACY_POLICY)->first();
        if (!$policy)
        {
            $policy = new Policy();
        }

        $policy->type = PRIVACY_POLICY;
        $policy->description = $request->description;
        $policy->save();

        return redirect()->back()->with('success', __('Updated Successfully'));

    }

    public function cookiePolicy()
    {
        $data['title'] = 'Cookie Policy';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subNavCookiePolicyActiveClass'] = 'active';
        $data['policy'] = Policy::whereType(COOKIE_POLICY)->first();

        return view('admin.policy.cookie-policy', $data);
    }

    public function cookiePolicyStore(Request $request)
    {
       $policy = Policy::whereType(COOKIE_POLICY)->first();
       if (!$policy)
       {
           $policy = new Policy();
       }

       $policy->type = COOKIE_POLICY;
       $policy->description = $request->description;
       $policy->save();

       return redirect()->back()->with('success', __('Updated Successfully'));
    }

}
