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

//Pages
Route::get('/overview', 'PagesController@overview')->middleware('auth');
Route::get('/sales', 'PagesController@sales')->middleware('auth');
Route::get('/suppliers', 'PagesController@suppliers')->middleware('auth');
Route::get('/inventory', 'PagesController@inventory')->middleware('auth');
Route::get('/financial', 'PagesController@financial')->middleware('auth');
Route::get('overview', 'OverviewController@getLaraChart')->middleware('auth');


Route::resource('posts', 'PostsController');
Route::resource('saft', 'SaftController');

Route::get('/sales/{id}','PagesController@getDetails')->name('sales.info');
Route::get('/sales/product/{name}', 'PagesController@getProductDetails')->name('sales.product');
Route::get('/inventory/{name}', 'PagesController@getInfoProduct')->name('inventory.info');
Route::get('/suppliers/{id}','PagesController@getSupDetails')->name('suppliers.info');
Route::get('/suppliers/product/{name}', 'PagesController@getProductSupDetails')->name('suppliers.product');

Route::get('/getYearSales','OverviewController@getYearSales');
//Route::get('/getYearSupplies','OverviewController@getYearSupplies');


Route::post('/postajax','AjaxController@graphsData');
Route::post('/postajaxRound','AjaxController@roundGraphsData');
Route::post('/postajaxRoundStock','AjaxController@roundGraphsStock');
Route::post('/store', 'SaftController@store')->name('file.store');

Auth::routes();

Route::get('/home', 'HomeController@index');
