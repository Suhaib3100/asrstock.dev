<?php

use App\Http\Controllers\Customer\BeneficiaryController;
use App\Http\Controllers\Customer\BoardController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\SubscriptionController;
use App\Http\Controllers\Customer\WalletController;
use App\Http\Controllers\Customer\WithdrawalController;
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

//START contributor route only

Route::group(['middleware' => 'contributor'], function () {
    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/edit/{slug}', [ProductController::class, 'edit'])->name('edit');
        Route::post('update/{uuid}', [ProductController::class, 'update'])->name('update');
        Route::get('product-type-category/{product_type_id}', [ProductController::class, 'fetchProductTypeCategory'])->name('fetch_product_type_category');
        Route::post('/delete/{uuid}', [ProductController::class, 'delete'])->name('delete');
    });

    Route::get('sales', [ProductController::class, 'sales'])->name('sales');
    Route::get('downloads', [ProductController::class, 'downloads'])->name('downloads');
});
//END contributor route only

Route::post('product-report-{id}', [ProductController::class, 'productReport'])->name('products.report');
Route::post('product-comment-{id}', [ProductController::class, 'productComment'])->name('products.comment');
Route::get('my-earning', [WithdrawalController::class, 'my_earning'])->name('my_earning');
Route::post('withdraw', [WithdrawalController::class, 'withdraw'])->name('withdraw');

Route::group(['prefix' => 'beneficiaries', 'as' => 'beneficiaries.'], function () {
    Route::get('', [BeneficiaryController::class, 'beneficiary'])->name('index');
    Route::get('edit/{id}', [BeneficiaryController::class, 'edit'])->name('edit');
    Route::post('delete/{id}', [BeneficiaryController::class, 'delete'])->name('delete');
    Route::post('save/{id?}', [BeneficiaryController::class, 'store'])->name('store');
});


Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::post('update', [ProfileController::class, 'profileUpdate'])->name('update')->middleware('isDemo');
    Route::post('change-password', [ProfileController::class, 'changePassword'])->name('change_password')->middleware('isDemo');
    Route::post('delete-my-account', [ProfileController::class, 'deleteMyAccount'])->name('delete_my_account')->middleware('isDemo');
});

Route::group(['prefix' => 'devices', 'as' => 'devices.'], function () {
    Route::get('/', [ProfileController::class, 'loginDevices'])->name('index');
    Route::post('/{id}', [ProfileController::class, 'singleDeviceLogout'])->name('logout');
});

Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
    Route::get('my-order-list', [OrderController::class, 'myOrderList'])->name('my_order_list');
    Route::get('invoice-download/{order_id}', [OrderController::class, 'invoiceDownload'])->name('invoice_download');
});

Route::group(['prefix' => 'subscriptions', 'as' => 'subscriptions.'], function () {
    Route::get('my-subscription-plan', [SubscriptionController::class, 'mySubscriptionPlan'])->name('my_subscription');
    Route::post('cancel-plan/{id}', [SubscriptionController::class, 'cancelSubscriptionPlan'])->name('cancel');
});

Route::group(['prefix' => 'checkout', 'as' => 'checkout.'], function () {
    Route::get('/', [CheckoutController::class, 'checkout'])->name('page');
    Route::post('pay', [CheckoutController::class, 'pay'])->name('pay');
    Route::get('response', [CheckoutController::class, 'successOrFail'])->name('success');
});

Route::group(['prefix' => 'wallets', 'as' => 'wallets.'], function () {
    Route::get('/', [WalletController::class, 'index'])->name('index');
    Route::get('/history-deposit-wallet', [WalletController::class, 'walletDepositHistory'])->name('history-deposit-wallet');
});

Route::get('/be-a-contributor', [ProfileController::class, 'beAContributor'])->name('be_a_contributor');
Route::post('/store-contributor', [ProfileController::class, 'beAContributorStore'])->name('store_contributor');
Route::get('/followings', [ProfileController::class, 'following'])->name('followings');
Route::post('/followings/follow-unfollow', [ProfileController::class, 'followingStoreRemove'])->name('followings.follow_unfollow');
Route::get('/my-downloads', [ProductController::class, 'myDownloads'])->name('my_downloads');
Route::get('/my-purchase', [ProductController::class, 'myPurchase'])->name('my_purchase');
Route::get('/my-purchase-download/{variation_id}', [ProductController::class, 'myPurchaseDownload'])->name('my_purchase_download');
Route::get('/product-download/{variation_id}', [ProductController::class, 'downloadProduct'])->name('product_download');
Route::get('/download-unique', [ProductController::class, 'oneTimeDownload'])->name('one_time_download');
Route::get('/favourite', [ProductController::class, 'favouriteProduct'])->name('favourite');
Route::get('/unfavourite/{id}', [ProductController::class, 'unfavouriteProduct'])->name('unfavourite');

Route::group(['prefix' => 'boards', 'as' => 'boards.'], function () {
    Route::get('/', [BoardController::class, 'index'])->name('index');
    Route::get('/edit/{id}', [BoardController::class, 'edit'])->name('edit');
    Route::get('/view/{id}', [BoardController::class, 'view'])->name('view');
    Route::post('store', [BoardController::class, 'store'])->name('store');
    Route::post('update/{id}', [BoardController::class, 'update'])->name('update');
    Route::post('delete/{id}', [BoardController::class, 'delete'])->name('delete');
    Route::post('product-delete/{id}', [BoardController::class, 'deleteBoardProduct'])->name('product_delete');
    Route::post('product-store', [BoardController::class, 'addBoardProduct'])->name('product.store');
});
