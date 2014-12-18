<?php
  if(!isset($_SESSION))
  session_start();
?>
<html>
    <script src="../include/artDialog/artDialog.js?skin=default"></script>
    <script src="../include/artDialog/plugins/iframeTools.source.js"></script>
    <script src="../include/My97DatePicker/WdatePicker.js"></script>
    <script src="../include/sha1.js"></script>
    <script src="../include/jquery-2.1.1.js"></script>
	<link href="../css/ConfigUser.css" rel="stylesheet" type="text/css" />
	<script src="../js/ConfigUser.js"> </script>	
	<body>
		<div id="title">
			<p>配置用户信息</p>
		</div>
		<span id="ID_tag">请输入待查用户身份证号</span>
		<input type="text" id="ID" />
		<input type="button" id="search" onclick="search_user()" 
		 value="搜索"/>
		<div id="user_info" style="display: none">
			<span class="tag" id="UserName_tag">用户</span>
			<input class="info"  type="text" id="UserName" />
			<span class="tag" id="Credit_Rank_tag">信用等级</span>
			<input class="info" type="text" id="Credit_Rank" />
			<br /><br />
			<span class="tag" id="Identity_ID_tag">身份证号</span>
			<input class="info" type="text" id="Identity_ID" />
			<span class="tag" id="Appointment_Limit_tag">预约限制</span>
			<input class="info" type="text" id="Appointment_Limit" />
			<br /><br />
			<span class="tag" id="Sex_tag">性别</span>
			<span><input name="Sex" type="radio" value="0"/>女&nbsp;&nbsp;&nbsp;</span>
			<span><input name="Sex" type="radio" value="1"/>男</span>
			<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<span class="tag" id="Phone_tag">手机</span>
		    <input class="info" type="text" id="Phone" />
			<br /><br />	
			<span class="tag" id="Birthday_tag">出生年月</span>
			<input id="Birthday" class="Wdate"
		    onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
		     <span class="tag" id="Mail_tag">邮箱</span>
		    <input class="info" type="text" id="Mail" />
		    <br /><br />
		    <span class="tag" id="Loaction_tag">居住地</span>
		    <select id="Province_ID"></select>
		    <select id="Area_ID"></select>
		    <input class="info" type="text" id="Location" />
		    <br /><br />
		    <input type="button" value="保存更改" id="save_change_btn" onclick="save_change()" />
		    <br />
		</div>
	</body>
</html>