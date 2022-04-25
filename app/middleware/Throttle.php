<?php

namespace app\middleware;

use  \xy_jx\Utils\Sundry;

class Throttle
{
    /**
     * 访问频率限制
     * @param \think\Request $request
     * @param \Closure $next
     * @return Response
     */
    public function handle($request, \Closure $next, $limit = 1, $time = 's', $prefix = '')
    {
        // 添加中间件执行代码
        if (!Sundry::restrict([], ($request->ip() . $prefix . $request->baseUrl()), $limit, $time)) \Api::fail('操作太频繁了', 429);

        //业务代码
        return $next($request);
    }
}