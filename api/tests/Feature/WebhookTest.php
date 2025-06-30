<?php


namespace Tests\Feature;

use App\Models\Payment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_webhook_updates_status()
    {
        $payment = Payment::factory()->create([
            'provider' => 'yookassa',
            'provider_id' => 'test_123',
            'status' => 'pending',
        ]);

        $response = $this->postJson('/api/v1/webhook/yookassa', [
            'object' => [
                'id' => 'test_123',
                'status' => 'succeeded',
            ]
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'succeeded',
        ]);
    }
}
