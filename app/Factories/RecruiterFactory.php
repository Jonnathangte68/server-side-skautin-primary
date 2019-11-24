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


class RecruiterFactory implements RCreatorFactory
{
  public function createRecruiter(Array $input)
  {
        $utilities = new Util;
        // User
        $user = new User;
        $user->email = $input['email'];
        $user->password = bcrypt($input['password']);
        if (!$user->save()) {
            return false;
        }
        // Asset
        $asset = new Asset;
        $asset->isvideo = false;
        $asset->isimage = true;
        $asset->file_extension = 'png';
        $asset->length = 350;
        $asset->file_uri = "http://fake-path-uri";
        $asset->path = "C:/fake-path-uri";
        if (!$asset->save()) {
            return false;
        }
        // Address
        $address = new Address;
        $address->first_line = $utilities->getValueByArrayIndexOrReplace($input, 'first_line', NULL);
        $address->second_line = $utilities->getValueByArrayIndexOrReplace($input, 'second_line', NULL);
        $address->zip_code = $utilities->getValueByArrayIndexOrReplace($input, 'zip_code', 00000);
        $address->city_id = $input['city'];
        if (!$address->save()) {
            return false;
        }
        // Recruiter
        $recruiter = new Recruiter;
        $recruiter->name = $input['name'];
        $recruiter->user_id = $user->id;
        $recruiter->address_id = $address->id;
        $recruiter->profile_picture = $asset->id;
        if (!$recruiter->save()) {
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