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
*/

Route::get('/', 'LearnController@index');
Route::post('/start', 'LearnController@store');

Route::get('/step-one', 'LearnController@stepReadText');
Route::post('/step-one', 'LearnController@checkStepReadText');

Route::get('/step-two', 'LearnController@stepSumNumber');
Route::post('/step-two', 'LearnController@checkStepSumNumber');

Route::get('/step-three', 'LearnController@stepProgrammingLanguages');
Route::post('/step-three', 'LearnController@checkProgrammingLanguages');

Route::get('/step-four', 'LearnController@stepDayIsToday');
Route::post('/step-four', 'LearnController@checkDayIsToday');

Route::get('/finish', 'LearnController@finish');

