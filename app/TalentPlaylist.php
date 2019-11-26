<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TalentPlaylist extends Model
{
    public function talent() {
        return $this->belongsTo('App\Talent');
    }
}
