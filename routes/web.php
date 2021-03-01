<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 * @category   Application Routes
 * @package    CoRA-Routes
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
*/
//use Illuminate\Support\Str;
//Route::get('/generate-api-token', function () {
//    // This route will be removed later after testing.
//    return response()->json(["data" => Str::random(60)], 200);
//});

//Route::get('/', function () {
//    return view('welcome');
//})->name('home');

// Authentication Routes
Auth::routes();
Route::get( 'password/change', 'Auth\ChangePasswordController@showChangePasswordForm')->name('changePassword');
Route::post('password/change', 'Auth\ChangePasswordController@changePassword');
Route::get('/password/expiration','Auth\PasswordExpirationController@showPasswordExpirationForm');
Route::post('/password/expiration','Auth\PasswordExpirationController@postPasswordExpiration')->name('passwordExpiration');
Route::get('/2fa','Auth\PasswordSecurityController@show2faForm');
Route::post('/generate2faSecret','Auth\PasswordSecurityController@generate2faSecret')->name('generate2faSecret');
Route::post('/2fa','Auth\PasswordSecurityController@enable2fa')->name('enable2fa');
Route::post('/disable2fa','Auth\PasswordSecurityController@disable2fa')->name('disable2fa');

Route::post('/2faVerify', function () { return redirect(URL()->previous()); })->name('2faVerify')->middleware('2fa');

// HomeController
Route::get('/', 'HomeController@home')->name('home');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/eula', 'HomeController@eula');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/aboutbrowser', 'HomeController@about')->name('aboutbrowser');
Route::get('/welcome', 'HomeController@about')->name('welcome');
Route::get('/drilldown/{type}', 'HomeController@drilldown')->name('drilldown');
Route::get('/projectDashboard/{project}', 'HomeController@showProjectDashboard')->name('projectDashboard');
Route::post('/drilldown/filter', 'HomeController@inventory_filter');

// TagsController
Route::get('/tags', 'TagsController@tags')->name('tags');

/*
|-------------------------------------------------------------------------------------------
| Web Routes - Users, Projects, Accessions and Instruments
|-------------------------------------------------------------------------------------------
|
| Here is where you will find all the web routes for Users/Projects and its associations.
| They have a prefix of orgadmin
| These routes pass through the throttle middleware with a max of 60 calls
| with a timeout of 10 minutes.
|
*/
Route::group([
    'middleware' => 'throttle:'.config('app.throttle.orgadmin.max_num_request').','.config('app.throttle.orgadmin.timeout')
], function () {
    Route::get( 'users/{user}/profiles', 'UsersController@showProfiles');
    Route::post('users/{user}/updateProfiles', 'UsersController@updateProfiles');
    Route::post('users/{user}/updateProfile', 'UsersController@updateProfile');
    Route::post('users/{user}/refreshDashboard', 'UsersController@refreshDashboard');
    Route::get( 'users/{user}/passwordbyadmin', 'UsersController@passwordViewByAdmin')->name('users.resetPassword');
    Route::post('users/{user}/passwordbyadmin', 'UsersController@passwordResetByAdmin');
    Route::get( 'users/{user}/inactivitypasswordbyadmin', 'UsersController@inactivityResetByAdmin');

    // Users
    Route::resource('users', 'UsersController');

    // Projects
    Route::resource('projects', 'ProjectsController');

    // Accessions
    Route::resource('accessions', 'AccessionsController');

    //Instruments
    Route::resource('instruments', 'InstrumentsController');

    //Haplogroups
    Route::resource('haplogroups', 'HaplogroupsController');
});

Route::group([
    'prefix' => 'users',
    'middleware' => 'throttle:'.config('app.throttle.orgadmin.max_num_request').','.config('app.throttle.orgadmin.timeout')
], function () {
    // User Profile Route
    Route::get('/{user}/profile', 'UsersController@getProfile')->name('profile');
    Route::post('/{user}/profile', 'UsersController@updateProfileContact');
    Route::post('/{user}/general', 'UsersController@updateGeneral');
    Route::post('/{user}/localization', 'UsersController@updateLocalization');
    Route::post('/{user}/projects', 'UsersController@updateProjects');
    Route::post('/{user}/notifications', 'UsersController@updateNotifications');
    Route::post('/{user}/profileImage', 'UsersController@uploadProfileImage');

    // User Notifications
    Route::get('/{user}/notifications', 'NotificationsController@index')->name('notifications.index');
    Route::get('/{user}/notifications/show/{id}', 'NotificationsController@show')->name('notifications.show');
    Route::post('/{user}/notifications/markAsRead', 'NotificationsController@markAsRead')->name('notifications.markAsRead');
    Route::post('/{user}/notifications/markAllRead', 'NotificationsController@markAllRead')->name('notifications.markAllRead');
});

