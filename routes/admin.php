<?php

use App\Http\Controllers\AddonUpdateController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BulkUploadController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\ContactUsTopicController;
use App\Http\Controllers\Admin\ContributorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EarningManagementController;
use App\Http\Controllers\Admin\GatewayController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\MetaManagementController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportedController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\WithdrawController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\PolicyController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductTypeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SourceController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\VersionUpdateController;
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

Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::group(['prefix' => 'contributor', 'as' => 'contributor.'], function () {
    Route::get('/{status?}', [ContributorController::class, 'index'])->name('index');
    Route::get('edit/{id}', [ContributorController::class, 'edit'])->name('edit');
    Route::post('status-update/{id}', [ContributorController::class, 'statusUpdate'])->name('status.update')->middleware('isDemo');
});

Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
    Route::get('/{status?}', [CustomerController::class, 'index'])->name('index');
    Route::post('change-customer-status', [CustomerController::class, 'changeCustomerStatus'])->name('changeCustomerStatus');
    Route::post('delete/{uuid}', [CustomerController::class, 'delete'])->name('delete')->middleware('isDemo');
    Route::get('edit/{id}', [CustomerController::class, 'edit'])->name('edit');
    Route::post('status-update/{id}', [CustomerController::class, 'statusUpdate'])->name('status.update')->middleware('isDemo');
});

Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
    Route::get('setting', [ProductController::class, 'productSetting'])->name('setting')->middleware('permission:product_setting');
    Route::get('index/{status?}', [ProductController::class, 'index'])->name('status');
    Route::get('status-modal/{id}', [ProductController::class, 'statusModal'])->name('status-modal');
    Route::get('is-feature-modal/{id}', [ProductController::class, 'isFeatureModal'])->name('is-feature-modal');
    Route::post('status-update/{id}', [ProductController::class, 'statusUpdate'])->name('status.update')->middleware('isDemo');
    Route::post('is-feature-update/{id}', [ProductController::class, 'isFeatureUpdate'])->name('is.feature.update')->middleware('isDemo');
    Route::post('delete/{id}', [ProductController::class, 'delete'])->name('delete')->middleware('isDemo');
    Route::group(['prefix' => 'comment', 'as' => 'comment.'], function () {
        Route::get('/', [ProductController::class, 'productComments'])->name('index')->middleware('permission:product_comment');
        Route::delete('delete/{id}', [ProductController::class, 'productCommentDelete'])->name('delete')->middleware('isDemo');
        Route::post('status', [ProductController::class, 'changeProductCommentStatus'])->name('changeStatus');
    });

    Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
        Route::get('index', [ProductCategoryController::class, 'index'])->name('index')->middleware('permission:category');
        Route::post('store', [ProductCategoryController::class, 'store'])->name('store')->middleware('isDemo');
        Route::put('update/{uuid}', [ProductCategoryController::class, 'update'])->name('update')->middleware('isDemo');
        Route::delete('delete/{uuid}', [ProductCategoryController::class, 'delete'])->name('delete')->middleware('isDemo');
        Route::post('change-status', [ProductCategoryController::class, 'changeStatus'])->name('changeStatus');
    });

    Route::group(['prefix' => 'tag', 'as' => 'tag.'], function () {
        Route::get('tag', [TagController::class, 'index'])->name('index')->middleware('permission:tags');
        Route::post('store', [TagController::class, 'store'])->name('store')->middleware('isDemo');
        Route::put('update/{uuid}', [TagController::class, 'update'])->name('update')->middleware('isDemo');
        Route::delete('delete/{uuid}', [TagController::class, 'delete'])->name('delete')->middleware('isDemo');
    });

    Route::group(['prefix' => 'product-type', 'as' => 'product-type.'], function () {
        Route::get('index', [ProductTypeController::class, 'index'])->name('index')->middleware('permission:product_type');
        Route::post('store', [ProductTypeController::class, 'store'])->name('store')->middleware('isDemo');
        Route::post('change-status', [ProductTypeController::class, 'changeStatus'])->name('changeStatus');
        Route::delete('delete/{uuid}', [ProductTypeController::class, 'delete'])->name('delete')->middleware('isDemo');
    });

    Route::get('product-type/category', [ProductController::class, 'fetchProductTypeCategory'])->name('product-type.category');

    Route::post('change-product-status', [ProductController::class, 'changeProductStatus'])->name('changeProductStatus');
    Route::post('change-product-featured-status', [ProductController::class, 'changeProductIsFeaturedStatus'])->name('changeProductIsFeaturedStatus');

    Route::group(['prefix' => 'bulk-upload', 'as' => 'bulk-upload.'], function () {
        Route::get('/', [BulkUploadController::class, 'product_bulk_upload'])->name('index')->middleware('permission:product_bulk_upload');
        Route::post('file', [BulkUploadController::class, 'product_bulk_upload_file'])->name('file');
        Route::get('check', [BulkUploadController::class, 'product_bulk_upload_check'])->name('check');
        Route::post('confirm', [BulkUploadController::class, 'product_bulk_upload_confirm'])->name('confirm');
    });
});
Route::resource('product', ProductController::class);

