<?php
/**
 * 数据模型基类
 * User: renxiaogang
 * Date: 2014/12/9
 * Time: 10:04
 */

namespace Server;

use \Lib\Db;
use \Structure\PbResult;

class Model {

    protected  $_db;
    protected  $_pbResult;

    protected  $_result = array(
        'SUCCESS'   =>  array('code'=>1,    'msg' => 'successful'),
        'ERROR'     =>  array('code'=>100,  'msg' => 'error'),
    );

    public function __Construct() {
        $this->_db = Db::instance('passport');
        $this->_pbResult = new PbResult();
    }

    /**
     * 格式化数据
     * @param $pbObj
     * @return string
     */
    protected function formatBuffer($pbObj) {
        $buffer = $pbObj->SerializeToString();
        $total_length = 4 + strlen($buffer);
        $buffer = pack('N', $total_length) . $buffer;

        return $buffer;
    }
}