// Org Profile Route
Route::group([
//    'prefix' => 'orgs',
    'middleware' => 'throttle:'.config('app.throttle.orgadmin.max_num_request').','.config('app.throttle.orgadmin.timeout')
], function () {
    Route::get('/org/{org}/profile', 'UsersController@getOrgProfile')->name('orgProfile');
    Route::post('/org/about', 'UsersController@updateOrgAbout');
    Route::post('/org/general', 'UsersController@updateOrgGeneral');
    Route::post('/org/measurements', 'UsersController@updateOrgMeasurements');
    Route::post('/org/localization', 'UsersController@updateOrgLocalization');
    Route::post('/org/apikeys', 'UsersController@updateOrgApiKeys');
    Route::get('/orgs', 'OrgsController@index');

});

/*
|-------------------------------------------------------------------------------------------
| Web Routes - Specimens
|-------------------------------------------------------------------------------------------
|
| Here is where you will find all the web routes for specimens and its associations.
| They have a prefix of skeletalelements and are named as skeletalelements.somename.
| These routes pass through the throttle middleware with a max of 60 calls
| with a timeout of 10 minutes.
|
*/
Route::group([
    'middleware' => 'throttle:'.config('app.throttle.se.max_num_request').','.config('app.throttle.se.timeout')
], function () {

    // Specimen Search
    Route::get('/skeletalelements/search', ['as' => 'skeletalelements.search', 'uses' => 'SkeletalElementsController@search']);         // must be above resource
    Route::post('/skeletalelements/searchgo', ['as' => 'skeletalelements.searchgo', 'uses' => 'SkeletalElementsController@searchgo']);  // must be above resource
    Route::get('/skeletalelements/createbygroup', ['as' => 'skeletalelements.createbygroup', 'uses' => 'SkeletalElementsController@createByGroup']); //must be above resource
    Route::post('/skeletalelements/storebygroup', ['as' => 'skeletalelements.storebygroup', 'uses' => 'SkeletalElementsController@storeByGroup']);
    Route::post('/skeletalelements/jsonbonesbygrouparray', ['as' => 'skeletalelements.jsonbonesbygrouparray', 'uses' => 'SkeletalElementsController@jsonBonesByGroupArray']);

    Route::resource('skeletalelements', 'SkeletalElementsController');

    // Associate Taphonomies
    Route::get('/skeletalelements/{skeletalelements}/taphonomys', 'SkeletalElementsController@taphonomys')->name('skeletalelements.associations');
    Route::get('/skeletalelements/{skeletalelements}/associatetaphonomys', 'SkeletalElementsController@edittaphonomys');
    Route::post('/skeletalelements/{skeletalelements}/associatetaphonomys', 'SkeletalElementsController@associatetaphonomys');

    // Associate Pairs
    Route::get('/skeletalelements/{skeletalelements}/pairs', 'SkeletalElementsController@pairs');
    Route::get('/skeletalelements/{skeletalelements}/associatepairs', 'SkeletalElementsController@editpairs');
    Route::post('/skeletalelements/{skeletalelements}/associatepairs', 'SkeletalElementsController@associatepairs');
    Route::get('/skeletalelements/{skeletalelements}/pairs/{pair}/view', 'SkeletalElementsController@viewpair');
    Route::get('/skeletalelements/{skeletalelements}/pairs/{pair}/edit', 'SkeletalElementsController@editpair');
    Route::post('/skeletalelements/{skeletalelements}/pairs/{pair}/update', 'SkeletalElementsController@updatepair');
    Route::post('/skeletalelements/jsonpairs', ['as' => 'skeletalelements.jsonpairs', 'uses' => 'SkeletalElementsController@jsonpairseliminationreason']);

    // Associate Articulations
    Route::get('/skeletalelements/{skeletalelements}/articulations', 'SkeletalElementsController@articulations');
    Route::get('/skeletalelements/{skeletalelements}/associatearticulations', 'SkeletalElementsController@editarticulations');
    Route::post('/skeletalelements/{skeletalelements}/associatearticulations', 'SkeletalElementsController@associatearticulations');

    // Associate DNA
    Route::get('/skeletalelements/{skeletalelement}/dnas/create', 'DnasController@create');
    Route::get('/skeletalelements/{skeletalelement}/dnas/{dna}', 'DnasController@show');
    Route::get('/skeletalelements/{skeletalelement}/dnas/{dna}/edit', 'DnasController@edit');
    Route::get('/skeletalelements/{skeletalelement}/dnas', 'DnasController@index');
    Route::delete('/skeletalelements/{skeletalelement}/dnas/{dna}', 'DnasController@destroy');

    // Associate Isotopes
    Route::get('/isotopes/{skeletalelement}/create', 'IsotopesController@create');
    Route::get('/isotopes/{skeletalelement}/{isotope}', 'IsotopesController@show');
    Route::get('/isotopes/{skeletalelement}', 'IsotopesController@index');
    Route::get('/isotopes/{skeletalelement}/{isotope}/edit', 'IsotopesController@edit');
    Route::delete('/isotopes/{skeletalelement}/{isotope}', 'IsotopesController@destroy');

    Route::resource('isotopes', 'IsotopesController');

    // Associate Refits
    Route::get('/skeletalelements/{skeletalelements}/refits', 'SkeletalElementsController@refits');
    Route::get('/skeletalelements/{skeletalelements}/associaterefits', 'SkeletalElementsController@editrefits');
    Route::post('/skeletalelements/{skeletalelements}/associaterefits', 'SkeletalElementsController@associaterefits');

    // Associate Morphologys
    Route::get('/skeletalelements/{skeletalelements}/morphologys', 'SkeletalElementsController@morphologys');
    Route::get('/skeletalelements/{skeletalelements}/associatemorphologys', 'SkeletalElementsController@editmorphologys');
    Route::post('/skeletalelements/{skeletalelements}/associatemorphologys', 'SkeletalElementsController@associatemorphologys');

    // Associate Measurements
    Route::get('/skeletalelements/{skeletalelements}/measurements', 'SkeletalElementsController@measurements');
    Route::get('/skeletalelements/{skeletalelements}/measurements/edit', 'SkeletalElementsController@editMeasurements');
    Route::post('/skeletalelements/{skeletalelements}/associatemeasurements', 'SkeletalElementsController@associatemeasurements');

    // Associate Zones
    Route::get('/skeletalelements/{skeletalelements}/zones/view', ['as' => 'skeletalelements.viewzones', 'uses' => 'SkeletalElementsController@viewZones']);
    Route::get('/skeletalelements/{skeletalelements}/zones/edit', ['as' => 'skeletalelements.editzones', 'uses' => 'SkeletalElementsController@editZones']);
    Route::post('/skeletalelements/{skeletalelements}/associatezones', 'SkeletalElementsController@associatezones');

    // Associate Anomalies
    Route::get('/skeletalelements/{skeletalelements}/anomalys', 'SkeletalElementsController@anomalys');
    Route::get('/skeletalelements/{skeletalelements}/associateanomalys', 'SkeletalElementsController@editanomalys');
    Route::post('/skeletalelements/{skeletalelements}/associateanomalys', 'SkeletalElementsController@associateanomalys');

    // Associate Traumas
    Route::get('/skeletalelements/{skeletalelements}/traumas', ['as' => 'skeletalelements.traumas', 'uses' => 'SkeletalElementsController@traumas']);
    Route::post('/skeletalelements/{skeletalelements}/associatetrauma', 'SkeletalElementsController@associatetrauma');
    Route::get('/skeletalelements/{skeletalelements}/traumas/create', ['as' => 'skeletalelements.createtrauma', 'uses' => 'SkeletalElementsController@createtrauma']);
    Route::get('/skeletalelements/{skeletalelements}/traumas/{id}', 'SkeletalElementsController@viewtrauma');
    Route::get('/skeletalelements/{skeletalelements}/traumas/{id}/edit', 'SkeletalElementsController@edittrauma');
    Route::delete('/skeletalelements/{skeletalelements}/traumas/{id}', ['as' => 'skeletalelements.traumas.destroy', 'uses' => 'SkeletalElementsController@deletetrauma']);

    // Associate Pathologies
    Route::get('/skeletalelements/{skeletalelements}/pathologys', ['as' => 'skeletalelements.pathologys', 'uses' => 'SkeletalElementsController@pathologys']);
    Route::post('/skeletalelements/{skeletalelements}/associatepathology', 'SkeletalElementsController@associatepathology');
    Route::get('/skeletalelements/{skeletalelements}/pathologys/create', ['as' => 'skeletalelements.createpathology', 'uses' => 'SkeletalElementsController@createpathology']);
    Route::get('/skeletalelements/{skeletalelements}/pathologys/{id}', 'SkeletalElementsController@viewpathology');
    Route::get('/skeletalelements/{skeletalelements}/pathologys/{id}/edit', 'SkeletalElementsController@editpathology');
    Route::delete('/skeletalelements/{skeletalelements}/pathologys/{id}', ['as' => 'skeletalelements.pathologys.destroy', 'uses' => 'SkeletalElementsController@deletepathology']);
    Route::get('/skeletalelements/{skeletalelements}/pat', 'SkeletalElementsController@showPat');

    //    Route::get('/skeletalelements/{skeletalelements}/methods/{methods}', 'SkeletalElementsController@method');
    Route::get('/skeletalelements/{skeletalelements}/methods', ['as' => 'skeletalelements.methods', 'uses' => 'SkeletalElementsController@methods']);
    Route::get('/skeletalelements/{skeletalelements}/methods/create', ['as' => 'skeletalelements.createmethod', 'uses' => 'SkeletalElementsController@createmethod']);
    Route::get('/skeletalelements/{skeletalelements}/methods/{methods}/edit', ['as' => 'skeletalelements.editmethod', 'uses' => 'SkeletalElementsController@editmethod']);
    Route::get('/skeletalelements/{skeletalelements}/methods/{methods}', ['as' => 'skeletalelements.viewmethod', 'uses' => 'SkeletalElementsController@viewmethod']);
    Route::post('/skeletalelements/{skeletalelements}/associatemethod/{method}', ['as' => 'skeletalelements.associatemethod', 'uses' => 'SkeletalElementsController@associatemethod']);
    Route::delete('/skeletalelements/{skeletalelements}/methods/{id}', ['as' => 'skeletalelements.methods.destroy', 'uses' => 'SkeletalElementsController@deletemethod']);

    // Associate Age
    Route::get('/skeletalelements/{skeletalelements}/age', ['as' => 'skeletalelements.age', 'uses' => 'SkeletalElementsController@age']);
    Route::post('/skeletalelements/{skeletalelements}/associateage', 'SkeletalElementsController@associateage');
    // Associate Sex
    Route::get('/skeletalelements/{skeletalelements}/sex', ['as' => 'skeletalelements.sex', 'uses' => 'SkeletalElementsController@sex']);
    Route::post('/skeletalelements/{skeletalelements}/associatesex', 'SkeletalElementsController@associatesex');
    // Associate Stature
    Route::get('/skeletalelements/{skeletalelements}/stature', ['as' => 'skeletalelements.stature', 'uses' => 'SkeletalElementsController@stature']);
    Route::post('/skeletalelements/{skeletalelements}/associatestature', 'SkeletalElementsController@associatestature');
    // Associate Ancestry
    Route::get('/skeletalelements/{skeletalelements}/ancestry', ['as' => 'skeletalelements.ancestry', 'uses' => 'SkeletalElementsController@ancestry']);
    Route::post('/skeletalelements/{skeletalelements}/associateancestry', 'SkeletalElementsController@associateancestry');

    // Review - Specimen
    Route::get('/skeletalelements/{skeletalelements}/review', 'SkeletalElementsController@review')->name('skeletalelements.review');
    Route::post('/skeletalelements/{skeletalelements}/updatereview', 'SkeletalElementsController@updatereview');

    Route::get('/skeletalelements/{skeletalelements}/review/general', 'SkeletalElementsController@reviewGeneral');
    Route::post('/skeletalelements/{skeletalelements}/review/general', 'SkeletalElementsController@storeReviewGeneral');
    Route::post('/skeletalelements/{skeletalelements}/review/acceptgeneral', 'SkeletalElementsController@storeAcceptReviewGeneral');
    Route::get('/skeletalelements/{skeletalelements}/review/dna', 'SkeletalElementsController@reviewDNA');
    Route::post('/skeletalelements/{skeletalelements}/review/dna', 'SkeletalElementsController@storeReviewDNA');
    Route::post('/skeletalelements/{skeletalelements}/review/acceptdna', 'SkeletalElementsController@storeAcceptReviewDNA');
    Route::get('/skeletalelements/{skeletalelements}/review/taphonomys', 'SkeletalElementsController@reviewTaphonomys');
    Route::post('/skeletalelements/{skeletalelements}/review/taphonomys', 'SkeletalElementsController@storeReviewTaphonomys');
    Route::post('/skeletalelements/{skeletalelements}/review/accepttaphonomys', 'SkeletalElementsController@storeAcceptReviewTaphonomys');
    Route::get('/skeletalelements/{skeletalelements}/review/zones', 'SkeletalElementsController@reviewZones');
    Route::post('/skeletalelements/{skeletalelements}/review/zones', 'SkeletalElementsController@storeReviewZones');
    Route::post('/skeletalelements/{skeletalelements}/review/acceptzones', 'SkeletalElementsController@storeAcceptReviewZones');
    Route::get('/skeletalelements/{skeletalelements}/review/measurements', 'SkeletalElementsController@reviewMeasurements');
    Route::post('/skeletalelements/{skeletalelements}/review/measurements', 'SkeletalElementsController@storeReviewMeasurements');
    Route::post('/skeletalelements/{skeletalelements}/review/acceptmeasurements', 'SkeletalElementsController@storeAcceptReviewMeasurements');
    Route::get('/skeletalelements/{skeletalelements}/review/associations', 'SkeletalElementsController@reviewAssociations');
    Route::post('/skeletalelements/{skeletalelements}/review/associations', 'SkeletalElementsController@storeReviewAssociations');
    Route::post('/skeletalelements/{skeletalelements}/review/acceptassociations', 'SkeletalElementsController@storeAcceptReviewAssociations');
    Route::get('/skeletalelements/{skeletalelements}/review/biologicalprofile', 'SkeletalElementsController@reviewBiologicalProfile');
    Route::post('/skeletalelements/{skeletalelements}/review/biologicalprofile', 'SkeletalElementsController@storeReviewBiologicalProfile');
    Route::post('/skeletalelements/{skeletalelements}/review/acceptbiologicalprofile', 'SkeletalElementsController@storeAcceptReviewBiologicalProfile');
    Route::get('/skeletalelements/{skeletalelements}/review/pathologys', 'SkeletalElementsController@reviewPathology');
    Route::post('/skeletalelements/{skeletalelements}/review/pathologys', 'SkeletalElementsController@storeReviewPathology');
    Route::post('/skeletalelements/{skeletalelements}/review/acceptpathologys', 'SkeletalElementsController@storeAcceptReviewPathology');

    // Review Complete State Button
    Route::post('/skeletalelements/{skeletalelements}/review/completed', 'SkeletalElementsController@ReviewCompleteStateButton');
});


