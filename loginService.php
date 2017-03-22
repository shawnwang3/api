<?php
/**
 * 验证判断 100成功   403用户或是密码错误   402用户或是密码错误    401无角色
 * @param array static $_AdminAtt 用户角色
 * @param array static $_AdminData 传输数据
 * return $array('code','message','data')
 */
header("Content-Type:text/html;charset=utf-8");

require_once 'Login.php';
require_once 'sqlHelper.php';

class LoginService
{
    public  static $_AdminData = array();
    public  static $_AdminAtt = array();
    private  static $_SqlHelper;

    public function __construct(){
        self::$_SqlHelper=new SqlHelper();
    }

    // 用户角色验证
    public function checkLogin($primalno, $password)
    {
        $sql = "select password from t_kj_worker where primalno='" . $primalno . "'";
        $res = self::$_SqlHelper->execute_dql($sql);

        if (! ($row = $res->fetch_assoc()) == false) {
            if ($password == $row['password']) {

                $sql = "SELECT worker FROM t_kj_worker WHERE primalno='" . $primalno . "'";
                $row = self::$_SqlHelper->fetch_assoc($sql);
                $worker = $row['worker'];
                self::$_AdminData[0] = $worker;

                $sql = "SELECT organid FROM t_kj_worker WHERE primalno='" . $primalno . "'";
                $row = self::$_SqlHelper->fetch_assoc($sql);
                $organId = $row['organid'];
                self::$_AdminData[1] = $organId;


                $sql = "SELECT organ.customeris,organ.cargois,organ.carryis,organ.stationis,organ.truckis,worker.driveris,organ.shopis
                       FROM t_kj_organ AS organ
                       LEFT JOIN  t_kj_worker AS worker
                       ON organ.organid=worker.organid
                       WHERE worker.primalno='" . $primalno . "'";
                $row = self::$_SqlHelper->fetch_row($sql);
               foreach ($row as $key=>$val){
                   if ($val==1){
                   self::$_AdminAtt[]=$key+1;
                   }
               }

                self::$_AdminData[2] = self::$_AdminAtt;

                self::$_SqlHelper->close_connect();

                if (count(self::$_AdminAtt) == false) {
                    return array(
                        'code' => 401,
                        'status' => 'fail',
                        'message' => '无角色',
                        'data' => self::$_AdminData
                    );
                } else {
                    return array(
                        'code' => 100,
                        'status' => 'ok',
                        'message' => '成功',
                        'data' => self::$_AdminData
                    );
                }
            } else {
                return array(
                    'code' => 402,
                    'status' => 'fail',
                    'message' => '用户或是密码错误',
                    'data' => null
                );
            }
        } else {
            return array(
                'code' => 403,
                'status' => 'fail',
                'message' => '用户或是密码错误',
                'data' => null
            );
        }
    }
}