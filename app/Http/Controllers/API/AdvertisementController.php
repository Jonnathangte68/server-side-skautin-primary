<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Advertisement;
use App\StoreAsset;
use App\Utils\Util;
use Validator;
use Illuminate\Support\Facades\Input;

class AdvertisementController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all the adds and retrieve
        $adds = Advertisement::all();
        return response()->json($adds);
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
        $util = new Util;
        $rules = array(
            'title'       => 'required',
            'type'        => 'required',
        );
        $requestValues = $request->all();
        $validator = Validator::make($requestValues, $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors']);
        } else {
            if(!$util->getLinkRegEx($requestValues['link'])) {
                return response()->json(['status' => false, 'message' => 'Validation errors.']);
            }
            $advertisement             = new Advertisement;
            $assetCreator              = new StoreAsset($requestValues['asset']);
            $advertisement->fill($requestValues);
            $advertisement->asset_id   = $assetCreator->getId();
            if($advertisement->save()) {
                return response()->json(['status' => true, 'message' => 'Add has been registered']);
            } else {
                return response()->json(['status' => false, 'message' => 'Validation errors.']);
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
        // get the add and return it
        $add = Advertisement::find($id);
        return response()->json($add);
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
        $util = new Util;
        $rules = array(
            'title'       => 'required',
            'type'        => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors']);
        } else {
            if(!$util->getLinkRegEx($request->input['link'])) {
                return response()->json(['status' => false, 'message' => 'Validation errors.']);
            }
            $advertisement              = Advertisement::find($id);
            $assetCreator              = new StoreAsset($request->input['asset']);
            $advertisement->fill($request->all());
            $advertisement->asset_id    = $assetCreator->getId();
            if($advertisement->save()) {
                return response()->json(['status' => true, 'message' => 'Add has been registered']);
            } else {
                return response()->json(['status' => false, 'message' => 'Validation errors.']);
            }
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
        $add = Advertisement::find($id);
        $add->delete();
        return response()->json($add);
    }
}
