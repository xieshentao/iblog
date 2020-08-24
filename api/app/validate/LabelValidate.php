<?php
declare (strict_types = 1);

namespace app\validate;

use app\model\Label as LabelModel;
use think\Validate;

class LabelValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'name' =>'require|max:10|checkName:thinkPHP'
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'name.require'=>'请输入标签名',
        'name.max'    =>'标签名应在1-10个字符'
    ];


    protected function checkName($value,$rule,$data){
        $labelModel = new LabelModel();
        $label = $labelModel->where('name',$value)->where('is_deleted',0)->select();
        return !$label ? true : "标签'{$value}'已经存在";
    }
}
