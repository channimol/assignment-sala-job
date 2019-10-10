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

Route::middleware('auth:api')->group(function () {

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        require(__DIR__ . '/backend/job.php');
        require(__DIR__ . '/backend/user.php');
    });

    Route::get('/user', 'Api\UserController@getUserInformation')->name('user-info');
    Route::get('/user/cvs', 'Api\Student\ProfileController@index')->name('user-cv');
});
