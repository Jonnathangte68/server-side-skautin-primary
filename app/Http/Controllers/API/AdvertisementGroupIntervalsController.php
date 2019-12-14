<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\AdvertisementGroupInterval;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Utils\Logger;

class AdvertisementGroupIntervalsController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = AdvertisementGroupInterval::all();
        return json_encode(array('status' => true, 'message' => $all));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'start_time'       => 'required:date',
            'end_time'         => 'required:date',
            'advertisements'   => 'required:json'
        );
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors']);
        } else {
            if($this->verifyIntersections($data['start_time'], $data['end_time'])) {
                return response()->json(['status' => false, 'message' => 'Validation errors']);
            }
            $groupInterval                   = new AdvertisementGroupInterval;
            $groupInterval->start_time       = $data['start_time'];
            $groupInterval->end_time         = $data['end_time'];
            $groupInterval->advertisements   = $data['advertisements'];
            if($groupInterval->save()) {
                return response()->json(['status' => true, 'message' => 'Interval has been registered']);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function verifyIntersections(String $si, String $et) {
        $firstTimeParam = strtotime($si.':00');
        $lastTimeParam = strtotime($et.':00');
        foreach(AdvertisementGroupInterval::all() as $inteval) {
            $intervalStartTime = strtotime($inteval->start_time);
            $intervalEndTime = strtotime($inteval->end_time);
            if($firstTimeParam === $intervalStartTime && $lastTimeParam === $intervalEndTime) {
                return true;
            }
            if($intervalStartTime < $firstTimeParam && $intervalEndTime > $firstTimeParam) {
                return true;
            }
            if($intervalStartTime < $lastTimeParam && $intervalEndTime > $lastTimeParam) {
                return true;
            }
        }
        return false;
    }
}
