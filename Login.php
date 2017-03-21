<?php
/*
 * 用户登录
 * @parame string $primalno 用户名
 * @parame string $password 用户密码
 *
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type:text/html;charset=utf-8");

require_once 'loginService.php';
require_once 'json.php';
// 接受数据
 $primalno = (empty($_POST['account'])) ? null : $_POST['account'];
 $password = (empty($_POST['password'])) ? null : $_POST['password'];

//实例化一个json返回数据
$json = new Json();

//判断用户输入是否为空
if ($primalno==null || $password==null){
    $status="fail";
    $message ="用户名或密码不能为空";
    $data=null;
    $dataJson = $json->jsonEn($status,$message,$data);
    echo $dataJson;
    exit();
}

//实例化验证用户登录
$loginService = new LoginService;
$res = $loginService->checkLogin($primalno, $password);


$status=$res['status'];
$message = $res['message'];
$data = $res['data'];

// var_dump($data);
// $code = $res['code'];
// $dataJson = $json->json($code, $message, $data);

$dataJson = $json->jsonEn($status,$message,$data);

echo $dataJson;


