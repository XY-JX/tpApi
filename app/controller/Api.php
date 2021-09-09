<?php

namespace app\controller;

use app\BaseController;
use  \xy_jx\Utils;
class Api extends BaseController
{

    public function index()
    {
        var_dump( Utils\Sundry::orderNo());
    }

    public function cs()
    {

        var_dump( Utils\Rmb::rmb_capital(15554.4));

    }
}