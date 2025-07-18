<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    // use RefreshDatabase;

    public function test_user_can_login_with_correct_credentials()
    {

        $response = $this->postJson('/api/login', [
            'email' => 'user@admin.com',
            'password' => '123456',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
        ]);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Invalid credentials',
        ]);
    }
}
