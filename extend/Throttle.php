<?php

class Throttle
{

    protected static $duration = [
        's' => 1,
        'm' => 60,
        'h' => 3600,
        'd' => 86400,
    ];

    /**
     * @param string $key ip|uid
     * @param int $limit 限制次数
     * @param string $time 时间范围
     */
    public static function restrict(string $key, int $limit = 3, string $time = 's')
    {
        $redis = \Utils::redis();
        $key = 'throttle_:' . $key . '_count';
        $count = $redis->get($key);
        if ($count) {
            $redis->incr($key);  //键值递增
            if ($count + 1 > $limit) {
                \Api::error('访问限制!', 429);
            }
        } else {
            $redis->set($key, 1, ['nx', 'ex' => self::$duration[$time]]);
        }
    }

}