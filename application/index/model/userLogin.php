<?php
namespace application\model;

use more\base\model;

class userLogin extends Model{
    protected $table = 'user';

    public function __construct() {
        parent::__construct();
    }

    /**
     * 测试用 获取文章
     */
    public function getArticle() {

        $users = self::find(1);
        var_dump($users);exit;
    }





}