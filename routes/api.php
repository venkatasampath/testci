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

/*
 * ToDo: Add the CoRA public API documentation
 * ToDo: Named routes
 * Welcome route - link to cora public API documentation goes here
 */
Route::get('/', function () {
    return redirect('version');
});

Route::get('/version', function () {
    $object = new \App\Http\Resources\CoraResource(null);
    return response()->json(array_merge( ["data" => "Welcome to the CoRA API"] , $object::$meta), 200);
})->name('version');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' =>'specimens',
    'middleware' => 'auth:api'
], function () {
    Route::get('/', 'Api\SpecimensController@index');
    Route::post('/', 'Api\SpecimensController@store');
    Route::get('/{specimen?}', 'Api\SpecimensController@show');
    Route::put('/{specimen}', 'Api\SpecimensController@update');
    Route::delete('/{specimen}', 'Api\SpecimensController@delete');
    Route::get('/search', 'Api\SpecimensController@search');

    // Get, Update and Delete specimen associations (mostly lists)
    Route::get('/{specimen}/associations', 'Api\SpecimensController@getAssociations');
    Route::put('/{specimen}/associations', 'Api\SpecimensController@updateAssociations');
    Route::delete('/{specimen}/associations', 'Api\SpecimensController@deleteAssociations');

    // Get specimen associations (with all data)
//    Route::get('/{specimen}/associations/instruments', 'Api\SpecimensController@getInstruments');
    Route::get('/{specimen}/associations/methods', 'Api\SpecimensController@getMethods');
    Route::get('/{specimen}/associations/all', 'Api\SpecimensController@getAllAssociations');
    Route::get('/{specimen}/associations/articulations', 'Api\SpecimensController@getAllAssociations');
    Route::get('/{specimen}/associations/pairs', 'Api\SpecimensController@getAllAssociations');
    Route::get('/{specimen}/associations/refits', 'Api\SpecimensController@getAllAssociations');
    Route::get('/{specimen}/associations/morphologys', 'Api\SpecimensController@getAllAssociations');
    Route::get('/{specimen}/associations/morphologies', 'Api\SpecimensController@getAllAssociations');
    // PAT is Pathology, Anomaly and Trauma
    Route::get('/{specimen}/pat', 'Api\SpecimensController@getPat');
    Route::get('/{specimen}/pathology', 'Api\SpecimensController@getPat');
    Route::get('/{specimen}/anomaly', 'Api\SpecimensController@getPat');
    Route::get('/{specimen}/trauma', 'Api\SpecimensController@getPat');

    // ToDo: List below
    Route::put('/{specimen}/review', 'Api\SpecimensController@updateReviewFields');
    Route::put('/{specimen}/individual-number', 'Api\SpecimensController@updateIndividualNumberFields');
});

Route::group([
    'prefix' =>'dnas',
    'middleware' => 'auth:api'
], function () {
    Route::get('/', 'Api\DnasController@index');
    Route::post('/', 'Api\DnasController@store');
    Route::get('/{dna}', 'Api\DnasController@show');
    Route::put('/{dna}', 'Api\DnasController@update');
    Route::delete('/{dna}', 'Api\DnasController@delete');
});

Route::group([
    'prefix' =>'isotopes',
    'middleware' => 'auth:api'
], function () {
    Route::get('/', 'Api\IsotopesController@index');
    Route::post('/', 'Api\IsotopesController@store');
    Route::get('/{isotope}', 'Api\IsotopesController@show');
    Route::put('/{isotope}', 'Api\IsotopesController@update');
    Route::delete('/{isotope}', 'Api\IsotopesController@delete');
});

