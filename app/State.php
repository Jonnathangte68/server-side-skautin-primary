<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use SoftDeletes;

    public function city()
    {
        return $this->hasOne('App\City');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }
}
