<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use SoftDeletes;

    public function talent() {
        return $this->belongsTo('App\Talent');
    }

    public function talent_playlists() {
        return $this->belongsTo('App\TalentPlaylists');
    }
}
