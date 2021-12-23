<?php

namespace app\controller;

use app\BaseController;

class Index extends BaseController
{
    public function index()
    {
        \Api::success('ThinkPHP V' . \think\facade\App::version());
    }


    public function cs()
    {
        $cs = $this->getData([
            ['name', 9],
            ['age', 1],
            ['email', 'qq@qq.com'],
            ['data', 'aaaaaaaaaaaaa']
        ], [
            'name' => 'require|max:25',
            'age' => 'number|between:1,120',
            'email' => 'email',
        ], [
            'name.require' => '名称必须',
            'name.max' => '名称最多不能超过25个字符',
            'age.number' => '年龄必须是数字',
            'age.between' => '年龄必须在1~120之间',
            'email' => '邮箱格式错误',
        ]);
        \Api::success($cs);
        print_r($cs);
        return 'hello, world !';
    }

    public function cs2()
    {
        $this->getData(['name' => '55555'], [
            'name' => 'require|max:25'
        ]);
        return 'hello, world !';
    }

    public function cs1()
    {
        $cache = \Utils::redis();
        for ($i = 1; $i < 10; $i++) {
            $orderInfo = ['goods' => mt_rand(1, 10000), 'uid' => mt_rand(1, 20), 'num' => mt_rand(1, 5)];
            $cache->lPush('order:create:list', json_encode([
                'goods' => $orderInfo['goods'],
                'uid' => $orderInfo['uid'],
                'num' => $orderInfo['num']
            ]));
        }
    }

    public function cs3()
    {
        $orderInfo = $this::getData([
            ['goods', mt_rand(1, 3)],
            ['uid', mt_rand(1, 100)],
            ['num', mt_rand(1, 5)]
        ]);
        $redis = \Utils::redis();
        $redis->lPush('order:createList', json_encode([
            'goods' => $orderInfo['goods'],
            'uid' => $orderInfo['uid'],
            'num' => $orderInfo['num']
        ]));
        for ($i = 0; $i < 500; $i++) {
            if ($result = $redis->get('order_list_' . $orderInfo['uid'] . '_' . $orderInfo['goods'])) {
                $data = json_decode($result, true);
                \Api::success($data['data'], $data['code'], $data['msg']);
            }
            //  usleep(10000);
            usleep(7000);
        }
        \Api::success(['goods' => $orderInfo['goods']], 201, '正在排队中。。。');
    }
}
