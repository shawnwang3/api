<?php
/**
 * 验证判断 100成功   403用户或是密码错误   402用户或是密码错误    401无角色
 * return $array('code','message','data')
 */
header("Content-Type:text/html;charset=utf-8");

require_once '.\Order.php';
require_once '..\\sqlHelper.php';

const ORDERNOADD = "HY";

const ORDERNONUM = 5;

const SONID = 5;

class OrderService
{

    protected static $_SqlHelper;

    protected static $_Createdate;

    public static $_Billid;

    public function __construct()
    {
        self::$_SqlHelper = new SqlHelper();
    }

    public function saveData($primalno, $orderdata)
    {
        $res = self::orderNo();
        // 是否大于系统时间
        if (! $res) {
            return array(
                'status' => 'fail',
                'message' => '大于系统时间'
            );
            exit();
        }
        self::$_Billid = $res;
        /**
         * *主表**
         */
        // 货源编号
        $billid = self::$_Billid;
        // 客户为0 销售为1
        $originid = 0;
        // 发生时间
        $happendate = date("Y-m-d h:i:s");
        // 工单号billno
        // 货方
        $cargoid = $orderdata['cargotypeId'];
        // 销售部门 sellid
        // 销售员sellerid
        // 客户
        $sql = "SELECT organid FROM t_kj_worker WHERE primalno= '" . $primalno . "';";
        $row = self::$_SqlHelper->fetch_row($sql);
        $customerid = $row[0];
        // 联系人contacter
        // 联系人电话phone
        // 运输类型
        $transittypeid = $orderdata['transittypeId'];
        // 货物性质
        $cargotypeid = $orderdata['cargotypeId'];
        // mbl
        $mbl = $orderdata['mbl'];
        // hbl
        $hbl = $orderdata['hbl'];
        // 客户单号orderno
        // 船名航次voyage
        // 开船日期
        $shipdate = $orderdata['shipdate'];
        // 接单日期
        $acceptdate = $orderdata['acceptdate'];
        // 截关日期
        $customdate = $orderdata['customdate'];
        // 开港日期
        $portdate = $orderdata['portdate'];
        // 报单价offer
        // 定价方式oricingid
        // 协议价pricingno
        // 货物名称
        $cargo = $orderdata['cargo'];
        // 包装种类
        $unitid = $orderdata['unitId'];
        // 件数
        $num = $orderdata['num'];
        // 重量
        $weight = $orderdata['weight'];
        // 体积
        $bulk = $orderdata['bulk'];
        // 运方
        $carryid = $orderdata['carryId'];
        // 判断是否有指定车方
        $truckis = $orderdata['truckIs'];
        // 指定车方
        $truckid = $orderdata['truckId'];
        // 路线
        $routeid = $orderdata['routeId'];
        // 备注
        $remark = $orderdata['remark'];
        // 状态
        $billstatetb = '1-0';
        // 订单完成情况
        $readyis = 0;
        // 引用
        $billrefer = 0;
        // 创建者
        $creatorid = $customerid;
        // 创建时间
        $createdate = self::$_Createdate;
        // 修改者
        $menderid = $customerid;
        // 修改时间
        $modifydate = date("Y-m-d h:i:s");
        // 审核人auditerid
        // 审核时间auditdate
        
        /**
         * ****子表站点***
         */
        
        // 提箱点
        
        $start_siteorder = $orderdata['site']['stationstart']['siteorder'];
        $start_billid = $billid;
        $res = sprintf('%0' . SONID . 'd', $start_siteorder);
        $start_sonid = $billid . $res;
        $start_sitetypeid = $orderdata['site']['stationstart']['sitetypeId'];
        $start_siteid = $orderdata['site']['stationstart']['stationId'];
        $start_address = $orderdata['site']['stationstart']['address'];
        $start_contact = $orderdata['site']['stationstart']['contact'];
        $start_phone = $orderdata['site']['stationstart']['phone'];
        $start_predicttime = $orderdata['site']['stationstart']['predicttime'];
        $start_remark = $orderdata['site']['stationstart']['remark'];
        
        // var_dump($billid,$originid,$happendate,$cargoid,$customerid,$transittypeid,$cargotypeid,$mbl,$hbl,$shipdate,$acceptdate,$customdate,$portdate,$cargo,$unitid,$num,$weight,$bulk,$carryid,$truckis,$truckid,$routeid,$remark,$billstatetb,$readyis,$billrefer,$creatorid,$createdate,$menderid,$modifydate);
        // 插入主表数据库
        $sql = "INSERT INTO t_zh_containerdemand(billid,originid,happendate,cargoid,customerid,transittypeid,cargotypeid,mbl,hbl,shipdate,acceptdate,customdate,portdate,cargo,unitid,num,weight,bulk,carryid,truckis,truckid,routeid,remark,billstatetb,readyis,billrefer,creatorid,createdate,menderid,modifydate)  
            VALUES('" . $billid . "','" . $originid . "','" . $happendate . "','" . $cargoid . "','" . $customerid . "','" . $transittypeid . "','" . $cargotypeid . "','" . $mbl . "','" . $hbl . "','" . $shipdate . "','" . $acceptdate . "','" . $customdate . "','" . $portdate . "','" . $cargo . "','" . $unitid . "','" . $num . "','" . $weight . "','" . $bulk . "','" . $carryid . "','" . $truckis . "','" . $truckid . "','" . $routeid . "','" . $remark . "','" . $billstatetb . "','" . $readyis . "','" . $billrefer . "','" . $creatorid . "','" . $createdate . "','" . $menderid . "','" . $modifydate . "');";
        $row = self::$_SqlHelper->excute_dml($sql);
        if ($row == 0 || $row == 2) {
            return array(
                'status' => 'fail',
                'message' => '数据存储失败'
            );
            exit();
        }
        // 插入提箱点数据库
        $sql = "INSERT INTO t_zh_containerdemandsite(billid,sonid,siteorder,sitetypeid,siteid,addressa,contacter,phone,predicttime,remark) 
            VALUES('" . $start_billid . "','" . $start_sonid . "','" . $start_siteorder . "','" . $start_sitetypeid . "','" . $start_siteid . "','" . $start_address . "','" . $start_contact . "','" . $start_phone . "','" . $start_predicttime . "','" . $start_remark . "');";
        $row = self::$_SqlHelper->excute_dml($sql);
        if ($row == 0 || $row == 2) {
            return array(
                'status' => 'fail',
                'message' => '数据存储失败'
            );
            exit();
        }
        
        // 门点
        $arr = $orderdata['site']['door'];
        $doorcount = count($arr);
        for ($i = 1; $i <= $doorcount; $i ++) {
            $door_siteorder = $orderdata['site']['door']["door" . $i]['siteorder'];
            $door_billid = $billid;
            $res = sprintf('%0' . SONID . 'd', $door_siteorder);
            $door_sonid = $billid . $res;
            $door_sitetypeid = $orderdata['site']['door']["door" . $i]['sitetypeId'];
            $door_siteid = $orderdata['site']['door']["door" . $i]['stationId'];
            $door_address = $orderdata['site']['door']["door" . $i]['address'];
            $door_contact = $orderdata['site']['door']["door" . $i]['contact'];
            $door_phone = $orderdata['site']['door']["door" . $i]['phone'];
            $door_predicttime = $orderdata['site']['door']["door" . $i]['predicttime'];
            $door_remark = $orderdata['site']['door']["door" . $i]['remark'];
            
            // 插入门点数据库
            $sql = "INSERT INTO t_zh_containerdemandsite(billid,sonid,siteorder,sitetypeid,siteid,addressa,contacter,phone,predicttime,remark)
            VALUES('" . $door_billid . "','" . $door_sonid . "','" . $door_siteorder . "','" . $door_sitetypeid . "','" . $door_siteid . "','" . $door_address . "','" . $door_contact . "','" . $door_phone . "','" . $door_predicttime . "','" . $door_remark . "');";
            $row = self::$_SqlHelper->excute_dml($sql);
            if ($row == 0 || $row == 2) {
                return array(
                    'status' => 'fail',
                    'message' => '数据存储失败'
                );
                exit();
            }
        }
        
        // 还箱点
        $end_siteorder = $orderdata['site']['stationend']['siteorder'];
        $end_billid = $billid;
        $res = sprintf('%0' . SONID . 'd', $end_siteorder);
        $end_sonid = $billid . $res;
        $end_sitetypeid = $orderdata['site']['stationend']['sitetypeId'];
        $end_siteid = $orderdata['site']['stationend']['stationId'];
        $end_address = $orderdata['site']['stationend']['address'];
        $end_contact = $orderdata['site']['stationend']['contact'];
        $end_phone = $orderdata['site']['stationend']['phone'];
        $end_predicttime = $orderdata['site']['stationend']['predicttime'];
        $end_remark = $orderdata['site']['stationend']['remark'];
        // 插入还箱点数据库
        $sql = "INSERT INTO t_zh_containerdemandsite(billid,sonid,siteorder,sitetypeid,siteid,addressa,contacter,phone,predicttime,remark)
            VALUES('" . $end_billid . "','" . $end_sonid . "','" . $end_siteorder . "','" . $end_sitetypeid . "','" . $end_siteid . "','" . $end_address . "','" . $end_contact . "','" . $end_phone . "','" . $end_predicttime . "','" . $end_remark . "');";
        $row = self::$_SqlHelper->excute_dml($sql);
        if ($row == 0 || $row == 2) {
            return array(
                'status' => 'fail',
                'message' => '数据存储失败'
            );
            exit();
        }
        
        // 箱量
        $arr = $orderdata['sub'];
        $subcount = count($arr);
        for ($i = 1; $i <= $subcount; $i ++) {
            $sub_order = $orderdata['sub']["sub" . $i]['suborder'];
            $sub_billid = $billid;
            $res = sprintf('%0' . SONID . 'd', $sub_order);
            $sub_sonid = $billid . $res;
            $sub_containertypeid = $orderdata['sub']["sub" . $i]['containertypeid'];
            $sub_containerkindid = $orderdata['sub']["sub" . $i]['containerkindid'];
            $sub_price = $orderdata['sub']["sub" . $i]['price'];
            $sub_plan = $orderdata['sub']["sub" . $i]['plan'];
            $sub_remark = $orderdata['sub']["sub" . $i]['remark'];
            // 插入箱量数据库
            $sql = "INSERT INTO t_zh_containerdemandsub(billid,sonid,containertypeid,containerkindid,price,plan,remark)
            VALUES('" . $sub_billid . "','" . $sub_sonid . "','" . $sub_containertypeid . "','" . $sub_containerkindid . "','" . $sub_price . "','" . $sub_plan . "','" . $sub_remark . "');";
            $row = self::$_SqlHelper->excute_dml($sql);
            if ($row == 0 || $row == 2) {
                return array(
                    'status' => 'fail',
                    'message' => '数据存储失败'
                );
                exit();
            }
        }
        return array(
            'status' => 'ok',
            'message' => '数据保存成功'
        );
        self::$_SqlHelper->close_connect();
    }

