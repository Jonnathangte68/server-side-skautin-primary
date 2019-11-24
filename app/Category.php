<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public function talents()
    {
        return $this->belongsToMany('App\Talent')->using('App\CategoryTalent');
    }

    public function recruiters()
    {
        return $this->belongsToMany('App\Recruiter')->using('App\CategoryRecruiter');
    }

    public function subcategories() 
    {
        return $this->hasMany('App\Subcategory');
    }
}
