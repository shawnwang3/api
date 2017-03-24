<?php
/*
 * 未完成订单模型     筛选未完成字段未加！！！！！！目前搜索所有
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type:text/html;charset=utf-8");

require_once '..\sqlHelper.php';

class unOrderService
{
    private static $_SqlHelper;

    public function __construct()
    {
        self::$_SqlHelper = new SqlHelper();
    }

    function getUnOrder($primalno){
      $sql= "SELECT t_zh_containerdemand.billid,t_zh_containerdemand.mbl,t_zh_containerdemandsite.predicttime,t_zh_containerdemandsite.addressa
             FROM t_zh_containerdemandsite
			 LEFT OUTER JOIN t_zh_containerdemand on t_zh_containerdemandsite.billid = t_zh_containerdemand.billid
              WHERE t_zh_containerdemand.customerid in (SELECT t_kj_worker.organid
						                                 FROM t_kj_worker WHERE t_kj_worker.primalno = '".$primalno."');";
      $res = self::$_SqlHelper->execute_dql($sql);
      while ($row = $res->fetch_assoc()){
          $arr = array(
              'demandBillid'=> $row['billid'],
              'mbl' => $row['mbl'],
              'doorPredicttime' => $row['predicttime'],
              'doorAddress' => $row['addressa']
          );
      }
        $unOrderData[]=$arr;
        return array(
            'status' => 'ok',
            'message' => '未完成订单',
            'data' => $unOrderData
        );
    }
    
    function DetUnorder($billid) {
        ;
    }

}

