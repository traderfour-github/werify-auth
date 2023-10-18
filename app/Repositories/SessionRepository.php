<?php

namespace App\Repositories;

use App\Models\Session;
use App\Models\User;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\ISessionRepository;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

/**
 * Class SessionRepository
 */
class SessionRepository extends BaseRepository implements ISessionRepository
{
    protected string $model = Session::class;

    /**
     * {@inheritDoc}
     */
    public function createSession(string $type): Session
    {
        return $this->getModel()->create(
            [
                'type' => $type,
                'hash' => Uuid::uuid4(),
            ]
        );
    }

    /**
     * {@inheritDoc}
     */
    public function createSessionForUser(string $type, User $user, string $otp, Request $request): Session
    {
        return $this->getModel()->create(
            [
                'type' => $type,
                'hash' => Uuid::uuid4(),
                'user_id' => $user->id,
                'otp' => $otp,
                'application_id' => $request->application->id,
            ]
        );
    }

    /**
     * {@inheritDoc}
     */
    public function loginWithSession(string $type, string $id, string $hash)
    {
        return $this->getModel()->where('type', $type)->where('id', $id)->where('hash', $hash)->where('claimed', 0)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function checkSession(string $type, string $id, string $hash)
    {
        return $this->getModel()->where('type', $type)->where('id', $id)->where('hash', $hash)->where('claimed', 1)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function getLatestUserSession(int $user_id)
    {
        return $this->getModel()->where('user_id', $user_id)->latest()->first();
    }
}
