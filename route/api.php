<?php

/**
 * 示例
 * 请求方式可以只用get和post两种方式
 */

use think\facade\Route;

Route::group('v1', function () {// api 版本
    Route::group(function () {  //需要登录
        Route::get('api', function () {
            \Api::success();
        });
        Route::group('user', function () {
            //用户列表
            Route::get('list', 'user.User/list');//分页命名必须是 list 或  *_list
            //用户信息详情
            Route::get('info', 'user.User/info');//详情命名必须是 info 或 show 或 details
            //用户新增
            Route::post('add', 'user.User/add');//新增命名 add 或 save 或 insert
            //用户信息修改
            Route::put('edit', 'user.User/edit');//修改命名必须是 edit 或 update
            //用户信息删除
            Route::delete('del', 'user.User/del');//删除名必须是 del 或 delete
            //用户组
            Route::get('all', 'user.User/all');//不分页命名必须是 all 或 arr 或 array


        });


    })->middleware(\app\middleware\Auth::class);


    Route::group(function () {  //不需要登录
        Route::post('login', 'login/login');//登录必须使用post 方式请求
        Route::get('cs', function () {
            \Api::fail('限流1分钟只能请求1次');
        })->middleware(\app\middleware\Throttle::class, 1, 'm');
    });
    Route::miss(function () { //路由不存在
        \Api::fail('api', 405);
    });
})->middleware(\app\middleware\Throttle::class, 2, 's', '_');//全局限流1秒中只能有2个请求

//Route::miss(function (){ //强制路由不存在
//    \Api::error('api',405 );
//});
