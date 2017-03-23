<?php
/*
 * 下单预加载信息模型
 */
header("Content-Type:text/html;charset=utf-8");
require_once '..\sqlHelper.php';

class InfoService
{

    private static $_SqlHelper;

    public static $_Infodata = array();

    public function __construct()
    {
        self::$_SqlHelper = new SqlHelper();
    }

    function getInfo($primalno)
    {

        // 用户单位id
        $sql = "SELECT organid,worker FROM t_kj_worker WHERE primalno='" . $primalno . "'";
        $row = self::$_SqlHelper->fetch_assoc($sql);
        $organid = $row['organid'];
        $worker = $row['worker'];
        self::$_Infodata[0] = $organid;
        self::$_Infodata[1] = $worker;
        // 运输类型
        $transittype = array();
        $sql = "SELECT transittypeid,transittype FROM t_zh_transittype";
        $res = self::$_SqlHelper->execute_dql($sql);
        while ($row = $res->fetch_assoc()) { 
                $arr = array(
                    'transitttypeId' => $row['transittypeid'],
                    'transittypeName' => $row['transittype']
                );
            
            $transittype[] = $arr;
        }
        // 货物性质
        $cargotype = array();
        $sql = "SELECT cargotypeid,cargotype FROM t_zh_cargotype";
        $res = self::$_SqlHelper->execute_dql($sql);
        while ($row = $res->fetch_assoc()) {
                $arr = array(
                    'cargotypeId' => $row['cargotypeid'],
                    'cargotypeName' => $row['cargotype']
                );
            $cargotype[] = $arr;
        }
        // 包装种类
        $unit = array();
        $sql = "SELECT unitid,unit FROM t_zh_unit";
        $res = self::$_SqlHelper->execute_dql($sql);
        while ($row = $res->fetch_assoc()) {
                $arr = array(
                    'unitId' => $row['unitid'],
                    'unitName' => $row['unit']
                );            
            $unit[] = $arr;
        }
        // 运方
        $carry = array();
        $sql = "SELECT organid,organ FROM t_kj_organ WHERE carryis=1";
        $res = self::$_SqlHelper->execute_dql($sql);
        while ($row = $res->fetch_assoc()) {
                $arr = array(
                    'carryId' => $row['organid'],
                    'carryName' => $row['organ']
                );          
            $carry[] = $arr;
        }
        // 指定车方
        $truck = array();
        $sql = "SELECT organid,organ FROM t_kj_organ WHERE truckis=1";
        $res = self::$_SqlHelper->execute_dql($sql);
        while ($row = $res->fetch_assoc()) {
                $arr = array(
                    'truckId' =>$row['organid'],
                    'truckName' =>$row['organ']
                );
            $truck[] = $arr;
        }
        // 路线
        $route = array();
        $sql = "SELECT routeid,route FROM t_zh_route";
        $res = self::$_SqlHelper->execute_dql($sql);
        while ($row = $res->fetch_assoc()) {
                $arr = array(
                    'routeId' => $row['routeid'],
                    'routeName' => $row['route']
                );            
            $route[] = $arr;
        }
        // 货方
        $cargo = array();
        $sql = "SELECT organid,organ FROM t_kj_organ WHERE cargois=1";
        $res = self::$_SqlHelper->execute_dql($sql);
        while ($row = $res->fetch_assoc()) {
                $arr = array(
                    'cargoId' => $row['organid'],
                    'cargoName' => $row['organ']
                );
            $cargo[] = $arr;
        }
        // 提箱点
        $stationstartis = array();
        $sql = "SELECT organid,organ,postaddress,contacter,phone FROM t_kj_organ WHERE stationstartis=1";
        $res = self::$_SqlHelper->execute_dql($sql);
        while ($row = $res->fetch_assoc()) {
                $arr = array(
                    'stationstartisId' => $row['organid'],
                    'stationstartName' => $row['organ'],
                    'stationstartPostaddress' =>$row['postaddress'],
                    'stationstartContacter' => $row['contacter'],
                    'stationstartPhone' => $row['phone']
                );
            $stationstartis[] = $arr;
        }
        // 门点
        $dooris = array();
        $sql = "SELECT organid,organ,postaddress,contacter,phone FROM t_kj_organ WHERE dooris=1";
        $res = self::$_SqlHelper->execute_dql($sql);
        while ($row = $res->fetch_assoc()) {
                $arr = array(
                    'doorId' => $row['organid'],
                    'doorName' => $row['organ'],
                    'doorPostaddress' =>$row['postaddress'],
                    'doorContacter' => $row['contacter'],
                    'doorPhone' => $row['phone']
                );
            $dooris[] = $arr;
        }
        // 还箱点
        $stationendis = array();
        $sql = "SELECT organid,organ,postaddress,contacter,phone FROM t_kj_organ WHERE stationendis=1";
        $res = self::$_SqlHelper->execute_dql($sql);
        while ($row = $res->fetch_assoc()) {
                $arr = array(
                    'stationendId' => $row['organid'],
                    'stationendName' => $row['organ'],
                    'stationendPostaddress' => $row['postaddress'],
                    'stationendContacter' => $row['contacter'],
                    'stationendPhone' => $row['phone']
                );
            $stationendis[] = $arr;
        }
        //箱型
        $containertype = array();
        $sql = "SELECT containertypeid,containertype FROM t_zh_containertype";
        $res = self::$_SqlHelper->execute_dql($sql);
        while ($row = $res->fetch_assoc()) {
                $arr = array(
                    'containertypeId' => $row['containertypeid'],
                    'containertypeName' => $row['containertype']
                );
            $containertype[] = $arr;
        }
        //类别
        $containerkind = array();
        $sql = "SELECT containerkindid,containerkind FROM t_zh_containerkind";
        $res = self::$_SqlHelper->execute_dql($sql);
        while ($row = $res->fetch_assoc()) {
                $arr = array(
                    'containerkindId' => $row['containerkindid'],
                    'containerkindName' => $row['containerkind']
                );
            $containerkind[] = $arr;
        }

        self::$_SqlHelper->close_connect();

         self::$_Infodata['infoAdd']= array(
            $transittype,
            $cargotype,
            $unit,
            $carry,
            $truck,
            $route,
            $cargo,
            $stationstartis,
            $dooris,
            $stationendis,
            $containertype,
            $containerkind
        );
        return array(
            'status' => 'ok',
            'message' => '请输入信息',
            'data' => self::$_Infodata
        );
    }
}

