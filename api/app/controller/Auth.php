<?php
namespace app\controller;

use app\model\Users;
use app\validate\AuthLoginValidate;
use app\validate\AuthRegisterValidate;
use Firebase\JWT\JWT;

class Auth extends IblogBase {

    private static $salt = 'Iblog';


    public function login(){
        $request = $this->request;
        $email = $request->post('email');
        $pwd = $request->post('pwd');

        validate(AuthLoginValidate::class)->check([
            'email' => $email,
            'pwd'   => $pwd,
        ]);

        $user = Users::Where('email',$email)->find();
        if(!$user) return error('该邮箱未注册');

        if(md5(self::$salt.$pwd) != $user->pwd){
            return error('密码错误',1002);
        }


        $token = getToken($user->email);

        echo '<pre>';
        var_dump($token);
        exit();









        return success('登陆成功');




    }


    public function register(){
        $request = $this->request;
        $email = $request->post('email');
        $pwd = $request->post('pwd');
        $pwd2 = $request->post('pwd2');
        $name = $request->post('name');
        $code = $request->post('code');

        validate(AuthRegisterValidate::class)->check([
           'email' =>$email,
           'name'  =>$name,
           'pwd'   =>$pwd,
           'pwd2'  =>$pwd2,
           'code'  =>$code,
        ]);

        if($pwd != $pwd2) return error('两次输入密码不一致');

        $user = Users::where('email',$email)->find();
        if($user) return error('该邮箱已经注册');

        $user = new Users();
        $user->name = $name;
        $user->email = $email;
        $user->pwd = md5(self::$salt.$pwd);
        $user->role = 'stuff';
        $user->avatar = 1;
        $user->save();

        return success('注册成功,即将跳转登陆...');


    }


    public function password(){

    }

}
