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
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {

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
        $token = $server['HTTP_TOKEN'];
        $check = checkToken($token);


        if($check['code'] != 0){
            $request->authStatusCode = $check['code'];
            return $next($request);
        }

        $email = $check['data']->email;
        $user = Users::Where('email',$email)->find();
        if(!$user){
            $request->authStatusCode = 1001;
            return $next($request);
        }

        if($user->status != 1){
            $request->authStatusCode = 1005;
            return $next($request);
        }


        //更新token 时间
        $request->authStatusCode = 0;
        return $next($request);

    }
}
