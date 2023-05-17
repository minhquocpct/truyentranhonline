<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route account
Route::post('login', 'Api\AuthController@login');
Route::post('signup', 'Api\AuthController@signup');
Route::get('logout','Api\AuthController@logout');
Route::post('reset-password', 'Api\AuthController@sendMail');
Route::post('edit', 'Api\AuthController@edit');
//Route list
Route::get('list','Api\ListController@list');
Route::get('category','Api\ListController@category');
Route::post('search','Api\ListController@search');
Route::post('manga','Api\ListController@manga');
Route::post('comment','Api\ListController@comment');
Route::post('chap','Api\ListController@chap');
Route::post('check','Api\ListController@check');
