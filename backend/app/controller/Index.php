<?php
namespace app\controller;

class Index extends IblogBase
{
    public function index()
    {
        return 'hello'.'grill';
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
