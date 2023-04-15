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
    //oauth
    Route::get('oauth/{service}','Aphly\LaravelCommon\Controllers\Front\OAuthController@redirectToProvider')->name('oauth');
    Route::get('oauth/{service}/callback','Aphly\LaravelCommon\Controllers\Front\OAuthController@handleProviderCallback')->name('oauthCallback');
    //currency
    Route::get('currency/{id}', 'Aphly\LaravelCommon\Controllers\Front\CurrencyController@ajax')->where('id', '[0-9]+');
    //country
    Route::get('country/{id}/zone', 'Aphly\LaravelCommon\Controllers\Front\CountryController@zone')->where('id', '[0-9]+');
    //checkout
    Route::get('checkout/success', 'Aphly\LaravelCommon\Controllers\Front\CheckoutController@success');
    Route::get('checkout/fail', 'Aphly\LaravelCommon\Controllers\Front\CheckoutController@fail');
    //news
    Route::match(['get'],'news/{id}', 'Aphly\LaravelCommon\Controllers\Front\NewsController@detail')->where('id', '[0-9]+');

    //Subscribe
    Route::post('subscribe/ajax', 'Aphly\LaravelCommon\Controllers\Front\AccountExt\SubscribeController@ajax');

    //404
    Route::get('404', 'Aphly\LaravelCommon\Controllers\Front\NotfoundController@index');

    Route::prefix('account')->group(function () {
        Route::match(['get'],'autologin/{token}', 'Aphly\LaravelCommon\Controllers\Front\AccountController@autoLogin');

        Route::match(['get'],'blocked', 'Aphly\LaravelCommon\Controllers\Front\AccountController@blocked')->name('blocked');
        Route::match(['get'],'email-verify', 'Aphly\LaravelCommon\Controllers\Front\AccountController@emailVerify')->name('emailVerify');
        Route::match(['get'],'email-verify/send', 'Aphly\LaravelCommon\Controllers\Front\AccountController@emailVerifySend');
        Route::get('email-verify/{token}', 'Aphly\LaravelCommon\Controllers\Front\AccountController@emailVerifyCheck');

        Route::match(['get', 'post'],'forget', 'Aphly\LaravelCommon\Controllers\Front\AccountController@forget');
        Route::match(['get'],'forget/confirmation', 'Aphly\LaravelCommon\Controllers\Front\AccountController@forgetConfirmation');
        Route::match(['get', 'post'],'forget-password/{token}', 'Aphly\LaravelCommon\Controllers\Front\AccountController@forgetPassword');

        Route::get('logout', 'Aphly\LaravelCommon\Controllers\Front\AccountController@logout');

        Route::middleware(['userAuth'])->group(function () {
            Route::match(['get', 'post'],'register', 'Aphly\LaravelCommon\Controllers\Front\AccountController@register')->name('register');
            Route::match(['get', 'post'],'login', 'Aphly\LaravelCommon\Controllers\Front\AccountController@login')->name('login');

            Route::match(['get', 'post'],'index', 'Aphly\LaravelCommon\Controllers\Front\AccountController@index');
            Route::match(['get', 'post'],'group', 'Aphly\LaravelCommon\Controllers\Front\AccountController@group');
            Route::match(['get', 'post'],'credit', 'Aphly\LaravelCommon\Controllers\Front\AccountController@credit');
            Route::match(['post'],'checkin', 'Aphly\LaravelCommon\Controllers\Front\AccountController@checkin');

        });
    });

    Route::prefix('account_ext')->group(function () {
        Route::middleware(['userAuth'])->group(function () {

            Route::get('address', 'Aphly\LaravelCommon\Controllers\Front\AccountExt\AddressController@index');
            Route::match(['get', 'post'],'address/save', 'Aphly\LaravelCommon\Controllers\Front\AccountExt\AddressController@save');
            Route::get('address/{id}/remove', 'Aphly\LaravelCommon\Controllers\Front\AccountExt\AddressController@remove')->where('id', '[0-9]+');

            Route::match(['get', 'post'],'subscribe', 'Aphly\LaravelCommon\Controllers\Front\AccountExt\SubscribeController@index');

            Route::get('review/index', 'Aphly\LaravelCommon\Controllers\Front\AccountExt\ReviewController@index');

        });
    });


    //api/upload
    Route::match(['post'],'news/img', 'Aphly\LaravelCommon\Controllers\Front\NewsController@imgs');

});

