<?php
/**
 * 验证判断 100成功   403用户或是密码错误   402用户或是密码错误    401无角色
 * @param array static $_AdminAtt 用户角色
 * @param array static $_AdminData 传输数据
 * return $array('code','message','data')
 */
header("Content-Type:text/html;charset=utf-8");

require_once '.\Order.php';
require_once '..\\sqlHelper.php';

const ORDERNOADD="HY";
const ORDERNONUM=5;

class OrderService{
    protected static $_SqlHelper;
    public  $date;

    public function __construct(){
       self::$_SqlHelper = new SqlHelper();
    }

    public function saveData($primalno,$password,$type,$orderdata){
       //货源编号
        $billid=self::orderNo();
        if($billid==0){
                return array(
                      'status' => 'fail',
                      'message' => '大于系统日期',
                      'data' => null
                  );
        }
       //客户为0 销售为1
       $originid = 0;
       //生产时间
       $happendate=date("Y-m-d h:i:sa" );
       //工单号 $billon
       //货方
       $cargoid=$orderdata["carryId"];
       //销售部门编号 sellid
       //销售编号 sellerid
       //客户名称
       $sql="SELECT organid FROM t_kj_worker WHERE primalno='".$primalno."';";
       $row= self::$_SqlHelper->fetch_row($sql);
       $customerid=$row[0];
       //联系人contacter
       //电话phone
       //运输类型
       $transittypeid=$orderdata["transittypeId"];
       //货物
       $cargotypeid=$orderdata["cargotypeId"];
       //mbl
       $mbl=$orderdata["mbl"];
       //hbl
       $hbl=$orderdata["hbl"];
       //客户端号 $orderno
       //船名航次$voyage
       //开船日期
       $shipdate=$orderdata["shipdate"];
       //截单日期
       $acceptdate=$orderdata["acceptdate"];
       //截关日期
       $customdate=$orderdata["customdate"];
       //开港日期
       $portdate=$orderdata["portdate"];
       //报价单 offer
       //定价方式 pricingid
       //协议号 pricingno
       //货物名称
       $cargo=$orderdata["cargo"];
       //包装种类
       $unitid=$orderdata["unitId"];
       //数量
       $num=$orderdata["num"];
       //重量
       $weight=$orderdata["weight"];
       //件数
       $bulk=$orderdata["bulk"];
       //运方判断 是1 否0
       $truckis=$orderdata["truckis"];
       //运方
       $truckid=$orderdata["truckid"];
       //路线
       $routeid=$orderdata["routeId"];
       //备注
       $remark=$orderdata["remark"];
       //状态 保存 1-0
       $billstatetb='1-0';
       //readyis
       //创建者
       $creatorid=$customerid;
       //创建时间
       $creatordate=$happendate;
       //修改者
       $modifydid=$customerid;
       //修改时间
       $modifydate=date("Y-m-d h:i:sa" );
       //auditerid
       //auitdate
      }



//      $sql="insert into t_test(id,valuea)  values(".$a.",'".$b."');
//           insert into t_test(id,valuea) values(3,'fds');
//           insert into t_test(id,valuea) values(4,'fds');";
//      $res = self::$sqlHelper->execute_dml($sql);



//     public function submitData(){
//     }

//     public function examineData(){

//     }

    public function orderNo(){
        $orderNo1=ORDERNOADD;
        $sql="SELECT date_format(now(),'%Y%m%d');";
        $row= self::$_SqlHelper->fetch_row($sql);
        $orderNo2=$row[0];
        $sql="SELECT MAX( substring(billid,3,8) )FROM t_zh_containerdemand;";
        $row= self::$_SqlHelper->fetch_row($sql);
        $res=$row[0];
        if($res==$orderNo2){
           $sql="SELECT RIGHT(MAX(RIGHT(billid,13)),5) FROM t_zh_containerdemand;";
           $orderNo3 = self::$_SqlHelper->fetch_row($sql);
           $orderNo3 = (int)$orderNo3[0]+1;
           $order=$orderNo1.$orderNo2.$orderNo3;
           return $order;
        }else if($res>$orderNo2){
            return 0;
        } else{
            $orderNo3=sprintf('%0'.ORDERNONUM.'d', 0);
            $order=$orderNo1.$orderNo2.$orderNo3;
            return $order;
        }
    }
}