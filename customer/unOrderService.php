<?php
/*
 * 未完成订单模型
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

    function getUnOrder($primalno)
    {
      $sql= "SELECT t_zh_containerdemand.mbl,t_zh_containerdemandsite.predicttime,t_zh_containerdemandsite.addressa
             FROM t_zh_containerdemandsite
			 LEFT OUTER JOIN t_zh_containerdemand on t_zh_containerdemandsite.billid = t_zh_containerdemand.billid
              WHERE t_zh_containerdemand.customerid in (SELECT t_kj_worker.organid
						                                 FROM t_kj_worker WHERE t_kj_worker.primalno = 'admin')";
    
        
        
        
        
       