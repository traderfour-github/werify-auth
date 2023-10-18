<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repositories\Contracts\ISessionRepository;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class LoginProcessTest extends TestCase
{
    public function test_request_otp(): void
    {
        $user = User::factory()->create();
        $response = $this->post('/api/login', ['identifier' => $user->identifier]);

        $response->assertStatus(201);
    }

    public function test_request_wrong_identifier_otp(): void
    {
        $response = $this->post('/api/login', ['identifier' => 'test']);

        $response->assertStatus(404);
    }

    public function test_login_with_otp(): void
    {
        $sessionRepository = app()->make(ISessionRepository::class);
        $user = User::factory()->create();
        $response = $this->post('/api/login', ['identifier' => $user->identifier]);
        $response->assertStatus(201);
        $session = $sessionRepository->getLatestUserSession($user->id);
        $response = $this->post('/api/otp', ['id' => $session->id, 'hash' => $session->hash, 'otp' => $session->otp]);
    }

    public function test_wrong_login_with_otp(): void
    {
        $sessionRepository = app()->make(ISessionRepository::class);
        $user = User::factory()->create();
        $response = $this->post('/api/login', ['identifier' => $user->identifier]);
        $response->assertStatus(201);
        $session = $sessionRepository->getLatestUserSession($user->id);
        $response = $this->post('/api/otp', ['id' => $session->id, 'hash' => $session->hash, 'otp' => '123456']);
    }

    public function test_wrong_id_login_with_otp(): void
    {
        $sessionRepository = app()->make(ISessionRepository::class);
        $user = User::factory()->create();
        $response = $this->post('/api/login', ['identifier' => $user->identifier]);
        $response->assertStatus(201);
        $session = $sessionRepository->getLatestUserSession($user->id);
        $response = $this->post('/api/otp', ['id' => Uuid::uuid4(), 'hash' => $session->hash, 'otp' => $session->otp]);
    }

    public function test_wrong_hash_login_with_otp(): void
    {
        $sessionRepository = app()->make(ISessionRepository::class);
        $user = User::factory()->create();
        $response = $this->post('/api/login', ['identifier' => $user->identifier]);
        $response->assertStatus(201);
        $session = $sessionRepository->getLatestUserSession($user->id);
        $response = $this->post('/api/otp', ['id' => $session->id, 'hash' => Uuid::uuid4(), 'otp' => $session->otp]);
    }
}
