<?php

Route::get('/', 'RecipeController@index');

Auth::routes();

/*
 * User
 */
Route::get('user/{user}/recipes', 'UserController@recipes');

/*
 * Recipes
 */
Route::get('recipe/create', 'RecipeController@create');
Route::post('recipe/store', 'RecipeController@store');
Route::get('recipe/{recipe}', 'RecipeController@show');
Route::get('recipe/{recipe}/update', 'RecipeController@edit');
Route::post('recipe/{recipe}/update', 'RecipeController@update');
Route::post('recipe/{recipe}/delete', 'RecipeController@destroy');
Route::get('print/recipe/{recipe}', 'PrintController@print');

/*
 * Categories
 */
Route::get('recipe/category/{category}', 'CategoryController@show');
Route::get('category/create', 'CategoryController@create');
Route::post('category/store', 'CategoryController@store');
