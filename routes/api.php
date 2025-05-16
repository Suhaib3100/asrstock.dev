<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CheckoutController;

////call back
Route::match(array('GET', 'POST'), 'verify/{type}', [CheckoutController::class, 'verify'])->name('payment.verify');
Route::match(array('GET', 'POST'), 'subscription/webhook', [CheckoutController::class, 'webhook'])->name('payment.subscription.webhook');
