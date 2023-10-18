<?php

namespace App\Repositories\Contracts;

interface IProfileMobileNumbersRepository
{
    /**
     * get mobile numbers by user id
     */
    public function getMobileNumbersByUserId(int $user_id);

    /**
     * add a mobile number to user
     */
    public function addMobileNumberToUser(int $user_id, string $mobile_number);
}
