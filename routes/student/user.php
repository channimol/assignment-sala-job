<?php


Route::group(['prefix' => 'users', 'as' => 'user.'], function () {
    Route::get('/cvs', 'Api\Student\ProfileController@index')->name('user-cv');
});
