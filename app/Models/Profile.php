<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $hidden = ['id', 'user_id', 'created_at'];

    protected $fillable = ['first_name', 'middle_name', 'last_name', 'mobile_number', 'avatar', 'cover', 'is_private', 'language', 'currency', 'timezone', 'calendar', 'shortcuts', 'layout', 'latitude', 'longitude', 'user_id'];

    public function getFullnameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }
}
