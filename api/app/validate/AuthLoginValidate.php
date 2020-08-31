<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class AuthLoginValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'email' => 'require|email',
        'pwd'   => 'require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'email.email' => '邮箱格式不正确',
        'email.require' => '请输入邮箱',
        'pwd.require' => '请输入密码',
    ];


}
