<?php

namespace App\Repositories\Contracts;

interface IProfileEducationRepository
{
    /**
     * get profile education by user id
     *
     * @param  int  $user_id;
     */
    public function getProfileEducationByUserId(int $user_id);

    /**
     * get profile education by user id
     *
     * @param  int  $user_id;
     */
    public function addProfileEducationByUserId(int $user_id);
}