//Start:: Order
Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
    Route::get('all-orders/{status?}', [OrderController::class, 'allOrders'])->name('all-orders');
    Route::get('bank-payment-orders/{status}', [OrderController::class, 'bankPaymentOrders'])->name('bank-payment-orders');
    Route::get('bank-status-modal/{id}', [OrderController::class, 'bankStatusModal'])->name('bank-status-modal');
    Route::post('bank-status-update/{id}', [OrderController::class, 'bankStatusUpdate'])->name('bank.status.update')->middleware('isDemo');
});
//End:: Order

//Start:: Wallet
Route::group(['prefix' => 'wallet', 'as' => 'wallet.'], function () {
    Route::get('setting', [WalletController::class, 'walletSetting'])->name('walletSetting')->middleware('permission:wallet_setting');
    Route::get('all-wallet-list/{status?}', [WalletController::class, 'allWalletList'])->name('all-wallet-list');
    Route::get('wallet-modal/{id}', [WalletController::class, 'statusChangeModal'])->name('status-change-modal');
    Route::post('status-update/{id}', [WalletController::class, 'statusUpdate'])->name('status.update');
});
//End:: Wallet

//Start:: Earning Management
Route::group(['prefix' => 'earning', 'as' => 'earning.'], function () {
    Route::get('download-products', [EarningManagementController::class, 'downloadProducts'])->name('downloadProducts')->middleware('permission:download_products');
    Route::get('product-history', [EarningManagementController::class, 'productEarningHistory'])->name('productHistory')->middleware('permission:product_history');
    Route::get('commission-setting', [EarningManagementController::class, 'commissionSetting'])->name('commissionSetting')->middleware('permission:commission_setting');
    Route::get('earning-management', [EarningManagementController::class, 'earningManagement'])->name('earningManagement')->middleware('permission:commission_distribution');
    Route::get('earning-info-via-month-year', [EarningManagementController::class, 'earningInfoViaMonthYear'])->name('earningInfoViaMonthYear');
    Route::post('send-money/store', [EarningManagementController::class, 'sendMoneyStore'])->name('send-money.store');
});
//End:: Earning Management

Route::resource('coupon', CouponController::class);
Route::post('change-coupon-status', [CouponController::class, 'changeCouponStatus'])->name('coupon.changeCouponStatus');
Route::get('coupon/used-customer-coupon-list/{coupon_id}', [CouponController::class, 'usedCustomerCouponList'])->name('coupon.usedCustomerCouponList');

Route::get('subscription-plan', [PlanController::class, 'subscriptionPlan'])->name('subscriptionPlan')->middleware('permission:subscription_plan');
Route::resource('plan', PlanController::class);
Route::post('change-plan-status', [PlanController::class, 'changePlanStatus'])->name('plan.changePlanStatus');


Route::group(['prefix' => 'withdraw', 'as' => 'withdraw.'], function () {
    Route::get('pending', [WithdrawController::class, 'pendingWithdraw'])->name('pending')->middleware('permission:pending_withdraw');
    Route::get('completed', [WithdrawController::class, 'completedWithdraw'])->name('completed')->middleware('permission:complete_withdraw');
    Route::get('cancelled', [WithdrawController::class, 'cancelledWithdraw'])->name('cancelled')->middleware('permission:cancelled_withdraw');
    Route::post('completed-status', [WithdrawController::class, 'completedStatus'])->name('completedStatus');
    Route::post('cancelled-reason', [WithdrawController::class, 'cancelledReason'])->name('cancelledReason');
});

