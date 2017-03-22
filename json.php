<?php

/**
 * 按json方式输出通信数据
*
* @param integer $code
*            状态码
* @param string $message
*            提示信息
* @param array $data
*            数据
*            return string
*/
header("Content-Type:text/html;charset=utf-8");

class Json
{
    public function jsonEn( $status="",$message = "", $data = array())
    {

          if($status=='ok'){
              if($data){
              $result = array(
                 
                  'status'=>$status,
                  'message' => $message,
                  'data' => $data
                  );}else{
                      $result = array(
                           
                          'status'=>$status,
                          'message' => $message,
                          );
              }             
          }else{
              $result = array(
                  'status'=>$status,
                  'message' => $message,                 
              );                  
              } 

        return json_encode($result);
    }
    public function jsonDe($data){
        
        return json_decode($data,true);
        
        
    }
    
    
    
}