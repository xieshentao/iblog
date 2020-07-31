<?php

namespace app\controller;

use app\BaseController;

class Login extends BaseController
{
    /**
     * JWT单点登陆
     */
    public function index()
    {

    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}