<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebsitePageContent extends Model
{
    use SoftDeletes;

    protected $table = 'website_page_content';
}