Route::group([
    'prefix' => 'orgs',
    'middleware' => 'auth:api'
], function () {
    Route::get('/', 'Api\OrgsController@index');
    Route::post('/', 'Api\OrgsController@store');
    Route::get('/{org?}', 'Api\OrgsController@show');
    Route::put('/{org}', 'Api\OrgsController@update');
    Route::get('/{org}/profiles', 'Api\OrgsController@getProfiles');
    Route::get('/{org}/profile', 'Api\OrgsController@getProfile');
    Route::put('/{org}/profile', 'Api\OrgsController@updateProfile');
    Route::get('/{org}/instruments', 'Api\OrgsController@getInstruments');
    Route::get('/{org}/users', 'Api\OrgsController@getUsers');
    Route::get('/{org}/projects', 'Api\OrgsController@getProjects');
    Route::get('/{org}/permissions', 'Api\OrgsController@getPermissions');
    Route::get('/{org}/individualnumbers', 'Api\OrgsController@getIndividualNumbers');


    //OrgDna
    Route::get('/{org}/dnas/mito-sequence-numbers', 'Api\OrgsController@getDnaMitoSequenceNumbers');
    Route::get('/{org}/dnas/ystr-sequence-numbers', 'Api\OrgsController@getDnaYstrSequenceNumbers');
    Route::get('/{org}/dnas/austr-sequence-numbers', 'Api\OrgsController@getDnaAustrSequenceNumbers');
    Route::get('/{org}/dnas/mito-sequence-subgroups', 'Api\OrgsController@getDnaMitoSequenceSubgroups');
    Route::get('/{org}/dnas/ystr-sequence-subgroups', 'Api\OrgsController@getDnaYstrSequenceSubgroups');
    Route::get('/{org}/dnas/austr-sequence-subgroups', 'Api\OrgsController@getDnaAustrSequenceSubgroups');
});

Route::group([
    'prefix' => 'users',
    'middleware' => 'auth:api'
], function () {
    Route::get('/', 'Api\UsersController@index');
    Route::post('/', 'Api\UsersController@store');
    Route::get('/{user?}', 'Api\UsersController@show');
    Route::put('/{user}', 'Api\UsersController@update');
    Route::get('/{user}/profiles', 'Api\UsersController@getProfiles');
    Route::get('/{user}/profile', 'Api\UsersController@getProfile');
    Route::put('/{user}/profile', 'Api\UsersController@updateProfile');
    Route::get('/{user}/current-project', 'Api\UsersController@getCurrentProject');
    Route::put('/{user}/current-project', 'Api\UsersController@updateCurrentProject');
    Route::get('/{user}/projects', 'Api\UsersController@getProjects');
    Route::get('/{user}/roles', 'Api\UsersController@getRoles');
    Route::get('/{user}/permissions', 'Api\UsersController@getPermissions');
    Route::get('/{user}/instruments', 'Api\UsersController@getInstruments');

    // Get, Update and Delete user associations (mostly lists)
    Route::get('/{user}/associations', 'Api\UsersController@getAssociations');
    Route::put('/{user}/associations', 'Api\UsersController@updateAssociations');

    // User Notifications
    Route::get('/{user}/notifications', 'Api\UsersController@getNotifications')->name('user.notifications');
    Route::get('/{user}/notifications/{notification}', 'Api\UsersController@notificationShow')->name('user.notifications.show');
    Route::post('/{user}/notifications/{notification}/markAsRead', 'Api\UsersController@notificationMarkAsRead')->name('user.notifications.markAsRead');
    Route::post('/{user}/notifications/markAllRead', 'Api\UsersController@notificationMarkAllRead')->name('user.notifications.markAllRead');

    // User Change Password, Password Reset and Inactivity Lock Reset, change/generate API token
    Route::post('/{user}/resetPassword', 'Api\UsersController@resetPassword');
    Route::post('/{user}/resetInactivityLock', 'Api\UsersController@resetInactivityLock');
    Route::post('/{user}/generateAPIToken', 'Api\UsersController@generateAPIToken');

    // Audit APIs - we have 2 names audit/activity that are used as synonyms here
    Route::get('/{user}/activity', 'Api\UsersController@getAudit');
    Route::get('/{user}/audit', 'Api\UsersController@getAudit');
});

