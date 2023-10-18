<?php

namespace App\Repositories\Contracts;

use App\Models\Application;

interface IApplicationRepository
{
    /**
     * get application by application key
     */
    public function getApplicationByKey(string $key): Application|null;
}
