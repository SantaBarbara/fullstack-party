<?php

Route::get('/', 'IndexController@index')->name('index');

Route::get('login/github', 'Auth\LoginController@redirectToProvider')->name('github-login');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback')->name('github-callback');
Route::get('login/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/issues', 'IssuesController@index')->name('issues');