Route::group([
    'prefix' => 'projects',
    'middleware' => 'auth:api'
], function () {
    Route::get('/', 'Api\ProjectsController@index');
    Route::post('/', 'Api\ProjectsController@store');
    Route::get('/{project?}', 'Api\ProjectsController@show');
    Route::put('/{project}', 'Api\ProjectsController@update');
    Route::delete('/{project}', 'Api\ProjectsController@destroy');

    Route::get('/{project}/profiles', 'Api\ProjectsController@getProfiles');
    Route::get('/{project}/profile', 'Api\ProjectsController@getProfile');
    Route::put('/{project}/profile', 'Api\ProjectsController@updateProfile');

    Route::get('/{project}/users', 'Api\ProjectsController@getUsers');
    Route::get('/{project}/specimens', 'Api\ProjectsController@getSpecimens');
    Route::get('/{project}/specimens/search', 'Api\ProjectsController@searchSpecimens');
    Route::get('/{project}/specimens/advanced-search', 'Api\ProjectsController@getProjectSpecimens');
    Route::get('/{project}/accessions', 'Api\ProjectsController@getAccessions');
    Route::get('/{project}/provenance1', 'Api\ProjectsController@getProvenance1');
    Route::get('/{project}/provenance2', 'Api\ProjectsController@getProvenance2');
    Route::get('/{project}/anp1p2', 'Api\ProjectsController@getAnP1P2');
    Route::get('/{project}/individual-numbers', 'Api\ProjectsController@getIndividualNumbers');
    Route::get('/{project}/tags', 'Api\ProjectsController@getTags');
    Route::get('/{project}/instruments', 'Api\ProjectsController@getInstruments');

    Route::get('/{project}/dnas', 'Api\ProjectsController@getDnas');
    Route::get('/{project}/dnas/search', 'Api\ProjectsController@searchDnas');
    Route::get('/{project}/dnas/advanced-search', 'Api\ProjectsController@getProjectDnas');
    Route::get('/{project}/dnas/sample-numbers', 'Api\ProjectsController@getDnaSampleNumbers');
    Route::get('/{project}/dnas/mito-sequence-numbers', 'Api\ProjectsController@getDnaMitoSequenceNumbers');
    Route::get('/{project}/dnas/ystr-sequence-numbers', 'Api\ProjectsController@getDnaYstrSequenceNumbers');
    Route::get('/{project}/dnas/austr-sequence-numbers', 'Api\ProjectsController@getDnaAustrSequenceNumbers');
    Route::get('/{project}/dnas/mito-sequence-subgroups', 'Api\ProjectsController@getDnaMitoSequenceSubgroups');
    Route::get('/{project}/dnas/ystr-sequence-subgroups', 'Api\ProjectsController@getDnaYstrSequenceSubgroups');
    Route::get('/{project}/dnas/austr-sequence-subgroups', 'Api\ProjectsController@getDnaAustrSequenceSubgroups');
    Route::get('/{project}/dnas/external-numbers', 'Api\ProjectsController@getDnaExternalNumbers');

    // Get, Update and Delete user associations (mostly lists)
    Route::get('/{project}/associations', 'Api\ProjectsController@getAssociations');
    Route::put('/{project}/associations', 'Api\ProjectsController@updateAssociations');

    // ToDo: List below
    Route::patch('/{project}/individual-number', 'Api\ProjectsController@updateIndividualNumber');
});

