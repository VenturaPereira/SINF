<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/users/{id}', function ($id, $name) {
    return 'This is user '.$name.'with an id of '.$id;
});*/


Route::get('/index', 'PagesController@index');
Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');

//Pages
Route::get('/overview', 'PagesController@overview');
Route::get('/sales', 'PagesController@sales');
Route::get('/suppliers', 'PagesController@suppliers');
Route::get('/inventory', 'PagesController@inventory');
Route::get('/financial', 'PagesController@financial');


Route::resource('posts', 'PostsController');
