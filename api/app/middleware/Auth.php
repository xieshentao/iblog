<?php
declare (strict_types = 1);

namespace app\middleware;
use app\model\Users;
use think\facade\Config;
use think\route\Rule;

class Auth
{
    /**
     * 处理请求
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {

        //允许跨域
        header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
        header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
        header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
        header('Access-Control-Allow-Headers: token,Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段


        $rule = $request->rule()->getRule();

        //验证是否需要权限验证
        $authConfig = Config::get('auth');
        $request->needAuth = false;

        if(in_array($rule,$authConfig['need'])){
            $request->needAuth = true;
        }
        
        if(in_array($rule,$authConfig['noNeed'])){
            $request->needAuth = false;
        }

        if(!$request->needAuth) return $next($request);

        //登陆验证
        $server = $request->server();
        $token = @$server['HTTP_TOKEN'];
        $check = checkToken($token);


        if($check['code'] != 0){
            $request->authStatusCode = $check['code'];
            return $next($request);
        }

        $email = $check['data']->email;
        $user = Users::Where('email',$email)->find();
        if(!$user){
            $request->authStatusCode = 1001;  //账户不存在
            return $next($request);
        }

        if($user->status != 1){
            $request->authStatusCode = 1005;   //用户已被禁用
            return $next($request);
        }

        //权限认证 boss OR stuff
        if($user['role'] == 'stuff' && in_array($rule,$authConfig['needBoss'])){
            $request->authStatusCode = 1003;   //权限不住
            return $next($request);
        }

        //更新token 时间
        $request->authStatusCode = 0;
        return $next($request);

    }
}
