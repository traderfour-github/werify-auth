<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileBadges extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = ['id', 'updated_at', 'user_id', 'deleted_at'];
}
