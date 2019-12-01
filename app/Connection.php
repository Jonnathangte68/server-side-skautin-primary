<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Connection extends Model
{
    use SoftDeletes;
    
    public function user()
    {
        return $this->belongsTo('App\User', 'follower_id', 'id');
    }
}
