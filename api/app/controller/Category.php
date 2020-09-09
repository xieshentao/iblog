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
        $parentCategory = Db::name('category')->where('parent_id',0)->select();
        $parent = [];
        $allData = [];

        foreach ($parentCategory as $item){
           $parent[] = $item['name'];
           $tmp = [];
           $tmp['name'] = $item['name'];
           $tmp['id'] = $item['id'];
           $tmp['articleCount'] = 1;
           array_push($allData,$tmp);

           $childCategory = Db::name('category')->where('parent_id',$item['id'])->select();
           foreach ($childCategory as $v){
               $cTmp = [];
               $cTmp['childName'] = $v['name'];
               $cTmp['id'] = $v['id'];
               $cTmp['articleCount'] = 1;
               array_push($allData,$cTmp);
           }

        }

        return success(['parent'=>$parent,'categoryData'=>$allData]);


    }


    public function add()
    {
        $parentName = input('parent');
        $name = input('name');
        if(!$name) return error('请输入分类名称');


        if($parentName == '——父级分类名称——'){
            $parentId = 0;
            $rs = Db::table('iblog_category')->where('name',$name)->where('parent_id',0)->find();
            if($rs) return error('当前父分类已存在');
        }else{
            $rs = Db::table('iblog_category')->where('name',$parentName)->where('parent_id',0)->find();
            if(!$rs) return error('父分类不存在!');
            $parentId = $rs['id'];

            $rs2 = Db::table('iblog_category')->where('name',$name)->where('parent_id',$parentId)->find();
            if($rs2) return error('当前子分类已存在');
        }

        $data = [
            'name'=>$name,
            'parent_id'=>$parentId
        ];

        Db::name('category')->insert($data);

        return success('添加成功');

    }

    public function remove()
    {
        $categoryId = input('category_id');

        //判断是否有文章 | 是否有子分类


        $rs = Db::name('category')->where('id',$categoryId)->delete();
        if(!$rs) return success('删除失败');

        return success('删除成功');
    }

}
