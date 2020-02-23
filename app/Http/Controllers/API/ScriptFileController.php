<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Utils\Logger;
use Validator;
use App\ScriptFile;

class ScriptFileController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $scriptFile = ScriptFile::all();
        return response()->json($scriptFile);
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
        $rules = array(
            'file_name'       => 'required|unique:script_files,file_name',
            'webpage'         => 'required'
        );
        $requestValues = $request->all();
        $validator = Validator::make($requestValues, $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors']);
        } else {
            $scriptFile             = new ScriptFile;
            $scriptFile->fill($requestValues);
            if($scriptFile->save()) {
                return response()->json(['status' => true, 'message' => 'New script has been registered']);
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
        $scriptFile = ScriptFile::where('file_name', '=', $id)->firstOrFail();
        return response()->json($scriptFile);
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
        $scriptFile = ScriptFile::where('file_name', '=', $id)->firstOrFail();
        $rules = array(
            'content'        => 'required',
        );
        $requestValues = $request->all();
        $validator = Validator::make($requestValues, $rules);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors']);
        } else {
            $scriptFile->content = json_encode($requestValues['content']);
            $scriptFile->min_content = json_encode($requestValues['min_content']);
            if($scriptFile->save()) {
                return response()->json(['status' => true, 'message' => 'New script has been registered']);
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
        $scriptFile = ScriptFile::where('file_name', '=', $id)->firstOrFail();
        $scriptFile->delete();
        return response()->json($scriptFile);
    }
}
