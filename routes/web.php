<?php

use Illuminate\Support\Facades\Route;

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


Route::get('view-list-users','App\Http\Controllers\User\UserController@viewListUser');
Route::get('view-create-user','App\Http\Controllers\User\UserController@viewCreateUser');

Route::post('create-users', [ 'as' => 'users.create', 'uses' => 'App\Http\Controllers\User\UserController@createUser']);
Route::post('edit-users/{id}',['uses' => 'App\Http\Controllers\User\UserController@editUser', 'as' => 'users.edit']);
Route::get('delete-users/{id}',['uses' => 'App\Http\Controllers\User\UserController@deleteUser', 'as' => 'users.delete']);
Route::get('view-edit-users/{id}',['uses' => 'App\Http\Controllers\User\UserController@viewEditUser', 'as' => 'users.viewEdit']);