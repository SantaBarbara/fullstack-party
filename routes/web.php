<?php

Route::get('/', 'IndexController@index')->name('index');
Route::get('/', 'IndexController@index')->name('login');

Route::get('login/github', 'Auth\LoginController@redirectToProvider')->name('github.login');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback')->name('github.callback');
Route::get('login/logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => ['auth'], 'prefix' => 'issues'], function () {
    Route::get('/', 'IssuesController@index')->name('issues');
    Route::get('/count', 'IssuesController@count')->name('issues.count');
    Route::get('/{username}/{repository}/{issue_id}', 'IssuesController@show')->name('issues.show');
    Route::get('/filter', 'IssuesController@filter')->name('issues.filter');
});
