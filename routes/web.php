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

Route::GET('/', 'LearnController@index');
Route::POST('/start', 'LearnController@store');
Route::GET('/step-one', 'LearnController@stepOne');
Route::GET('/step-two', 'LearnController@stepTwo');
Route::GET('/step-three', 'LearnController@stepThree');
Route::GET('/step-four', 'LearnController@stepFour');
Route::GET('/finish', 'LearnController@finish');

