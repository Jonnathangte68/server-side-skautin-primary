<?php

namespace App\Http\Controllers\API;

use App\PendingConnection;
use App\Connection;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PendingInvitationController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $requests = PendingConnection::where('requested_id', $userId)->get();
        return json_encode($requests);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestorId = $request->user()->id;
        $requestedId = $request->input('requested_user_id');
        $rules = array(
            'requested_user_id'       => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        $validator->after(function ($validator) use ($requestorId, $requestedId) {
            if(PendingConnection::where([['requestor_id', $requestorId], ['requested_id', $requestedId]])->exists()) {
                $validator->errors()->add('error', 'invitation already sent');
            }
            if(PendingConnection::where([['requested_id', $requestorId], ['requestor_id', $requestedId]])->exists()) {
                $validator->errors()->add('error', 'invitation already sent');
            }
            if(Connection::where([['follower_id', $requestorId], ['following_id', $requestedId]])->exists()) {
                $validator->errors()->add('error', 'users already connected');
            }
            if(Connection::where([['following_id', $requestorId], ['follower_id', $requestedId]])->exists()) {
                $validator->errors()->add('error', 'users already connected');
            }
        });

        if ($validator->fails()) {
            // reject
            return response()->json(['status' => false, 'message' => 'Validation errors']);
        } else {
            $pc = new PendingConnection;
            $pc->requestor_id = $requestorId;
            $pc->requested_id = $requestedId;
            $pc->confirmed = false;
            if($pc->save()) {
                return response()->json(['status' => true, 'message' => 'invitation stored successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'unexpected error']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PendingConnection  $pendingConnection
     * @return \Illuminate\Http\Response
     */
    public function show(PendingConnection $pendingConnection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PendingConnection  $pendingConnection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $pendingConnection)
    {
        $requestedId = $request->user()->id;
        if(PendingConnection::where('id', $pendingConnection)->exists()) {
            $pc = PendingConnection::find($pendingConnection)->first();
            if($pc->requested_id !== $requestedId) {
                return response()->json(['status' => false, 'message' => 'unexpected error']);
            } 
            $connection = new Connection;
            $connection->follower_id  = $pc->requestor_id;
            $connection->following_id = $pc->requested_id;
            $connection->type = 'connections';
            // Destroy pending record
            $pc->delete();
            // Save connection
            if($connection->save()) {
                return response()->json(['status' => true, 'message' => 'connection has been added']);
            } else {
                return response()->json(['status' => false, 'message' => 'unexpected error']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'unexpected error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PendingConnection  $pendingConnection
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $pendingConnection)
    {
        $pc = PendingConnection::find($pendingConnection);
        return $pc->destroy(); 
    }
}
