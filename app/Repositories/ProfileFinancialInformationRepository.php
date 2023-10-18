<?php

namespace App\Repositories;

use App\Models\FinancialInformation;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\IProfileFinancialInformationRepository;

/**
 * Class ProfileFinancialInformationRepository
 */
class ProfileFinancialInformationRepository extends BaseRepository implements IProfileFinancialInformationRepository
{
    protected string $model = FinancialInformation::class;

    /**
     * {@inheritDoc}
     */
    public function createEmptyFinancialInformationForUser(int $user_id): bool
    {
        return $this->getModel()->create(
            [
                'user_id' => $user_id,
            ]
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getProfileFinancialInformationByUserId(int $user_id)
    {
        return $this->getModel()->whereUserId($user_id)->paginate();
    }
}
