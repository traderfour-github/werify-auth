<?php

namespace App\Repositories;

use App\Models\ProfileBadges;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\IProfileBadgesRepository;

/**
 * Class ProfileBadgesRepository
 */
class ProfileBadgesRepository extends BaseRepository implements IProfileBadgesRepository
{
    protected string $model = ProfileBadges::class;
}
