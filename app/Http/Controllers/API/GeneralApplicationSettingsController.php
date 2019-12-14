<?php

namespace App\Http\Controllers\api;

use App\GeneralApplicationSettings;
use Illuminate\Http\Request;

class GeneralApplicationSettingsController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settingsModel = GeneralApplicationSettings::find(1);
        if(!$settingsModel) {
            return json_encode(array('status' => false, 'message' => GeneralApplicationSettings::find(1)));
        }
        return json_encode(array('status' => true, 'message' => GeneralApplicationSettings::find(1)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GeneralApplicationSettings  $generalApplicationSettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GeneralApplicationSettings $generalApplicationSettings)
    {
        $settingsModel = GeneralApplicationSettings::find(1);
        if(!$settingsModel) {
            // No settings yet, create first.
            $data = $request->all();
            $settingsModel = new GeneralApplicationSettings($data);
            if($settingsModel->save()) {
                return json_encode(array('status' => true, 'message' => 'Settings updated succesfully'));
            }
        }
        $data = $request->all();
        $settingsModel->fill($data);
        if($settingsModel->save()) {
            return json_encode(array('status' => true, 'message' => 'Settings updated succesfully'));
        }
        return json_encode(array('status' => false, 'message' => 'Error updating model.'));
        // Update settings only object.

    }
}
