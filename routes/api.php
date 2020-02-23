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

// Public Routes
Route::post('login', 'API\UserController@login');
Route::post('register-talent', 'API\Auth\RegisterTalentController@register');
Route::post('register-recruiter', 'API\Auth\RegisterRecruiterController@register');
Route::get('website-content/{website}', 'API\WebsitePageContentController@show');
Route::get('/change_route_name', function () {
    return response()->json(['error' => 'unauthenticated']);
})->name('change_route_name');
// End of public Routes

// Testing Routes
// Route::apiResource('talentplaylists', 'API\TalentPlaylistController');
// Route::apiResource('favorite-folders', 'API\FavoriteFolderController');
// Route::get('filter-opportunities-for-talents', 'API\TalentOpportunityFilter');
// Route::apiResource('advertisements', 'API\AdvertisementController');
// Route::get('show-advertising', 'API\ShowAdvertisement');
// Route::resource('interval-advertisements', 'API\AdvertisementGroupIntervalsController');
Route::resource('website-content-test', 'API\WebsitePageContentController')->except([
    'index', 'create', 'edit', 'update', 'destroy'
]);
Route::apiResource('scriptfile', 'API\ScriptFileController');
// End testing routes.

// Private api routes

Route::group(['middleware' => 'auth:api'], function(){
    Route::prefix('/v1')->group(function () {
    Route::get('retrieveImage/{id}', 'API\AssetManager@getImage');
    Route::get('downloadImage/{id}', 'API\AssetManager@downloadFile');
    Route::post('details', 'API\UserController@details');
    Route::get('search', 'API\SearchController');
    Route::get('stream/{id}', 'API\VideoStreamer');
    Route::get('get-users-on-connection', 'API\UsersDetailsOnConnections');
    Route::get('filter-opportunities-for-talents', 'API\TalentOpportunityFilter');
    Route::get('show-advertising', 'API\ShowAdvertisement');
    
    // Resources

    Route::apiResource('talentplaylists', 'API\TalentPlaylistController');
    Route::apiResource('favorite-folders', 'API\FavoriteFolderController');
    Route::apiResource('addresses', 'API\AddressController');
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
    Route::apiResource('pending-invitations', 'API\PendingInvitationController');

    // Admin routes
    Route::apiResource('general-app-settings', 'API\GeneralApplicationSettingsController')->except([
        'create', 'store', 'show', 'destroy'
    ]);
    Route::apiResource('advertisements', 'API\AdvertisementController');
    Route::resource('interval-advertisements', 'API\AdvertisementGroupIntervalsController');
    // Route::resource('website-content', 'API\WebsitePageContentController');
    // TODO
    // Route::resource('users', 'API\UserController');
    });
});