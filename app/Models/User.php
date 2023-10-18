<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Uuid;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
    = [
        'name',
        'identifier',
        'password',
        'username',
        'uuid',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden
    = [
        'id',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts
    = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['profile', 'profileBadges', 'profileNumbers', 'profileEducation', 'financialInformation', 'profileMetas'];

    protected $appends = ['ulid'];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function financialInformation()
    {
        return $this->hasOne(FinancialInformation::class, 'user_id', 'id');
    }

    public function profileBadges()
    {
        return $this->hasMany(ProfileBadges::class, 'user_id', 'id');
    }

    public function profileNumbers()
    {
        return $this->hasMany(ProfileMobileNumbers::class, 'user_id', 'id');
    }

    public function profileEducation()
    {
        return $this->hasMany(ProfileEducation::class, 'user_id', 'id');
    }

    public function profileMetas()
    {
        return $this->hasMany(ProfileMeta::class, 'user_id', 'id');
    }

    public function getEmailAttribute()
    {
        return $this->identifier;
    }

    public function getuuidAttribute()
    {
        $current = $this->getRawOriginal('uuid');
        if (! $current) {
            $this->update(['uuid' => Uuid::uuid6()]);

            return $this->uuid;
        }

        return $current;
    }

    public function getulidAttribute()
    {
        $app_id = app()->request->application->id;

        return $app_id.$this->id;
    }
}