/*
|-------------------------------------------------------------------------------------------
| Web Routes - Dental
|-------------------------------------------------------------------------------------------
|
| Here is where you will find all the web routes for dental specimens.
| They have a prefix of dental and are named as dental.somename.
| These routes pass through the throttle middleware with a max of 60 calls
| with a timeout of 10 minutes.
|
*/
Route::group([
    'prefix' => 'dental',
    'middleware' => 'throttle:'.config('app.throttle.se.max_num_request').','.config('app.throttle.se.timeout')
], function () {

    Route::get('/create', 'DentalController@create');
    Route::get('/createbychart', 'DentalController@createByChart');
    Route::get('/createbygroup', ['as' => 'createbygroup', 'uses' => 'DentalController@createByGroup']);
    Route::get('/search', ['as' => 'dental.search', 'uses' => 'DentalController@search']); // must be above resource
});


/*
|-------------------------------------------------------------------------------------------
| Web Routes - DNAs
|-------------------------------------------------------------------------------------------
|
| Here is where you will find all the web routes for DNA and its associations.
| These routes pass through the throttle middleware with a max of 60 calls
| with a timeout of 10 minutes.
|
*/
Route::group([
    'middleware' => 'throttle:'.config('app.throttle.module.max_num_request').','.config('app.throttle.module.timeout')
], function () {
    Route::get('/dnas/search', ['as' => 'dnas.search', 'uses' => 'DnasController@search']); // must be above resource
    Route::post('/dnas/searchgo', ['as' => 'dnas.searchgo', 'uses' => 'DnasController@searchgo']);

    // DNAs
    Route::resource('dnas', 'DnasController');
});

