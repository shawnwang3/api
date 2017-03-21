<?php
/*
 * 反馈下拉信息
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type:text/html;charset=utf-8");

require_once '..\json.php';
require_once '.\infoService.php';

// 接受数据
$primalno = (empty($_POST['account'])) ? null : $_POST['account'];
$password = (empty($_POST['password'])) ? null : $_POST['password'];


$json=new Json;
//判断用户输入的必填字段是否为空
if ($primalno==null || $password==null){
    $status="fail";
    $message ="数据加载失败";
    $data=null;
    $dataJson = $json->jsonEn($status,$message,$data);
    echo $dataJson;
    exit();
}

$info=new InfoService;
$res=$info->getInfo($primalno);
$status=$res['status'];
$message = $res['message'];
$data = $res['data'];

$dataJson = $json->jsonEn($status,$message,$data);

echo $dataJson;















