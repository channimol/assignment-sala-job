<?php

Route::group(['prefix' => 'jobs', 'as' => 'jobs.'], function () {
    Route::get('/list', 'Api\Admin\JobController@getListJobs')->name('list-jobs');
    Route::get('/{id}', 'Api\Admin\JobController@show')->name('show-job');
    Route::post('/create', 'Api\Admin\JobController@store')->name('store-job');
    Route::post('/update/{id}', 'Api\Admin\JobController@update')->name('update-job');
    Route::post('/delete/{id}', 'Api\Admin\JobController@delete')->name('delete-job');
});