/*
|-------------------------------------------------------------------------------------------
| Web Routes - Isotopes
|-------------------------------------------------------------------------------------------
|
| Here is where you will find all the web routes for Isotopes and its associations.
| These routes pass through the throttle middleware with a max of 60 calls
| with a timeout of 10 minutes.
|
*/
Route::group([
    'middleware' => 'throttle:'.config('app.throttle.module.max_num_request').','.config('app.throttle.module.timeout')
], function () {
    Route::get('/isotopes/search', ['as' => 'isotopes.search', 'uses' => 'IsotopesController@search']); // must be above resource
    Route::post('/isotopes/searchgo', ['as' => 'isotopes.searchgo', 'uses' => 'IsotopesController@searchgo']);


    // Isotope Batch
    Route::resource('isotopebatch', 'IsotopeBatchesController');
    Route::post('/isotopearray', ['as' => 'isotopearray', 'uses' => 'IsotopeBatchesController@isotopeArray']);

    Route::get('/isotopebatch/create', 'IsotopeBatchesController@create');
    Route::get('/isotopebatch/{isotopeBatch}', 'IsotopeBatchesController@show');
    Route::get('/isotopebatch/{isotopeBatch}/edit', 'IsotopeBatchesController@edit');
    Route::get('/isotopebatch', 'IsotopeBatchesController@index');
    Route::delete('/isotopebatch/{isotopeBatch}', 'IsotopeBatchesController@destroy');

    // Associate Isotopes
    Route::get('/isotopebatch/associateisotopes/{isotopeBatch}', 'IsotopeBatchesController@editIsotopes');
    Route::post('/isotopebatch/associateisotopes/{isotopeBatch}', 'IsotopeBatchesController@associateIsotopes');
    Route::get('/isotopebatch/{isotopeBatch}/startprocessing', 'IsotopeBatchesController@startprocessing');
});

