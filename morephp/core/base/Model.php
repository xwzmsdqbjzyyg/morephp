<?php
namespace more\base;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model as baseModel;

class Model extends baseModel{
    protected $model;
    public function __construct() {
        $this->DB = new DB;
        // 创建链接
        $database = include  APP_PATH.'common/config/db.config.php';
        $this->DB->addConnection($database['db']);
       // 设置全局静态可访问
        $this->DB->setAsGlobal();
       // 启动Eloquent
        $this->DB->bootEloquent();

    }

}