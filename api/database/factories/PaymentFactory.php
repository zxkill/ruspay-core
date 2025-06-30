<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'id' => (string)Str::uuid(),
            'provider' => 'yookassa',
            'provider_id' => 'test_' . $this->faker->uuid(),
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'currency' => 'RUB',
            'status' => 'pending',
            'raw_payload' => [],
        ];
    }
}
