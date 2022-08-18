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

Route::middleware(['web'])->group(function () {


});

Route::middleware(['web'])->group(function () {

    Route::prefix('common_admin')->middleware(['managerAuth'])->group(function () {

        Route::middleware(['rbac'])->group(function () {

            $route_arr = [
                ['category','\CategoryController']
            ];

            foreach ($route_arr as $val){
                Route::get('/'.$val[0].'/index', 'Aphly\LaravelCommon\Controllers\Admin'.$val[1].'@index');
                Route::get('/'.$val[0].'/form', 'Aphly\LaravelCommon\Controllers\Admin'.$val[1].'@form');
                Route::post('/'.$val[0].'/save', 'Aphly\LaravelCommon\Controllers\Admin'.$val[1].'@save');
                Route::post('/'.$val[0].'/del', 'Aphly\LaravelCommon\Controllers\Admin'.$val[1].'@del');
            }

            Route::get('/category/ajax', 'Aphly\LaravelCommon\Controllers\Admin\CategoryController@ajax');
            Route::get('/category/show', 'Aphly\LaravelCommon\Controllers\Admin\CategoryController@show');

        });
    });

});