Route::group([
    'prefix' => 'base-data',
    'middleware' => 'auth:api'
], function () {
    Route::get('/anomalies', 'Api\CoraBaseDataController@getAnomalies');
    Route::get('/bones', 'Api\CoraBaseDataController@getBones');
    Route::get('/bone-articulations', 'Api\CoraBaseDataController@getBoneArticulations');
    Route::get('/bone-morphologies', 'Api\CoraBaseDataController@getBoneMorphologies');
    Route::get('/bone-groups', 'Api\CoraBaseDataController@getBoneGroups');
    Route::get('/bones-in-group', 'Api\CoraBaseDataController@getBonesInGroup');
    Route::get('/measurements', 'Api\CoraBaseDataController@getMeasurements');
    Route::get('/methods', 'Api\CoraBaseDataController@getMethods');
    Route::get('/methodfeatures', 'Api\CoraBaseDataController@getMethodFeatures');
    Route::get('/pathologies', 'Api\CoraBaseDataController@getPathologies');
    Route::get('/taphonomies', 'Api\CoraBaseDataController@getTaphonomies');
    Route::get('/traumas', 'Api\CoraBaseDataController@getTraumas');
    Route::get('/zones', 'Api\CoraBaseDataController@getZones');
    Route::get('/labs', 'Api\CoraBaseDataController@getLabs');
    Route::get('/dna-analysis-types', 'Api\CoraBaseDataController@getDnaAnalysisTypes');
    Route::get('/profiles', 'Api\CoraBaseDataController@getProfiles');
    Route::get('/role-permissions', 'Api\CoraBaseDataController@getRolePermissions');
    Route::get('/project-statuses', 'Api\CoraBaseDataController@getProjectStatuses');
    Route::get('/localization-codes', 'Api\CoraBaseDataController@getLocalizationCodes');
    Route::get('/roles', 'Api\CoraBaseDataController@getRoles');
});

Route::group([
    'prefix' => 'dashboard',
    'middleware' => 'auth:api'
], function () {
    Route::get('/orgs/{org}/highlights', 'Api\DashboardController@getOrgHighlights');
    Route::get('/projects/{project}/highlights', 'Api\DashboardController@getProjectHighlights');
    Route::get('/projects/specimens/all', 'Api\DashboardController@getSpecimensAll');
    Route::get('/projects/specimens/complete', 'Api\DashboardController@getSpecimensComplete');
    Route::get('/projects/specimens/individual', 'Api\DashboardController@getSpecimensIndividual');
    Route::get('/projects/specimens/measured', 'Api\DashboardController@getSpecimensMeasured');
    Route::get('/projects/specimens/ct-scanned', 'Api\DashboardController@getSpecimensCTScanned');
    Route::get('/projects/specimens/xray-scanned', 'Api\DashboardController@getSpecimensXrayScanned');
    Route::get('/projects/specimens/3D-scanned', 'Api\DashboardController@getSpecimens3DScanned');
    Route::get('/projects/specimens/clavicle-triage', 'Api\DashboardController@getSpecimensClavicleTriage');
    Route::get('/projects/specimens/dna-sampled', 'Api\DashboardController@getSpecimensDnaSampled');
    Route::get('/projects/specimens/isotope-sampled', 'Api\DashboardController@getSpecimensIsotopeSampled');

    // Summary related
    Route::get('/projects/{project}/summary', 'Api\DashboardController@getProjectSummary');
    Route::get('/users/allprojectsummary', 'Api\DashboardController@getAllProjectSummary');

    // Activity related
    Route::get('/projects/activity', 'Api\DashboardController@getActivity');

    // MNI related
    Route::get('/projects/mni', 'Api\DashboardController@getMni');

    // DNA related
    Route::get('/projects/dnas/mito-results', 'Api\DashboardController@getDnaMitoResults');
    Route::get('/projects/dnas/austr-results', 'Api\DashboardController@getDnaAustrResults');
    Route::get('/projects/dnas/ystr-results', 'Api\DashboardController@getDnaYstrResults');
    Route::get('/projects/dnas/mito', 'Api\DashboardController@getMitoSequence');

    // Mito related: Note both the routes [/projects/dnas/mito] and [/projects/mito] go to the same method
    // mainly for convenience purposes
    Route::get('/projects/mito', 'Api\DashboardController@getMitoSequence');

    //Dashboard Drilldowns
    Route::get('projects/{project}/drilldowns', 'Api\DashboardController@getDrilldownDetails');

});

