<?php
/**
 * 视图基类
 * @author  chenchangsheng
 * @Date    2018/07/11
 */

namespace more\base;

//use  Symfony\Component\Translation;
class View {
    protected $variables = array();
    protected $_controller;
    protected $_action;

    function __construct($module, $controller, $action) {
        $this->_module = strtolower($module);
        $this->_controller = strtolower($controller);
        $this->_action = strtolower($action);
    }

    // 分配变量
    public function assign($name, $value) {
        $this->variables[$name] = $value;
    }

    // 渲染显示
    public function render($html = '') {
//        empty($html) ? $html = APP_PATH . APP_NAME . DIRECTORY_SEPARATOR . $this->_module . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR  : $html . '.html';
        //todo  制定html路径的文经的 $html 需要修改 : 后面的内容
        $file = APP_PATH . APP_NAME . DIRECTORY_SEPARATOR . $this->_module . DIRECTORY_SEPARATOR . 'view' ;
        empty($html) ? $html =  $file . DIRECTORY_SEPARATOR . $this->_action . '.html' : $file. $html .DIRECTORY_SEPARATOR.$html.'.html';

        //判断视图文件是否存在
        if (is_file($html)) {
//            \Twig_Autoloader::register();
            $loader = new \Twig_Loader_Filesystem($file);
            $twig = new \Twig_Environment($loader,[
                'cache' =>  APP_PATH . 'cache/twig',
                'debug' =>  APP_DEBUG,
            ]);
            echo  $twig->render('index.html',$this->variables ?? []);

        } else {
            echo "<h1>无法找到视图文件</h1>";
        }


    }
}