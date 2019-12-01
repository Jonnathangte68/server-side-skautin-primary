<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
      'email', 'password',
    ];
    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
      'password', 'remember_token',
    ];

    public function talent()
    {
        return $this->belongsTo('App\Talent');
    }

    public function recruiter()
    {
        return $this->belongsTo('App\Recruiter');
    }

    public function connections()
    {
        return $this->hasMany('App\Connection', 'follower_id', 'id');
    }

    public function scopeEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    public function favoritefolders() {
        return $this->belongsTo('App\FavoriteFolder');
    }
}