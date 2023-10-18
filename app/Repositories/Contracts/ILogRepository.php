<?php

namespace App\Repositories\Contracts;

use App\Models\Log;

interface ILogRepository
{
    /**
     * Create a log instance and persist it to the database using the provided data.
     *
     * @param  array  $data An associative array containing data to be stored in the log.
     * @return Log The newly created Log instance.
     */
    public function createLogFromRequest(array $data): Log;
}
