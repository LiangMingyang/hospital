<?php
    if(!isset($_SESSION))
	 session_start();
?>
<html>
	<head>
		<link href="../css/ConfigAdmin.css" rel="stylesheet" type="text/css" />
	    <script src="../include/jquery-2.1.1.js"></script>
        <script src="../include/artDialog/artDialog.js?skin=default"></script>
	    <script src="../include/artDialog/plugins/iframeTools.source.js"></script>
	    <script language="JavaScript" src="../include/sha1.js"></script>
	    <script language="JavaScript" src="../js/ConfigAdmin.js"> </script>
	</head>
	<body>
		<div id="title">
			<p>配置管理员权限</p>			
		</div>
		<div id="Admin_div">
			<span id="tb_title">管理员列表</span>
			<table id="Admin_tb">
				<tr>
					<td>1</td>
					<td>2</td>
					<td>3</td>
					<td>4</td>
				</tr>
				<tr>
					<td>1</td>
					<td>2</td>
					<td>3</td>
					<td>4</td>
				</tr>
				<tr>
					<td>1</td>
					<td>2</td>
					<td>3</td>
					<td>4</td>
				</tr>
				<tr>
					<td>1</td>
					<td>2</td>
					<td>3</td>
					<td>4</td>
				</tr>
			</table>
			<div id="tb_footer">
				<span>共</span><span id="admin_num">?</span><span>条记录,共
				<span id="page_num">?</span>页</span>
				<span id="go_btn" onclick="gopage()">GO</span>
				<span>第</span>
				   <input type="text" id="page_no" value="1"/>
				<span>页</span>
			</div>
			
		</div>
		<div id="Admin_Info" style="display: none">
			<div id="del_div">
			<span id="Admin_tag"><span id="Admin_Name">Admin?</span><span>权限信息</span></span>
			<a id="changePwd_btn" onclick="changePwd()">更改密码</a>
			<table id="Admin_Priv_tb">
			</table>
			<input type="button" id="del_btn" value="解除权限" onclick="del_Priv()"/>
			</div>
			<div id="return_div">
				<a id="return_list" onclick="returnList()">返回管理员列表</a>
			</div>
			<div id="del_admin_div">
				<input type="button" id="del_Admin_btn" value="删除该管理员" onclick="del_Admin()" />
			</div>
			<div id="add_div">
				<span id="add_tag">增加权限</span><a id="show_hospital_btn" onclick="show_hospital()">显示医院列表</a>
				<select id="Province" onchange="fillArea()">
				</select>
				<select id="Area" >
				</select>
				<select id="Hospital_Level">
					<option value="31">三级甲等</option>
					<option value="32">三级乙等</option>
					<option value="33">三级丙等</option>
					<option value="21">二级甲等</option>
					<option value="22">二级乙等</option>
					<option value="23">二级丙等</option>
					<option value="11">一级甲等</option>
					<option value="12">一级乙等</option>
					<option value="13">一级丙等</option>
				</select>
				<br />
				
				<table id="add_Hospital">
				</table>
				<div id="footer">
				<span>共</span><span id="total">?</span><span>条记录，</span>
				<span id="page_num">1</span><span>页</span>
				<span id="go_btn2" onclick="goPage2()">GO</span><input type="text"  id="page_no2"/>
				<span>页</span>
				</div>
				<input type="button" value="添加权限" id="add_btn" onclick="add_Priv()" />
			</div>
		</div>
		<div id="change_pwd_div" style="display: none">
			<span>更新密码</span>
			<input type="password" id="Password" />
			<br /><br />
			<input type="button" id="confirm_pwd"  value="确认" onclick="update_admin_pwd()"/>
		</div>
	</body>
</html>