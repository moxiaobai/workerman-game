<?php
/**
 * 在线数据
 *
 * @auther moxiaobai
 * Date: 2014/12/8
 * Time: 15:21
 */

use \Lib\Db;

class Online {

    /**
     * 获取在线数据
     * @param null $sid 服务器ID
     * @return mixed
     */
    public static function getOnline($sid=null) {
        if(is_null($sid)) {
            $where = 'WHERE 1=1';
        } else {
            $where = "WHERE s_id = $sid";
        }

        $db       = Db::instance('passport');
        $sql    = "SELECT COUNT(*) AS totle FROM `t_online` {$where}";
        $result = $db->single($sql);
        return $result;
    }
}