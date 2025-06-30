<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_payment()
    {
        $service = new \App\Services\PaymentService();
        $payment = $service->create([
            'provider' => 'yookassa',
            'amount' => 100,
            'currency' => 'RUB',
        ]);

        $this->assertDatabaseHas('payments', ['id' => $payment->id]);
    }
}
