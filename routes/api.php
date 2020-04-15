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

        Route::get('all-categories', 'CategoryController@getAllCategories')->name('get-all-categories');
        Route::get('all-areas', 'AreaController@getAllAreas')->name('get-all-areas');
        Route::get('room-tree', 'RoomController@tree')->name('room-tree');


        // 以下是基础结构里面， RESTFUL格式的增删改查，查询列表全部使用分页的方式。
        Route::get('rooms', 'RoomController@index')->name('rooms.index');
        Route::post('rooms', 'RoomController@store')->name('rooms.store');
        Route::get('rooms/{id}', 'RoomController@show')->name('rooms.show');
        Route::put('rooms/{id}', 'RoomController@update')->name('rooms.update');
        Route::delete('rooms/{id}', 'RoomController@delete')->name('rooms.delete');
        Route::patch('rooms/{id}', 'RoomController@restore')->name('rooms.restore');

        Route::get('areas', 'AreaController@index')->name('areas.index');
        Route::post('areas', 'AreaController@store')->name('areas.store');
        Route::get('areas/{id}', 'AreaController@show')->name('areas.show');
        Route::put('areas/{id}', 'AreaController@update')->name('areas.update');
        Route::delete('areas/{id}', 'AreaController@delete')->name('areas.delete');
        Route::patch('areas/{id}', 'AreaController@restore')->name('areas.restore');

        Route::get('categories', 'CategoryController@index')->name('categories.index');
        Route::post('categories', 'CategoryController@store')->name('categories.store');
        Route::get('categories/{id}', 'CategoryController@show')->name('categories.show');
        Route::put('categories/{id}', 'CategoryController@update')->name('categories.update');
        Route::delete('categories/{id}', 'CategoryController@delete')->name('categories.delete');
        Route::patch('categories/{id}', 'CategoryController@restore')->name('categories.restore');

        Route::get('people', 'PersonController@index')->name('people.index');

        Route::get('charge-rules', 'ChargeRuleController@index')->name('charge-rules.index');

        Route::get('fee-types', 'FeeTypeController@index')->name('fee-types.index');
    });
