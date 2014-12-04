<?php
/**
 * 用户服务器
 *
 * @auther moxiaobai
 * @since  2014/11/13
 *
 */

namespace Server;

use \Lib\Context;
use \Lib\Gateway;
use \Lib\StatisticClient;
use \Lib\Store;
use \Lib\Db;
use \Protocols\GatewayProtocol;
use \Protocols\JsonProtocol;
use \Structure\UserInfo;
use \Structure\Cmd;


class User {

    /**
     * 当网关有客户端链接上来时触发，每个客户端只触发一次，如果不许要任何操作可以不实现此方法
     * 这里当客户端一连上来就给客户端发送输入名字的提示
     */
    public static function onGatewayConnect($client_id)
    {
        //Gateway::sendToCurrentClient(TextProtocol::encode("type in your name:"));
    }

    /**
     * 网关有消息时，判断消息是否完整
     */
    public static function onGatewayMessage($buffer)
    {
        // 已经收到的长度（字节）
        $recv_length = strlen($buffer);

        // 接收到的数据长度不够？
        if($recv_length<4)
        {
            return 4 - $recv_length;
        }


        // 读取首部4个字节，网络字节序int
        $buffer_data = unpack('Ntotal_length', $buffer);
        // 得到这次数据的整体长度（字节）
        $total_length = $buffer_data['total_length'];
        if($total_length>$recv_length)
        {
            // 还有这么多字节要接收
            return $total_length - $recv_length;
        }
        // 接收完毕
        return 0;
    }

    /**
     * 有消息时触发该方法
     * @param int $client_id 发消息的client_id
     * @param string $message 消息
     * @return void
     */
    public static function onMessage($client_id, $message)
    {
        var_dump($message);

        $message = substr($message, 4);

        $cmd = new Cmd();
        $cmd->parseFromString($message);


        $type    = $cmd->getCmd();
        $mid     = $cmd->getMid();

        switch($type) {
            case 'login':


                break;
            case 'reg':


                break;
            case 'userInfo':
                $result = self::getUserInfoBy($mid);

                $userInfo = new UserInfo();
                $userInfo->setMid($result['m_id']);
                $userInfo->setNickname($result['m_nickname']);
                $userInfo->setEmail($result['m_email']);
                $userInfo->setRegtime($result['m_regtime']);


                $buffer = $userInfo->SerializeToString();
                $total_length = 4 + strlen($buffer);
                $buffer = pack('N', $total_length) . $buffer;

                return Gateway::sendToCurrentClient($buffer);

                break;
            case 'online':


                break;
            default:

                break;

        }

    }

    /**
     * 当用户断开连接时触发的方法
     * @param integer $client_id 断开连接的用户id
     * @return void
     */
    public static function onClose($client_id)
    {
        // 广播 xxx 退出了
        //GateWay::sendToAll(TextProtocol::encode("{$_SESSION['name']}[$client_id] logout"));
    }

    /**
     * 验证用户登录
     *
     * @param $username
     * @param $password
     * @return mixed
     */
    public static function authLogin($username, $password) {
        $passportDb = Db::instance('passport');
        $password = md5(md5($password));

        $sql = "SELECT m_id,m_nickname,m_email,m_regtime FROM `t_member`
                WHERE m_nickname='{$username}' and m_password = '{$password}'
                limit 1";
        $result = $passportDb->row($sql);
        return $result;
    }

    /**
     * 注册用户
     * @return array
     */
    public static function authReg() {
        return array('code'=>1, 'data'=>'hello 弟弟');
    }

    /**
     * 获取用户信息
     *
     * @param $uid
     * @return mixed
     */
    public static function getUserInfoBy($uid) {
        $key = "GAME_USER_INFO_{$uid}";
        $store = Store::instance('game');

        $userInfo = $store->get($key);
        if($userInfo) {
            return $userInfo;
        }

        $passportDb = Db::instance('passport');
        $sql = "SELECT m_id,m_nickname,m_email,m_regtime FROM `t_member`
                WHERE m_id='{$uid}'
                limit 1";
        $result = $passportDb->row($sql);
        if($result) {
            $store->set($key, $result);
        }

        return $result;

    }
}