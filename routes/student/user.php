<?php


Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/cv', 'Api\Student\ProfileController@cv')->name('user-cv');
    Route::get('/profile', 'Api\Student\ProfileController@index')->name('user-profile');

    Route::post('/update-experience', 'Api\Student\ProfileController@updateWorkExperience')->name('user-experience');

    Route::post('/update-basic-info', 'Api\Student\ProfileController@updateBasicInformation')->name('user-info');

    Route::post('/update-skill', 'Api\Student\ProfileController@updateSkills')->name('user-skill');
    Route::post('/delete-skill/{id}', 'Api\Student\ProfileController@removeSkill')->name('user-skill');

    Route::post('/update-language', 'Api\Student\ProfileController@updateLanguage')->name('user-language');
    Route::post('/delete-language/{id}', 'Api\Student\ProfileController@removeLanguage')->name('user-language');
});
