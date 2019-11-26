<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Vacant;
use Validator;
use Illuminate\Support\Facades\Input;

class VacantController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all the adds and retrieve
        $vacants = Vacant::all();
        return response()->json($vacants);
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
            $vacant               = new Vacant;
            $vacant->name         = Input::get('name');
            $vacant->description  = Input::get('description');
            $vacant->city_id      = Input::get('city_id');
            $vacant->recruiter_id = Input::get('recruiter_id');
            $vacant->save();
            return response()->json(['status' => true, 'message' => 'Job has been registered']);
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
        $vacant = Vacant::find($id);
        return response()->json($vacant);
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
            $vacant             = Vacant::find($id);
            $vacant->name       = Input::get('name');
            $vacant->save();
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
        $vacant = Vacant::find($id);
        $vacant->delete();
        return response()->json($vacant);
    }
}
