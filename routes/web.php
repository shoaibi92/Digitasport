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

Route::get('/', function () {
    return view('welcome');
});


Route::resource('assign', 'AssignController');


Auth::routes();
Route::get('get_members', 'AssignController@all_members');
Route::get('assing_to/{id}', 'AssignController@assign_to');
Route::put('assing/{maneger_id}/{user_id}', 'AssignController@assign');
Route::post('assing/register_user', 'AssignController@register_user');
Route::get('home', 'HomeController@index')->name('home');
