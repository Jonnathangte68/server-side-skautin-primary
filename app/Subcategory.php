<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use SoftDeletes;

    public function talents()
    {
        return $this->belongsToMany('App\Talent')->using('App\SubcategoryTalent');
    }

    public function recruiters()
    {
        return $this->belongsToMany('App\Recruiter')->using('App\SubcategoryRecruiter');
    }

    public function category() 
    {
        return $this->belongsTo('App\Category');
    }
}
