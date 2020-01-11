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
Route::group([

    
    'prefix' => 'auth',

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::group([

    
    'middleware' => 'jwt.auth',

], function ($router) {

    //users
    Route::get('users','UserController@index');
    Route::get('users/edit/{id}','UserController@edit');
    Route::post('users/add','UserController@create');
    Route::post('users/edit/update/{id}','UserController@update');
    Route::get('users/downloadUsers','UserController@downloadusers');
    Route::get('users/deactivate/{id}','UserController@deactivate');
    Route::get('users/getUsersInGroup/{id}','UserController@getUsersInGroup');
    Route::get('users/getUsersNotInGroup/{id}','UserController@getUsersNotInGroup');

    //groups
    Route::get('groups','GroupController@index');
    Route::get('groups/edit/{id}','GroupController@edit');
    Route::post('groups/add','GroupController@create');
    Route::post('groups/edit/update/{id}','GroupController@update');
    Route::post('groups/manage','GroupController@manage');
    Route::get('groups/downloadGroups','GroupController@downloadgroups');
    Route::get('groups/deactivate/{id}','GroupController@deactivate');
    Route::post('groups/addUsers/{id}','GroupController@addUsers');


    //exercises
    Route::get('exercises','ExerciseController@index');
    Route::get('exercises/edit/{id}','ExerciseController@edit');
    Route::post('exercises/add','ExerciseController@create');
    Route::post('exercises/edit/update/{id}','ExerciseController@update');
    Route::get('exercises/downloadExercise','ExerciseController@downloadexercises');
    Route::get('exercises/deactivate/{id}','ExerciseController@deactivate');
    Route::get('exercises/getJointsInExercise/{id?}','ExerciseController@getJointsInExercise');
    Route::get('exercises/getJointsNotInExercise/{id?}','ExerciseController@getJointsNotInExercise');
    Route::get('exercises/getGamesInExercise/{id?}','ExerciseController@getGamesInExercise');
    Route::get('exercises/getGamesNotInExercise/{id?}','ExerciseController@getGamesNotInExercise');

    //games
    Route::get('games','GameController@index');
    Route::get('games/edit/{id}','GameController@edit');
    Route::post('games/add','GameController@create');
    Route::post('games/edit/update/{id}','GameController@update');
    Route::get('games/downloadGames','GameController@downloadgames');
    Route::get('games/deactivate/{id}','GameController@deactivate');
    Route::post('games/uploadAPK', 'GameController@uploadFile');
    
    //patients
    Route::get('patients','PatientController@index');
    Route::get('patients/edit/{id}','PatientController@edit');
    Route::post('patients/add','PatientController@create');
    Route::post('patients/edit/update/{id}','PatientController@update');
    Route::get('patients/downloadPatients','PatientController@downloadpatients');
    Route::get('patients/deactivate/{id}','PatientController@deactivate');
    
    //personal
    Route::get('personal/edit/{id}','PersonalController@edit');
    Route::post('personal/edit/update/{id}','PersonalController@update');
    Route::post('personal/edit/changepassword/{id}', 'PersonalController@changePassword');

    //joints
    Route::get('joints/getRoms','JointController@getJointAndRoms');
    Route::get('joints/getExistingRoms','JointController@getExistingJointAndRoms');
    Route::post('joints/getExerciseRoms','JointController@getExerciseRoms');
    Route::post('joints/getExerciseLimbs','JointController@getExerciseLimbs');

    //targets
    Route::get('targets','TargetController@index');
    Route::post('targets/add','TargetController@store');
    Route::post('targets/edit/update/{id}','TargetController@update');
    Route::get('targets/downloadTargets','TargetController@downloadtargets');
    Route::get('targets/deactivate/{id}','TargetController@deactivate');


});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
