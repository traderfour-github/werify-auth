<?php

namespace App\Repositories;

use App\Models\ProfileEducation;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\IProfileEducationRepository;

/**
 * Class ProfileEducationRepository
 */
class ProfileEducationRepository extends BaseRepository implements IProfileEducationRepository
{
    protected string $model = ProfileEducation::class;

    /**
     * {@inheritDoc}
     */
    public function getProfileEducationByUserId(int $user_id)
    {
        return $this->getModel()->where('user_id', $user_id)->paginate();
    }

    public function addProfileEducationByUserId(int $user_id)
    {
    }
}
