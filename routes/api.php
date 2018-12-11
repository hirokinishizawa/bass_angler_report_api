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
    Route::get('/me', 'User\UserController@me');
    Route::get('/user', 'User\UserController@user');
    Route::get('/report', 'Report\ReportController@index')->name('report');
    Route::post('/report', 'Report\ReportController@post')->name('report-post');
    Route::get('/report/ranking', 'Report\ReportController@goodRanking')->name('report-goodRanking');
    Route::post('/report/upload', 'Report\ReportController@upload')->name('report-goodRanking');
    Route::get('/my-report', 'Report\ReportController@myReport')->name('my-report');
    Route::get('/report/{report}', 'Report\ReportController@show')->name('report-show');
    Route::post('/report/{report}/good', 'Report\GoodsController@store')->name('report-good-store');
    Route::post('/report/{report}/good/{good}', 'Report\GoodsController@destroy')->name('report-good-destroy');
});
