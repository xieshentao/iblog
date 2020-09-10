<?php

namespace app\controller;

use app\model\Users;
use app\validate\BlogEditorValidate;
use think\facade\Db;

class Blog extends IblogBase
{
    /**
     * blog List
     * 20200910xst
     */
    public function blogList(){
        
    }




    /**
     * blog Content
     */
    public function blogContent()
    {
        //编辑blog传入ID
        $blogId = input('blogId');
        $user = Users::getUser();
        $blog = Db::name('article')->where('id', $blogId)->where('user_id', $user['id'])->find();

        $data = [
            'title' => $blog['title'],
            'blogContent'=> $blog['markdown'],
            'isShow'=> !isset($blog['display']) || $blog['display'] == 1 ? true :false,
        ];

        return success($data);
    }

    /**
     * 新增|编辑博客
     */
    public function blogEditor()
    {
        //编辑blog传入ID
        $blogId = input('blogId');
        $selectTags = input('selectTags', []);
        $selectCategory = input('selectCategory', []);
        $isShow = input('isShow');
        $blogTitle = input('blogTitle');
        $blogContent = input('blogContent');
        $blogHtml = input('blogHtml');

        validate(BlogEditorValidate::class)->check([
            'title' => $blogTitle
        ]);

        $user = Users::getUser();
        $blog = Db::name('article')->where('id', $blogId)->where('user_id', $user['id'])->find();
        $data = [
            'title' => $blogTitle,
            'display' => $isShow ? 1 : 0,
            'order_by' => 50,
            'html' => $blogHtml,
            'markdown' => $blogContent,
            'user_id' => $user['id'],
            'is_push' => 1,
        ];

        //更新 | 编辑blog
        if ($blog) {
            $rs = Db::name('article')->where('id', '<>', $blog['id'])->where('title', $blogTitle)->find();
            if ($rs) return error('文章名已存在');

            Db::name('article')->where('id', $blogId)->update($data);
            //编辑时先删除所有 分类|标签
            Db::name('articlemeta')->where('blog_id', $blog['id'])->whereRaw("type='category' OR type='label'")->delete();
        } else {

            $rs = Db::name('article')->where('title', $blogTitle)->find();
            if ($rs) return error('文章名已存在');

            $data['publish_time'] = date('Y-m-d H:i:s');
            $blogId = Db::name('article')->insertGetId($data);
        }

        //分类
        $insertCategory = Db::name('category')->where('id', 'IN', $selectCategory)
            ->where('parent_id', '<>', 0)->select();
        $insertCategoryData = [];
        foreach ($insertCategory as $item) {
            $tmp['type'] = 'category';
            $tmp['blog_id'] = $blogId;
            $tmp['target_id'] = $item['id'];
            $insertCategoryData[] = $tmp;
        }
        $noCategory = ['type' => 'category', 'blog_id' => $blogId, 'target_id' => -1];

        //增加未分类
        if (count($insertCategoryData) < 1 || in_array(-1, $selectCategory)) {
            array_push($insertCategoryData, $noCategory);
        }

        //标签
        $insertTagsData = [];

        foreach ($selectTags as $item) {
            $rs = Db::name('label')->where('name', $item)->where('is_deleted', 0)->find();

            if ($rs) $targetId = $rs['id'];
            else $targetId = Db::name('label')->insertGetId(['name' => $item]);

            $insertTagsData[] = ['type' => 'label', 'blog_id' => $blogId, 'target_id' => $targetId];
        }

        //插入所有分类与标签
        Db::name('articlemeta')->insertAll(array_merge($insertCategoryData, $insertTagsData));


        return success(['blogId' => $blogId]);

    }


    public function blogTags()
    {

        //编辑blog传入ID
        $blogId = input('blogId', '');
        //标签
        $tags = Db::name('label')->where('is_deleted', 0)->column('name');
        $selectedTags = [];

        $user = Users::getUser();
        $blog = Db::name('article')->where('id', $blogId)->where('user_id', $user['id'])->find();

        if ($blog) {
            $selectedTags = Db::name('articlemeta')->alias('a')
                ->leftJoin('label l', 'l.id = a.target_id')
                ->where('a.blog_id', $blog['id'])
                ->where('a.type', 'label')
                ->where('l.is_deleted', '<>', 1)
                ->column('l.name');
        }

        return success(['tags' => $tags, 'selectedTags' => $selectedTags]);


    }

    public function blogCategory()
    {
        //编辑blog传入ID
        $blogId = input('blogId', '');

        $user = Users::getUser();
        $blog = Db::name('article')->where('id', $blogId)->where('user_id', $user['id'])->find();
        //分类
        $category = Db::name('category')->select();
        $categoryData = [];
        $selectCategory = [];

        foreach ($category as $item) {
            if ($item['parent_id'] == 0) {
                $categoryData[$item['id']]['id'] = $item['id'];
                $categoryData[$item['id']]['label'] = $item['name'];
                $categoryData[$item['id']]['disabled'] = true;
            } else {
                $tmp = [];
                $tmp['id'] = $item['id'];
                $tmp['label'] = $item['name'];
                $categoryData[$item['parent_id']]['children'][] = $tmp;
            }
        }
        $categoryData = array_values($categoryData);
        $categoryData[] = ['id' => -1, 'label' => '未分类'];


        if ($blog) {
            $selectCategory = Db::name('articlemeta')->alias('a')
                ->leftJoin('category c', 'c.id = a.target_id')
                ->where('a.blog_id', $blog['id'])
                ->where('a.type', 'category')
               // ->where('c.is_deleted', '<>', 1)
                ->column('c.id');
        }

        return success(['category' => $categoryData,'selectCategory'=>$selectCategory]);
    }


}
