<?php

class Utils
{
    public static function redis($redis = 'redis'): ?object
    {
        return think\facade\Cache::store($redis)->handler();
    }
}