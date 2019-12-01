<?php

namespace App\Factories;

use App\Interfaces\RCreatorFactory;
use App\Utils\Logger;
use App\Utils\Util;
use App\User;
use App\Organization;
use App\Asset;
use App\Address;
use App\Recruiter;
use App\StoreAsset;


class RecruiterFactory implements RCreatorFactory
{
  public function createRecruiter(Array $input)
  {
        $utilities = new Util;
        // User
        $user = new User;
        $user->email = $input['email'];
        $user->password = bcrypt($input['password']);
        try {
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
        // Address
        $address = new Address;
        $address->first_line = $utilities->getValueByArrayIndexOrReplace($input, 'first_line', NULL);
        $address->second_line = $utilities->getValueByArrayIndexOrReplace($input, 'second_line', NULL);
        $address->zip_code = $utilities->getValueByArrayIndexOrReplace($input, 'zip_code', 00000);
        $address->city_id = $input['city'];
        try {
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
        // Recruiter
        $recruiter = new Recruiter;
        $recruiter->name = $input['name'];
        $recruiter->user_id = $user->id;
        $recruiter->address_id = $address->id;
        $assetCreator = new StoreAsset($input['profile_picture']);
        $recruiter->profile_picture = $assetCreator->getId();
        try {
            if (!$recruiter->save()) {
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
            if(!empty($recruiter)) {
                $recruiter->forceDelete();
            }
            return false;
        }
        $categories = $utilities->parseStringToArray($input['categories']);
        foreach ($categories as $category) {
            $recruiter->categories()->attach($category);
        }
        $subCategories = $utilities->parseStringToArray($input['subcategories']);
        foreach ($subCategories as $subCategory) {
            $recruiter->subcategories()->attach($subCategory);
        }
        // Organization
        if(array_key_exists('organization_name', $input)) {
            $org = new Organization;
            $org->name = $input['organization_name'];
            $org->website = $utilities->getValueByArrayIndexOrReplace($input, 'website', NULL);
            $org->phone_number = $utilities->getValueByArrayIndexOrReplace($input, 'phone_number', NULL);
            $org->recruiter_id = $recruiter->id;
            $org->save();
        }
        return true;
  }
}