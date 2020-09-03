<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('xst', function () {
    return 'hello,xst!';
});

Route::post('login', 'auth/login');
Route::post('register', 'auth/register');

Route::rule('label', 'label/index','options|get')->ext('json');
Route::rule('label_add', 'label/add','options|post')->ext('json');
Route::rule('label_remove', 'label/remove','options|post')->ext('json');




