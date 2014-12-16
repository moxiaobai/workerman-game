Http Web Server
===================

## 项目介绍 ##
 可以实现RestFul Api

#### 代码块
```php
define("AUTH_KEY", "^@@!@$17611");

$class      = "Zone";
$method     = "getData";
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
```

## 目录介绍 ##
1. index.php 入口文件
2. Services 存放Api接口




 
 
