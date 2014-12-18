<?php
    if(!isset($_SESSION))
	 session_start();
?>
<html>
	<head>
		<link href="../css/CreateAdmin.css" rel="stylesheet" type="text/css" />
	    <script src="../include/jquery-2.1.1.js"></script>
        <script src="../include/artDialog/artDialog.js?skin=default"></script>
	    <script src="../include/artDialog/plugins/iframeTools.source.js"></script>
	    <script language="JavaScript" src="../include/sha1.js"></script>
	    <script language="JavaScript" src="../js/CreateAdmin.js"> </script>
	</head>
	<body>
		<div id="title">
			<p>创建普通管理员</p>
		</div>
		<div id="Admin_Area">
			<br />
			<span id="tb_title">管理员用户名</span>
			<input type="text" id="Admin_Name" />
			<br />
			<span id="repeat_signal" style="display: none">用户名已经存在</span>
			<br />
			<span>密码&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<input type="password" id="Password" />
			<br /><br />
			<input type="button" onclick="createAdmin()" value="创建" id="createadmin" />
		</div>
	</body>
</html>
	
	