<?php
namespace app\controller;

use app\model\Users;
use app\validate\BlogEditorValidate;
use think\facade\Db;

class Blog extends IblogBase{


    /**
     * 后端博客列表
     */
    public function index(){

    }

    /**
     * 新增|编辑博客
     */
    public function blogEditor(){

        $blogId = input('blogId');
        $selectTags = input('selectTags');
        $selectCategory = input('selectCategory');
        $isShow = input('isShow');
        $blogTitle = input('blogTitle');
        $blogContent = input('blogContent');
        $blogHtml = input('blogHtml');

        validate(BlogEditorValidate::class)->check([
            'title'=>$blogTitle
        ]);

        $user = Users::getUser();
        $blog = Db::name('article')->where('id',$blogId)->find();
        $data = [
            'title'=>$blogTitle,
            'display'=>$isShow ? 1:0,
            'order_by'=>50,
            'html' => $blogHtml,
            'markdown' => $blogContent,
            'user_id'=> $user['id'],
            'is_push' => 1,
        ];

        if($blog){
            Db::name('article')->where('id',$blogId)->update($data);
        }else{
            $data['publish_time'] = date('Y-m-d H:i:s');
            $blogId = Db::name('article')->insertGetId($data);
        }

        if($blog){
            Db::name('articlemeta')->where('blog_id',$blog['id'])->whereRaw("type='category' OR type='label'")->delete();
        }

        //分类
        $insertCategory = Db::name('category')->where('id','IN',$selectCategory)
            ->where('parent_id','<>',0)->select();
         $insertCategoryData = [];
         foreach ($insertCategory as $item){
            $tmp['type'] = 'category';
            $tmp['blog_id'] = $blogId;
            $tmp['target_id'] = $item['id'];
            $insertCategoryData[] = $tmp;
         }

         if($insertCategoryData && count($insertCategoryData) >0){
             Db::name('articlemeta')->insertAll($insertCategoryData);
         }

        //标签

        return success();

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
        $categoryData = array_values($categoryData);
        $categoryData[] = ['id'=>-1,'label'=>'未分类'];
        return success(['category'=>$categoryData]);
    }








}
