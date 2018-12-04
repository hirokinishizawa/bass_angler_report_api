<?php


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


Route::post('register', 'AuthController@register')->name('register');
Route::post('login', 'AuthController@login')->name('login');

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/me', 'User\AuthController@me');
    Route::get('/user', 'User\AuthController@user');
    Route::get('/report', 'Report\ReportController@index')->name('report');
    Route::post('/report', 'Report\ReportController@post')->name('report-post');
    Route::get('/my-report', 'Report\ReportController@myReport')->name('my-report');
});
