<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruiter extends Model
{
    use SoftDeletes;

    public function organization() {
        return $this->hasOne('App\Organization');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category')->using('App\CategoryRecruiter', 'category_id', 'recruiter_id');
    }

    public function subcategories()
    {
        return $this->belongsToMany('App\Subcategory')->using('App\SubcategoryRecruiter', 'subcategory_id', 'recruiter_id');
    }

    public function profile_picture() {
        return $this->belongsTo('App\Asset');
    }
}
