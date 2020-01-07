<?php

Auth::routes();

Route::get('{any}', 'AuthController@index')
    ->where('any', '.*')
    ->middleware('auth')
    ->name('home');
