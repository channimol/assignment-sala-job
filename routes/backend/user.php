<?php

Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    Route::get('/list', 'Api\Admin\UserController@getListUsers')->name('list-users');
    Route::get('/{id}', 'Api\Admin\UserController@show')->name('show-user');
    Route::post('/create', 'Api\Admin\UserController@store')->name('create-user');
    Route::post('/update/{id}', 'Api\Admin\UserController@update')->name('update-user');
    Route::post('/delete/{id}', 'Api\Admin\UserController@delete')->name('delete-user');
});
