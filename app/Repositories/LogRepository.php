<?php

namespace App\Repositories;

use App\Models\Log;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\ILogRepository;

/**
 * Class LogRepository
 */
class LogRepository extends BaseRepository implements ILogRepository
{
    /**
     * The model to be used by this repository
     */
    protected string $model = Log::class;

    /**
     * {@inheritDoc}
     */
    public function createLogFromRequest(array $data): Log
    {
        return $this->getModel()->create($data);
    }
}
