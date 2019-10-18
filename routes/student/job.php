<?php

Route::group(['prefix' => 'jobs', 'as' => 'jobs.'], function () {
    Route::get('/list', 'Api\Student\JobController@index')->name('list-jobs');
    Route::post('/apply', 'Api\Student\JobController@apply')->name('apply-job');
    Route::post('/bookmark', 'Api\Student\JobController@bookmark')->name('bookmark-job');

    Route::get('/list-apply', 'Api\Student\JobController@listApplied')->name('apply-job');
    Route::get('/list-bookmark', 'Api\Student\JobController@listBookmarks')->name('bookmark-job');
    Route::post('/remove-bookmark', 'Api\Student\JobController@removeBookmark')->name('bookmark-job');
});
