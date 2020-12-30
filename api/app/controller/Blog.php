<?php

namespace app\controller;

use app\model\Users;
use app\validate\BlogEditorValidate;
use think\facade\Db;

class Blog extends IblogBase
{

    /**
     * 查看blog 内容
     */
    public function viewBlog(){
        //查看传入blog Name
        $name = trim(input('name'));

        $blog = Db::name('article')->where('title',$name)->where('display', 1)->find();

        if(!$blog) return error('文章不存在!');
        $user = Db::name('users')->where('status',1)->where('id',$blog['user_id'])->find();

        $data = [
            'title' => $blog['title'],
            'blogContent'=> $blog['html'],
            'publishTime'=> $blog['publish_time'],
            'user'=> $user['name'] ?:'',
            'avatar'=> $user['avatar'] ? UPLOAD_SITE_URL.$user['avatar'] :'',
        ];

        return success($data);
    }


    public function showTags(){
        //查看blog传入name
        $title = input('name', '');
        //标签
        $tags = [];
        $blog = Db::name('article')->where('title', $title)->where('display', 1)->find();

        if ($blog) {
            $tags = Db::name('articlemeta')->alias('a')
                ->leftJoin('label l', 'l.id = a.target_id')
                ->where('a.blog_id', $blog['id'])
                ->where('a.type', 'label')
                ->where('l.is_deleted', '<>', 1)
                ->column('l.name');
        }

        return success(['tags' => $tags]);
    }


    public function showCategory(){
        //查看blog传入name
        $title = input('name', '');
        //标签
        $category = [];
        $blog = Db::name('article')->where('title', $title)->where('display', 1)->find();

        if ($blog) {
            $category = Db::name('articlemeta')->alias('a')
                ->leftJoin('category c', 'c.id = a.target_id')
                ->where('a.blog_id', $blog['id'])
                ->where('a.type', 'category')
                ->column('c.name,c.id');
        }

        return success(['category' => $category]);
    }


    public function showCategorys(){

        //分类s
        $category = [];

        $parents = Db::name('category')->where('parent_id',0)->select();
        $type = ['primary','success','warning','danger','info'];

        $typeIndex = 0;
        foreach ($parents as $parent){
            $childs = Db::name('category')->where('parent_id',$parent['id'])->select();
            if(count($childs) < 1) continue;

            foreach ($childs as $child){
                $tmp = [];
                $tmp['id'] = $child['id'];
                $tmp['name'] = $child['name'];
                $tmp['parent'] = $parent['name'];
                $tmp['type'] = $type[$typeIndex];
                $category[] = $tmp;
            }
            $typeIndex ++;
            if( $typeIndex >= count($type)){
                $typeIndex = 0;
            }
        }

        array_push($category,['id'=>-1,'name'=>'未分类']);

        return success(['category' => $category]);
    }


    /**
     * blog List
     * 20200910xst
     */
    public function showList(){

        $category_id = input('category');
        $page = input('page',1);
        $limit = 10;
        $start = ($page-1)*$limit;



        $list = Db::name('article')->alias('a')
            ->leftJoin('users u','u.id = a.user_id')
            ->where('a.display',1)
            ->where('a.is_push',1)
            ->order('a.order_by','desc')
            ->order('a.modifyd_time','desc')
            ->limit($start,$limit)
            ->column('a.title,a.html,u.name,u.avatar,a.publish_time,a.modifyd_time');

        $count =  Db::name('article')->alias('a')
            ->leftJoin('users u','u.id = a.user_id')
            ->where('a.display',1)
            ->where('a.is_push',1)
            ->count('a.id');

        $data = [
            'data'=>$list,
            'count'=>$count
        ];

        return success($data);
        
    }

    /**
     * ---------------------------后台博客相关-------------------------------------------------------------
     */

    /**
     * 后台博客列表
     *
     * return blogList category users
     */
    public function blogList(){
        $user = Users::getUser();

        $page = input('page',1);
        $limit = input('limit',10);
        $query = input('query');
        $category = input('category');
        $selectedUser = input('user');

        $start = ($page-1)*$limit;

        $blogSql = Db::name('article')->alias('a');
        $blogSql->leftJoin('articlemeta at',"at.type = 'category' AND at.blog_id = a.id");
        $blogSql->leftJoin('category c',"c.id = at.target_id");
        $blogSql->leftJoin('users u',"u.id = a.user_id");

        if($category){
            $blogSql->where("c.id",$category);
        }

        if($query){
            $blogSql->where("a.title","like","%$query%");
        }

        if($selectedUser){
            $blogSql->where("a.user_id",$selectedUser);
        }
        $blogSql->where('a.is_deleted',0)->group('a.id');

        $total = $blogSql->count('a.id');

        $blogList = $blogSql->order('a.modifyd_time','desc')->limit($start,$limit)->column("a.id,a.title,u.name,a.display,a.is_push,a.modifyd_time");

        foreach ($blogList as $index=>$item){
            //分类
            $tmpCategory = Db::name('category')->alias('c')
                ->leftJoin('articlemeta at',"at.target_id = c.id")
                ->where('at.type','category')
                ->where('at.blog_id',$item['id'])->column('c.name');
            //标签
            $tmpLabel = Db::name('label')->alias('l')
                ->leftJoin('articlemeta at',"at.target_id = l.id")
                ->where('at.type','label')
                ->where('at.blog_id',$item['id'])->column('l.name');

            $blogList[$index]['category'] = $tmpCategory;
            $blogList[$index]['label'] = $tmpLabel;
        }

        //分类数据
        $category = Db::name('category')->select();
        $categoryData = [];

        foreach ($category as $item) {
            if ($item['parent_id'] == 0) {
                $categoryData[$item['id']]['value'] = $item['id'];
                $categoryData[$item['id']]['label'] = $item['name'];
            } else {
                $tmp = [];
                $tmp['value'] = $item['id'];
                $tmp['label'] = $item['name'];
                $categoryData[$item['parent_id']]['children'][] = $tmp;
            }
        }
        $categoryData = array_values($categoryData);
        $categoryData[] = ['id' => -1, 'label' => '未分类'];


        //用户数据
        $userList = [];
        if($user['role'] == 'stuff'){
            $userList[0]['name'] = $user['name'];
            $userList[0]['id'] = $user['id'];
        }else if($user['role'] == 'boss'){
            $userList = Db::name('users')->column("name,id");
        }

        $data = [
            'category'=>$categoryData,
            'userList'=>$userList,
            'blogList'=>$blogList,
            'total'   =>$total,
        ];

        return success($data);

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
            'title' => $blog['title'] ?:'',
            'blogContent'=> $blog['markdown']?:'',
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
