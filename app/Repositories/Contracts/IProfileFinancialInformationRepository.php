<?php

namespace App\Repositories\Contracts;

interface IProfileFinancialInformationRepository
{
    /**
     * create an empty financial information for a user
     */
    public function createEmptyFinancialInformationForUser(int $user_id): bool;

    /**
     * get financial information for a user
     *
     *
     * @return bool
     */
    public function getProfileFinancialInformationByUserId(int $user_id);
}
