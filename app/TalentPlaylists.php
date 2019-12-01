<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TalentPlaylists extends Model
{
    protected $table = "talent_playlists";

    public function talent() {
        return $this->belongsTo('App\Talent');
    }

    public function asset() {
        return $this->hasMany('App\Asset');
    }
}
