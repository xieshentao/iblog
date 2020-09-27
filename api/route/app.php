<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('xst', function () {
    return 'hello,xst!';
});

Route::post('login', 'auth/login');
Route::post('register', 'auth/register');

Route::rule('label', 'label/index','options|get')->ext('json');
Route::rule('label_add', 'label/add','options|post')->ext('json');
Route::rule('label_remove', 'label/remove','options|post')->ext('json');

Route::rule('category', 'category/index','options|get')->ext('json');
Route::rule('category_add', 'category/add','options|post')->ext('json');
Route::rule('category_remove', 'category/remove','options|post')->ext('json');

Route::rule('blog/list', 'blog/index','options|get')->ext('json');
Route::rule('blog/tags', 'blog/blogTags','options|get')->ext('json');
Route::rule('blog/category', 'blog/blogCategory','options|get')->ext('json');
Route::rule('blog/editor', 'blog/blogEditor','options|post')->ext('json');
Route::rule('blog/content', 'blog/blogContent','options|get')->ext('json');

Route::rule('blog/view', 'blog/viewBlog','options|get')->ext('json');
Route::rule('blog/show_tags', 'blog/showTags','options|get')->ext('json');
Route::rule('blog/show_categorys', 'blog/showCategorys','options|get')->ext('json');
Route::rule('blog/show_category', 'blog/showCategory','options|get')->ext('json');
Route::rule('blog/show_list', 'blog/showList','options|get')->ext('json');
//Route::rule('blog/:name', 'blog/blog','options|get')->ext('json');
//Route::rule('category_remove', 'category/remove','options|post')->ext('json');


Route::rule('upload', 'upload/upload','options|post');

