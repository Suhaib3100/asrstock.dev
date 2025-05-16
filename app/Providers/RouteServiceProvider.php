<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const ADMIN_HOME = '/admin/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // Customer routes
            Route::middleware(['web', 'auth', 'installed', 'version.update', 'addon'])
                ->prefix('customer')
                ->as('customer.')
                ->group(base_path('routes/customer.php'));

            // Admin routes
            Route::middleware(['web', 'auth:admin_web', 'installed', 'version.update', 'addon'])
                ->prefix('admin')
                ->as('admin.')
                ->group(base_path('routes/admin.php'));

            // Frontend routes
            Route::middleware(['web', 'installed', 'version.update', 'addon'])
                ->as('frontend.')
                ->group(base_path('routes/frontend.php'));

            // Web routes
            Route::middleware(['web', 'installed', 'version.update'])
                ->group(base_path('routes/web.php'));

            // API routes
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            if(isAddonInstalled('PIXELDONATION')){
                // Customer routes
                Route::middleware(['web', 'auth', 'installed', 'version.update', 'addon'])
                    ->prefix('customer')
                    ->as('customer.')
                    ->group(base_path('routes/addon/donation/customer.php'));

                // Admin routes
                Route::middleware(['web', 'auth:admin_web', 'installed', 'version.update', 'addon'])
                    ->prefix('admin')
                    ->as('admin.')
                    ->group(base_path('routes/addon/donation/admin.php'));
            }
            if(isAddonInstalled('PIXELAFFILIATE')){
                // Customer routes
                Route::middleware(['web', 'auth', 'installed', 'version.update', 'addon'])
                    ->prefix('customer')
                    ->as('customer.')
                    ->group(base_path('routes/addon/affiliate/customer.php'));

                // Admin routes
                Route::middleware(['web', 'auth:admin_web', 'installed', 'version.update', 'addon'])
                    ->prefix('admin')
                    ->as('admin.')
                    ->group(base_path('routes/addon/affiliate/admin.php'));
            }
        });

    }

    public static function getHome()
    {
        $user = auth()->user();

        // Dynamically determine the home route based on contributor_status
        return ($user && $user->contributor_status == CONTRIBUTOR_STATUS_APPROVED)
            ? '/customer/products/create'
            : '/customer/profile';
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}