Route::group(['prefix' => 'reported', 'as' => 'reported.'], function () {
    Route::get('members', [ReportedController::class, 'memberReportedIndex'])->name('members.index')->middleware('permission:member_reported');
    Route::delete('member/delete/{id}', [ReportedController::class, 'memberReportedDelete'])->name('member.delete')->middleware('isDemo');
    Route::get('products', [ReportedController::class, 'productReportedIndex'])->name('products.index')->middleware('permission:product_reported');
    Route::delete('product/delete/{id}', [ReportedController::class, 'productReportedDelete'])->name('product.delete')->middleware('isDemo');

    Route::get('category', [ReportedController::class, 'reportedCategoryIndex'])->name('category.index');
    Route::post('category/store', [ReportedController::class, 'reportedCategoryStore'])->name('category.store')->middleware('permission:reported_category', 'isDemo');
    Route::put('category/update/{id}', [ReportedController::class, 'reportedCategoryUpdate'])->name('category.update')->middleware('isDemo');
    Route::delete('category/delete/{id}', [ReportedController::class, 'reportedCategoryDelete'])->name('category.delete')->middleware('isDemo');
});

Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
    Route::group(['middleware' => ['permission:general_setting']], function () {
        Route::get('application-settings', [SettingController::class, 'applicationSetting'])->name('application-settings')->middleware('permission:settings');
        Route::post('application-settings-update', [SettingController::class, 'applicationSettingUpdate'])->name('application-settings.update')->middleware('isDemo');
        Route::get('logo-settings', [SettingController::class, 'logoSettings'])->name('logo-settings')->middleware('permission:settings');
        Route::get('general-settings', [SettingController::class, 'generalSetting'])->name('general-settings');
        Route::post('general-settings-update', [SettingController::class, 'generalSettingUpdate'])->name('general-settings.update')->middleware('isDemo');
        Route::post('general-settings-env-update', [SettingController::class, 'generalSettingEnvUpdate'])->name('general-settings-env.update')->middleware('isDemo');
        Route::get('configuration-settings', [SettingController::class, 'configurationSetting'])->name('configuration-settings')->middleware('permission:configure_settings');
        Route::post('configuration-settings-update', [SettingController::class, 'configurationSettingUpdate'])->name('configuration-settings.update')->middleware('isDemo');
        Route::get('configuration-settings/configure', [SettingController::class, 'configurationSettingConfigure'])->name('configuration-settings.configure')->middleware('isDemo');
        Route::get('configuration-settings/help', [SettingController::class, 'configurationSettingHelp'])->name('configuration-settings.help')->middleware('isDemo');
        Route::post('application-env-update', [SettingController::class, 'saveSetting'])->name('settings_env.update')->middleware('isDemo');

        Route::get('color-settings', [SettingController::class, 'colorSettings'])->name('color-settings')->middleware('permission:settings');
        Route::group(['prefix' => 'currency', 'as' => 'currency.'], function () {
            Route::get('', [CurrencyController::class, 'index'])->name('index')->middleware('permission:settings');
            Route::post('currency', [CurrencyController::class, 'store'])->name('store')->middleware('isDemo');
            Route::get('edit/{id}/{slug?}', [CurrencyController::class, 'edit'])->name('edit');
            Route::patch('update/{id}', [CurrencyController::class, 'update'])->name('update')->middleware('isDemo');
            Route::post('delete/{id}', [CurrencyController::class, 'delete'])->name('delete')->middleware('isDemo');
        });
        Route::group(['prefix' => 'language', 'as' => 'language.', 'middleware' => 'permission:manage_language'], function () {
            Route::get('/', [LanguageController::class, 'index'])->name('index')->middleware('permission:settings');
            Route::get('create', [LanguageController::class, 'create'])->name('create');
            Route::post('store', [LanguageController::class, 'store'])->name('store')->middleware('isDemo');
            Route::get('edit/{id}/{iso_code?}', [LanguageController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [LanguageController::class, 'update'])->name('update')->middleware('isDemo');
            Route::get('delete/{id}', [LanguageController::class, 'delete'])->name('delete')->middleware('isDemo');
            Route::get('translate/{id}/{iso_code?}', [LanguageController::class, 'translateLanguage'])->name('translate');
            Route::post('update-translate/{id}', [LanguageController::class, 'updateTranslate'])->name('update.translate')->middleware('isDemo');
            Route::post('import', [LanguageController::class, 'import'])->name('import')->middleware('isDemo');
            Route::post('update-language/{id}', [LanguageController::class, 'updateLanguage'])->name('update-language');
        });

        Route::group(['prefix' => 'gateway', 'as' => 'gateway.'], function () {
            Route::get('/', [GatewayController::class, 'index'])->name('index')->middleware('permission:settings');
            Route::get('edit/{id}', [GatewayController::class, 'edit'])->name('edit')->middleware('permission:settings');
            Route::post('store', [GatewayController::class, 'store'])->name('store')->middleware('isDemo')->middleware('permission:settings');
            Route::get('get-info', [GatewayController::class, 'getInfo'])->name('get.info')->middleware('permission:settings');
            Route::get('get-currency-by-gateway', [GatewayController::class, 'getCurrencyByGateway'])->name('get.currency')->middleware('permission:settings');
            Route::get('syncs', [GatewayController::class, 'syncs'])->name('syncs')->middleware('permission:settings');
        });

        Route::group(['prefix' => 'meta', 'as' => 'meta.'], function () {
            Route::get('/', [MetaManagementController::class, 'metaIndex'])->name('index')->middleware('permission:settings');
            Route::get('add', [MetaManagementController::class, 'add'])->name('add');
            Route::post('store', [MetaManagementController::class, 'store'])->name('store');

            Route::get('edit/{uuid}', [MetaManagementController::class, 'editMeta'])->name('edit');
            Route::put('update/{uuid}', [MetaManagementController::class, 'updateMeta'])->name('update')->middleware('isDemo');
            Route::delete('delete/{uuid}', [MetaManagementController::class, 'delete'])->name('delete')->middleware('isDemo');
            Route::get('get-page', [MetaManagementController::class, 'getPage'])->name('get_page');
        });
        Route::group(['prefix' => 'source', 'as' => 'source.'], function () {
            Route::get('/', [SourceController::class, 'index'])->name('index')->middleware('permission:settings');
            Route::post('store', [SourceController::class, 'store'])->name('store')->middleware('isDemo');
            Route::post('update/{id}', [SourceController::class, 'update'])->name('update')->middleware('isDemo');
            Route::delete('delete/{id}', [SourceController::class, 'delete'])->name('delete')->middleware('isDemo');
        });
        Route::group(['prefix' => 'tax', 'as' => 'tax.'], function () {
            Route::get('/', [TaxController::class, 'index'])->name('index')->middleware('permission:settings');
            Route::post('store', [TaxController::class, 'store'])->name('store')->middleware('isDemo');
            Route::post('update/{id}', [TaxController::class, 'update'])->name('update')->middleware('isDemo');
            Route::delete('delete/{id}', [TaxController::class, 'delete'])->name('delete')->middleware('isDemo');
        });

        Route::get('storage-settings', [SettingController::class, 'storageSetting'])->name('storage.index')->middleware('permission:settings');
        Route::post('storage-settings', [SettingController::class, 'storageSettingsUpdate'])->name('storage.update')->middleware('isDemo');
        Route::get('storage-link', [SettingController::class, 'storageLink'])->name('storage.link')->middleware('isDemo');
        Route::get('google-adsense-settings', [SettingController::class, 'googleAdsenseSetting'])->name('google.adsense')->middleware('permission:settings');
        Route::get('google-2fa-settings', [SettingController::class, 'google2faSetting'])->name('google.2fa');
        Route::get('social-login-settings', [SettingController::class, 'socialLoginSetting'])->name('social-login');
        Route::get('google-recaptcha-settings', [SettingController::class, 'googleRecaptchaSetting'])->name('google-recaptcha');
        Route::get('google-analytics', [SettingController::class, 'googleAnalytics'])->name('google-analytics');
    });

    Route::get('mail-configuration', [SettingController::class, 'mailConfiguration'])->name('mail-configuration')->middleware('permission:mail_configuration');
    Route::post('send-test-mail', [SettingController::class, 'sendTestMail'])->name('send.test.mail')->middleware('isDemo');

    Route::group(['prefix' => 'locations', 'as' => 'location.', 'middleware' => 'permission:location_setting'], function () {
        Route::get('country', [LocationController::class, 'countryIndex'])->name('country.index')->middleware('permission:frontend_settings');
        Route::post('country', [LocationController::class, 'countryStore'])->name('country.store')->middleware('isDemo');
        Route::get('country/{id}/{slug?}', [LocationController::class, 'countryEdit'])->name('country.edit');
        Route::patch('country/{id}', [LocationController::class, 'countryUpdate'])->name('country.update')->middleware('isDemo');
        Route::delete('country/delete/{id}', [LocationController::class, 'countryDelete'])->name('country.delete')->middleware('isDemo');

        Route::get('state', [LocationController::class, 'stateIndex'])->name('state.index')->middleware('permission:frontend_settings');
        Route::post('state', [LocationController::class, 'stateStore'])->name('state.store')->middleware('isDemo');
        Route::get('state/{id}/{slug?}', [LocationController::class, 'stateEdit'])->name('state.edit');
        Route::patch('state/{id}', [LocationController::class, 'stateUpdate'])->name('state.update')->middleware('isDemo');
        Route::delete('state/delete/{id}', [LocationController::class, 'stateDelete'])->name('state.delete')->middleware('isDemo');

        Route::get('city', [LocationController::class, 'cityIndex'])->name('city.index')->middleware('permission:frontend_settings');
        Route::post('city', [LocationController::class, 'cityStore'])->name('city.store')->middleware('isDemo');
        Route::get('city/{id}/{slug?}', [LocationController::class, 'cityEdit'])->name('city.edit');
        Route::patch('city/{id}', [LocationController::class, 'cityUpdate'])->name('city.update')->middleware('isDemo');
        Route::delete('city/delete/{id}', [LocationController::class, 'cityDelete'])->name('city.delete')->middleware('isDemo');
    });

    Route::group(['prefix' => 'home', 'as' => 'home.', 'middleware' => 'permission:home_setting'], function () {
        Route::get('home-settings', [SettingController::class, 'homeSettings'])->name('home-settings')->middleware('permission:frontend_settings');

        Route::get('why-us', [SettingController::class, 'whyUs'])->name('why-us')->middleware('permission:frontend_settings');
        Route::post('why-us', [SettingController::class, 'whyUsUpdate'])->name('why-us.update')->middleware('isDemo');

        Route::get('testimonial', [SettingController::class, 'testimonial'])->name('testimonial')->middleware('permission:frontend_settings');
        Route::post('testimonial', [SettingController::class, 'testimonialUpdate'])->name('testimonial.update')->middleware('isDemo');
    });

    Route::get('be-a-contributor', [SettingController::class, 'beAContributor'])->name('be-a-contributor')->middleware('permission:frontend_settings');

    // Start:: About Us
    Route::group(['prefix' => 'about-us', 'as' => 'about.', 'middleware' => 'permission:about_us_setting'], function () {
        Route::get('gallery-area', [AboutUsController::class, 'galleryArea'])->name('gallery-area')->middleware('permission:frontend_settings');
        Route::post('gallery-area', [AboutUsController::class, 'galleryAreaUpdate'])->name('gallery-area.update')->middleware('isDemo');

        Route::get('team-member', [AboutUsController::class, 'teamMember'])->name('team-member')->middleware('permission:frontend_settings');
        Route::post('team-member', [AboutUsController::class, 'teamMemberUpdate'])->name('team-member.update')->middleware('isDemo');
    });
    // End:: About Us

    Route::get('contact-us-cms', [SettingController::class, 'contactUsCMS'])->name('contactus.index')->middleware('permission:frontend_settings');
    Route::group(['prefix' => 'faq', 'as' => 'faq.', 'middleware' => 'permission:faq_setting'], function () {
        Route::get('faq-settings', [SettingController::class, 'faq'])->name('index');
        Route::post('faq-settings', [SettingController::class, 'faqUpdate'])->name('update')->middleware('isDemo');
    });

    //Start:: Maintenance Mode
    Route::get('maintenance-mode-changes', [SettingController::class, 'maintenanceMode'])->name('maintenance')->middleware('permission:settings');
    Route::post('maintenance-mode-changes', [SettingController::class, 'maintenanceModeChange'])->name('maintenance.change')->middleware('permission:settings');
    //End:: Maintenance Mode

    //Migrate, Cache
    Route::get('cache-settings', [SettingController::class, 'cacheSettings'])->name('cache-settings')->middleware('permission:settings');
    Route::get('auth-page-settings', [SettingController::class, 'authPageSettings'])->name('auth-page-settings');
    Route::get('cache-update/{id}', [SettingController::class, 'cacheUpdate'])->name('cache-update')->middleware('isDemo');
    Route::get('migrate-update', [SettingController::class, 'migrateUpdate'])->name('migrate-update')->middleware('isDemo');
});

