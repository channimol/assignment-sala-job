<?php

use App\Mail\SendMail;
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

    Route::group(['prefix' => 'student', 'as' => 'student.'], function () {
        require(__DIR__ . '/student/job.php');
        require(__DIR__ . '/student/user.php');
    });


    Route::get('/user', 'Api\UserController@getUserInformation')->name('user-info');
    Route::get('/departments', 'Api\DepartmentController@index')->name('departments');
    Route::get('/languages', 'Api\LanguageController@index')->name('languages');
    Route::get('/logout', 'Api\UserController@logout')->name('logout');
    Route::get('/upload', 'Api\UploadController@upload')->name('upload');


    Route::post('/job/apply/send', 'Api\SendMailController@SendMail')->name('send-email');
});
