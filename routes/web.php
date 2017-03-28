<?php

Route::get('/', 'WelcomeController@index');

Auth::routes();

Route::get('home', 'HomeController@index');

/*
 * Recipes
 */
Route::get('recipe/create', 'RecipeController@create');
Route::post('recipe/store', 'RecipeController@store');
Route::get('recipe/{recipe}', 'RecipeController@show');
Route::get('recipe/{recipe}/update', 'RecipeController@edit');
Route::post('recipe/{recipe}/update', 'RecipeController@update');
Route::post('recipe/{recipe}/delete', 'RecipeController@destroy');

/*
 * Categories
 */
Route::get('recipe/category/{category}', 'CategoryController@show');
Route::get('category/create', 'CategoryController@create');
Route::post('category/store', 'CategoryController@store');
