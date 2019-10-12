<?php

Route::group(['prefix' => 'jobs', 'as' => 'jobs.'], function () {
    Route::get('/list', 'Api\Student\JobController@index')->name('list-jobs');
    Route::post('/apply', 'Api\Student\JobController@apply')->name('apply-job');
    Route::post('/bookmark', 'Api\Student\JobController@bookmark')->name('bookmark-job');
});
