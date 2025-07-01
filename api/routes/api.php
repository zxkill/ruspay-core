<?php

use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\WebhookController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::post('/v1/payments', [PaymentController::class, 'store']);

Route::post('/v1/webhook/yookassa', [WebhookController::class, 'handle']);

Route::get('/health/db', function () {
    try {
        DB::connection()->getPdo()->query('SELECT 1');
        return response()->json(['db' => 'ok']);
    } catch (\Throwable $e) {
        return response()->json(['db' => 'fail'], 500);
    }
});
