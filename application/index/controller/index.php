<?php
namespace application\index\controller;

use more\base\Controller;
use application\model\userLogin;

class index extends Controller{
    public function __construct($moduleName,$controllerName, $actionName) {
        parent::__construct($moduleName,$controllerName, $actionName);
    }

    /**
     * 首页
     */
    public function index() {
//        var_dump(userLogin());exit;
//        $model = new userLogin();
//        $data = $model->getArticle();






        $this->assign('keyword', '123123123asdasdasd');
        $this->assign('items', 'testtest');
        $this->assign('testArray', [
            '123'=>'123',
            '789'=>'木头人'
        ]);
        $this->render();

    }





}