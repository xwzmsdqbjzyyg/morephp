<?php
namespace application\index\model;

use more\base\Model;

class userLogin extends Model{
    /**
     * 与模型关联的数据表
     * @var string
     */
//    protected $table = 'user';
    protected $table = 'wonder_article';
    /**
     * 该模型是否被自动维护时间戳
     * @var bool
     */
    public    $timestamps = false;


    public function __construct() {
        parent::__construct();





    }

    /**
     * 测试用 获取文章
     */
    public function getArticle() {
        $users = self::find(38)->toArray();
        print_r($users);exit;
//        var_dump($users);exit;
    }





}