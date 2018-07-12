<?php
/**
 * index.php 文件单一入口
 *
 * @author           陈长生  
 * @license          https://github.com/xwzmsdqbjzyyg/morephp
 * @lastmodify       2018-07-9
 */

/**
 * 本框架是基于PHP7开发，版本应大于7.0
 */
version_compare(PHP_VERSION,'7.0.0','<') &&  exit('您的PHP版本不能小于7.0,当前版本为 '. PHP_VERSION);

//调试模式：开发阶段设为开启true，部署阶段设为关闭false。
define('APP_DEBUG',true);
//define('APP_DEBUG',false);

//URL模式: 0=>普通模式，1=>PATHINFO模式。
define('URL_MODEL', '1');

//项目名称，同时在网站根目录下有同名项目
define('APP_NAME', 'application');

//morephp根路径
define('MOREPHP_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);



//加载morephp框架的入口文件
require(MOREPHP_PATH.'morephp'.DIRECTORY_SEPARATOR.'morephp.php');
//加载common下的db.config文件
$config = require(MOREPHP_PATH . 'common/config/config.php');

(new more\Morephp($config))->run();




