<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requirement extends Model
{
    use SoftDeletes;

    public function vacant() {
        return $this->belongsTo('App\Vacant');
    }
}
