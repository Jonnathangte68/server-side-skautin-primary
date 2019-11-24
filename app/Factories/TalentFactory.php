<?php

namespace App\Factories;

use App\Interfaces\CreatorFactory;
use App\Utils\Logger;
use App\Utils\Util;
use App\User;
use App\Address;
use App\Talent;


class TalentFactory implements CreatorFactory
{
  public function createTalent(Array $input)
  {
    new Logger('Factory talent started!');
    $utilities = new Util;
    $user = new User;
    $user->email = $input['email'];
    $user->password = bcrypt($input['password']);
    if (!$user->save()) {
        return false;
    }
    $address = new Address;
    $address->first_line = $utilities->getValueByArrayIndexOrReplace($input, 'first_line', NULL); // Not required
    $address->second_line = $utilities->getValueByArrayIndexOrReplace($input, 'second_line', NULL); // Not required
    $address->zip_code = $utilities->getValueByArrayIndexOrReplace($input, 'zip_code', 00000); // Not required;
    $address->city_id = $input['city'];
    if (!$address->save()) {
        return false;
    }
    $talent = new Talent;
    $talent->name = $input['name'];
    $talent->title = $input['title'];
    $talent->birth_year = $input['birth_year'];
    $talent->gender = $input['gender'];
    $talent->profile_image = $input['profile_image'];
    $talent->user_id = $user->id;
    $talent->address_id = $address->id;
    if (!$talent->save()) {
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