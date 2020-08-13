<?php
namespace app\controller;
use app\BaseController;

class  IblogBase extends BaseController{

    public function __construct()
    {
        //验证登陆
        //统计
    }
}


/*
 * API实现
 *
 * 1.  JWT 单点登陆
 * 2.  用户注册，找回账号  [role boss-> all-article ， stuff-> only self]
 * 3.  article 增删改查 （贴标签，分类....）
 * 4.  label && category  增删改查    [category 必须选择小分类，未选择 --- 未分类]
 * 5.  字段验证封装
 * 6.  note 日记 增删改查
 * 7.  QQ-mail封装
 * 8.  option 配置  [网页图表，名，...配置] [-评论登陆开关-  登陆后可以编辑文章] [网页风格配置] .............
 * 9.  redis 缓存
 * 10. Swoole
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