<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Talent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'title', 'birth_year', 'gender',
        'profile_image'
    ];

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category')->using('App\CategoryTalent', 'category_id', 'talent_id');
    }

    public function subcategories()
    {
        return $this->belongsToMany('App\Subcategory')->using('App\SubcategoryTalent', 'subcategory_id', 'talent_id');
    }

    public function profile_picture() {
        return $this->hasOne('App\Asset');
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function talent_playlist()
    {
        return $this->hasOne('App\TalentPlaylists');
    }

    public function connections()
    {
        return $this->hasManyThrough('App\Connection', 'App\User');
    }
}
