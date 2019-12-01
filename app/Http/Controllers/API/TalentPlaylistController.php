<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Talent;
use App\TalentPlaylists;
use App\Asset;
use App\CreateTalentPlaylist;
use App\StoreAssetOnPlaylist;
use Validator;
use Illuminate\Support\Facades\Input;

class TalentPlaylistController extends \App\Http\Controllers\Controller
{

    /**
     * Display a listing of the resource for specific talent
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Not implemented for this class.
        return true;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // No GUI available
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'talent_id'       => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            // reject
            return response()->json(['status' => false, 'message' => 'Validation errors']);
        } else {

            $talent = Talent::findOrFail($request->input('talent_id'));
            if($talent->talent_playlist()->exists()) {
                // Do not create a new playlist just add a new asset.
                $input = $request->all();
                foreach($input['assets'] as $asset) {
                    $assetCreator = new StoreAssetOnPlaylist($asset, $talent->talent_playlist->id);
                }
                return response()->json(['status' => true, 'message' => 'New assets has been added to playlist']);
            } else {
                $instance = new CreateTalentPlaylist;
                if ($instance->store($request->all())) {
                    return response()->json(['status' => true, 'message' => 'Playlist has been registered']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Validation errors']);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $talent = Talent::findOrFail($id);
        $playlistId = $talent->talent_playlist->id;
        $assetList = Asset::where('talent_playlists_id', $playlistId)
               ->orderBy('created_at')
               ->get();
        $response = array(
            'playlist_id' => $playlistId, 
            'talent_id' => $talent->talent_playlist->talent_id, 
            'assets' => $assetList, 
            'created_at' => $talent->talent_playlist->created_at, 
            'updated_at' => $talent->talent_playlist->updated_at
        );
        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // No GUI available
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Not implemented for this route.
        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = TalentPlaylists::find($id);
        $subcategory->delete();
        return response()->json($subcategory);
    }
}
