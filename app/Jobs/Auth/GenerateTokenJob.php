<?php

namespace App\Jobs\Auth;

use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class GenerateTokenJob
{
    /**
     * Create a new job instance.
     */
    public function __construct(public string $identifier, public string $password, public array $extra = [], public $user = null)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if ($this->user) {
            return JWTAuth::claims($this->claims($this->user))->fromUser($this->user);
        } else {
            /** @var IUserRepository $userRepository */
            $userRepository = app()->make(IUserRepository::class);
            $user = $userRepository->findOrFailUserWithIdentifier($this->identifier);

            return JWTAuth::claims($this->claims($user))->attempt(['identifier' => $this->identifier, 'password' => $this->password]);
        }
    }

    private function claims(User $user)
    {
        $request = app()->request;

        return array_merge(
            $this->extra,
            [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'deleted_at' => $user->deleted_at,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'application_id' => $request->application->id,
            ]
        );
    }
}
