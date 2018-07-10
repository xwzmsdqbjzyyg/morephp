<?php
defined('IN_YZMPHP') or exit('Access Denied');
yzm_base::load_sys_class('page','',0);

/**
 * Class dataProcess
 * 数据处理类： 数据判断、数据提取
 * @Date   2018-06-25
 */
class dataProcess{
    public function __construct(){

    }

    /**
     * 数据提取，根据需要的数据来从request拿
     * @param $arr  array   需要的参数
     * @return  array   结果集
     */
    public function dataExt($arr){
        !is_array($arr) && $arr = explode(',',$arr);
        $data = [];
        foreach ($arr as $v){
            $data[$v] = $_REQUEST[$v];
        }
        return $data;
    }

    /**
     * 数据筛选,返回错误信息并结束进程
     * $arr array   二维数组
     * $return  array   结果集
     */
    //todo  根据各种情况下的数据过滤处理
    public  function dataFifter($arr){

    }



}