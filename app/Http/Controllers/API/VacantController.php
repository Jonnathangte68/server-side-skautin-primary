<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Vacant;
use App\Recruiter;
use App\Requirement;
use Validator;
use Illuminate\Support\Facades\Input;

class VacantController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // get all the adds and retrieve
        $userId = $request->user()->id;
        $recruiter = Recruiter::where('user_id', $userId)->firstOrFail();
        $result = array();
        foreach($recruiter->vacants()->get() as $vacant) {
            $requirements = Requirement::where('vacant_id', $vacant->id)->get();
            $vacant['requirements'] = $requirements;
            array_push($result, $vacant);
        }
        return response()->json($result);
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
            'name'       => 'required',
            'city_id'    => 'required:digits'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            // reject
            return response()->json(['status' => false, 'message' => 'Validation errors']);
        } else {
            $userId = $request->user()->id;
            $recruiter = Recruiter::where('user_id', $userId)->firstOrFail();
            // store
            $vacant               = new Vacant;
            $vacant->name         = Input::get('name');
            $vacant->description  = Input::get('description');
            $vacant->city_id      = Input::get('city_id');
            $vacant->recruiter_id = $recruiter->id;
            if($vacant->save()) {
                foreach($request->input('requirements') as $requirement) {
                    $requirementObject                   = new Requirement;
                    $requirementObject->description      = $requirement;
                    $requirementObject->vacant_id        = $vacant->id;
                    $requirementObject->save();
                }
                return response()->json(['status' => true, 'message' => 'Vacant has been added']);
            } else {
                return response()->json(['status' => false, 'message' => 'Validation errors']);
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
            'name'       => 'required',
            'city_id'    => 'required:digits'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            // reject
            return response()->json(['status' => false, 'message' => 'Validation errors']);
        } else {
            $userId = $request->user()->id;
            $recruiter = Recruiter::where('user_id', $userId)->firstOrFail();
            $vacant = Vacant::findOrFail($id);
            if($vacant->recruiter_id !== $recruiter->id) {
                return response()->json(['status' => false, 'message' => 'Validation errors']);
            }
            $vacant->name         = Input::get('name');
            $vacant->description  = Input::get('description');
            $vacant->city_id      = Input::get('city_id');
            if($vacant->save()) {
                Requirement::where('vacant_id', $id)->delete();
                foreach($request->input('requirements') as $requirement) {
                    $requirementObject                   = new Requirement;
                    $requirementObject->description      = $requirement;
                    $requirementObject->vacant_id        = $id;
                    $requirementObject->save();
                }
                return response()->json(['status' => true, 'message' => 'Vacant has been updated!']);
            } else {
                return response()->json(['status' => false, 'message' => 'Validation errors']);
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
        $vacant = Vacant::find($id);
        $vacant->delete();
        return response()->json($vacant);
    }
}
