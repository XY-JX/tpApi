<?php
//示例
use think\facade\Route;
Route::group('v1',function () {// api 版本
    Route::group(function () {  //需要登录
        Route::rule('api',  function (){
            \Api::success();
        });

    })->middleware(\app\middleware\Auth::class);



  Route::group(function () {  //不需要登录
      Route::rule('login', 'login/login');
      Route::rule('cs', function (){
          \Api::error('路由');
      });
  });
  Route::miss(function (){ //路由不存在
      \Api::error('api',405 );
  });
});

//Route::miss(function (){ //强制路由不存在
//    \Api::error('api',405 );
//});
