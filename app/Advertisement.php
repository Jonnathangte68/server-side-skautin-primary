<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    protected $fillable = ['title', 'description', 'link', 'type', 'perc'];
    use SoftDeletes;
}
