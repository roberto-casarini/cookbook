<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->group(function () {
    Route::post('/recipes', 'RecipeController@store');
});

