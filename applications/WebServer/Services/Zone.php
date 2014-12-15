<?php

/**
 * 大区列表
 *
 * @auther moxiaobai
 * @since  2014/12/05
 *
 */

use \Lib\Store;
use \Lib\Db;


class Zone {

    /**
     * @return mixed
     */
    public static function getServerList() {
        $store    = Store::instance('game');
        $db       = Db::instance('passport');

        $key = "GAME_ZONE_SERVER_LIST";

        $serverList = $store->get($key);
        if($serverList) {
           return $serverList;
        }

        $sql = "SELECT s_id,s_name,s_type,s_ip FROM `t_server`
                WHERE s_status=1
                ORDER BY s_id ASC";
        $result = $db->query($sql);
        if($result) {
           $store->set($key, $result);
        }

        return $result;
    }

    public static function getData($a, $b) {
        return  $a+$b;
    }
}
