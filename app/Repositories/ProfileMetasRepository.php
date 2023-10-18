<?php

namespace App\Repositories;

use App\Models\ProfileMeta;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\IProfileMetasRepository;

/**
 * Class ProfileMetasRepository
 */
class ProfileMetasRepository extends BaseRepository implements IProfileMetasRepository
{
    protected string $model = ProfileMeta::class;

    /**
     * {@inheritDoc}
     */
    public function getProfileMetasByUserId(int $user_id)
    {
        return $this->getModel()->whereUserId($user_id)->paginate();
    }

    /**
     * {@inheritDoc}
     */
    public function setProfileMetaByUserId(int $user_id, string $key, $value)
    {
        $this->getModel()->where('key', $key)->where('user_id', $user_id)->delete();

        return $this->getModel()->create(
            [
                'user_id' => $user_id,
                'key' => $key,
                'value' => $value,
            ]
        );
    }
}