Route::resource('user', UserController::class);

Route::resource('role', RoleController::class);
Route::get('role/get-sub-module/{id}', [RoleController::class, 'getSubmodule'])->name('getSubmodule');

Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('change-password', [ProfileController::class, 'changePassword'])->name('change-password');
    Route::post('change-password', [ProfileController::class, 'changePasswordUpdate'])->name('change-password.update')->middleware('isDemo');
    Route::post('update', [ProfileController::class, 'update'])->name('update')->middleware('isDemo');
});


Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {
    Route::get('/', [BlogController::class, 'index'])->name('index')->middleware('permission:all_blog');
    Route::get('create', [BlogController::class, 'create'])->name('create')->middleware('permission:add_blog');
    Route::post('store', [BlogController::class, 'store'])->name('store')->middleware('isDemo');
    Route::get('edit/{uuid}', [BlogController::class, 'edit'])->name('edit');
    Route::put('update/{uuid}', [BlogController::class, 'update'])->name('update')->middleware('isDemo');
    Route::delete('delete/{uuid}', [BlogController::class, 'delete'])->name('delete')->middleware('isDemo');

    Route::group(['prefix' => 'comment', 'as' => 'comment.', 'middleware' => 'permission:blog_comment_list'], function () {
        Route::get('/', [BlogController::class, 'blogCommentList'])->name('index');
        Route::post('change-status', [BlogController::class, 'changeBlogCommentStatus'])->name('changeStatus');
        Route::delete('delete/{id}', [BlogController::class, 'blogCommentDelete'])->name('delete')->middleware('isDemo');
    });

    Route::group(['prefix' => 'category', 'as' => 'category.', 'middleware' => 'permission:blog_category'], function () {
        Route::get('/', [BlogCategoryController::class, 'index'])->name('index');
        Route::post('store', [BlogCategoryController::class, 'store'])->name('store')->middleware('isDemo');
        Route::patch('update/{uuid}', [BlogCategoryController::class, 'update'])->name('update')->middleware('isDemo');
        Route::get('delete/{uuid}', [BlogCategoryController::class, 'delete'])->name('delete')->middleware('isDemo');
    });
});

