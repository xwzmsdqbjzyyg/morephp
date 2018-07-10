<?php

/**
 * Class cRedis
 * @author  changsheng
 * @Date    2018-06-29
 * redis操作类
 */
class cRedis {
    private $redis; //redis对象
    function __construct() {
        $redis_host = '127.0.0.1';
        $redis_port = 6379;
        $auth = '';
        try {
            $this->redis = new Redis();
            if (!$this->redis->connect($redis_host, $redis_port)) {
//                logs(4, "DkmRedis->newRedis ", "无法连接Redis服务,数据：主机->" . $redis_host . "，端口->" . $redis_port);    // 文件错误日志
                return false;
            }
            if (!empty($auth) && !$this->redis->auth($auth)) {
//                logs(4, "DkmRedis->newRedis ", "redis无法使用登录验证");    // 文件错误日志
                return false;
            }
            return $this->redis;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 设置值
     * @param string $key KEY名称
     * @param string|array $value 获取得到的数据
     * @param int $timeOut 时间
     */
    public function set($key, $value, $timeOut = 0) {
        try {
            $value = serialize($value);
            $retRes = $this->redis->set($key, $value);
            if ($timeOut > 0) {
                $this->redis->setTimeout($key, $timeOut);
            }
            return $retRes;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 通过KEY获取数据
     * @param string $key KEY名称
     */
    public function get($key) {
        try {
            $result = $this->redis->get($key);
            return unserialize($result);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 删除一条数据
     * @param string $key KEY名称
     */
    public function delete($key) {
        return $this->redis->delete($key);
    }

    /**
     * 清空数据
     */
    public function flushAll() {
        return $this->redis->flushAll();
    }

    /**
     * 数据入队列
     * @param string $key KEY名称
     * @param string|array $value 获取得到的数据
     * @param bool $right 是否从右边开始入
     */
    public function push($key, $value, $right = true) {
        $value = serialize($value);
        return $right ? $this->redis->rPush($key, $value) : $this->redis->lPush($key, $value);
    }

    /**
     * 数据出队列
     * @param string $key KEY名称
     * @param bool $left 是否从左边开始出数据
     */
    public function pop($key, $left = true) {
        $val = $left ? $this->redis->lPop($key) : $this->redis->rPop($key);
        return unserialize($val);
    }

    /**
     * 数据自增
     * @param string $key KEY名称
     */
    public function increment($key) {
        return $this->redis->incr($key);
    }

    /**
     * 数据自减
     * @param string $key KEY名称
     */
    public function decrement($key) {
        return $this->redis->decr($key);
    }

    /**
     * key是否存在，存在返回ture
     * @param string $key KEY名称
     */
    public function exists($key) {
        return $this->redis->exists($key);
    }

    /**
     * 返回redis对象
     * redis有非常多的操作方法，我们只封装了一部分
     * 拿着这个对象就可以直接调用redis自身方法
     */
    public function redis() {
        return $this->redis;
    }

}

?>
