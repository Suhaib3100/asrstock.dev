<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class AddonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $addons = getAddonAppNameList();

        foreach ($addons as $addon) {
            $codeBuildVersion = getAddonCodeBuildVersion($addon);
            $dbBuildVersion = getCustomerAddonBuildVersion($addon);

            if ($codeBuildVersion > $dbBuildVersion) {
                // Clear various caches
                Artisan::call('view:clear');
                Artisan::call('route:clear');
                Artisan::call('config:clear');
                Artisan::call('cache:clear');

                // Check if the user is authenticated
                if (Auth::check()) {
                    // Check if the user is authenticated using the 'admin_web' guard
                    if (Auth::guard('admin_web')->check() && Auth::guard('admin_web')->user()->can('manage_version_update')) {
                        return redirect()->route('admin.addon.details', $addon);
                    } else {
                        Auth::logout();
                        return redirect()->route('admin.login')->with('error', __('Please contact the Admin'));
                    }
                } else {
                    return redirect()->route('admin.login')->with('error', __('Please contact the Admin'));
                }
            }
        }

        return $next($request);
    }
}