Route::group(['prefix' => 'newsletter', 'as' => 'newsletter.', 'middleware' => 'permission:newsletter_subscriber'], function () {
    Route::get('list', [NewsletterController::class, 'list'])->name('index');
    Route::delete('delete/{id}', [NewsletterController::class, 'delete'])->name('delete')->middleware('isDemo');
    Route::post('send-mail', [NewsletterController::class, 'sendMail'])->name('sendMail')->middleware('isDemo');
});

Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
    Route::get('contact-us-list', [ContactUsController::class, 'contactUsIndex'])->name('index')->middleware('permission:all_contact_us');
    Route::delete('contact-us-delete/{id}', [ContactUsController::class, 'contactUsDelete'])->name('delete')->middleware('isDemo');
    Route::resource('topic', ContactUsTopicController::class)->middleware('permission:contact_us_topic');
});

//Start:: Policy Setting
Route::get('terms-conditions', [PolicyController::class, 'termsConditions'])->name('terms-conditions')->middleware('permission:frontend_settings');
Route::post('terms-conditions', [PolicyController::class, 'termsConditionsStore'])->name('terms-conditions.store')->middleware('isDemo');

Route::get('privacy-policy', [PolicyController::class, 'privacyPolicy'])->name('privacy-policy')->middleware('permission:frontend_settings');
Route::post('privacy-policy', [PolicyController::class, 'privacyPolicyStore'])->name('privacy-policy.store')->middleware('isDemo');

