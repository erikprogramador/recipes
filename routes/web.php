<?php

Route::get('/', 'WelcomeController@index');

Auth::routes();

Route::get('home', 'HomeController@index');
Route::get('recipe/create', 'RecipeController@create');
Route::post('recipe/store', 'RecipeController@store');
Route::get('recipe/{recipe}', 'RecipeController@show');
