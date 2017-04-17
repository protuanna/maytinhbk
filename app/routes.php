<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('prefix' => '', 'before' => ''), function () {
    Route::get('/', array('as' => 'site.home', 'uses' => 'SiteController@home'));
});

Route::group(array('prefix' => 'admin', 'before' => ''), function () {
    /*****************************login,logout****************************/
    Route::get('login/{url?}', array('as' => 'admin.login', 'uses' => 'LoginController@loginInfo'));
    Route::post('login/{url?}', array('as' => 'admin.login', 'uses' => 'LoginController@login'));
    Route::get('logout', array('as' => 'admin.logout', 'uses' => 'LoginController@logout'));
    /*****************************màn hình chính**************************/
    Route::get('dashboard', array('as' => 'admin.dashboard', 'uses' => 'DashBoardController@dashboard'));
    /*****************************thông tin tài khoản*********************/
    Route::get('user/view', array('as' => 'admin.user_view', 'uses' => 'UserController@view'));
    Route::get('user/create', array('as' => 'admin.user_create', 'uses' => 'UserController@createInfo'));
    Route::post('user/create', array('as' => 'admin.user_create', 'uses' => 'UserController@create'));
    Route::get('user/edit/{id}', array('as' => 'admin.user_edit', 'uses' => 'UserController@editInfo'))->where('id', '[0-9]+');
    Route::post('user/edit/{id}', array('as' => 'admin.user_edit', 'uses' => 'UserController@edit'))->where('id', '[0-9]+');
    Route::get('user/change/{id}', array('as' => 'admin.user_change', 'uses' => 'UserController@changePassInfo'));
    Route::post('user/change/{id}', array('as' => 'admin.user_change', 'uses' => 'UserController@changePass'));
    Route::post('user/remove/{id}', array('as' => 'admin.user_remove', 'uses' => 'UserController@remove'));
    /*****************************quản lý Sản Phẩm*********************/
    Route::get('product/view', array('as' => 'admin.product_list', 'uses' => 'ProductController@index'));
    Route::get('product/getCreate/{id?}', array('as' => 'admin.product_edit', 'uses' => 'ProductController@getCreate'));
    Route::post('product/getCreate/{id?}', array('as' => 'admin.product_edit_post', 'uses' => 'ProductController@postCreate'));
    /*****************************quản lý danh mục*********************/
    Route::get('category/view', array('as' => 'admin.category_list', 'uses' => 'CategoryController@index'));
    Route::get('category/getCreate/{id?}', array('as' => 'admin.category_edit', 'uses' => 'CategoryController@getCreate'));
    Route::post('category/getCreate/{id?}', array('as' => 'admin.category_edit_post', 'uses' => 'CategoryController@postCreate'));
});