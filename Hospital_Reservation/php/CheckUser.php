<?php
    if(!isset($_SESSION))
	 session_start();
?>
<html>
	<head>
		<link href="../css/CheckUser.css" rel="stylesheet" type="text/css" />
	    <script src="../include/jquery-2.1.1.js"></script>
        <script src="../include/artDialog/artDialog.js?skin=default"></script>
	    <script src="../include/artDialog/plugins/iframeTools.source.js"></script>
	    <script language="JavaScript" src="../include/sha1.js"></script>
	    <script language="JavaScript" src="../js/CheckUser.js"> </script>
	</head>
	<body>
		<div id="title">
			<p>审核用户</p>
		</div>
		<div id="condition_tb">
			<span>省份</span>
			<select id="Province_ID" onchange="fillArea()">
			</select>
			<span>地区</span>
			<select id="Area_ID">
			</select>
			<input type="checkbox" id="unchecked_only"/>
			<span>仅显示未审核</span>
			<a id="show_user_btn" onclick="show_user(0,10)">显示用户</a>
		</div>
		<div id="user_area">
			<table id="user_tb">
				<tr>
					<th id="th_id">身份证号</th>
					<th id="th_un">用户名</th>
					<th id="th_status">状态</th>
					<th id="th_lk">查看</th>
					<th id="th_ck">审核操作</th>
					<th>
						<input type="button" id="del_btn" value="批量删除" onclick="del_user()"/>
					</th>
				</tr>
			
				<tr id="no_signal" style="display: none">
					<td colspan="5">
						<span>没有符合条件的记录</span>
					</td>
				</tr>
			</table>
			<div id="tb_footer" style="display: none">
				<span>共</span><span id="total">?</span><span>条记录,共</span>
				<span id='page_num'>?</span><span>页</span>
				<span id="go_btn3" onclick="goPage3()">GO</span>
				<span>第</span><input id="page_no3" value="1" />
				<span>页</span>
			</div>
		</div>
		<div id="user_detail" style="display: none">
			<span class="tag" id="UserName_tag">姓名</span>
			<span class="info" id="UserName"></span>
			<br /><br />
			<span class="tag" id="Identity_ID_tag">身份证号</span>
			<span class="info" id="Identity_ID"></span>
			<br /><br />
			<span class="tag" id="Sex_tag">性别</span>
			<span class="info" id="Sex"></span>
			<br /><br />
			<span class="tag" id="Birthday_tag">出生年月</span>
			<span class="info" id="Birthday"></span>
			<br /><br />
	        <span class="tag" id="Location_tag">现居地</span>
			<span class="info" id="Province_Name"></span>
			<span class="info" id="Area_Name"></span>
			<br /><br />
			<span class="info" id="Location"></span>
			<br /><br />
			<span class="tag" id="Phone_tag">手机/电话</span>
			<span class="info" id="Phone"></span>
			<br /><br />
			<span class="tag" id="Mail_tag">邮箱</span>
			<span class="info" id="Mail"></span>
			
		</div>
	</body>
</html>
	
	