<?php

define('ROOT_DIR', realpath(__DIR__ . '/../') . '/');

require_once 'pb_proto_ping.php';

$cmd = new Ping();
$cmd->setType('ping');

$buffer = $cmd->SerializeToString();
$total_length = 4 + strlen($buffer);
$buffer = pack('N', $total_length) . $buffer;


file_put_contents(ROOT_DIR .'ping.data', $buffer);


