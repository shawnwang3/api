<?php

require_once 'dbHelper.php';

class SqlHelper
{

    public static $_conn;

    public function __construct()
    {
        self::$_conn = DbHelper::getInstance()->connect();
    }

    // 操作ql
    public function execute_dql($sql)
    {
        $res = self::$_conn->query($sql) or die("sql_dql报错" . self::$_conn->error);
        return $res;
        $res->free();
    }
    //

    // 操作dml
    public function excute_dml($sql)
    {
        $res = self::$_conn->query($sql) or die("sql_dml报错" . self::$_conn->error);
        if (! $res) {
            return 0;                //操作失败
        } else {
            if (self::$_conn->affected_rows > 0) {
                return 1;            //操作成功
            } else {
                return 2;            //没有影响到行数
            }
        }
        $res->free();
    }
    //mysqli_fetch_assoc 查数据 关联数组
    public function fetch_assoc($sql){
        $res = $this->execute_dql($sql);
        return $res->fetch_assoc();
        $res->free();
    }
    //mysqli_fetch_row 查数据 关联数值
    public function fetch_row($sql){
        $res = $this->execute_dql($sql);
        return $res->fetch_row();
        $res->free();
    }

    //关闭数据库
    public function close_connect() {
        if(!empty(self::$_conn)){
            self::$_conn->close();
        }
    }
}