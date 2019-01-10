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

Route::any('/adduser','User\UserController@add');

//路由跳转
Route::redirect('/hello1','/world1',301);
Route::any('/world1','Test\TestController@world1');

Route::any('hello2','Test\TestController@hello2');
Route::any('world2','Test\TestController@world2');


//路由参数
Route::any('/user/test','User\UserController@test');
Route::any('/user/{uid}','User\UserController@user');
Route::any('/month/{m}/date/{d}','Test\TestController@md');
Route::any('/name/{str?}','Test\TestController@showName');



// View视图路由
Route::view('/mvc','mvc');
Route::view('/error','error',['code'=>40300]);


// Query Builder
Route::any('/query/get','Test\TestController@query1');
Route::any('/query/where','Test\TestController@query2');


//Route::match(['get','post'],'/test/abc','Test\TestController@abc');
Route::any('/test/abc','Test\TestController@abc');


Route::any('/view/test1','Test\TestController@viewTest1');
Route::any('/view/test2','Test\TestController@viewTest2');
Route::any('/check_cookie','Test\TestController@checkCookie')->middleware('check.cookie');//中间价测试


//用户注册
Route::any('/userreg','User\UserController@reg');
Route::any('/regadd','User\UserController@regadd');


//用户登录
Route::any('/login','User\UserController@login');
Route::any('/loginadd','User\UserController@loginadd');

//个人中心
Route::any('/center','User\UserController@center');
//购物车
Route::any('/cart','Cart\CartController@index')->middleware('check.login.token');
Route::any('/cart/add/{goods_id}','Cart\CartController@add')->middleware('check.login.token');  //商品添加
Route::any('/cart/add2/','Cart\CartController@add2')->middleware('check.login.token');      //添加商品
Route::any('/cart/del/{goods_id}','Cart\CartController@del')->middleware('check.login.token');  //删除商品
Route::any('/cart/del2/{goods_id}','Cart\CartController@del2')->middleware('check.login.token');  //删除商品

//商品
Route::any('/goods/{goods_id}','Goods\GoodsController@goods')->middleware('check.login.token');   //商品详情

Route::any('/goods2/list','Goods\GoodsController@goods2')->middleware('check.login.token');   //商品展示
//添加订单
Route::any('/order','Order\OrderController@add')->middleware('check.login.token');  ;  //订单
//订单展示
Route::any('/order/list','Order\OrderController@list')->middleware('check.login.token');   //订单展示
//支付展示
Route::any('/order/payment/{order_id}','Order\OrderController@payment')->middleware('check.login.token');   //订单支付
//订单支付成功
Route::any('/order/payments/{order_id}/{type}','Order\OrderController@payments'); //订单支付成功






