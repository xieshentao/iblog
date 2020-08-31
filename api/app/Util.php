<?php

use Firebase\JWT\JWT;

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
    return  json($res);
}

function error($msg = null,$code = null){
    $res = [
        'success'=>false,
        'msg'    =>$msg,
        'code'   =>$code,

    ];
    return json($res);
}


/**
 * 生成token
 * @param $email
 * @return string
 */
function getToken($email){
    $key = 'Iblog';

    $token=array(
        "iss"=>$key,        //签发者 可以为空
        "aud"=>'',          //面象的用户，可以为空
        "iat"=>time(),      //签发时间
        "nbf"=>time()+1,    //在什么时候jwt开始生效
        "exp"=> time()+60*60*24*7, //token 过期时间
        "data"=>[
            'email'=>$email,
        ]
    );

    $jwt = JWT::encode($token, $key, "HS256");  //根据参数生成了 token
    return $jwt;

}


/**
 * 验证token
 * @param $token
 * @return array
 */
function checkToken($token){
    $key='Iblog';
    $status=[];
    try {
        JWT::$leeway = 60;//当前时间减去60，把时间留点余地
        $decoded = JWT::decode($token, $key, array('HS256')); //HS256方式，这里要和签发的时候对应
        $arr = (array)$decoded;
        $res['code']=0;
        $res['data']=$arr['data'];
        return $res;

    } catch(SignatureInvalidException $e) { //签名不正确
        $status['msg']="签名不正确";
        $tatus['code'] = 1006;
        return $status;
    }catch(BeforeValidException $e) { // 签名在某个时间点之后才能用
        $status['code'] = 1004;
        $status['msg']="token失效";
        return $status;
    }catch(ExpiredException $e) { // token过期
        $status['code'] = 1004;
        $status['msg']="token过期";
        return $status;
    }catch(Exception $e) {
        //其他错误
        $status['code'] = 1006;
        $status['msg'] = "未知错误";
        return $status;
    }
}


/**
 * 获取用户
 * @return array|\think\Model|null
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\DbException
 * @throws \think\db\exception\ModelNotFoundException
 */
function getUser(){
    $tokenData = checkToken(@$_SERVER['HTTP_TOKEN']);
    if(!$tokenData || $tokenData['code'] != 0 || !$tokenData['data']){
        throw new \think\exception\IblogException('未登录',1000);
    }

    $user = \app\model\Users::where('email',$tokenData['data']->email)->find();
    if(!$user) throw new \think\exception\IblogException('用户不存在',1001);

    if($user->status != 1) throw new \think\exception\IblogException('用户已经被禁用',1005);

    return $user;
}


