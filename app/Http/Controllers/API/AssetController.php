<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Asset;
use Validator;
use Illuminate\Support\Facades\Input;

class AssetController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all the adds and retrieve
        $assets = Asset::all();
        return response()->json($assets);
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
            'name'       => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            // reject
            return response()->json(['status' => false, 'message' => 'Validation errors']);
        } else {
            // store
            $asset             = new Asset;
            $asset->name       = Input::get('name');
            $asset->save();
            return response()->json(['status' => true, 'message' => 'Country has been registered']);
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
        // get the add and return it
        $asset = Asset::find($id);
        return response()->json($asset);
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
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            // reject
            return response()->json(['status' => false, 'message' => 'Validation errors']);
        } else {
            // store
            $asset             = Asset::find($id);
            $asset->name       = Input::get('name');
            $asset->save();
            return response()->json(['status' => true, 'message' => 'Country has been registered']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asset = Asset::find($id);
        $asset->delete();
        return response()->json($asset);
    }
}
