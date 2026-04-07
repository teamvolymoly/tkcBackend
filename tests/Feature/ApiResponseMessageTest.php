<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiResponseMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_protected_api_returns_clear_authentication_message_for_guests(): void
    {
        $response = $this->getJson('/api/addresses');

        $response
            ->assertUnauthorized()
            ->assertJson([
                'status' => false,
                'message' => 'Authentication is required to access this resource. Please log in and try again.',
            ]);
    }

    public function test_admin_protected_api_returns_clear_permission_message_for_authenticated_users(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson('/api/inventory');

        $response
            ->assertForbidden()
            ->assertJson([
                'status' => false,
                'message' => 'You do not have permission to perform this action.',
            ]);
    }
}
