<?php

namespace App\Repositories\Contracts;

use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;

interface ISessionRepository
{
    /**
     * create new login session
     */
    public function createSession(string $type): Session;

    /**
     * create new login session for user
     */
    public function createSessionForUser(string $type, User $user, string $otp, Request $request): Session;

    /**
     * check login session
     *
     *
     * @return mixed
     */
    public function loginWithSession(string $type, string $id, string $hash);

    /**
     * check session
     *
     *
     * @return mixed
     */
    public function checkSession(string $type, string $id, string $hash);

    /**
     * get latest user session
     *
     *
     * @return mixed
     */
    public function getLatestUserSession(int $user_id);
}
