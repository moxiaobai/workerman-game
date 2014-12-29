<html><head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>workerman-chat PHP聊天室 Websocket(HTLM5/Flash)+PHP多进程socket实时推送技术</title>
  <script type="text/javascript">
  //WebSocket = null;
  </script>
  <!-- Include these three JS files: -->
  <script type="text/javascript" src="/js/swfobject.js"></script>
  <script type="text/javascript" src="/js/web_socket.js"></script>
  <script type="text/javascript" src="/js/json.js"></script>
  <script type="text/javascript" src="/js/jquery.min.js"></script>

  <script type="text/javascript">
    WEB_SOCKET_SWF_LOCATION = "/swf/WebSocketMain.swf";
    WEB_SOCKET_DEBUG = true;
    var ws, name, client_list={},timeid, reconnect=false;
    function init() {
       // 创建websocket
    	ws = new WebSocket("ws://"+document.domain+":7272");
      // 当socket连接打开时，输入用户名
      ws.onopen = function() {
          //发送数据给服务端
          var data = JSON.stringify({"class":"Zone","method":"getServerList","param_array":{"mid":13392, "sid":2}});
          //var data = JSON.stringify({"class":"Online","method":"getOnline","param_array":{"sid":1}});
          ws.send(data);
      };
      // 当有消息时根据消息类型显示不同信息
      ws.onmessage = function(e) {
    	console.log(e.data);
        var data = JSON.parse(e.data);
        console.log(data);
      };
      ws.onclose = function() {
    	  console.log("连接关闭，定时重连");
      };
      ws.onerror = function() {
    	  console.log("出现错误");
      };
    }

  </script>
</head>
<body onload="init();">

</body>
</html>
