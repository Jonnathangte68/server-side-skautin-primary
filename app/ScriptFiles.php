<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScriptFile extends Model
{
    use SoftDeletes;
    
    protected $table = 'script_files';

    protected $fillable = ['file_name', 'webpage', 'content', 'min_content'];
}
