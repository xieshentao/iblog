<?php
namespace app\model;

use think\Model;

class Users extends Model{

    /**
     * 获取当前用户
     * @return array|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getUser()
    {
        $tokenData = checkToken(@$_SERVER['HTTP_TOKEN']);
        if(!$tokenData || $tokenData['code'] != 0 || !$tokenData['data']){
            throw new \think\exception\IblogException('未登录',1000);
        }

        $user = \app\model\Users::where('email',$tokenData['data']->email)->find();
        if(!$user) throw new \think\exception\IblogException('用户不存在',1001);

        if($user->status != 1) throw new \think\exception\IblogException('用户已经被禁用',1005);

        return $user;
    }
}