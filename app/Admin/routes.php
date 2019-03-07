<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('/goods',GoodsController::class);
    $router->resource('/users',UsersController::class);
    $router->resource('/weixin',WeixinController::class);
    $router->resource('/media',WxMediaController::class);

    $router->get('/sendmsg','WeixinController@sendMsgView');
    $router->post('/sendmsg','WeixinController@sendMsg');



});
