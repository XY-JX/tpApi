<?php

class Utils
{
    public static function redis($redis = 'redis'){
        return think\facade\Cache::store($redis)->handler();
    }
}