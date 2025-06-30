<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Enums\PaymentStatus;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        // Log всю сырую нагрузку
        Log::info('YooKassa Webhook', $payload);

        // Базовая idempotency-защита
        if (!isset($payload['object']['id']) || !isset($payload['object']['status'])) {
            return response()->json(['error' => 'invalid'], 400);
        }

        $providerId = $payload['object']['id'];
        $status = $payload['object']['status']; // 'succeeded' | 'waiting_for_capture' | 'canceled' | etc.

        $payment = Payment::where('provider_id', $providerId)->first();

        if (!$payment) {
            return response()->json(['error' => 'payment not found'], 404);
        }

        // Простейшая идемпотентность: статус уже установлен?
        if ($payment->status === PaymentStatus::Succeeded->value) {
            return response()->json(['ok' => true], 200);
        }

        // Обновление статуса
        if ($status === 'succeeded') {
            $payment->status = PaymentStatus::Succeeded->value;
        } elseif ($status === 'canceled') {
            $payment->status = PaymentStatus::Canceled->value;
        } else {
            $payment->status = PaymentStatus::Failed->value;
        }

        $payment->raw_payload = $payload;
        $payment->save();

        return response()->json(['ok' => true], 201);
    }
}
