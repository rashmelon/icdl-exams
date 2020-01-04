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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('category/{id}', 'CategoryController@update');
Route::resource('category', 'CategoryController');

Route::post('skills-card/{id}', 'SkillsCardController@update');
Route::resource('skills-card', 'SkillsCardController');

Route::post('subject/{id}', 'SubjectController@update');
Route::resource('subject', 'SubjectController');

Route::post('candidate/{id}', 'CandidateController@update');
Route::resource('candidate', 'CandidateController');

Route::post('exam/{id}', 'ExamController@update');
Route::resource('exam', 'ExamController');

Route::post('reservation/{id}', 'ReservationController@update');
Route::resource('reservation', 'ReservationController');
