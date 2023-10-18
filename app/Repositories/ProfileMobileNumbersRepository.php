<?php

namespace App\Repositories;

use App\Models\ProfileMobileNumbers;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\IProfileMobileNumbersRepository;

/**
 * Class ProfileMobileNumbersRepository
 */
class ProfileMobileNumbersRepository extends BaseRepository implements IProfileMobileNumbersRepository
{
    protected string $model = ProfileMobileNumbers::class;

    /**
     * {@inheritDoc}
     */
    public function getMobileNumbersByUserId(int $user_id)
    {
        return $this->getModel()->where('user_id', $user_id)->paginate();
    }

    /**
     * {@inheritDoc}
     */
    public function addMobileNumberToUser(int $user_id, string $mobile_number)
    {
        return $this->getModel()->create(
            [
                'user_id' => $user_id,
                'mobile_number' => $mobile_number,
            ]
        );
    }
}
