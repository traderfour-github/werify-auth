<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileMobileNumbers extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'mobile_number'];

    protected $hidden = ['id', 'user_id', 'updated_at', 'deleted_at'];
}
