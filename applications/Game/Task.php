<?php
/**
 * 一个定时任务，向通过workerman定时向客户端发送数据
 * User: renxiaogang
 * Date: 2014/12/2
 * Time: 13:59
 */

class Task extends Man\Core\SocketWorker {

    // 子进程启动时会运行onStart， 整个进程生命周期只运行一次，这里用来注册定时任务
    public function onStart() {
        // 初始化定时任务，让$this->event负责定时触发
        \Man\Core\Lib\Task::init($this->event);

        // 定时任务1的时间间隔2秒
        $time_interval1 = 2;
        // 设定定时任务
        \Man\Core\Lib\Task::add($time_interval1, function(){
            // 任务逻辑
            //echo 11 . PHP_EOL;
        });

        // 定时任务2的时间间隔10秒
        $time_interval2 = 10;
        // 设定定时任务，定时运行 $this->dealProcess();
        \Man\Core\Lib\Task::add($time_interval2, array($this, 'taskTwo'));
    }

    // 另外一个要定时运行的类成员函数
    public function taskTwo() {
        //echo 2 . PHP_EOL;
    }

    // 这里不接收请求，函数留空
    public function dealInput($recv_buffer){}

    // 这里不接收请求，函数留空
    public function dealProcess($recv_buffer){}
}