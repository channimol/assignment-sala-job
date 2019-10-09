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
    Route::get('/admin/users/list', 'Api\Admin\UserController@getListUsers')->name('list-users');
    Route::get('/admin/jobs/list', 'Api\Admin\JobController@getListJobs')->name('list-jobs');
    Route::post('/admin/jobs/create', 'Api\Admin\JobController@store')->name('store-jobs');
    Route::get('/user', 'Api\UserController@getUserInformation')->name('user-info');
});
