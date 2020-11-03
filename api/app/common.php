<?php
//常量定义
define('DS',DIRECTORY_SEPARATOR);
define('ROOT',dirname(dirname(__FILE__)).DS);   //api根目录
define('UPLOAD_PATH',ROOT."public".DS."static".DS);   //文件上传目录
define('UPLOAD_SITE_URL',"http://iblog.localhost/static/"); //文件预览目录








// 应用公共文件
$files = [
    'Util.php',
    'IblogException.php'
];


//加载文件
foreach ($files as $file){
    include_once "{$file}";
}

