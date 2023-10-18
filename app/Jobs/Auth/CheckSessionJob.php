<?php

namespace App\Jobs\Auth;

use App\Repositories\Contracts\ISessionRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Validation\UnauthorizedException;

class CheckSessionJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $type, public $id, public $hash)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        /** @var ISessionRepository $sessionRepository */
        $sessionRepository = app()->make(ISessionRepository::class);
        $session = $sessionRepository->checkSession($this->type, $this->id, $this->hash);
        if ($session) {
            // $session->delete();
            return ['user' => $session->user, 'token' => dispatch_sync(new GenerateTokenJob('', '', [], $session->user))];
        }
        throw new UnauthorizedException();
    }
}
