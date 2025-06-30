<?php

use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\WebhookController;
use Illuminate\Support\Facades\Route;


Route::post('/v1/payments', [PaymentController::class, 'store']);

Route::post('/v1/webhook/yookassa', [WebhookController::class, 'handle']);
