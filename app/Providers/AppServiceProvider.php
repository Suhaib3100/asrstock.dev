<?php

namespace App\Providers;

use App\Models\Language;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('layouts.partial.common_pagination');

        try {
            $connection = DB::connection()->getPdo();
            if ($connection){
                $allOptions = [];
                $allOptions['settings'] = Setting::all()->pluck('option_value', 'option_key')->toArray();
                config($allOptions);
            }

            $language = Language::where('default_language', ACTIVE)->first();
            if ($language) {
                $ln = $language->iso_code;
                session(['local' => $ln]);
                App::setLocale(session()->get('local'));
            }
            config(['app.currencySymbol' => getCurrencySymbol()]);
            config(['app.isoCode' => getIsoCode()]);
            config(['app.currencyPlacement' => getCurrencyPlacement()]);

            config(['services.google.client_id' => getOption('google_client_id')]);
            config(['services.google.client_secret' => getOption('google_client_secret')]);
            config(['services.google.redirect' => url('auth/google/callback')]);

            config(['services.facebook.client_id' => getOption('facebook_client_id')]);
            config(['services.facebook.client_secret' => getOption('facebook_client_secret')]);
            config(['services.facebook.redirect' => url('auth/facebook/callback')]);

        } catch (\Exception $e) {
            //
        }
    }
}