/*
|-------------------------------------------------------------------------------
| Web Routes - Reporting
|-------------------------------------------------------------------------------
|
| Here is where you will find all the web routes for reports.
| They have a prefix of reports and are named as reports.somename. These
| routes pass through the throttle middleware with a max of 30 calls
| with a timeout of 10 minutes.
|
*/
Route::group([
    'as' => 'reports.',
    'prefix' => 'reports',
    'middleware' => 'throttle:'.config('app.throttle.reports.max_num_request').','.config('app.throttle.reports.timeout')
], function () {
    Route::get('showsepairs', ['as' => 'showsepairs', 'uses' => 'ReportsController@showsepairs']);
    Route::post('sepairs', ['as' => 'sepairs', 'uses' => 'ReportsController@sepairs']);
    Route::get('search', ['as' => 'search', 'uses' => 'ReportsController@search']);
    Route::get('searchgo', ['as' => 'searchgo', 'uses' => 'ReportsController@searchgo']);
    Route::get('mtdna', ['as' => 'mtdna', 'uses' => 'ReportsController@mtdna']);
    Route::post('mtdna', ['as' => 'mtdna.go', 'uses' => 'ReportsController@mtdnaGo']);
    Route::get('mtdna/{mitosequencelist}', ['as' => 'mtdna.quicklink', 'uses' => 'ReportsController@mtdnaQuickLink']);
    Route::get('austrdna', ['as' => 'austrdna', 'uses' => 'ReportsController@austrdna']);
    Route::post('austrdna', ['as' => 'austrdna.go', 'uses' => 'ReportsController@austrdnaGo']);
    Route::get('austrdna/{austrsequencelist}', ['as' => 'austrdna.quicklink', 'uses' => 'ReportsController@austrdnaQuickLink']);
    Route::get('ystrdna', ['as' => 'ystrdna', 'uses' => 'ReportsController@ystrdna']);
    Route::post('ystrdna', ['as' => 'ystrdna.go', 'uses' => 'ReportsController@ystrdnaGo']);
    Route::get('ystrdna/{ystrsequencelist}', ['as' => 'ystrdna.quicklink', 'uses' => 'ReportsController@ystrdnaQuickLink']);
    Route::get('advanced', ['as' => 'advanced.search', 'uses' => 'ReportsController@advanced']);
    Route::post('advanced/results', ['as' => 'advanced.searchgo', 'uses' => 'ReportsController@advancedGo']);
    Route::get('consolidatedAccession', ['as' => 'consolidatedAccession.search', 'uses' => 'ReportsController@consolidatedANsearch']);
    Route::post('consolidatedAccession/results', ['as' => 'consolidatedAccession.searchgo', 'uses' => 'ReportsController@consolidatedANsearchgo']);
    Route::get('articulation',['as' => 'articulation.search', 'uses' => 'ReportsController@articulations']);
    Route::post('articulation/results', ['as' => 'articulation.searchgo', 'uses' => 'ReportsController@articulationsGo']);
    Route::post('articulation/finalresults', ['as' => 'articulation.searchgo', 'uses' => 'ReportsController@articulationsGo']);
    Route::get('zones', ['as' => 'zones', 'uses' => 'ReportsController@zones']);
    Route::post('zones', ['as' => 'zones', 'uses' => 'ReportsController@zonesGo']);
    Route::post('jsonzonesarray', ['as' => 'jsonzonesarray', 'uses' => 'ReportsController@jsonZonesArray']);
    Route::get('methods', ['as' => 'methods', 'uses' => 'ReportsController@methods']);
    Route::post('methods', ['as' => 'methods', 'uses' => 'ReportsController@methodsGo']);
    // Ajax calls for method search screen
    Route::post('jsonmethodsarray', ['as' => 'jsonmethodsarray', 'uses' => 'ReportsController@jsonMethodsArray']);
    Route::post('jsonmethodfeaturesarray', ['as' => 'jsonmethodfeaturesarray', 'uses' => 'ReportsController@jsonMethodFeaturesArray']);
    Route::post('jsonscoresarray', ['as' => 'jsonscoresarray', 'uses' => 'ReportsController@jsonScoresArray']);
    Route::post('jsonrangesarray', ['as' => 'jsonrangesarray', 'uses' => 'ReportsController@jsonRangesArray']);

    Route::get('measurements', ['as' => 'measurements', 'uses' => 'ReportsController@measurements']);
    Route::post('measurements', ['as' => 'measurements', 'uses' => 'ReportsController@measurementsGo']);
    Route::get('individualnumber', ['as' => 'individualnumber', 'uses' => 'ReportsController@individualNumbers']);
    Route::post('individualnumber', ['as' => 'individualnumber', 'uses' => 'ReportsController@individualNumbersGo']);
    Route::get('individualnumberdetails/{individualnumber}', ['as' => 'individualnumber.quicklink', 'uses' => 'ReportsController@individualNumbersQuickLink']);
    Route::get('individualnumberdetails', [ 'as' => 'individualnumberdetails', 'uses' => 'ReportsController@individualNumberDetails']);

    Route::get('traumas', ['as' => 'traumas', 'uses' => 'ReportsController@traumas']);
    Route::post('traumas', ['as' => 'traumas', 'uses' => 'ReportsController@traumasGo']);
    Route::get('pathologys', ['as' => 'pathologys', 'uses' => 'ReportsController@pathologys']);
    Route::post('pathologys', ['as' => 'pathologys', 'uses' => 'ReportsController@pathologysGo']);

    Route::get('anomalys', ['as' => 'anomalys', 'uses' => 'ReportsController@anomalys']);
    Route::post('anomalys', ['as' => 'anomalys', 'uses' => 'ReportsController@anomalysGo']);

    Route::get('secomparisons', ['as' => 'secomparisons', 'uses' => 'ReportsController@secomparisons']);
    Route::post('secomparisons', ['as' => 'secomparisons', 'uses' => 'ReportsController@seComparisonsGo']);

    Route::post('jsonp1array', ['as' => 'jsonp1array', 'uses' => 'ReportsController@jsonP1Array']);
    Route::post('jsonp2array', ['as' => 'jsonp2array', 'uses' => 'ReportsController@jsonP2Array']);
    Route::post('jsonanarray', ['as' => 'jsonanarray', 'uses' => 'ReportsController@jsonANArray']);
    Route::get('jsondnaarray', ['as' => 'jsondnaarray', 'uses' => 'ReportsController@jsonDNAArray']);


    Route::get('bonegroup/{bone_group_id}', ['as' => 'bonegroup', 'uses' => 'ReportsController@searchgoBoneGroup']);

    Route::get('isotopes', ['as' => 'isotopes', 'uses' => 'ReportsController@isotopes']);
    Route::post('isotopes', ['as' => 'isotopes', 'uses' => 'ReportsController@isotopesGo']);

    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'ReportsController@projectReportsDashboard']);
    Route::get('org/dashboard', ['as' => 'org-reports-dashboard', 'uses' => 'ReportsController@orgReportsDashboard']);

    // Org Report Routes
    Route::get('org/dna/mito', ['as' => 'org-reports-dna_mito', 'uses' => 'ReportsController@orgDnaMito']);
    Route::get('org/dna/ystr', ['as' => 'org-reports-dna_ystr', 'uses' => 'ReportsController@orgDnaYstr']);
    Route::get('org/dna/austr', ['as' => 'org-reports-dna_austr', 'uses' => 'ReportsController@orgDnaAustr']);
    Route::get('org/user', ['as' => 'org-reports-user', 'uses' => 'ReportsController@orgUserRpt']);
    Route::get('org/isotopes', ['as' => 'org-isotopes-report', 'uses' => 'ReportsController@orgIsotopes']);
    Route::get('org/isotope', ['as' => 'org-reports-isotope', 'uses' => 'ReportsController@orgDnaAustr']);
    Route::get('org/individual/number/details', ['as' => 'org-reports-individual_number_details', 'uses' => 'ReportsController@orgIndividualNumberDetails']);
});

