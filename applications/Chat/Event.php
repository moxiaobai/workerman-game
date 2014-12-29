<?php
/**
 * 
 * 聊天主逻辑
 * 主要是处理onGatewayMessage onMessage onClose 三个方法
 * @author walkor < walkor@workerman.net >
 * 
 */

use \Lib\Gateway;
use \Protocols\WebSocket;

class Event
{
    /**
     * 网关有消息时，判断消息是否完整
     */
    public static function onGatewayMessage($buffer)
    {
        return WebSocket::check($buffer);
    }
   
   /**
    * 有消息时
    * @param int $client_id
    * @param string $message
    */
   public static function onMessage($client_id, $message)
   {
       // 如果是websocket握手
       if(self::checkHandshake($message))
       {
           // debug
           echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id onMessage:".$message."\n";
           return;
       }
       
       // 判断是不是websocket的关闭连接的包
        if(WebSocket::isClosePacket($message))
        {
            return Gateway::kickClient($client_id);
        }
        
        // 解码websocket，得到原始数据
        $message =WebSocket::decode($message);
        // debug
        //echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id session:".json_encode($_SESSION)." onMessage:".$message."\n";
        
        // 客户端传递的是json数据
       $data = json_decode($message, true);
       print_r($data);

       // 判断数据是否正确
       if(empty($data['class']) || empty($data['method']) || !isset($data['param_array'])) {
           // 发送数据给客户端，请求包错误
           $result = json_encode(array('code'=>400, 'msg'=>'bad request', 'data'=>null));
           return Gateway::sendToCurrentClient(WebSocket::encode($result));
       }

       // 获得要调用的类、方法、及参数
       $class       = $data['class'];
       $method      = $data['method'];
       $param_array = $data['param_array'];

       // 判断类对应文件是否载入
       if(!class_exists($class)) {
           $include_file = ROOT_DIR . "/Services/$class.php";
           if(is_file($include_file))
           {
               require_once $include_file;
           }
           if(!class_exists($class))
           {
               $code = 404;
               $msg = "class $class not found";

               // 发送数据给客户端 类不存在
               $result = json_encode(array('code'=>$code, 'msg'=>$msg, 'data'=>null));
               return Gateway::sendToCurrentClient(WebSocket::encode($result));
           }
       }

       // 调用类的方法
       try {
           $ret = call_user_func_array(array($class, $method), $param_array);

           // 发送数据给客户端，调用成功，data下标对应的元素即为调用结果
           $result = json_encode(array('code'=>0, 'msg'=>'ok', 'data'=>$ret));
           return Gateway::sendToCurrentClient(WebSocket::encode($result));
       } catch(Exception $e) {
           // 发送数据给客户端，发生异常，调用失败
           $code = $e->getCode() ? $e->getCode() : 500;

           $result = json_encode(array('code'=>$code, 'msg'=>$e->getMessage(), 'data'=>$e));
           return Gateway::sendToCurrentClient(WebSocket::encode($result));
       }

   }
   
   /**
    * 当客户端断开连接时
    * @param integer $client_id 客户端id
    */
   public static function onClose($client_id)
   {
       // debug
       echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id onClose:''\n";
   }
   
   /**
    * websocket协议握手
    * @param string $message
    */
   public static function checkHandshake($message)
   {
       // WebSocket 握手阶段
       if(0 === strpos($message, 'GET'))
       {
           // 解析Sec-WebSocket-Key
           $Sec_WebSocket_Key = '';
           if(preg_match("/Sec-WebSocket-Key: *(.*?)\r\n/", $message, $match))
           {
               $Sec_WebSocket_Key = $match[1];
           }
           $new_key = base64_encode(sha1($Sec_WebSocket_Key."258EAFA5-E914-47DA-95CA-C5AB0DC85B11",true));
           // 握手返回的数据
           $new_message = "HTTP/1.1 101 Switching Protocols\r\n";
           $new_message .= "Upgrade: websocket\r\n";
           $new_message .= "Sec-WebSocket-Version: 13\r\n";
           $new_message .= "Connection: Upgrade\r\n";
           $new_message .= "Sec-WebSocket-Accept: " . $new_key . "\r\n\r\n";
            
           // 发送数据包到客户端 完成握手
           Gateway::sendToCurrentClient($new_message);
           return true;
       }
       // 如果是flash发来的policy请求
       elseif(trim($message) === '<policy-file-request/>')
       {
           $policy_xml = '<?xml version="1.0"?><cross-domain-policy><site-control permitted-cross-domain-policies="all"/><allow-access-from domain="*" to-ports="*"/></cross-domain-policy>'."\0";
           Gateway::sendToCurrentClient($policy_xml);
           return true;
       }
       return false;
   }
}
