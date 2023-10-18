<?php

namespace App\Jobs\Log;

use App\Repositories\Contracts\ILogRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class StoreLogJob
 *
 * This class represents a job that stores log data in the database.
 */
class StoreLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The data to be stored in the log.
     */
    public array $data;

    /**
     * Create a new job instance.
     *
     * @param  array  $data The data to be stored in the log.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @throws BindingResolutionException
     */
    public function handle(): void
    {
        /**
         * Get an instance of the log repository using Laravel's service container.
         *
         * @var ILogRepository $logRepository
         */
        $logRepository = app()->make(ILogRepository::class);

        // Store the log data in the database.
        $logRepository->createLogFromRequest($this->data);
    }
}