Route::group([
    'prefix' =>'tags',
    'middleware' => 'auth:api'
], function () {
    Route::get('/', 'Api\TagsController@index');
    Route::post('/', 'Api\TagsController@store');
    Route::get('/{tag?}', 'Api\TagsController@show');
    Route::put('/{tag}', 'Api\TagsController@update');
    Route::delete('/{tag}', 'Api\TagsController@destroy');
});

Route::group([
    'prefix' =>'instruments',
    'middleware' => 'auth:api'
], function () {
    Route::get('/', 'Api\InstrumentsController@index');
    Route::post('/', 'Api\InstrumentsController@store');
    Route::get('/{instrument?}', 'Api\InstrumentsController@show');
    Route::put('/{instrument}', 'Api\InstrumentsController@update');
    Route::delete('/{instrument}', 'Api\InstrumentsController@destroy');
    Route::get('/{instrument}/users', 'Api\InstrumentsController@getUsers');

    // Get, Update and Delete specimen associations (mostly lists)
    Route::get('/{instrument}/associations', 'Api\InstrumentsController@getAssociations');
    Route::put('/{instrument}/associations', 'Api\InstrumentsController@updateAssociations');
});

Route::group([
    'prefix' =>'haplogroups',
    'middleware' => 'auth:api'
], function () {
    Route::get('/', 'Api\HaplogroupsController@index');
    Route::post('/', 'Api\HaplogroupsController@store');
    Route::get('/{haplogroup?}', 'Api\HaplogroupsController@show');
    Route::put('/{haplogroup}', 'Api\HaplogroupsController@update');
    Route::delete('/{haplogroup}', 'Api\HaplogroupsController@destroy');
});

Route::group([
    'prefix' =>'accessions',
    'middleware' => 'auth:api'
], function () {
    Route::get('/', 'Api\AccessionsController@index');
    Route::post('/', 'Api\AccessionsController@store');
    Route::get('/{accession?}', 'Api\AccessionsController@show');
    Route::put('/{accession}', 'Api\AccessionsController@update');
    Route::delete('/{accession}', 'Api\AccessionsController@destroy');
    Route::get('/{accession}/specimens', 'Api\AccessionsController@getSpecimens');
});

Route::group([
    'prefix' =>'comments',
    'middleware' => 'auth:api'
], function () {
    Route::get('/', 'Api\CommentsController@index');
    Route::post('/', 'Api\CommentsController@store');
    Route::get('/{comment?}', 'Api\CommentsController@show');
    Route::put('/{comment}', 'Api\CommentsController@update');
    Route::delete('/{comment}', 'Api\CommentsController@destroy');
});

Route::group([
    'prefix' => 'review',
    'middleware' => 'auth:api'
], function(){
    Route::get('/', 'Api\SpecimensReviewController@index');
    Route::post('/', 'Api\SpecimensReviewController@store');
    Route::get('/{specimen}', 'Api\SpecimensReviewController@show');
    Route::get('/{specimen}/list-associationdata', 'Api\SpecimensReviewController@getAssociationData');
    Route::post('/{specimen}/accept', 'Api\SpecimensReviewController@accept');
    Route::post('/{specimen}/complete', 'Api\SpecimensReviewController@complete');
    Route::post('/{specimen}/notify-review-ready', 'Api\SpecimensReviewController@notifyReviewReady');
});

Route::group([
    'prefix' => 'dental',
    'middleware' => 'auth:api'
], function(){
    Route::get('/', 'Api\DentalController@index');
});

