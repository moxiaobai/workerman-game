Demo Gateway/Worker进程模型框架
============
适合绝大多数长链接应用，开发者只需要关注./ChatDemo/Event.php一个文件即可

Game Gateway/Worker进程模型框架
============
游戏服务器，长链接应用， 入口文件Game.php
业务逻辑模块放在Server目录下面，结构体文件放在Stucture目录下面

Login Gateway/Worker进程模型框架
============
游戏登录服务器，长链接应用， 入口文件Login.php
业务逻辑模块放在Server目录下面，结构体文件放在Stucture目录下面

JsonRpc Gateway/Worker进程模型框架
============
基于Json数据格式的Rpc服务器，短链接应用， 入口文件JsonRpcWorker.php
Api接口放在Services目录下面

WebServer Gateway/Worker进程模型框架
============
Http Web Server， 入口文件index.php
Api接口放在Services目录下面，对于提供基于http协议的restful api

Statistics 统计系统
============
用于统计各个接口调用情况，包括系统可用性、各个接口调用量、延迟、成功率、错误信息等
