<?php

namespace App\Http\Controllers\API;

use App\FavoriteFolder;
use App\Asset;
use App\Utils\Util;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavoriteFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all the favorite folders and retrieve
        $userId = $request->user()->id;
        if(!$userId) {
            return response()->json(array('status' => false, 'error user is not present'));
        }
        $favoriteFolders = FavoriteFolder::where('user_id', $userId)->get();
        return response()->json($favoriteFolders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $utils = new Util;
        $assets = $utils->parseStringToArray($request->input('assets'));
        $name = $request->input('name');
        $userId = $request->user()->id;
        if(!FavoriteFolder::where([['name', $name], ['user_id', $userId]])->exists()) {
            if(!$name) {
                return response()->json(array('status' => false, 'message' => 'name cannot be empty'));
            }
            $newAssets = array();
            if($assets) {
                foreach($assets as $asset_id) {
                    $asset = Asset::find($asset_id);
                    array_push($newAssets, $asset);
                }
            }
            $favoriteFolder = new FavoriteFolder;
            $favoriteFolder->name = $name;
            $favoriteFolder->user_id = $userId;
            if($favoriteFolder->save()) {
                $favoriteFolder->assets()->saveMany($newAssets);
                return response()->json(array('status' => true, 'message' => 'folder saved successfully')); 
            }
        } 
        return response()->json(array('status' => false, 'message' => 'folder already exists'));
    }

    /**
     * Get folder with all of its videos.
     *
     * @param  \App\FavoriteFolder  $favoriteFolder
     * @return \Illuminate\Http\Response
     */
    public function show(FavoriteFolder $favoriteFolder)
    {
        // Get folder with all of its videos.
    }

    /**
     * Add new asset to existing folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FavoriteFolder  $favoriteFolder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $favoriteFolder)
    {
        $userId = $request->user()->id;
        $asset_id = $request->input('asset_id');
        $asset = Asset::find($asset_id);
        if(!FavoriteFolder::where([['id', $favoriteFolder], ['user_id', $userId]])->exists()) {
            return response()->json(array('status' => false, 'message' => 'folder does not exists'));
        }
        if(!$favoriteFolder) {
            return response()->json(array('status' => false, 'message' => 'folder does not exists'));
        }
        if(!$asset) {
            return response()->json(array('status' => false, 'message' => 'please send asset id'));
        }
        $favoriteFolder = FavoriteFolder::where([['id', $favoriteFolder], ['user_id', $userId]])->first();
        $favoriteFolder->assets()->attach($asset);
        if($favoriteFolder->save()) {
            return response()->json(array('status' => true, 'message' => 'asset has been added to folder!'));
        } else {
            return response()->json(array('status' => false, 'message' => 'unexpected error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FavoriteFolder  $favoriteFolder
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $favoriteFolder)
    {
        $favoriteFolder = FavoriteFolder::where('id', $favoriteFolder)->firstOrFail();
        $favoriteFolder->delete();
    }
}
