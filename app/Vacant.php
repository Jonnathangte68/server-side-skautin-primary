<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacant extends Model
{
    use SoftDeletes;

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSubcategory($query, $subcategory)
    {
        return $query->where('subcategory', $subcategory);
    }
}
