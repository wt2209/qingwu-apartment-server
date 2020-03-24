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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', 'Api\UserController@login')->name('api.auth.login');
Route::namespace('Api')
    ->name('api.')
    ->middleware('auth:api')
    ->group(function () {
        Route::post('/auth/logout', 'UserController@logout')->name('auth.logout');
        Route::get('/users/current-user', 'UserController@me')->name('users.me');
        Route::get('rooms', 'RoomController@index')->name('rooms.index');
        Route::post('rooms', 'RoomController@store')->name('rooms.store');
        Route::get('rooms/{id}', 'RoomController@show')->name('rooms.show');
    });
