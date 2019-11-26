<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use App\Utils\Util;

class StoreAsset extends Model
{
    public $id;

    public function __construct(UploadedFile $file)
    {
        $utilities = new Util;
        $realPath = $file->store('profile_images');
        $asset = new Asset;
        $asset->isvideo = false;
        $asset->isimage = true;
        $asset->file_extension = $ext = pathinfo($realPath, PATHINFO_EXTENSION);
        $asset->length = $file->getSize();
        $asset->file_uri = $utilities->gen_uuid();
        $asset->path = $realPath;
        if($asset->save()) {
            $this->id = $asset->id;
        }
    }

    public function getId() {
        return $this->id;
    }
}
