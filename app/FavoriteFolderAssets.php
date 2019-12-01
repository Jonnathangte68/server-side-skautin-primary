<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FavoriteFolderAssets extends Pivot
{
    protected $table = 'asset_favorite_folder';
}
