<?php

namespace app\controller;

use app\BaseController;
use  \xy_jx\Utils;

class Api extends BaseController
{

    public function index()
    {

        \Api::success(orderNo());
    }

    public function cs()
    {
        \Api::success(Utils\Rmb::rmbCapital(15554.4));

    }
    //export 导出需要安装额外扩展  composer require phpoffice/phpspreadsheet
    public static function export($list)
    {
        \Excel::header('推广费用', ['plat_name' => '渠道', 'area_name' => '城市', 'account' => '账号', 'date' => '日期'], '共导出数据:' . count($list) . '条')
            ->content($list)
            ->save();
    }
}