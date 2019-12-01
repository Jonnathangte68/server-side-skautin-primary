<?php

namespace App\DataMap;

use App\Utils\Logger;
use App\Recruiter;
use App\Address;
use App\Asset;
use App\City;
use App\State;
use App\Country;

class RecruiterDataMap
{
    public function getInfo(Recruiter $recruiter) {
        $asset = Asset::where('id', $recruiter->profile_picture)->first();
        $address = Address::where('id', $recruiter->address_id)->first();
        if($address->first_line) {
            $fullAddress[0] = $address->first_line;
        }
        if($address->second_line) {
            $fullAddress[1] = $address->second_line;
        }
        if($address->zip_code) {
            $fullAddress[2] = $address->zip_code;
        }
        if($address->city_id) {
            $city = City::find($address->city_id)->first();
            $state = State::find($city->state->id)->first();
            $country = Country::find($state->country->id)->first();
            $fullAddress[3] = $city->name;
            $fullAddress[4] = $state->name;
            $fullAddress[5] = $country->name;
        }
        $fullAddress = implode(", ", $fullAddress);
        $objectResponse['name'] = $recruiter->name;
        $objectResponse['categories'] = $recruiter->categories()->select('name')->get();
        $objectResponse['subcategories'] = $recruiter->subcategories()->select('name')->get();
        $objectResponse['profile_picture'] = $asset->file_uri;
        $objectResponse['address'] = $fullAddress;
        return $objectResponse;
    }
}