Route::get('cookie-policy', [PolicyController::class, 'cookiePolicy'])->name('cookie-policy')->middleware('permission:frontend_settings');
Route::post('cookie-policy', [PolicyController::class, 'cookiePolicyStore'])->name('cookie-policy.store')->middleware('isDemo');
//End:: Policy Setting

Route::get('version-update', [VersionUpdateController::class, 'versionFileUpdate'])->name('version-update');
Route::post('version-update', [VersionUpdateController::class, 'versionFileUpdateStore'])->name('version-update-store');
Route::get('version-update-execute', [VersionUpdateController::class, 'versionUpdateExecute'])->name('version-update-execute');
Route::get('version-delete', [VersionUpdateController::class, 'versionFileUpdateDelete'])->name('version-delete');

Route::group(['prefix' => 'addon', 'as' => 'addon.'], function () {
    Route::get('details/{code}', [AddonUpdateController::class, 'addonDetails'])->name('details')->withoutMiddleware(['addon']);
    Route::post('store', [AddonUpdateController::class, 'addonFileStore'])->name('store')->withoutMiddleware(['addon']);
    Route::post('execute', [AddonUpdateController::class, 'addonFileExecute'])->name('execute')->withoutMiddleware(['addon']);
    Route::get('delete/{code}', [AddonUpdateController::class, 'addonFileDelete'])->name('delete')->withoutMiddleware(['addon']);
});


