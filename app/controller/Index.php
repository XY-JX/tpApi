<?php

namespace app\controller;

use app\BaseController;

class Index extends BaseController
{
    public function index()
    {
        \Api::success('ThinkPHP V' . \think\facade\App::version());
    }

}
