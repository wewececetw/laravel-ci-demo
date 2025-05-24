<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_routes_are_not_available()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/user');
        $response->assertStatus(404);

        $response = $this->putJson('/api/user', [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
        $response->assertStatus(404);
    }
}
