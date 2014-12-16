<?php

require_once __DIR__ . '/Lib/Autoloader.php';

define('AUTH_KEY', '^@@!@$17611');

$urlInfo = parse_url($_SERVER['REQUEST_URI']);

$path  = '';
$query = '';
if(isset($urlInfo['path'])) {
    $path = $urlInfo['path'];
}

if(isset($urlInfo['query'])) {
    $query = $urlInfo['query'];
}

$tmpData = explode('/', $path);
foreach($tmpData as $key=>$value) {
    if(trim($value) == '') {
        unset($tmpData[$key]);
    }
}
$tmpData = array_values($tmpData);

//获取请求的类和方法
if(count($tmpData) != 0 ) {
    $class = $tmpData[0];
    $method = $tmpData[1];
} else {
    $data = array('code'=>500, 'msg'=>'Invalid Params', 'data'=>null);
    echo json_encode($data);
    return;
}

//获取请求的参数
$tmpParams = explode('&', $query);
$params    = array();
foreach($tmpParams as $key=>$value) {
    if(trim($value) == '') {
        unset($tmpParams[$key]);
    } else {
    	$value = explode('=', $value);
    	$params[$value[0]] = $value[1];
    }
}


$requestAuthKey   = $params['authKey'];
$requestTimestamp = $params['timestamp'];
unset($params['authKey']);
unset($params['timestamp']);

//判断参数是否完整
if(!isset($requestAuthKey) || !isset($requestTimestamp)) {
    $data = array('code'=>500, 'msg'=>'Invalid Params', 'data'=>null);
    echo json_encode($data);
    return;
}

//验证数据是否过期,过期时间为5分钟
$expires = time() - $requestTimestamp;
if($expires > 1*60) {
    $data = array('code'=>500, 'msg'=>'Request expired', 'data'=>null);
    echo json_encode($data);
    return;
}

//验证Url合法性
$authStr = AUTH_KEY . $class . $method;
foreach($params as $key => $val) {
    $authStr .= $val;
}

$authKey = md5($authStr);
if($authKey != $requestAuthKey) {
    $data = array('code'=>500, 'msg'=>'Invalid AuthKey', 'data'=>null);
    echo json_encode($data);
    return;
}

//todo验证权限
if(false) {
    $data = array('code'=>401, 'msg'=>'Unauthorized', 'data'=>null);
    echo json_encode($data);
    return;
}

//判断类是否存在
if(!class_exists($class)) {
    $include_file = ROOT_DIR . "/Services/$class.php";
    if(is_file($include_file)) {
        require_once $include_file;
    }
    if(!class_exists($class)) {
        $data = array('code'=>404, 'msg'=>"class $class not found", 'data'=>null);
        echo json_encode($data);
        return;
    }
}

// 调用类的方法
try {
    $ret = call_user_func_array(array($class, $method), $params);

    $data = array('code'=>200, 'msg'=>'ok', 'data'=>$ret);
    echo json_encode($data);
    return;
} catch(Exception $e) {
    // 发送数据给客户端，发生异常，调用失败
    $code = $e->getCode() ? $e->getCode() : 500;
    $data = array('code'=>$code, 'msg'=>$e->getMessage(), 'data'=>$e);
    echo json_encode($data);
    return;
}

