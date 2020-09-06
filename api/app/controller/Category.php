<?php
/**
 * Creat by xst.
 * Date : 2020-09-02.
 * Time : 21:40.
 */

namespace app\controller;

use app\validate\LabelValidate;
use think\facade\Db;

class Category extends IblogBase
{

    public function index()
    {

        $categoryData = Db::name('category')->select()->toArray();

        return success();

    }

    public function add()
    {
        $name = input('label_name');
        if (trim($name) == '') return error('标签名不能为空!');

        validate(LabelValidate::class)->check([
            'name' => $name
        ]);

        $labelModel = new LabelModel();
        $labelModel->name = $name;
        $labelModel->save();

        return success('添加成功');

    }

    public function remove()
    {
        $name = input('name');

        validate(LabelValidate::class)->check([
            'r_name' => $name
        ]);

        $label = LabelModel::where('name', $name)->where('is_deleted', 0)->find();
        $label->is_deleted = 1;
        $label->save();

        return success('删除成功');
    }

}
