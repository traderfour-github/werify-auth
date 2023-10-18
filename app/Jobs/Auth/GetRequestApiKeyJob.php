<?php

namespace App\Jobs\Auth;

use Illuminate\Queue\Jobs\SyncJob;

class GetRequestApiKeyJob extends SyncJob
{
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $request = app()->request;

        return $request->query('api-key') ?? $request->header('api-key');
    }
}
