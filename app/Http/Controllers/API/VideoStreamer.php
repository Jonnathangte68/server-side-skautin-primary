<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Asset;
use App\Streamer;

class VideoStreamer extends \App\Http\Controllers\Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        try {
            $asset = Asset::where('file_uri', $id)->first();
            $fileToStreamPath = getenv('VIDEO_STORAGE_ADDR') . $asset->path;
            $stream = new Streamer($fileToStreamPath);
            $stream->start();
        } catch(Exception $exception) {
            new Logger("Exception throw: " . $exception->getMessage());
        }
    }
}
