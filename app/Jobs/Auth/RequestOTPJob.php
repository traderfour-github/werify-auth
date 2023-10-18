<?php

namespace App\Jobs\Auth;

use App\Repositories\Contracts\IUserRepository;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\SyncJob;

class RequestOTPJob extends SyncJob
{
    public IUserRepository $userRepository;

    /**
     * Create a new job instance.
     */
    public function __construct(public Request $request)
    {
        $this->userRepository = app()->make(IUserRepository::class);
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $identifier = $this->request->identifier;

        $user = $this->userRepository->findOrCreateUserWithEmail($identifier);

        $result = dispatch_sync(new GenerateOtpSessionJob($user, $this->request));
		$response = $result->toArray();
		if ($result->user->identifier == 'sandbox@werify.net')
		{
			$response[ 'otp' ] = $result->otp;
		}
		return $response;
    }
}