/*
|-------------------------------------------------------------------------------
| Web Routes - Visualization
|-------------------------------------------------------------------------------
|
| Here is where you will find all the web routes visualizations.
| They have a prefix of visualizations and are named as visualizations.somename. These
| routes pass through the throttle middleware with a max of 30 calls
| with a timeout of 10 minutes.
|
*/
Route::group([
    'as' => 'visualizations.',
    'prefix' => 'visualizations',
    'middleware' => 'throttle:'.config('app.throttle.reports.max_num_request').','.config('app.throttle.reports.timeout')
], function () {
    Route::get('pairs', ['as' => 'pairs', 'uses' => 'VisualizationsController@searchPairs']);
    Route::post('pairs', ['as' => 'pairs', 'uses' => 'VisualizationsController@graphPairs']);
    Route::post('jsonskeletalelements', ['as' => 'jsonskeletalelements', 'uses' => 'VisualizationsController@jsonskeletalelements']);

    // Visualization Dashboard.
    Route::get('dashboard', ['as' => 'visualizations-dashboard', 'uses' => 'VisualizationsController@dashboard']);

    // Taphonomy.
    Route::get('/', ['as' => 'viz-main', 'uses' => 'VisualizationsController@getViz']);
});

/*
|-------------------------------------------------------------------------------
| Web Routes - Analytics
|-------------------------------------------------------------------------------
|
| Here is where you will find all the web routes for analytics.
| They have a prefix of analytics and are named as analytics.somename. These
| routes pass through the throttle middleware with a max of 30 calls
| with a timeout of 10 minutes.
|
*/
Route::group([
    'as' => 'analytics.',
    'prefix' => 'analytics',
    'middleware' => 'throttle:'.config('app.throttle.reports.max_num_request').','.config('app.throttle.reports.timeout')
], function () {
    Route::get('specimen-canvas', ['as' => 'specimen-canvas', 'uses' => 'AnalyticsController@getSpecimenCanvas']);
    Route::get('project-canvas', ['as' => 'project-canvas', 'uses' => 'AnalyticsController@getProjectCanvas']);
    // Verify below route is being used.
    Route::get('individual-numbers', ['as' => 'individual-numbers', 'uses' => 'AnalyticsController@getIndividualNumbers']);
});


