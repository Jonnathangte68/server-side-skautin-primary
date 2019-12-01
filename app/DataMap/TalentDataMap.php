<?php

namespace App\DataMap;

use App\Talent;
use App\Address;
use App\Asset;
use App\City;
use App\State;
use App\Country;

class TalentDataMap
{
    public function getInfo(Talent $talent) {
        $asset = Asset::where('id', $talent->profile_picture)->first();
        $address = Address::where('id', $talent->address_id)->first();
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
        $objectResponse['name'] = $talent->name;
        $objectResponse['categories'] = $talent->categories()->select('name')->get();
        $objectResponse['subcategories'] = $talent->subcategories()->select('name')->get();
        $objectResponse['profile_picture'] = $asset->file_uri;
        $objectResponse['birth_year'] = $talent->birth_year;
        $objectResponse['gender'] = $talent->gender;
        $objectResponse['address'] = $fullAddress;
        return $objectResponse;
    }
}