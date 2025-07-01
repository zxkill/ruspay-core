<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HealthTest extends TestCase
{
    use RefreshDatabase;

    public function test_db_is_up()
    {
        $resp = $this->get('/api/health/db');
        $resp->assertStatus(200)
            ->assertExactJson(['db' => 'ok']);
    }
}
