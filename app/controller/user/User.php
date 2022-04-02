<?php

namespace app\controller\user;

use app\BaseController;
use app\Logic\UserLogic;

class User extends BaseController
{
    public function list(UserLogic $logic)
    {
        $param = $this->getParam(['nickname', 'sex' => 2], ['nickname|昵称' => 'max:20', 'sex|性别' => 'in:0,1,2']);
        \Api::success($logic->list($param));
    }

    public function add(UserLogic $logic)
    {
        $param = $this->getParam(['nickname', 'sex' => 2], ['nickname|昵称' => 'max:20', 'sex|性别' => 'in:0,1,2']);
        if ($logic->add($param))
            \Api::success();
        \Api::fail();
    }

    public function del(UserLogic $logic)
    {
        $param = $this->getParam(['id'], ['id' => 'require|number']);
        if ($logic->del($param['id']))
            \Api::success();
        \Api::fail();
    }

    public function info(UserLogic $logic)
    {
        $param = $this->getParam(['id'], ['id' => 'require|number']);
        if ($info = $logic->info($param['id']))
            \Api::success($info);
        \Api::fail();
    }

    public function edit(UserLogic $logic)
    {
        $param = $this->getParam(['id', 'nickname', 'sex'], ['id' => 'require|number', 'nickname|昵称' => 'max:10|chsDash', 'sex|性别' => 'in:0,1,2']);
        if ($logic->edit($param))
            \Api::success();
        \Api::fail();
    }
}