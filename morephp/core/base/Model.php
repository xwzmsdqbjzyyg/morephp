<?php

namespace more\base;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as DB;

class Model {
    protected $model;

    public function __construct() {
        $DB = new DB;
        // 创建链接
        $database = include  APP_PATH.'common/config/db.config.php';
        $DB->addConnection($database);
        // 设置全局静态可访问
        $DB->setAsGlobal();
        // 启动Eloquent
        $DB->bootEloquent();
    }
}