<?php
/**
 * 调用Http接口
 * User: renxiaogang
 * Date: 2014/12/16
 * Time: 10:58
 */

define('AUTH_KEY', '^@@!@$17611');

$class      = 'Zone';
$method     = 'hello';
$a          = 1;
$b          = 2;
$authKey    = md5(AUTH_KEY . $class . $method . $a . $b);
$timestamp  = time();
$url     = "http://192.168.1.248:8282/{$class}/{$method}/?authKey={$authKey}&timestamp={$timestamp}&a={$a}&b={$b}";

$result = file_get_contents($url);
echo '<pre>';
echo '请求地址：' . $url .  PHP_EOL;
print_r(json_decode($result));
echo '</pre>';


