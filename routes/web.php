<?php

Route::get('/', 'IndexController@index')->name('index');

Route::get('login/github', 'Auth\LoginController@redirectToProvider')->name('github.login');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback')->name('github.callback');
Route::get('login/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/issues', 'IssuesController@index')->name('issues');
Route::get('/issues/count', 'IssuesController@count')->name('issues.count');
Route::get('/issues/{username}/{repository}/{issue_id}', 'IssuesController@show')->name('issues.show');
Route::get('/issues/filter', 'IssuesController@filter')->name('issues.filter');
