<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    public function recruiter() {
        return $this->belongsTo('App\Recruiter');
    }
}
