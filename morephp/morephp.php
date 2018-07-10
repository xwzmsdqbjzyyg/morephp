<?php
/**
 * MOREPHP框架入口文件
 *
 * @author           陈长生
 * @license          http://www.yzmcms.com
 * @lastmodify       2016-09-19
 */

namespace more;

//设置系统的输出字符为utf-8
header('Content-Type:text/html;charset=utf-8');

//设置时区（中国）
date_default_timezone_set('PRC');

defined('MOREPHP_PATH') or exit('Access Denied.');


//MOREPHP框架版本信息
define('MOREPHP_VERSION', '1.0');
//MOREPHP应用目录
define('APP_PATH', MOREPHP_PATH );
define('CORE_PATH', MOREPHP_PATH . 'morephp' . DIRECTORY_SEPARATOR.'core');
//系统开始时间
define('SYS_START_TIME', microtime(true));
//系统时间
define('SYS_TIME', time());

//主机协议
define('SERVER_PORT', isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://');
//当前访问的主机名
define('HTTP_HOST', (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ''));
//来源
define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
//类文件后缀
define('EXT', '.class.php');


class Morephp {
    protected $config = [];

    public function __construct($config) {
        $this->config = $config;
    }

    public function run() {
        spl_autoload_register(array($this, 'loadClass'));
        $this->setReporting();
        $this->removeMagicQuotes();
        $this->unregisterGlobals();
        $this->setDbConfig();
        $this->route();
    }

    /**
     * 路由处理
     */
    public function route() {
        $controllerName = $this->config['defaultController'];
        $actionName = $this->config['defaultAction'];
        $param = array();

        $url = $_SERVER['REQUEST_URI'];
        switch (URL_MODEL){
            case 0:
                $moduleName = $_GET['m'] ?? '';   // 获取模块名
                $controllerName = $_GET['c'] ?? '';   // 获取控制器名
                $actionName = $_GET['a'] ?? '';       // 获取方法名
            case 1:
                $request = array_values(array_filter(explode('/',$url)));
                $moduleName =$request[0] ?? '';
                $controllerName = $request[1] ?? '';
                $actionName = $request[2] ?? '';
            default:
                $request = array_values(array_filter(explode('/',$url)));
                $moduleName =$request[0] ?? '';
                $controllerName = $request[1] ?? '';
                $actionName = $request[2] ?? '';
        }
        // 判断控制器和操作是否存在
        strlen($url) < 3  && $moduleName = $controllerName  = $actionName  = 'index';;
        $controller = APP_NAME.DIRECTORY_SEPARATOR.$moduleName.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.$controllerName;
        if (!class_exists($controller)) {

            exit($controller . '控制器不存在');
        }
        if (!method_exists($controller, $actionName)) {
            exit($actionName . '方法不存在');
        }
        $dispatch = new $controller($moduleName,$controllerName, $actionName);

        // $dispatch保存控制器实例化后的对象，我们就可以调用它的方法，
        // 也可以像方法中传入参数，以下等同于：$dispatch->$actionName($param)
        call_user_func_array(array($dispatch, $actionName), $param);
    }

    /**
     * 是否显示错误信息
     */
    public function setReporting() {
        if (APP_DEBUG === true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
        }
    }

    /**
     * 删除敏感字符
     */
    public function stripSlashesDeep($value) {
        $value = is_array($value) ? array_map(array($this, 'stripSlashesDeep'), $value) : stripslashes($value);
        return $value;
    }

    /**
     * 检测敏感字符并删除
     */
    public function removeMagicQuotes() {
        if (get_magic_quotes_gpc()) {
            $_GET = isset($_GET) ? $this->stripSlashesDeep($_GET) : '';
            $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST) : '';
            $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
            $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
        }
    }

    /**
     * 检测自定义全局变量并移除。因为 register_globals 已经弃用，如果已经弃用的 register_globals 指令被设置为 on，
     * 那么局部变量也将在脚本的全局作用域中可用。 例如， $_POST['foo'] 也将以 $foo 的形式存在，这样写是不好的实现，
     * 会影响代码中的其他变量。 相关信息，
     *参考: http://php.net/manual/zh/faq.using.php#faq.register-globals
     */
    public function unregisterGlobals() {
        if (ini_get('register_globals')) {
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach ($array as $value) {
                foreach ($GLOBALS[$value] as $key => $var) {
                    if ($var === $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    /**
     * 获取数据库信息
     */
    public function setDbConfig() {
        if ($this->config['db']) {
            define('DB_HOST', $this->config['db']['host']);
            define('DB_NAME', $this->config['db']['dbname']);
            define('DB_USER', $this->config['db']['username']);
            define('DB_PASS', $this->config['db']['password']);
        }
    }

    // 自动加载类
    public function loadClass($className) {
        $classMap = $this->classMap();
        if (isset($classMap[$className])) {// 包含内核文件
            $file = $classMap[$className];
        } elseif (strpos($className, '\\') !== false) { // 包含应用（application目录）文件
            $file = APP_PATH . str_replace('\\', '/', $className) . '.php';
            if (!is_file($file)) {
                return;
            }
        } else {
            return;
        }
        include $file;

        // 这里可以加入判断，如果名为$className的类、接口或者性状不存在，则在调试模式下抛出错误
    }

    // 内核文件命名空间映射关系
    protected function classMap() {
        return [
            'more\base\Controller' => CORE_PATH . '/base/Controller.php',
            'more\base\Model' => CORE_PATH . '/base/Model.php',
            'more\base\View' => CORE_PATH . '/base/View.php',
            'more\db\Db' => CORE_PATH . '/db/Db.php',
            'more\db\Sql' => CORE_PATH . '/db/Sql.php',
        ];
    }

}