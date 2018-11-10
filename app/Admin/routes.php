<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('movies', MovieController::class);//客户信息
    $router->resource('archives', ArchivesController::class);//学员档案
    $router->resource('visiting', VisitingController::class);//来访信息
    $router->resource('channel', ChannelController::class);//来源渠道
    $router->resource('statistical', StatisticalController::class);//数据统计
    $router->resource('spending', SpendingController::class);//来源渠道

    $router->resource('financial', FinancialController::class);//财务系统

    $router->get('movies/{id}/list', 'MovieController@lists');//客户信息详情




    $router->get('archives/{id}/list', 'ArchivesController@lists');//学员档案信息详情

    $router->get('archives/{id}/network', 'ArchivesController@network');//学员档案数据

    $router->get('financial/{id}/network', 'FinancialController@network');//财务数据月报数据






});
