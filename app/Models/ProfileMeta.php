<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileMeta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'key', 'value'];

    protected $hidden = ['id', 'user_id'];
}
