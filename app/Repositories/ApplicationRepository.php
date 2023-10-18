<?php

namespace App\Repositories;

use App\Models\Application;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\IApplicationRepository;

/**
 * Class LogRepository
 */
class ApplicationRepository extends BaseRepository implements IApplicationRepository
{
    /**
     * The model to be used by this repository
     */
    protected string $model = Application::class;

    /**
     * {@inheritDoc}
     */
    public function getApplicationByKey(string $key): Application|null
    {
        return $this->getModel()->where('key', $key)->first();
    }
}
