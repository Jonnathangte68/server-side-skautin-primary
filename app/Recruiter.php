<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruiter extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->hasOne('App\User');
    }

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

    public function connections()
    {
        return $this->hasManyThrough('App\Connection', 'App\User');
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

    // public function scopeEmail($query, $type)
    // {
    //     return $query->where('email', $email);
    // }

    // public function scopeCategory($query, $category)
    // {
    //     return $query->where('category', $category);
    // }

    // public function scopeSubcategory($query, $subcategory)
    // {
    //     return $query->where('subcategory', $subcategory);
    // }
}
