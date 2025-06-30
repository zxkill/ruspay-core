<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use App\Services\OmnipayFactory;
use App\Enums\PaymentStatus;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function store(StorePaymentRequest $request)
    {
        $data = $request->validated();

        $gateway = OmnipayFactory::make();

        $transactionId = (string)Str::uuid();
        $purchase = $gateway->purchase([
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'transactionId' => $transactionId,
            'description' => $data['description'] ?? 'Оплата заказа',
            'returnUrl' => url('/success'),
            'cancelUrl' => url('/fail'),
            'capture' => true,
        ]);

        $response = $purchase->send();

        $payment = Payment::create([
            'id' => $transactionId,
            'provider' => $data['provider'],
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'status' => PaymentStatus::Pending->value,
            'provider_id' => $response->getTransactionReference(),
            'raw_payload' => $response->getData(),
        ]);

        return response()->json([
            'payment_id' => $payment->id,
            'checkout_url' => $response->getRedirectUrl(),
        ], 201);
    }
}
