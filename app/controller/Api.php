<?php

namespace app\controller;

use app\BaseController;
use think\facade\Log;
use xy_jx\Utils;

class Api extends BaseController
{

    public function index()
    {
        \Api::success(orderNo());
    }

    /**
     * 实时写入日志信息
     * @return void
     */
    public function log()
    {
        Log::write('aaaaaaaa', 'loh');
        \Api::success('log');
    }

    public function cs()
    {
        \Api::success(Utils\Rmb::rmbCapital(15554.4));

    }

    //export 导出需要安装额外扩展  composer require phpoffice/phpspreadsheet
    public function export()
    {
        //导出数据 二维数组
        $list = [
            ['name' => 'name_A', 'area_name' => '北京', 'account' => 'beijing', 'date' => '2020-01-01'],
            ['name' => 'name_B', 'area_name' => '深圳', 'account' => 'shenzhen', 'date' => '2020-01-02'],
            ['name' => 'name_C', 'area_name' => '上海', 'account' => 'shanghai', 'date' => '2020-01-03']
        ];

        \Excel::header('账号导出', ['name' => '名字', 'account' => '账号', 'area_name' => '城市', 'date' => '日期'], '共导出数据:' . count($list) . '条')
            ->content($list)
            ->save();
    }

    public function getData1()
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

    public function getData12()
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

    public function getData123()
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