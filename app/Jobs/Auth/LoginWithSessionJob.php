<?php

namespace App\Jobs\Auth;

use App\Repositories\Contracts\ISessionRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Validation\UnauthorizedException;

class LoginWithSessionJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $type, public string $id, public string $hash)
    {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        /** @var ISessionRepository $sessionRepository */
        $sessionRepository = app()->make(ISessionRepository::class);
        $session = $sessionRepository->loginWithSession($this->type, $this->id, $this->hash);

        if ($session) {
            $user = auth()->user();
            $session->update(['claimed' => 1, 'user_id' => $user->id]);

            return [];
        }
        throw new UnauthorizedException();
    }
}
