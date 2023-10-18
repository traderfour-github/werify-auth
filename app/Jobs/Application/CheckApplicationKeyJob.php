<?php

namespace App\Jobs\Application;

use App\Jobs\Auth\GetRequestApiKeyJob;
use App\Repositories\Contracts\IApplicationRepository;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\SyncJob;
use Illuminate\Validation\UnauthorizedException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckApplicationKeyJob extends SyncJob
{
    /**
     * Create a new job instance.
     */
    public function __construct(public Request $request)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $key = dispatch_sync(new GetRequestApiKeyJob());

        if ($key) {
            $applicationRepository = app()->make(IApplicationRepository::class);
            $app = $applicationRepository->getApplicationByKey($key);
            if ($app) {
                if (auth()->user()) {
                    $payload = JWTAuth::getPayload(JWTAuth::getToken());
                    $application_id = $payload->getClaims()->getByClaimName('application_id')->getValue();
                    if (! $application_id) {
                        throw new UnauthorizedException('api_key mismatch!');
                    }

                }
            }

            return $app;
        }
        throw new UnauthorizedException('api_key not set!');
    }
}
