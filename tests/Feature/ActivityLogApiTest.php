<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityLogApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_test_list_activity_logs(): void
    {
        $response = $this->getJson('/api/activity-logs');
        $response->assertStatus(200)->assertJsonStructure(['logs']);
    }
}
