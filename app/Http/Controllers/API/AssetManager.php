<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;

use App\Asset;
use Illuminate\Support\Facades\Storage;
use File;
use App\Utils\Logger;

class AssetManager extends \App\Http\Controllers\Controller
{
    public function getImage($id) {
        $file = str_replace('profile_images/', '', $this->getStoredPath($id));
        return $this->serveImage($file);
    }

    public function downloadFile($id) {
        return Storage::download($this->getStoredPath($id));
    }

    protected function getStoredPath(String $file_uri) {
        $asset = Asset::where('file_uri', '=', $file_uri)->firstOrFail();
        return $asset->path;
    }

    protected function getImageRealUri(String $file_uri) {
        $asset = Asset::where('file_uri', '=', $file_uri)->firstOrFail();
        $url = Storage::url($asset->path);
        return $url;
    }

    protected function getFileSize(String $file_uri) {
        $asset = Asset::where('file_uri', '=', $file_uri)->firstOrFail();
        return Storage::size($asset->path);
    }

    protected function serveImage($file_name) {
        $file = '/Users/jonnathanguarate/workspace/api/storage/app/profile_images/' . $file_name;
        $type = 'image/jpeg';
        header('Content-Type:'.$type);
        header('Content-Length: ' . filesize($file));
        readfile($file);
    }
}
