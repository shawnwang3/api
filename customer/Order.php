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
$orderdata = (empty($_POST['orderData'])) ? null : $_POST['orderData'];

// 实例化一个json
$json = new json();
// 实例化下订单
$orderService = new OrderService();

// 判断用户输入的必填字段是否为空
if ($primalno == null || $password == null || $type == null || $orderdata == null) {
    $status = "fail";
    $message = "数据链接失败";
    $data = null;
    $dataJson = $json->jsonEn($status, $message, $data);
    echo $dataJson;
    exit();
}

$orderdata = $json->jsonDe($orderdata);

if ($type == "save") {
    $res = $orderService->saveData($primalno, $orderdata);
    $status = $res['status'];
    $message = $res['message'];
    $dataJson = $json->jsonEn($status, $message);
    echo $dataJson;
} else 
    if ($type == "submit") {
        $res = $orderService->submitData($primalno, $orderdata);
        $status = $res['status'];
        $message = $res['message'];
        $dataJson = $json->jsonEn($status, $message);
        echo $dataJson;
    } else 
        if ($type == "affirm") {
            $res = $orderService->affirmData($primalno, $orderdata);
            $status = $res['status'];
            $message = $res['message'];
            $dataJson = $json->jsonEn($status, $message);
            echo $dataJson;
        } else {
            $status = "fail";
            $message = "数据类型链接失败";
            $data = null;
            $dataJson = $json->jsonEn($status, $message, $data);
            echo $dataJson;
        }





















