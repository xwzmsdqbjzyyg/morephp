<?php
namespace application\index\controller;

use more\base\Controller;
//use application\models\ItemModel;

class index extends Controller{
    public function __construct($moduleName,$controllerName, $actionName) {
        parent::__construct($moduleName,$controllerName, $actionName);
    }

    /**
     * 首页
     */
    public function index() {
        $this->assign('keyword', '123123123asdasdasd');
        $this->assign('items', 'testtest');
        $this->render();

    }





}