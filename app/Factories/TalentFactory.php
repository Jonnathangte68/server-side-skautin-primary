<?php

namespace App\Factories;

use App\Interfaces\CreatorFactory;
use App\Utils\Util;
use App\User;
use App\Address;
use App\Talent;
use App\StoreAsset;


class TalentFactory implements CreatorFactory
{
  public function createTalent(Array $input)
  {
    $utilities = new Util;
    $user = new User;
    $user->email = $input['email'];
    $user->password = bcrypt($input['password']);
    try{
        if (!$user->save()) {
            return false;
        }
    } catch(\Illuminate\Database\QueryException $ex) {
        report($ex);
        if(!empty($user)) {
            $user->forceDelete();
        }
        return false;
    }
    $address = new Address;
    $address->first_line = $utilities->getValueByArrayIndexOrReplace($input, 'first_line', NULL); // Not required
    $address->second_line = $utilities->getValueByArrayIndexOrReplace($input, 'second_line', NULL); // Not required
    $address->zip_code = $utilities->getValueByArrayIndexOrReplace($input, 'zip_code', 00000); // Not required;
    $address->city_id = $input['city'];
    try{
        if (!$address->save()) {
            return false;
        }
    } catch(\Illuminate\Database\QueryException $ex) {
        report($ex);
        if(!empty($user)) {
            $user->forceDelete();
        }
        if(!empty($address)) {
            $address->forceDelete();
        }
        return false;
    }
    $assetCreator = new StoreAsset($input['profile_picture']);
    $assetId = $assetCreator->getId();
    $talent = new Talent;
    $talent->name = $input['name'];
    $talent->title = $input['title'];
    $talent->birth_year = $input['birth_year'];
    $talent->gender = $input['gender'];
    $talent->user_id = $user->id;
    $talent->profile_picture = $assetId;
    $talent->address_id = $address->id;
    try {
        if (!$talent->save()) {
            return false;
        }
    } catch(\Illuminate\Database\QueryException $ex) {
        report($ex);
        if(!empty($user)) {
            $user->forceDelete();
        }
        if(!empty($address)) {
            $address->forceDelete();
        }
        if(!empty($talent)) {
            $talent->forceDelete();
        }
        return false;
    }
    $categories = $utilities->parseStringToArray($input['categories']);
    foreach ($categories as $category) {
        $talent->categories()->attach($category);
    }
    $subCategories = $utilities->parseStringToArray($input['subcategories']);
    foreach ($subCategories as $subCategory) {
        $talent->subcategories()->attach($subCategory);
    }
    return true;
  }
}