/*
|-------------------------------------------------------------------------------
| Web Routes - Admin and Admin Voyager
|-------------------------------------------------------------------------------
|
| Here is where you will find all the web routes for administration purposes.
| They have a prefix of admin and are named as admin.somename. These
| routes pass through admin.user middleware with a max of 60 calls
| with a timeout of 30 minutes.
|
*/
Route::group([
    'prefix' => 'admin',
    'middleware' => 'throttle:'.config('app.throttle.admin.max_num_request').','.config('app.throttle.admin.timeout')
], function () {
    Voyager::routes();

    // The following two routes are protected and can be called only by an
    // Admin User. These are for development & testing purposes only.
    // They should be removed. Having these is a security violation.
    Route::group(['middleware' => 'admin.user'], function () {
        Route::get('php-version', function()
        {
            return phpinfo();
        });

        Route::get('laravel-version', function()
        {
            $laravel = app();
            return 'Your Laravel Version is '.$laravel::VERSION;
        });
    });
});

/*
|-------------------------------------------------------------------------------
| Web Routes - Import & Export Files (Initial)
|-------------------------------------------------------------------------------
|
| Here is where you will find all the web routes for importing and exporting files.
|
*/
Route::get('/importFile', 'FileController@listImportOptions')->name('importFile');
Route::post('/uploadFile', 'FileController@storeUploadedFile');
Route::get('/exportType/{id}', 'FileController@exportType')->name('selectTables');
Route::post('/exportType/{id}', 'FileController@exportFile');
Route::get('/exportOptions', 'FileController@listExportOptions')->name('exportOptions');
Route::get('/exportOptions/advanced/{id}','FileController@exportOptionsAdvanced') -> name('exportOptionsAdvanced');
Route::post('/exportOptions', 'FileController@exportGroup');

Route::get('/exportFileManager', 'FileController@viewExports')->name('exportFileManager');
Route::get('/exportFileManager/{exportType}/download/{id}', 'FileController@downloadExportsAsZip');

Route::post('/importFile/{importTypeId}/downloadTemplate', 'FileController@downloadTemplate');
Route::post('/importFile/downloadAllTemplates', 'FileController@downloadAllTemplates');
