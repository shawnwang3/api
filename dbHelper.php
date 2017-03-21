<?php
header("Content-Type:text/html;charset=utf-8");
class DbHelper
{

    private static $_instance;

    private static $_connectSource;

    private $_dbConfig = array(
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
		'database' => 'tms'
    );

    private function __construct()
    {}

    //单例模式
    static public function getInstance()
    {
        if (! (self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    // 连接数据库
    public function connect()
    {
        if (! self::$_connectSource) {
            self::$_connectSource = new mysqli($this->_dbConfig['host'], $this->_dbConfig['user'], $this->_dbConfig['password'], $this->_dbConfig['database']);

            if (! self::$_connectSource) {
                die('mysql connect error' . self::$_connectSource->connect_error());
            }

            self::$_connectSource->query("set names UTF8");
        }
        $res = self::$_connectSource;
        return $res;
    }
}
//  $sql="select * from t_kj_naming";
//  $a=DbHelper::getInstance()->connect();
//  var_dump($a);




