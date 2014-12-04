<?php

/**
 * 登录服务器
 *
 * @auther moxiaobai
 * @since  2014/11/13
 */

namespace Server;

use \Lib\Context;
use \Lib\Gateway;
use \Lib\StatisticClient;
use \Lib\Store;
use \Lib\Db;
use \Protocols\GatewayProtocol;
use \Protocols\JsonProtocol;


class Login {

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
        return JsonProtocol::check($buffer);
    }

    /**
     * 有消息时触发该方法
     * @param int $client_id 发消息的client_id
     * @param string $message 消息
     * @return void
     */
    public static function onMessage($client_id, $message)
    {
        $data    = JsonProtocol::decode($message);

        $cmd     = $data['cmd'];
        $params  = $data['params'];

        switch($cmd) {
            case 'login':
                $username = $params['username'];
                $password = $params['password'];

                $result = self::authLogin($username, $password);

                $data = JsonProtocol::encode($result);
                return GateWay::sendToCurrentClient($data);

                break;
            case 'reg':
                $result = self::authReg();

                $data = JsonProtocol::encode($result);
                return GateWay::sendToCurrentClient($data);

                break;
            case 'userInfo':
                $uid = $params['uid'];
                $result = self::getUserInfoBy($uid);

                $data = JsonProtocol::encode($result);
                return Gateway::sendToCurrentClient($data);

                break;
            case 'online':
                $onlineList = Gateway::getOnlineStatus();

                $data = JsonProtocol::encode($onlineList);
                return Gateway::sendToAll($data);

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