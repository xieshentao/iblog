<?php
namespace app\controller;
use app\model\Label AS LabelModel;
use app\validate\LabelValidate;

class Label extends IblogBase{

    public function index(){




    }

    public function add(){
       $name = input('label_name');

       validate(LabelValidate::class)->check([
           'name'=>$name
       ]);

       $labelModel = new LabelModel();
       $labelModel->name = $name;
       $labelModel->save();

       return json('添加成功');


    }


}
