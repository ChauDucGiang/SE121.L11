<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements JWTSubject

{
    use Notifiable, SoftDeletes;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'roles'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $appends = [
        'RoleName', 'avatar', 'created'
    ];

    public function getAvatarAttribute()
    {
        if (empty($this->attributes['avatar'])) {
            return '/images/portrait/small/avatar_default.jpg';
        }
        return '/storage/' . $this->attributes['avatar'];
    }

    public function getCreatedAttribute()
    {
        return date("Y/m/d", strtotime($this->attributes['created_at']));
    }

    public function getRoleNameAttribute()
    {
        return ($this->attributes['roles'] == 1) ? 'Sales' : 'Manager';
    }


    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'user_id');
    }
}
