<?php

namespace more\base;

/**
 * 视图基类
 */
class View {
    protected $variables = array();
    protected $_controller;
    protected $_action;

    function __construct($module,$controller, $action) {
        $this->_module = strtolower($module);
        $this->_controller = strtolower($controller);
        $this->_action = strtolower($action);
    }

    // 分配变量
    public function assign($name, $value) {
        $this->variables[$name] = $value;
    }

    // 渲染显示
    public function render($html='') {
        empty($html) ? $html =  $this->_action.'.html' : $html. '.html';
//        var_dump($this);exit;
        extract($this->variables);


        //判断视图文件是否存在
        $template = APP_NAME.DIRECTORY_SEPARATOR.$this->_module.DIRECTORY_SEPARATOR.'view'.DIRECTORY_SEPARATOR.$html;
        if (is_file($template)) {
            include($template);
        } else {
            echo "<h1>无法找到视图文件</h1>";
        }


    }
}