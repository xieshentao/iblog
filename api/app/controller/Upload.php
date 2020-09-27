<?php
namespace app\controller;
use think\file;
class Upload{

    public function upload(){
        echo '<pre>';
        var_dump($_FILES);
        exit();
        
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        
        // 上传到本地服务器
        $savename = \think\facade\Filesystem::putFile( 'public', $file);

        return success(['url'=>$savename]);
    }

}
