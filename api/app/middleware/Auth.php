<?php
declare (strict_types = 1);

namespace app\middleware;
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

        //需要权限验证时判断登陆状态
        $request->noLogin = true;


        return $next($request);
    }
}
