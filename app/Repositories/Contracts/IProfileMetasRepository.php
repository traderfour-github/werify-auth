<?php

namespace App\Repositories\Contracts;

interface IProfileMetasRepository
{
    /**
     * get profile metas by user id
     *
     * @param  int  $user_id User Id.
     */
    public function getProfileMetasByUserId(int $user_id);

    /**
     * set profile meta key by user id,key and value
     *
     * @param  int  $user_id User Id.
     * @param  string  $key     Key.
     * @param  string  $value   value.
     */
    public function setProfileMetaByUserId(int $user_id, string $key, $value);
}
