<?php


namespace app\controller;


class Error
{
    /**
     * 控制器不存在
     * @param $method
     * @param $args
     */
    public function __call($method, $args)
    {
        \Api::error('资源不存在', 404);
    }
}