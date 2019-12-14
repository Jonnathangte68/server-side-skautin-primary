<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Talent;
use App\Recruiter;
use App\Address;
use App\Utils\Logger;
use App\Utils\StandardResponse;
use Validator;
use Illuminate\Support\Facades\Input;

class AddressController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $recruiter = Recruiter::where('user_id', $userId)->first();
        if($recruiter) {
            $address = Address::where('id', $recruiter->address_id)->first();
            return response()->json(array(
                    'status' => true, 
                    'message' => $address
                )
            );
        }
        $talent = Talent::where('user_id', $userId)->first();
        if($talent) {
            $address = Address::where('id', $talent->address_id)->first();
            return response()->json(array(
                'status' => true, 
                'message' => $address
            )
        );
        }
        return response()->json(array(
            'status' => false, 
            'message' => 'No address.'
        ));
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
        // Route not implemented address are created though another models.
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recruiter = Recruiter::where('user_id', $id)->first();
        if($recruiter) {
            $address = Address::where('id', $recruiter->address_id)->first();
            return response()->json(array(
                    'status' => true, 
                    'message' => $address
                )
            );
        }
        $talent = Talent::where('user_id', $id)->first();
        if($talent) {
            $address = Address::where('id', $talent->address_id)->first();
            return response()->json(array(
                'status' => true, 
                'message' => $address
                )
            );
        }
        return response()->json(array(
            'status' => false, 
            'message' => 'Sorry, no address.'
        ));
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
            'city_id'       => 'required:digits'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            // reject
            return response()->json(['status' => false, 'message' => 'Validation errors']);
        } else {
            // store
            $address                   = Address::findOrFail($id);
            $address->first_line       = Input::get('first_line');
            $address->second_line      = Input::get('second_line');
            $address->zip_code         = Input::get('zip_code');
            $address->city_id          = Input::get('city_id');
            $address->save();
            return response()->json(['status' => true, 'message' => 'Address has been registered']);
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
        $address = Address::find($id);
        $address->delete();
        return response()->json($address);
    }
}