    public function submitData($primalno, $orderdata)
    {
        self::saveData($primalno, $orderdata);
        $billid = self::$_Billid;
        $type = '1-2';
        $sql = "call p_zh_containerdemand_billstate('" . $billid . "','" . $type . "',@ai_code,@as_msg);";
        $row = self::$_SqlHelper->execute_dql($sql);
        $res = $row->fetch_row();
        if ($res[0] == 1) {
            return array(
                'status' => 'ok',
                'message' => '数据提交成功'
            );
        } else {
            return array(
                'status' => 'fail',
                'message' => '数据提交失败'
            );
        }
        self::$_SqlHelper->close_connect();
    }

    public function affirmData($primalno, $orderdata)
    {
        self::saveData($primalno, $orderdata);
        $billid = self::$_Billid;
        $type = '1-5';
        $sql = "call p_zh_containerdemand_billstate('" . $billid . "','" . $type . "',@ai_code,@as_msg);";
        $row = self::$_SqlHelper->execute_dql($sql);
        $res = $row->fetch_row();
        if ($res[0] == 1) {
            return array(
                'status' => 'ok',
                'message' => '数据审核成功'
            );
        } else {
            return array(
                'status' => 'fail',
                'message' => '数据审核失败'
            );
        }
        self::$_SqlHelper->close_connect();
    }

    public function orderNo()
    {
        self::$_Createdate = date("Y-m-d h:i:s");
        $orderNo1 = ORDERNOADD;
        $sql = "SELECT date_format(now(),'%Y%m%d');";
        $row = self::$_SqlHelper->fetch_row($sql);
        $orderNo2 = $row[0];
        $sql = "SELECT MAX(substring(billid,3,8)) FROM t_zh_containerdemand;";
        $row = self::$_SqlHelper->fetch_row($sql);
        $res = $row[0];
        if ($res == $orderNo2) {
            $sql = "SELECT RIGHT(MAX(RIGHT(billid,13)),5) FROM t_zh_containerdemand;";
            $orderNo3 = self::$_SqlHelper->fetch_row($sql);
            $orderNo3 = (int) $orderNo3[0] + 1;
            $orderNo3 = sprintf('%0' . ORDERNONUM . 'd', $orderNo3);
            $order = $orderNo1 . $orderNo2 . $orderNo3;
            return $order;
        } else 
            if ($res > $orderNo2) {
                return null;
            } else {
                $orderNo3 = sprintf('%0' . ORDERNONUM . 'd', 1);
                $order = $orderNo1 . $orderNo2 . $orderNo3;
                return $order;
            }
    }
}