<?php
// +----------------------------------------------------------------------
// | 应用路由权限配置
// +----------------------------------------------------------------------

//默认不需要权限认证，no_need比need优先级高;


$need = [
    'label',
];

$noNeed = [
    'login'
];

//非 boss 权限
$noNeedBoss = [

];







return [
    'noNeed'=>$noNeed,
    'need'   =>$need,
    'noNeedBoss' => $noNeedBoss,
];
