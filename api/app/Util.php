<?php

/**
 * JSON 返回封装
 * @param null $data
 * @param null $code
 * @return \think\response\Json
 */
function success($data = null,$code = null){
    $res = [
        'success'=>true,
        'data'   =>$data,
        'code'   =>$code
    ];
    return  json($code);
}

function error($msg = null,$code = null){
    $res = [
        'success'=>false,
        'msg'    =>$msg,
        'code'   =>$code,

    ];
    return json($code);
}
