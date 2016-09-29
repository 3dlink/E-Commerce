<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'StartController@welcome');

Route::get('tree/{id}',[
    'uses'  =>  'GroupsController@get_tree'
]);
Route::get('detail/{id}', [
    'uses'  =>  "StartController@item_detail",
    'as'    =>  'index.item'
]);

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
	Route::get('/', [
		'uses' 	=>	'HomeController@index',
		'as'	=>	'admin.index'
	]);

	Route::resource('items', 'ItemsController');

	Route::get('items/{id}/destroy', [
    	'uses'	=>	'ItemsController@destroy',
    	'as'	=>	'items.destroy'
    ]);

    Route::post('upload', [
    	'uses'	=>	'HomeController@upload',
    	'as'	=>	'img.upload'
    ]);

	Route::resource('categories', 'CategoriesController');

	Route::get('categories/{id}/destroy', [
    	'uses'	=>	'CategoriesController@destroy',
    	'as'	=>	'categories.destroy'
    ]);

    Route::resource('groups', 'GroupsController');

    Route::get('groups/{id}/destroy', [
        'uses'  =>  'GroupsController@destroy',
        'as'    =>  'groups.destroy'
    ]);
});