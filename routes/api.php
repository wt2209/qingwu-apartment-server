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
        Route::post('file-upload', 'UploadController@upload')->name('file.upload');
        Route::delete('file-remove', 'UploadController@remove')->name('file.remove');

        Route::post('/auth/logout', 'UserController@logout')->name('auth.logout');
        Route::get('/users/current-user', 'UserController@me')->name('users.me');

        Route::get('all-categories', 'CategoryController@getAllCategories')->name('get-all-categories');
        Route::get('all-areas', 'AreaController@getAllAreas')->name('get-all-areas');
        Route::get('room-tree', 'RoomController@tree')->name('room-tree');
        Route::get('all-fee-types', 'FeeTypeController@getAllFeeTypes')->name('all-fee-types');
        Route::get('all-charge-rules', 'ChargeRuleController@getAllChargeRules')->name('all-charge-rules');
        Route::get('all-companies', 'CompanyController@getAllCompanies')->name('all-companies');
        Route::get('one-company', 'CompanyController@getOneCompany')->name('one-company');
        Route::get('one-person', 'PersonController@getOnePerson')->name('one-person');

        Route::get('livings/moves/{personId}', 'LivingController@getMoveList')->name('livings.moveList');
        Route::get('livings/renames/{companyId}', 'LivingController@getRenameList')->name('livings.renameList');
        Route::get('livings/renews/{recordId}', 'LivingController@getRenewList')->name('livings.renewList');
        Route::get('livings/{id}', 'LivingController@getOneLiving')->name('livings.one');
        Route::get('livings', 'LivingController@index')->name('livings.index');
        Route::post('livings', 'LivingController@store')->name('livings.store');
        Route::put('livings/{id}', 'LivingController@update')->name('livings.update');
        Route::patch('livings/rename/{companyId}', 'LivingController@rename')->name('livings.rename');
        Route::patch('livings/renew/{id}', 'LivingController@renew')->name('livings.renew');
        Route::patch('livings/{id}', 'LivingController@move')->name('livings.move');
        Route::delete('livings/{id}', 'LivingController@quit')->name('livings.quit');

        Route::get('bills', 'BillController@index')->name('bills.index');

        Route::get('statistics/living', 'StatisticController@living')->name('statistics/living');

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
        Route::post('charge-rules', 'ChargeRuleController@store')->name('charge-rules.store');
        Route::put('charge-rules/{id}', 'ChargeRuleController@update')->name('charge-rules.update');
        Route::delete('charge-rules/{id}', 'ChargeRuleController@delete')->name('charge-rules.delete');
        Route::patch('charge-rules/{id}', 'ChargeRuleController@restore')->name('charge-rules.restore');

        Route::get('fee-types', 'FeeTypeController@index')->name('fee-types.index');
        Route::post('fee-types', 'FeeTypeController@store')->name('fee-types.store');
        Route::put('fee-types/{id}', 'FeeTypeController@update')->name('fee-types.update');
        Route::delete('fee-types/{id}', 'FeeTypeController@delete')->name('fee-types.delete');
        Route::patch('fee-types/{id}', 'FeeTypeController@restore')->name('fee-types.restore');

        Route::get('records', 'RecordController@index')->name('records.index');

        Route::get('companies', 'CompanyController@index')->name('company.index');

        Route::get('renews', 'RenewController@index')->name('renews.index');

        Route::get('renames', 'CompanyRenameController@index')->name('renames.index');
    });
