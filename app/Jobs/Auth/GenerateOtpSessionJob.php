<?php

namespace App\Jobs\Auth;

use App\Events\RequestOTPEvent;
use App\Models\Session;
use App\Models\User;
use App\Repositories\Contracts\ISessionRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateOtpSessionJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user, public Request $request)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): Session
    {
        /** @var ISessionRepository $sessionRepository */
        $sessionRepository = app()->make(ISessionRepository::class);
        $otp = rand(111111, 999999);
        $result = $sessionRepository->createSessionForUser('otp', $this->user, $otp, $this->request);
        if ($result) {
            event(new RequestOTPEvent($result));
        }
        return $result;
    }
}
