<?php

namespace app;

use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\Response;
use Throwable;

/**
 * 应用异常处理类
 */
class ExceptionHandle extends Handle
{
    /**
     * 不需要记录信息（日志）的异常类列表
     * @var array
     */
    protected $ignoreReport = [
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        DataNotFoundException::class,
        ValidateException::class,
    ];

    /**
     * 记录异常信息（包括日志或者其它方式记录）
     *
     * @access public
     * @param Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        // 使用内置的方式记录异常日志
        //parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        // 添加自定义异常处理机制
        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } else {
            $error = [
                'code' => $e->getCode(),
                'msg' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => [  //请求
                    'method' => $request->method(),
                    'pathinfo' => $request->pathinfo(),
                    'controller' => $request->controller(),
                    'action' => $request->action(),
                    'header' => $request->header(config('trace.monitor_header', 'Authorization'), ''),
                    'param' => $request->all()
                ]
            ];
            $request_id = uniqid();
            trace('[' . $request_id . ']' . json_encode($error), 'api');  //写入日志
            if (env('app_debug')) { //调试模式
                $error['request_id'] = $request_id;
                $error['trace'] = $e->getTrace();
                \Api::fail('Internal Server Error', 500, $error);
            } else {  //非调试模式
                \Api::fail('网络错误', 500, ['request_id' => $request_id]);
            }
        }
        // 其他错误交给系统处理
        return parent::render($request, $e);
    }
}
