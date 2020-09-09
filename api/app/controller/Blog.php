<?php
namespace app\controller;

use think\facade\Db;

class Blog extends IblogBase{


    /**
     * 后端博客列表
     */
    public function index(){

    }



    public function blogTags(){

        $blogName = input('blogName');
        //标签
        $tags = Db::name('label')->where('is_deleted',0)->column('name');
        $selectedTags = [];

        if($blogName){

        }


        return success(['tags'=>$tags,'selectedTags'=>$selectedTags]);



    }


    public function blogCategory(){
        $blogName = input('blogName');
        
        //分类
        $category = Db::name('category')->select();
        $categoryData = [];

        foreach ($category as $item){
            if($item['parent_id'] == 0){
                $categoryData[$item['id']]['id'] = $item['id'];
                $categoryData[$item['id']]['label'] = $item['name'];
                $categoryData[$item['id']]['disabled'] = true;
            }else{
                $tmp = [];
                $tmp['id'] = $item['id'];
                $tmp['label'] = $item['name'];
                $categoryData[$item['parent_id']]['children'][] = $tmp;
            }
        }

        return success(['category'=>array_values($categoryData)]);
    }


    /**
     * 新增|编辑博客
     */
    public function blogEditor(){
        $blogName = input('blogName');
    }





}
