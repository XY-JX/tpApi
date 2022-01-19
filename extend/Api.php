<?php

/**
 * code 可根据业务自行设置
 * 200    操作成功
 * 204    没有数据
 * 400    操作失败 错误
 * 401    用户未登录，或者token错误 header
 * 402    数据验证错误
 * 404    参数错误导致未找到资源（可能与权限有关）
 * 405    api地址错误 不存在
 * 407    Verify 请求验证失败 header
 * 429    过多请求 用户已经发送了太多的请求在指定的时间里。用于限制速率。
 * 500    服务器内部错误 （php 代码错误）
 * Class Api
 */
class Api
{
    /**
     * @param int $code 业务状态码
     * @param mixed $data 返回数据{}/[]
     * @param string $msg 返回描述
     */
    private static function return(int $code = 200, $data = [], string $msg = 'success')
    {
        $json = [
            'code' => $code,
            'data' => $data,
            'msg' => $msg,
        ];
        if (config('app.is_it_encrypted')) {
            $Openssl = new \xy_jx\Utils\Openssl();
            $json = $Openssl::encrypt($json);//私钥加密
        }
        throw new \think\exception\HttpResponseException(json($json));
    }

    /**
     * 成功 success
     * @param mixed $data
     * @param int $code
     * @param string $msg
     */
    public static function success($data = [], int $code = 200, string $msg = 'success')
    {
        return self::return($code, $data, $msg);
    }

    /**
     * 失败 fail
     * @param string $msg
     * @param int $code
     * @param mixed $data
     */
    public static function error(string $msg = 'fail', int $code = 400, $data = [])
    {
        return self::return($code, $data, $msg);
    }
}