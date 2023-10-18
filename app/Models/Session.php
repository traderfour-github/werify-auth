<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = ['type', 'claimed', 'user_id', 'hash', 'otp', 'application_id'];

    protected $hidden = ['updated_at', 'claimed', 'user_id', 'otp', 'application_id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
