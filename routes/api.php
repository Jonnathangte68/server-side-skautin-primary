<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\UserController@login');
// Route::post('register', 'API\UserController@register');
Route::post('register-talent', 'API\Auth\RegisterTalentController@register');
Route::post('register-recruiter', 'API\Auth\RegisterRecruiterController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::prefix('/v1')->group(function () {
    Route::post('details', 'API\UserController@details');
    
    // Resources
    
    Route::apiResource('addresses', 'API\AddressController');
    Route::apiResource('advertisements', 'API\AdvertisementController');
    Route::apiResource('applications', 'API\ApplicationController');
    Route::apiResource('assets', 'API\AssetController');
    Route::apiResource('awards', 'API\AwardController');
    Route::apiResource('categories', 'API\CategoryController');
    Route::apiResource('certifications', 'API\CertificationController');
    Route::apiResource('cities', 'API\CityController');
    Route::apiResource('connections', 'API\ConnectionController');
    Route::apiResource('countries', 'API\CountryController');
    Route::apiResource('educations', 'API\EducationController');
    Route::apiResource('languages', 'API\LanguageController');
    Route::apiResource('organizations', 'API\OrganizationController');
    Route::apiResource('professionalexperiences', 'API\ProfessionalexperienceController');
    Route::apiResource('recruiters', 'API\RecruiterController');
    Route::apiResource('requirements', 'API\RequirementController');
    Route::apiResource('settings', 'API\SettingController');
    Route::apiResource('states', 'API\StateController');
    Route::apiResource('subcategories', 'API\SubcategoryController');
    Route::apiResource('talents', 'API\TalentController');
    Route::apiResource('vacants', 'API\VacantController');
    // Not a resource controller TODO
    // Route::resource('users', 'API\UserController');
    });
});