/*
|-------------------------------------------------------------------------------
| Api Routes - Reporting
|-------------------------------------------------------------------------------
|
| Here is where you will find all the api routes for reports.
| They have a prefix of reports and are named as reports.somename. These
| routes pass through the throttle middleware with a max of 30 calls
| with a timeout of 10 minutes.
|
*/
Route::group([
    'as' => 'reports.',
    'prefix' => 'reports',
    'middleware' => 'auth:api',
], function () {
    // Project specific reports
    Route::get('/projects/{project}/dna', 'Api\ReportsController@getProjectDna');
    Route::get('/projects/{project}/individualnumberdetails', 'Api\ReportsController@getProjectIndividualNumberDetails');
    Route::get('/projects/{project}/isotopes', 'Api\ReportsController@getProjectIsotope');
    Route::get('/projects/{project}/specimenarticulations', 'Api\ReportsController@getSpecimensForArticulation');
    Route::get('/projects/{project}/articulations', 'Api\ReportsController@getProjectArticulations');
    Route::get('/projects/{project}/anomaly', 'Api\ReportsController@getProjectAnomaly');
    Route::get('/projects/{project}/trauma', 'Api\ReportsController@getProjectTrauma');
    Route::get('/projects/{project}/advanced', 'Api\ReportsController@getProjectAdvanced');
    Route::get('/projects/{project}/measurements', 'Api\ReportsController@getProjectMeasurements');
    Route::get('/projects/{project}/zones', 'Api\ReportsController@getProjectZones');
    Route::get('/projects/{project}/pathology', 'Api\ReportsController@getProjectPathology');
    Route::get('/projects/{project}/individualnumber', 'Api\ReportsController@getProjectIndividualNumbers');
    Route::get('/projects/{project}/methods', 'Api\ReportsController@getProjectMethod');
    Route::get('/projects/{project}/bonegroup', 'Api\ReportsController@getProjectBoneGroup');



    // Methods Related
    Route::get('/jsonmethodfeaturesarray', 'Api\ReportsController@getMethodFeatures');
    Route::get('/jsonscoresarray', 'Api\ReportsController@getMethodFeatureScores');
    Route::get('/jsonrangesarray', 'Api\ReportsController@getMethodFeatureScoreRanges');


    // Org specific reports
    Route::get('/orgs/{org}/dna', 'Api\ReportsController@getOrgDna');
    Route::get('/orgs/{org}/individualnumberdetails', 'Api\ReportsController@getOrgIndividualNumberDetails');
    Route::get('/orgs/{org}/isotopes', 'Api\ReportsController@getOrgIsotope');



    // Specimen Comparison
    Route::get('/projects/{project}/specimen-comparison', 'Api\ReportsController@getProjectSpecimenComparison');

//    Route::post('sepairs', ['as' => 'sepairs', 'uses' => 'ReportsController@sepairs']);
//    Route::get('searchgo', ['as' => 'searchgo', 'uses' => 'ReportsController@searchgo']);
//    Route::post('mtdna', ['as' => 'mtdna.go', 'uses' => 'ReportsController@mtdnaGo']);
//    Route::get('mtdna/{mitosequencelist}', ['as' => 'mtdna.quicklink', 'uses' => 'ReportsController@mtdnaQuickLink']);
//    Route::post('austrdna', ['as' => 'austrdna.go', 'uses' => 'ReportsController@austrdnaGo']);
//    Route::get('austrdna/{austrsequencelist}', ['as' => 'austrdna.quicklink', 'uses' => 'ReportsController@austrdnaQuickLink']);
//    Route::post('ystrdna', ['as' => 'ystrdna.go', 'uses' => 'ReportsController@ystrdnaGo']);
//    Route::get('ystrdna/{ystrsequencelist}', ['as' => 'ystrdna.quicklink', 'uses' => 'ReportsController@ystrdnaQuickLink']);
//    Route::post('advanced/results', ['as' => 'advanced.searchgo', 'uses' => 'ReportsController@advancedGo']);
//    Route::post('articulation/results', ['as' => 'articulation.searchgo', 'uses' => 'ReportsController@articulationsGo']);
//    Route::post('articulation/finalresults', ['as' => 'articulation.searchgo', 'uses' => 'ReportsController@articulationsGo']);
//    Route::post('zones', ['as' => 'zones', 'uses' => 'ReportsController@zonesGo']);
//    Route::post('jsonzonesarray', ['as' => 'jsonzonesarray', 'uses' => 'ReportsController@jsonZonesArray']);
//
//    Route::post('methods', ['as' => 'methods', 'uses' => 'ReportsController@methodsGo']);
//    Route::post('measurements', ['as' => 'measurements', 'uses' => 'ReportsController@measurementsGo']);
//    Route::post('individualnumber', ['as' => 'individualnumber', 'uses' => 'ReportsController@individualNumbersGo']);
//    Route::get('individualnumber/{individualnumber}', ['as' => 'individualnumber.quicklink', 'uses' => 'ReportsController@individualNumbersQuickLink']);
//    Route::get('individualnumberdetails', [ 'as' => 'individualnumberdetails', 'uses' => 'ReportsController@individualNumberDetails']);
//
//    Route::post('traumas', ['as' => 'traumas', 'uses' => 'ReportsController@traumasGo']);
//    Route::post('pathologys', ['as' => 'pathologys', 'uses' => 'ReportsController@pathologysGo']);
//
//    Route::post('anomalys', ['as' => 'anomalys', 'uses' => 'ReportsController@anomalysGo']);
//
//    Route::post('secomparisons', ['as' => 'secomparisons', 'uses' => 'ReportsController@seComparisonsGo']);
//
//    Route::get('bonegroup/{bone_group_id}', ['as' => 'bonegroup', 'uses' => 'ReportsController@searchgoBoneGroup']);
//
//    Route::post('isotopes', ['as' => 'isotopes', 'uses' => 'ReportsController@isotopesGo']);
//
//    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'ReportsController@dashboard']);
});

