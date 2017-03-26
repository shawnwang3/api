<<<<<<< HEAD
    <?php
    /*
     *未完成订单模型
     */
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header("Content-Type:text/html;charset=utf-8");
=======
<?php
/*
 * 未完成订单模型     筛选未完成字段未加！！！！！！目前搜索所有
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type:text/html;charset=utf-8");
>>>>>>> origin/master

    require_once '..\sqlHelper.php';

    class unOrderService
    {

<<<<<<< HEAD
        private static $_SqlHelper;

        public function __construct()
        {
            self::$_SqlHelper = new SqlHelper();
        }

        function getUnOrder($primalno)
        {
            $unOrderData = array();
            $sql = "SELECT t_zh_containerdemand.billid,t_zh_containerdemand.mbl,t_zh_containerdemandsite.predicttime,t_zh_containerdemandsite.addressa
             FROM t_zh_containerdemandsite
			 LEFT OUTER JOIN t_zh_containerdemand on t_zh_containerdemandsite.billid = t_zh_containerdemand.billid
             WHERE t_zh_containerdemand.customerid in (SELECT t_kj_worker.organid FROM t_kj_worker WHERE t_kj_worker.primalno = '" . $primalno . "')
             AND t_zh_containerdemand.transitstateid<8";
            $res = self::$_SqlHelper->execute_dql($sql);

            while ($row = $res->fetch_assoc()) {
                $arr = array(
                    'demandBillid' => $row['billid'],
                    'mbl' => $row['mbl'],
                    'doorPredicttime' => $row['predicttime'],
                    'doorAddress' => $row['addressa']
                );
                $unOrderData[] = $arr;
            }
            $res->free();
            self::$_SqlHelper->close_connect();
            return array(
                'status' => 'ok',
                'message' => '未完成订单列表',
                'data' => $unOrderData
            );
        }

        function detUnorder($billid)
        {
            $DetUnorder = array();
            $sub = array();
            $patch = array();
            // mbl
            $sql = "SELECT mbl FROM t_zh_containerdemand WHERE billid='" . $billid . "'";
            $row = self::$_SqlHelper->fetch_assoc($sql);
            $DetUnorder[0] = $row['mbl'];
            // 箱型 类别 箱量 车队
            $sql = "SELECT t_zh_containertype.containertype,t_zh_containerkind.containerkind,t_zh_containerproposesub.plan,t_kj_organ.organ
              FROM t_zh_containerproposesub
              LEFT JOIN t_zh_containerpropose ON t_zh_containerpropose.billid=t_zh_containerproposesub.billid
              LEFT JOIN t_zh_containerdemandsub ON t_zh_containerdemandsub.sonid=t_zh_containerproposesub.demandsubsonid
              LEFT JOIN t_zh_containertype ON t_zh_containerdemandsub.containertypeid=t_zh_containertype.containertypeid
              LEFT JOIN t_zh_containerkind ON t_zh_containerdemandsub.containerkindid=t_zh_containerkind.containerkindid
              LEFT JOIN t_kj_organ ON t_zh_containerpropose.truckid=t_kj_organ.organid
              WHERE t_zh_containerpropose.demandbillid='" . $billid . "';";
            $res = self::$_SqlHelper->execute_dql($sql);
            while ($row = $res->fetch_assoc()) {
                $arr = array(
                    'containertype' => $row['containertype'],
                    'containerkind' => $row['containerkind'],
                    'plan' => $row['plan'],
                    'organ' => $row['organ']
                );
                $sub[] = $arr;
            }
            $DetUnorder[1] = $sub;
            // 班次 班次号 箱号 封号 车号 还没有填当前状态 和GPS跟踪
            $sql = "SELECT t_zh_containerdispatch.billid,t_zh_containerdemandplan.containerno,t_zh_containerdemandplan.sealno,t_zh_tractor.plateno,t_zh_transitstate.transitstate
              FROM t_zh_containerdispatch
              LEFT JOIN t_zh_containerdispatchplan ON t_zh_containerdispatch.billid=t_zh_containerdispatchplan.billid
              LEFT JOIN t_zh_containerdemandplan ON t_zh_containerdemandplan.sonid=t_zh_containerdispatchplan.demandplansonid
              LEFT JOIN t_zh_tractor ON t_zh_containerdispatch.tractorid=t_zh_tractor.tractorid
              LEFT JOIN t_zh_containerdemand ON t_zh_containerdemand.billid=t_zh_containerdispatch.demandbillid
              LEFT JOIN t_zh_transitstate ON t_zh_transitstate.transitstateid=t_zh_containerdemand.transitstateid
              WHERE t_zh_containerdispatch.demandbillid='" . $billid . "'";
            $res = self::$_SqlHelper->execute_dql($sql);
            while ($row = $res->fetch_assoc()) {
                $arr = array(
                    'patchbillid' => $row['billid'],
                    'containerno' => $row['containerno'],
                    'sealno' => $row['sealno'],
                    'plateno' => $row['plateno'],
                    'transitstate' => $row['transitstate']
                );
                $patch[] = $arr;
            }
            $DetUnorder[2] = $patch;
            $res->free();
            self::$_SqlHelper->close_connect();
            return array(
                'status' => 'ok',
                'message' => '订单详情',
                'data' => $DetUnorder
            );
        }
    }


=======
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
>>>>>>> origin/master

