<?php
/**
 * 在线数据
 *
 * @auther moxiaobai
 * Date: 2014/12/8
 * Time: 15:21
 */

use \Lib\Db;
use \Structure\PbResult;

class Online {

    private $_db;
    private $_pbResult;

    public function __Construct() {
        $this->_db = Db::instance('passport');
        $this->_pbResult = new PbResult();
    }

    public function addUserOnline() {}

    public function deleteUserOnline() {

    }
}