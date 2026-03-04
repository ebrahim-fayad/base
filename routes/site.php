<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\IntroController;
use App\Services\PaymentGateway\PaymentService;
use App\Http\Controllers\Site\PaymentController;


Route::get('/', [IntroController::class, 'index'])->name('intro');
Route::get('/privacy-policy', [IntroController::class, 'privacyPolicy'])->name('IntroPrivacyPolicy');
Route::get('/delete-account-page', [IntroController::class, 'deleteAccount'])->name('deleteAccountPage');
Route::post('/send-message', [IntroController::class, 'sendMessage']);
Route::get('/lang/{lang}', [IntroController::class, 'SetLanguage']);


Route::get(
    '/hyper-pay-form/{transaction_id}/{brand_id}/{brand_type}',
    [PaymentController::class, 'getHyperPay']
)->name('getHyperPay');

// redirect to home if url not found
// Route::fallback(function () {
//     $route = str_contains(url()->current(), 'admin') ? 'admin.show.login' : 'intro';
//     return  redirect()->route($route);
// });

// payment
Route::get('payment/get-payment-status/{brand_id?}',  [PaymentService::class, 'callback'])
    ->name('payment.getPaymentStatus');
  // payment
