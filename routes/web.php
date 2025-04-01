<?php

use App\Http\Controllers\Telegram\WebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('telegram')
    ->name('telegram.')
    ->group(function () {
        Route::get('webhook', [WebhookController::class, 'set'])->name('webhook-set');
        Route::post('webhook', [WebhookController::class, 'handle'])->name('webhook-handle');
    });
