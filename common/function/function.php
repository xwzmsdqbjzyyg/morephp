<?php
/**
 * function.php   用户自定义函数库
 *
 * @author           陈长生
 * @license          https://github.com/xwzmsdqbjzyyg/morephp
 * @lastmodify       2018-07-9
 */


/**
 * 返回附件类型图标
 *
 * @param $file 附件名称
 */
function file_icon($file) {
    $ext_arr = array('doc', 'docx', 'ppt', 'xls', 'txt', 'pdf', 'mdb', 'jpg', 'gif', 'png', 'bmp', 'jpeg', 'rar', 'zip', 'swf', 'flv');
    $ext = fileext($file);
    if (in_array($ext, $ext_arr))
        return STATIC_URL . 'images/ext/' . $ext . '.gif';
    else return STATIC_URL . 'images/ext/hlp.gif';
}


/**
 * 设置路由映射
 */
function set_mapping() {
    if (!$mapping = getcache('mapping', 2)) {
        $data = D('category')->field('type,catid,catdir')->where(array('type!=' => 2))->select();
        $mapping = array();
        foreach ($data as $val) {
            $mapping['^' . $val['catdir'] . '$'] = 'index/index/lists/catid/' . $val['catid'];
            if (!$val['type']) {
                $mapping['^' . $val['catdir'] . '\/list_(\d+)$'] = 'index/index/lists/catid/' . $val['catid'] . '/page/$1';
                $mapping['^' . $val['catdir'] . '\/(\d+)$'] = 'index/index/show/catid/' . $val['catid'] . '/id/$1';
            }
        }
        //结合自定义URL规则
        $route_rules = get_urlrule();
        if (!empty($route_rules))
            $mapping = array_merge($route_rules, $mapping);
        setcache('mapping', $mapping, 2);
    }
    return $mapping;
}


/**
 * 获取自定义URL规则
 * @return array
 */
function get_urlrule() {
    if (!$urlrule = getcache('urlrule', 2)) {
        $data = D('urlrule')->select();
        $urlrule = array();
        foreach ($data as $val) {
            $val['urlrule'] = '^' . str_replace('/', '\/', $val['urlrule']) . '$';
            $urlrule[$val['urlrule']] = $val['route'];
        }
        setcache('urlrule', $urlrule, 2);
    }
    return $urlrule;
}


/**
 * 对用户的密码进行加密(yzmphp用)
 *
 * @param $pass 字符串
 *
 * @return string 字符串
 */
function password($pass) {
    return substr(md5(trim($pass)), 3, 26);
}


/**facebook  专用
 * [_curl_get description]
 *
 * @param  [type]  $url     [description]
 * @param  integer $timeout [description]
 * @param  [type]  $ip      [description]
 * @param  integer $port    [description]
 *
 * @return [type]           [description]
 */
function _curl_get($url, $timeout = 30, $ip = null, $port = 80) {
    $arrCurlResult = array();
    if ($ip === null) {    //不带代理方式
        $ch = curl_init($url);
    } else {
        $ch = curl_init();
        $proxy = "http://$ip:$port";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
    }


    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    $output = curl_exec($ch);
    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $arrCurlResult['output'] = $output;    //返回结果
    $arrCurlResult['response_code'] = $responseCode; //返回http状态
    curl_close($ch);
    unset($ch);
    return $arrCurlResult;
}


/**  使用curl发送数据 以post形式
 * [_curl_post description]
 *
 * @param  [type]  $url     [description]
 * @param  integer $timeout [description]
 * @param  [type]  $ip      [description]
 * @param  integer $port    [description]
 *
 * @return [type]           [description]
 */
function _curl_post($url, $data, $timeout = 30, $ip = null, $port = 80) {
    $arrCurlResult = array();
    if ($ip === null) {    //不带代理方式
        $ch = curl_init($url);
    } else {
        $ch = curl_init();
        $proxy = "http://$ip:$port";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
    }

    $str = http_build_query($data);


    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    $output = curl_exec($ch);
    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $arrCurlResult['output'] = $output;    //返回结果
    $arrCurlResult['response_code'] = $responseCode; //返回http状态
    curl_close($ch);
    unset($ch);
    return $arrCurlResult;
}



