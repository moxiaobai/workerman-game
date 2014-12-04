<?php

require_once 'pb_proto_test.php';

$test = new Test();
$test->setCmd('userInfo');
$test->appendMid('moxiaobai');
$test->appendMid('rxg622124');
$test->appendMid('mlkom@live.com');

$buffer = $test->SerializeToString();


$test->parseFromString($buffer);
echo '<pre>' .PHP_EOL;
print_r($test->getCmd());
echo '<pre>' .PHP_EOL;


echo '<pre>' .PHP_EOL;
print_r($test->getCountMid());
echo '<pre>' .PHP_EOL;