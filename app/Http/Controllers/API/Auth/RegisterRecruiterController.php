<?php

namespace App\Http\Controllers\api\Auth;

use Illuminate\Http\Request;
use App\Certification;
use App\Utils\Util;
use App\CreateRecruiterUser;
use Validator;
use Illuminate\Support\Facades\Input;
use App\CustomValidators\CategoryExistsBySubcategory;

class RegisterRecruiterController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
            'name'       => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        $validator->after(function ($validator) {
            if(!$this->validateCustomFields(Input::all())) {
                $validator->errors()->add('error', 'custom fields validation error!');
            }
        });

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors']);
        } else {
            $instance = new CreateRecruiterUser;
            if ($instance->store($request->all())) {
                return response()->json(['status' => true, 'message' => 'User has been registered']);
            } else {
                return response()->json(['status' => false, 'message' => 'Validation errors']);
            }
        }
    }

    public function validateCustomFields(Array $input) {
        // Check that category exists for all subcategories
        $utilities = new Util;
        if(empty($input['categories'])) {
            return false;
        }
        if(empty($input['subcategories'])) {
            return false;
        }
        $categories = $utilities->parseStringToArray($input['categories']);
        $subcategories = $utilities->parseStringToArray($input['subcategories']);
        $subcategoryByCategoryValidator = new CategoryExistsBySubcategory;
        if(!$subcategoryByCategoryValidator->check($categories, $subcategories)) return false;
        // Nothing found return true
        return true;
    }
}