Route::middleware(['web'])->group(function () {

    Route::prefix('common_admin')->middleware(['managerAuth'])->group(function () {

        Route::middleware(['rbac'])->group(function () {

            Route::get('user/index', 'Aphly\LaravelCommon\Controllers\Admin\UserController@index');
            Route::match(['get', 'post'],'user/{uuid}/edit', 'Aphly\LaravelCommon\Controllers\Admin\UserController@edit')->where('uuid', '[0-9]+');
            Route::match(['get', 'post'],'user/{uuid}/password', 'Aphly\LaravelCommon\Controllers\Admin\UserController@password')->where('uuid', '[0-9]+');
            Route::post('user/del', 'Aphly\LaravelCommon\Controllers\Admin\UserController@del');
            Route::match(['get', 'post'],'user/{uuid}/credit', 'Aphly\LaravelCommon\Controllers\Admin\UserController@credit')->where('uuid', '[0-9]+');
            Route::match(['get', 'post'],'user/{uuid}/avatar', 'Aphly\LaravelCommon\Controllers\Admin\UserController@avatar')->where('uuid', '[0-9]+');

            $route_arr = [
                ['group','\GroupController'],['credit_price','\CreditPriceController'],['user_credit_log','\UserCreditLogController'],['user_credit_order','\UserCreditOrderController'],
                ['user_group_order','\UserGroupOrderController'],['user_address','\UserAddressController'],['news','\NewsController'],['filter','\FilterController'],
                ['country','\CountryController'],['geo','\GeoController'],['zone','\ZoneController'],['currency','\CurrencyController'],['subscribe','\SubscribeController']
            ];

            foreach ($route_arr as $val){
                Route::get($val[0].'/index', 'Aphly\LaravelCommon\Controllers\Admin'.$val[1].'@index');
                Route::get($val[0].'/form', 'Aphly\LaravelCommon\Controllers\Admin'.$val[1].'@form');
                Route::post($val[0].'/save', 'Aphly\LaravelCommon\Controllers\Admin'.$val[1].'@save');
                Route::post($val[0].'/del', 'Aphly\LaravelCommon\Controllers\Admin'.$val[1].'@del');
            }

            Route::get('filter/ajax', 'Aphly\LaravelCommon\Controllers\Admin\FilterController@ajax');
            Route::get('category/ajax', 'Aphly\LaravelCommon\Controllers\Admin\CategoryController@ajax');
            Route::get('category/show', 'Aphly\LaravelCommon\Controllers\Admin\CategoryController@show');
            Route::get('links/show', 'Aphly\LaravelCommon\Controllers\Admin\LinksController@show');
            Route::get('news_category/show', 'Aphly\LaravelCommon\Controllers\Admin\NewsCategoryController@show');

			$route_arr = [
				['category','\CategoryController'],['news_category','\NewsCategoryController'],['links','\LinksController']
			];

			foreach ($route_arr as $val){
				Route::get($val[0].'/index', 'Aphly\LaravelCommon\Controllers\Admin'.$val[1].'@index');
				Route::match(['get', 'post'],$val[0].'/add', 'Aphly\LaravelCommon\Controllers\Admin'.$val[1].'@add');
				Route::match(['get', 'post'],$val[0].'/edit', 'Aphly\LaravelCommon\Controllers\Admin'.$val[1].'@edit');
				Route::post($val[0].'/del', 'Aphly\LaravelCommon\Controllers\Admin'.$val[1].'@del');
			}
        });
    });

});
