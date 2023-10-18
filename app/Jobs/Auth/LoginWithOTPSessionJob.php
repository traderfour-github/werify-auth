<?php

namespace App\Jobs\Auth;

use App\Repositories\Contracts\ISessionRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Validation\UnauthorizedException;

class LoginWithOTPSessionJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $id, public string $hash, public string $otp, public Request $request)
    {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        /** @var ISessionRepository $sessionRepository */
        $sessionRepository = app()->make(ISessionRepository::class);
        $session = $sessionRepository->loginWithSession('otp', $this->id, $this->hash);
        if ($session) {
            if ($this->otp) {
                if ($session->otp == $this->otp) {
                    if ($session->application_id !== $this->request->application->id) {
                        throw new UnauthorizedException('app_key does not match!');
                    }
                    $user = $session->user;
                    $session->update(['claimed' => 1]);

                    return ['user' => $user, 'token' => dispatch_sync(new GenerateTokenJob('', '', [], $user))];
                }
            }
        }
        throw new UnauthorizedException();
    }
}
