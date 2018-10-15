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
    return view('home.index');
});


//后台的登录页面
Route::any('admin/login', 'Admin\LoginController@login');
Route::any('admin/dologin', 'Admin\LoginController@dologin');
Route::any('admin/cap', 'Admin\LoginController@captcha');

//后台管理
Route::group(['middleware'=>['adminlogin','roleper']], function(){

	//后台首页
	Route::any('admin', 'Admin\IndexController@index');
	//Route::post('admin/user/xiugai_touxiang/{id}','Admin\LoginController@xiugai_touxiang');
	
	//后台角色
	Route::resource('/admin/role','Admin\RoleController');
	Route::any('/admin/role_per/{id}','Admin\RoleController@role_per');
	Route::any('/admin/do_role_per','Admin\RoleController@do_role_per');

	//后台的权限
	Route::resource('/admin/permission','Admin\PermissionController');


	//后台的用户模块
	Route::resource('admin/user', 'Admin\UserController');
	Route::any('admin/user_role/{id}', 'Admin\UserController@user_role');
	Route::any('admin/do_user_role', 'Admin\UserController@do_user_role');


	//后台的分类模块
	Route::resource('admin/category', 'Admin\CategoryController');
	//后台的商品管理模块
	Route::resource('admin/goods', 'Admin\GoodsController');


	//修改头像
	Route::any('admin/profile','Admin\LoginController@profile');
	Route::any('admin/doprofile','Admin\LoginController@doprofile');

	//修改密码
	Route::any('admin/pass','Admin\LoginController@pass');
	Route::any('admin/dopass','Admin\LoginController@dopass');

	// //退出后台
	Route::any('admin/logout','Admin\LoginController@logout');

});

Route::any('home/gren', 'Home\GrenController@gren');
//前台管理
Route::group([],function(){

});

