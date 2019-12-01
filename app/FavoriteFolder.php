<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FavoriteFolder extends Model
{
    protected $table = 'favorite_folders';

    use SoftDeletes;

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function assets()
    {
        return $this->belongsToMany('App\Asset', 'asset_favorite_folder');
    }
}
