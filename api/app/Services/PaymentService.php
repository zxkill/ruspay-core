<?php

namespace App\Services;

use App\Models\Payment;
use App\Enums\PaymentStatus;

class PaymentService
{
    public function create(array $data): Payment
    {
        $data['status'] = PaymentStatus::Pending->value;
        return Payment::create($data);
    }

    public function updateStatus(string $id, PaymentStatus $status): bool
    {
        $payment = Payment::findOrFail($id);
        $payment->status = $status->value;
        return $payment->save();
    }
}
