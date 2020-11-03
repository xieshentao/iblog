<?php
namespace app\controller;
use think\Console;
use think\file;
class Upload{

    public function uploadBase64(){
        $image = input("image");

        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $image, $result)) {
            $type     = $result[2];
            $file = uniqid()."-".date("Y-m-d-His").".{$type}";
            $dir = date("Y-m");
            $file_path = UPLOAD_PATH.$dir;

            //不存在则创建文件夹-一个月一个文件夹
            if(!is_dir($file_path)){
                mkdir($file_path,0777);
            }

            if (!file_put_contents($file_path.DS.$file, base64_decode(str_replace($result[1], '', $image)))) {
                return error("上传失败");
            }

            return success(['url'=>UPLOAD_SITE_URL.$dir."/".$file]);

        }
    }

}
