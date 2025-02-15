<?php

namespace Tests\Feature\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'password' => bcrypt('password')
        ]);
    }

    /** @test */
    public function it_logs_in_successfully()
    {
        $response = $this->postJson('api/login', [
            'email' => $this->user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => ['token']
                ]);
    }

    /** @test */
    public function it_validates_invalid_credentials()
    {
        $response = $this->postJson('api/login', [
            'email' => $this->user->email,
            'password' => 'wrong'
        ]);

        $response->assertStatus(401)
                ->assertJson(['message' => 'Invalid credentials']);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->postJson('api/login', []);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['email', 'password']);
    }
}

