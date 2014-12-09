<?php
/**
 * Created by PhpStorm.
 * User: renxiaogang
 * Date: 2014/12/9
 * Time: 9:55
 */

namespace Server;

use \Server\Model;

class Online extends Model {

    public function __Construct() {
        parent::__Construct();
    }

    /**
     * 记录用户在线数据
     *
     * @param array $params
     * @return string
     */
    public function addUserOnline($params) {
        //先更新数据，更新数据影响行数为0，则插入数据
        $rowCount = $this->updateOnlineLog($params);
        if($rowCount == 0 ) {
            $result = $this->addOnlineLog($params);
        } else {
            $result = true;
        }

        if($result) {
            $tip = $this->_result['SUCCESS'];
        } else {
            $tip = $this->_result['ERROR'];
        }
        $this->_pbResult->setCode($tip['code']);
        $this->_pbResult->setMsg($tip['msg']);
        $buffer = $this->formatBuffer($this->_pbResult);
        return $buffer;
    }

    /**
     * 玩家退出，删掉在线数据
     *
     * @param array $params
     * @return string
     */
    public function deleteUserOnline($params) {
        $where     = "s_id = {$params[0]} AND m_id = {$params[1]}";
        $row_count = $this->_db->delete('t_online')->where($where)->query();

        $tip = $this->_result['SUCCESS'];
        $this->_pbResult->setCode($tip['code']);
        $this->_pbResult->setMsg($tip['msg']);
        $buffer = $this->formatBuffer($this->_pbResult);
        return $buffer;
    }

    //更新用户在线数据
    private function updateOnlineLog($params) {
        $cols  = array('l_addtime'=>time(), 's_id'=>$params[0], 's_name'=>$params[1]);
        $where = "m_id = {$params[2]} AND s_id = {$params[0]}";

        $rowCount = $this->_db->update('t_online')->cols($cols)->where($where)->query();
        return $rowCount;
    }

    //插入用户在线数据
    private function addOnlineLog($params) {
        $data = array(
            's_id'      => $params[0],
            's_name'    => $params[1],
            'm_id'      => $params[2],
            'l_addtime' => time()
        );

        $result = $this->_db->insert('t_online')->cols($data)->query();
        return $result;
    }
} 