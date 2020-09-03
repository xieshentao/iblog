<?php
// 应用公共文件
$files = [
    'Util.php',
    'IblogException.php'
];


//加载文件
foreach ($files as $file){
    include_once "{$file}";
}

