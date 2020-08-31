<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class AuthRegisterValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'name' =>  'require|max:10',
        'email' => 'require|email',
        'pwd'   => 'require|max:20',
        'pwd2'  => 'require|max:20',
        'code'  => 'require',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'name.require' => '请输入姓名',
        'name.max' =>'姓名长度应小于个字符',
        'email.email' => '邮箱格式不正确',
        'email.require' => '请输入邮箱',
        'pwd.require' => '请输入密码',
        'pwd.max' =>'密码长度应小于20个字符',
        'pwd2.require' => '请再次输入密码',
        'pwd2.max' =>'第二次输入密码长度应小于20个字符',
        'code.require' => '请输入验证码',
    ];


}
