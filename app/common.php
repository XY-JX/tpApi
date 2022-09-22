<?php
// 应用公共文件
if (!function_exists('get_ip')) {
    /**
     * 获取当前用户ip
     * @return string
     */
    function get_ip(): string
    {
        return request()->ip();
    }
}