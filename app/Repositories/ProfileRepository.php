<?php

namespace App\Repositories;

use App\Models\Profile;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\IProfileRepository;

/**
 * Class ProfileRepository
 */
class ProfileRepository extends BaseRepository implements IProfileRepository
{
    protected string $model = Profile::class;

    /**
     * {@inheritDoc}
     */
    public function createEmptyProfileForUser(int $user_id)
    {
        return $this->getModel()->create(
            [
                'user_id' => $user_id,
            ]
        );
    }
}
