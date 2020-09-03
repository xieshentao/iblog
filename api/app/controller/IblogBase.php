<?php
namespace app\controller;
use app\BaseController;
use think\exception\IblogException;
use think\Request;

class IblogBase extends BaseController{

    public function __construct(Request $request)
    {
        //权限认证
        $this->request = $request;
        $this->Auth();
        //统计
    }


    private function Auth(){
        $request = $this->request;

        $msgMap = [
            '1000' => '未登录',
            '1001' => '账户不存在',
            '1002' => '密码错误',
            '1003' => '权限不足',
            '1004' => '登陆状态失效',
            '1005' => '用户已被禁用',
            '1006' => '登陆错误',
        ];

        //登陆权限认证,参数来自app\middleware\Auth.php;
        if($request->needAuth && in_array($request->authStatusCode,array_keys($msgMap))){
            throw new IblogException($msgMap[$request->authStatusCode],$request->authStatusCode);
        }

    }

}


/*
 * admin api
 *
 * 1.登陆  jwt 单点登陆   |  注册 邮箱注册  |  找回密码   --------> 注册默认头像     ---> 中间件
 * 2.控制台  [pv、uv、待办、（本周|本月统计）、通知]   --->事件
 * 3.blog
 *      a. 新增
 *          -标题；
 *          -内容：富文本处理器、文件的保存;
 *          -附件上传;
 *          -贴标签、分类;
 *      b. 列表
 *      c. 回收站
 *
 * 4.日记
 * 5.计划 [代办事项]
 * 6.分类 (二级分类)[有文章时不可删除]   标签 [可删除]
 * 7.用户 [boss,stuff]
 *        boss: a.控制台可查看系统 pv uv ;
 *              b.blog 操作时   可以选择所有的用户 ;
 *              c.可操作分类与  标签；
 *              d.setting -
 *                        -网站设置
 *                        -网站是否开启登陆
 *
 * 8.统计
 *     a : 文章查看 | 写文章 | 写日记  | 访问站点 | 后台访问 | ----> pv  与  iv
 *
 * 10. 设置
 *     a. 网站设置  |主题图 | 网站标题 | 网站图标
 *     b. 通知设置 (email 通知 | 网站通知)
 *                 1.日记未写通知  时间
 *                 2.代办事项通知
 *                 3.文章复看通知
 *                 4.通知方式
 *     c. 网站是否开启登陆
 *
 *
 * 11. 脚本运行写入通知  ---->  通知表 | 通知setting表
 *                 1.日记未写通知   是否开启 --->  写入通知表  (设置通知时间)
 *                 2.代办事项通知   是否开启 --->  写入通知表  (提前通知)
 *                 3.文章复看通知   是否开启 --->  写入通知表  (第二天查看|第4天查看|第10天查看)---> 配置
 *
 * 12  脚本运行发送 email 通知;
 *
 *
 *
 * index api
 *
 * 1. 主页
 *    搜索
 *    分类
 *    标签
 * [登陆弹框  [退出 与 进入 控制台]  ]-------所有登陆在此页面完成 ---登陆后显示头像;
 * 2. 搜索后的页面
 * 3. 查看页面   -----  是本人   可以点击进入 编辑;
 * 4. 点击头像可查看  个人主页
 * 5. 查看文章页面  ---> 可以给小心心  按照 ip--来;
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */