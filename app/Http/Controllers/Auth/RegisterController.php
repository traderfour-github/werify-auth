<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Jobs\Auth\GenerateTokenJob;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Create a new instance of RegisterController
     *
     *
     * @return void
     */
    public function __construct(public IUserRepository $userRepository)
    {
    }

    /**
     * Store a new user in database
     */
    public function register(RegisterRequest $request): array
    {
        $identifier = $request->identifier;
        $password = Hash::make($request->password);
        $name = $request->name;

        $this->createUser($identifier, $password, $name);

        $token = dispatch_sync(new GenerateTokenJob($identifier, $password));

        return $this->response(
            [
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60, 'token' => $token,
            ]
        );
    }

    /**
     * Create a new user
     */
    private function createUser(mixed $identifier, string $password, string|null $name = ''): bool
    {
        return $this->userRepository->createNewUser($identifier, $password, $name);
    }
}
