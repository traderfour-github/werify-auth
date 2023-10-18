<?php

namespace App\Jobs\Auth;

use App\Models\Session;
use App\Repositories\Contracts\ISessionRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateQrSessionJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
    public function handle(): Session
    {
        /** @var ISessionRepository $sessionRepository */
        $sessionRepository = app()->make(ISessionRepository::class);

        return $sessionRepository->createSession('qr');
    }
}
