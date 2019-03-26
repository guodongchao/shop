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

Route::get('/', 'Index\IndexController@index')->middleware('check.login');


Route::any('/adduser','User\UserController@add');
Route::post('/abc','User\UserController@abc');
Route::post('/abcd','User\UserController@abcd');
Route::get('/centre','User\UserController@centre');


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
Route::any('/check_cookie','Test\TestController@checkCookie');

Route::any('/goods2/list','Goods\GoodsController@goods2');   //商品展示


//用户注册
Route::any('/userreg','User\UserController@reg');
Route::any('/regadd','User\UserController@regadd');


//用户登录
Route::any('/login','User\UserController@login');
Route::any('/loginadd','User\UserController@loginadd');

//个人中心
Route::any('/center','User\UserController@center');
//购物车
Route::any('/cart','Cart\CartController@index');
Route::any('/cart/add/{goods_id}','Cart\CartController@add');  //商品添加
Route::any('/cart/add2/','Cart\CartController@add2');      //添加商品
Route::any('/cart/del/{goods_id}','Cart\CartController@del');  //删除商品
Route::any('/cart/del2/{cart_id}','Cart\CartController@del2');  //删除商品

//商品
Route::any('/goods/{goods_id}','Goods\GoodsController@goods');   //商品详情


////添加订单
Route::any('/order','Order\OrderController@add'); //订单
//订单展示
Route::any('/order/list','Order\OrderController@list');   //订单展示
//支付展示

Route::any('/order/payment/{order_id}','Order\OrderController@payment');   //订单支付

//订单支付成功
Route::any('/order/payments/{order_id}/{type}','Order\OrderController@payments'); //订单支付成功
Route::any('/alipay','Alipay\AlipayController@alipay'); //订单支付成功

Route::post('/alipay2/notify','Pay\AlipayController@aliNotify');        //支付宝支付 异步通知回调
Route::get('/alipay2/return','Pay\AlipayController@aliReturn');        //支付宝支付 同步通知回调



//支付
Route::any('/alipay/{order_id}','Pay\AlipayController@pay');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/update','Goods\GoodsController@file');
Route::post('/update/inse','Goods\GoodsController@fileInse');


//微信
Route::get('/weixin/test','Weixin\WeixinController@test');
Route::get('/weixin/valid','Weixin\WeixinController@validToken');
Route::get('/weixin/valid1','Weixin\WeixinController@validToken1');
//Route::post('/weixin/valid1','Weixin\WeixinController@wxEvent');
Route::post('/weixin/valid1','Weixin\LaravelController@wxEvent');  //接收微信服务器事件推送
Route::get('/weixin/black/{id}','Weixin\LaravelController@black');  //根据id获取拉人黑名单
Route::get('/weixin/labeladd/{id}','Weixin\LaravelController@labeladd');  //根据id打标签
Route::get('/weixin/label','Weixin\LaravelController@label');  //创建标签

Route::post('/weixin/valid','Weixin\WeixinController@validToken');

Route::get('/weixin/create_menu','Weixin\WeixinController@createMenu');     //创建菜单
Route::get('/weixin/qun','Weixin\WeixinController@all');     //创建菜单

Route::get('/form/show','Weixin\WeixinController@formShow');     //表单测试
Route::post('/form/test','Weixin\WeixinController@formTest');     //表单测试

Route::get('/weixin/material/list','Weixin\WeixinController@materialList');     //获取永久素材列表
Route::get('/weixin/material/upload','Weixin\WeixinController@upMaterial');     //上传永久素材
Route::post('/weixin/material','Weixin\WeixinController@materialTest');     //创建菜单

//微信聊天
Route::get('/weixin/kefu/chat','Weixin\WeixinController@chatView');     //客服聊天
Route::get('/weixin/chat/get_msg','Weixin\WeixinController@getChatMsg');     //获取用户聊天信息
Route::get('/weixin/chat/get_msgs','Weixin\WeixinController@getChatMsgs');     //获取客服聊天信息


//微信支付
Route::get('/weixin/pay/test/{order_sn}','Weixin\PayController@test');     //微信支付测试
Route::post('/weixin/pay/notice','Weixin\PayController@notice');     //微信支付通知回调
Route::get('/weixin/pay/qr/{code_url}','Weixin\PayController@qr');     //微信支付通知回调


Route::get('/wechat/pay/wxsuccess','Weixin\PayController@WxSuccess');     //微信支付通知回调


//微信登录
Route::get('/weixin/login','Weixin\WeixinController@login');        //微信登录
Route::get('/weixin/getcode','Weixin\WeixinController@getCode');        //接收code

Route::get('/weixin/jssdk/test','Weixin\WeixinController@jssdkTest');       // 测试


Route::get('/api/test','Weixin\WeixinController@tests');       // 批量pull
Route::post('/halou','Weixin\WeixinController@halou');       // 批量pull



