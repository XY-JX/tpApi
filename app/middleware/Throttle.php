<?php

namespace app\middleware;
use  \xy_jx\Utils\Sundry;

class Throttle
{
    /**
     * 访问频率限制
     * @param $request
     * @param \Closure $next
     * @param int $limit 指定时间内可请求的次数
     * @param string $time 时间范围 s|m|h|d
     * @param string $prefix 分组和全局指定单独key
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, \Closure $next, int $limit = 3, string $time = 's', string $prefix = '')
    {
        $key = $prefix ?? md5($request->ip() . $prefix . $request->baseUrl());
        // 访问频率限制
        if (!Sundry::restrict([], $key, $limit, $time))
            \Api::fail('操作太频繁了', 429);

        //业务代码
        return $next($request);
    }

}