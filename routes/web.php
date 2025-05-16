<?php

use App\Http\Controllers\Api\OrderController as ApiOrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VersionUpdateController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Models\Language;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Language Switcher
Route::get('/local/{ln}', function ($ln) {
    $language = Language::where('iso_code', $ln)->first();
    if (!$language) {
        $language = Language::where('default_language', 'on')->first();
        if ($language) {
            $ln = $language->iso_code;
            session(['local' => $ln]);
            App::setLocale(session()->get('local'));
        }
    }

    session(['local' => $ln]);
    App::setLocale(session()->get('local'));
    return redirect()->back();
});

// Use default Auth::routes for customers
Auth::routes();

// Social Login (Facebook, Google)
Route::get('auth/{provider}', [LoginController::class, 'redirectSocialLogin'])->name('social.login');
Route::get('auth/{provider}/callback', [LoginController::class, 'handleSocialLogin']);

// Admin Authentication and Routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminLoginController::class, 'login']);
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');
});

// Additional Utility Routes
Route::get('storage-link', function () {
    Artisan::call('storage:link');
    return redirect()->back()->with('success', 'Storage Link Successfully');
});

Route::get('version-update', [VersionUpdateController::class, 'versionUpdate'])->name('version-update')->withoutMiddleware(['version.update']);
Route::post('process-update', [VersionUpdateController::class, 'processUpdate'])->name('process-update')->withoutMiddleware(['version.update']);
