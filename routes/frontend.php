<?php

use App\Http\Controllers\Frontend\AuthorController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PricingController;
use App\Http\Controllers\Frontend\ProductController;
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

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::post('favourite-product-store', [HomeController::class, 'favouriteProductStoreDelete'])->name('favourite.product.store');
Route::get('page/{type}', [HomeController::class, 'page'])->name('page');
Route::get('pricing', [PricingController::class, 'pricing'])->name('pricing');
Route::get('contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
Route::get('about-us', [HomeController::class, 'aboutUs'])->name('about-us');
Route::post('contact-us/store', [HomeController::class, 'contactUsStore'])->name('contact-us-store');
Route::get('country-states/{country_id}', [HomeController::class, 'fetchCountryStates'])->name('fetchCountryStates');
Route::get('state-cities/{state_id}', [HomeController::class, 'fetchStateCities'])->name('fetchStateCities');
Route::get('type/{uuid}', [ProductController::class, 'productType'])->name('product_category');
Route::get('search-result', [ProductController::class, 'searchResult'])->name('search-result');
Route::get('author-{type}-{user_name}', [AuthorController::class, 'profile'])->name('author.profile');
Route::get('product-board-modal/{product_id?}', [HomeController::class, 'productBoardModal'])->name('board.modal');
Route::get('author/{type}-{id}-{uuid}', [ProductController::class, 'getProductByContributor'])->name('product_by_contributor');
Route::post('subscriber', [HomeController::class, 'newsletter'])->name('newsletter');//
Route::get('product-{product_slug}', [ProductController::class, 'productDetails'])->name('product-details');

Route::group(['prefix' => 'blog','as' => 'blogs.'],function (){
    Route::get('list',[BlogController::class,'list'])->name('list');
    Route::get('details/{slug}',[BlogController::class,'details'])->name('details');
    Route::post('blog-comment/store', [BlogController::class, 'blogCommentStore'])->name('comment.store');
    Route::post('blog-comment-reply/store', [BlogController::class, 'blogCommentReplyStore'])->name('comment.reply');
    Route::get('blog-comment-reply-modal/{id}', [BlogController::class, 'blogCommentReplyModal'])->name('comment.reply.modal');
});
