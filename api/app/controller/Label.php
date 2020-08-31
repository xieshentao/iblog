<?php
namespace app\controller;
use app\model\Label AS LabelModel;
use app\validate\LabelValidate;
use think\facade\Db;

class Label extends IblogBase{

    public function index(){

        $labelModel = new LabelModel();
        $labelData = $labelModel->where('is_deleted',0)->field('name')->select()->toArray();
        $categoryData = Db::name('category')->select()->toArray();

        return success(['label'=>$labelData,'category'=>$categoryData]);

    }

    public function add(){
       $name = input('label_name');

       validate(LabelValidate::class)->check([
           'name'=>$name
       ]);

       $labelModel = new LabelModel();
       $labelModel->name = $name;
       $labelModel->save();

       return success('添加成功');

    }

    public function remove(){
        $name = input('label_name');

        validate(LabelValidate::class)->check([
            'r_name'=>$name
        ]);

        $label = LabelModel::where('name',$name)->where('is_deleted',0)->find();
        $label->is_deleted = 1;
        $label->save();

        return success('删除成功');
    }

}