Route::group([
    'prefix' =>'files',
    'middleware' => 'auth:api'
], function () {
    Route::get('/export-types', 'Api\FilesController@getExportTypes');
    Route::get('/import-types', 'Api\FilesController@getImportTypes');
    Route::post('/uploadFile', 'Api\FilesController@storeUploadedFile');
    Route::get('/importFile/downloadTemplate', 'Api\FilesController@downloadTemplate');
    Route::get('/export-details/{id}', 'Api\FilesController@getExportTypeDetails')->name('selectTables');
    Route::post('/export-file/{id}', 'Api\FilesController@exportFile');
    Route::post('/export-all-tables', 'Api\FilesController@exportGroup');
    Route::get('/exportFileManager', 'Api\FilesController@viewExports')->name('exportFileManager');
    Route::get('/exportFileManager/{exportType}/download/{id}', 'FileController@downloadExportsAsZip');
});

Route::group([
    'prefix' =>'analytics',
    'middleware' => 'auth:api'
], function () {
    Route::get('/specimens/{specimen}/degree/{degree}', 'Api\AnalyticsController@getSpecimen');
    Route::get('/anp1p2/specimens', 'Api\AnalyticsController@getSpecimensForAnP1P2');
    Route::get('/taphonomy', 'Api\AnalyticsController@getTaphonomy');
    Route::get('/pairs', 'Api\AnalyticsController@getPairs');
});

Route::group([
    'prefix' =>'isotope',
    'middleware' => 'auth:api'
], function () {
    Route::get('/batches', 'Api\IsotopeBatchesController@index');
    Route::post('/', 'Api\IsotopeBatchesController@store');
    Route::get('/batch/{batch}', 'Api\IsotopeBatchesController@show');
    Route::put('/batch/{batch}/associateisotopes', 'Api\IsotopeBatchesController@associateIsotopes');
    Route::put('/batch/{batch}/startprocessing', 'Api\IsotopeBatchesController@startProcessing');
    Route::put('/{batch}', 'Api\IsotopeBatchesController@update');
    Route::get('/projectisotopes', 'Api\IsotopeBatchesController@getProjectIsotopeList');
    Route::get('/associatedisotopes', 'Api\IsotopeBatchesController@getAssociatedIsotopeList');


});

Route::fallback(function(){
    return response()->json([
        'message' => 'Api Route Not Found. Please check the route name or URL. If error persists, contact Sachin Pawaskar at sachinpawaskar@msn.com'], 404);
});
