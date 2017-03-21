<?php
/*
 * 下订单
 * @parame string $
 * @parame string $
 *
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type:text/html;charset=utf-8");

require_once '.\orderService.php';
require_once '..\json.php';

// 接受数据
$primalno = (empty($_POST['account'])) ? null : $_POST['account'];
$password = (empty($_POST['password'])) ? null : $_POST['password'];
$type = (empty($_POST['type'])) ? null : $_POST['type'];
$data = (empty($_POST['orderData'])) ? null : $_POST['orderData'];


//判断用户输入的必填字段是否为空
if  ($primalno==null ||$password==null || $type==null|| $data ==null){
    $status="fail";
    $message ="数据链接失败";
    $data=null;
    $dataJson = $json->jsonEn($status,$message,$data);
    echo $dataJson;
    exit();
}


//实例化一个json
$json = new json();
$orderdata=$json->jsonDe($data);

//实例化下订单
$orderService=new OrderService;
$res= $orderService->saveData($primalno,$password,$type,$orderdata);
var_dump($res);


var_dump($primalno,$password,$type,$orderdata);

















