<?php

namespace App\Repositories\Contracts;

interface IProfileRepository
{
    /**
     * create an empty profile for a user
     *
     *
     * @return Profile
     */
    public function createEmptyProfileForUser(int $user_id);
}
