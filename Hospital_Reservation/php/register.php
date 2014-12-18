<?php
if(!isset($_SESSION))session_start();
//print_r($_SESSION);

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    	<script src="../include/artDialog/artDialog.js?skin=default"></script>
    	<script src="../include/artDialog/plugins/iframeTools.source.js"></script>
   	 	<script src="../include/sha1.js"></script>
    	<script src="../include/jquery-2.1.1.js"></script>
    	<script src="../include/My97DatePicker/WdatePicker.js"></script>
		<link href="../css/register.css" rel="stylesheet" type="text/css" />
		<script src="../js/register.js"> </script>	
	    <title>注册页面</title>
	</head>
	<body>
		<div id="title">
			<span>注册页面</span>
		</div>	
		<br /><br />
		<div id="register_area">
		<table id="register_tb">
			<tr>
				<td class="tag">姓名</td>
				<td>
					<input type="text" id="UserName"/>
					<span class="tag_error" id="username_error_tag" style="display: none">用户名不合法（长度不超过10）</span>
				</td>
			</tr>
			<tr>
				<td class="tag">性别</td>
				<td>
					<input type="radio" name="sex" value="0"/>
					<img class="sexicon" src="../images/female.jpg" />
					<input type="radio" name="sex" value="1"/>
					<img class="sexicon" src="../images/male.jpg" />
					<span class="tag_1" id="sex_error_tag" style="display: none">性别选择不合法</span>
				</td>
			</tr>
			<tr>
				<td class="tag">身份证号</td>
				<td>
					<input type="text" id="Identity_ID"/>
					<span class="tag_error" id="identity_id_error_tag" style="display: none">身份证号不合法</span>
				</td>
			</tr>
			<tr>
				<td class="tag">出生年月</td>
				<td>
					<input name="Birthday" id="Birthday" 
		            class="Wdate"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})">	
				    <span class="tag_error" id="birthday_error_tag" style="display: none">出生年月不合法</span>
				</td>
			</tr>
			<tr>
				<td class="tag">省份</td>
				<td>
					<select id="Province_ID" onchange="get_Area()">
						<option value="-1">选择省份</option>
					</select>
					<span class="tag_error" id="province_error_tag" style="display: none">省份不合法</span>
				</td>
			</tr>
			<tr>
				<td class="tag">地区</td>
				<td>
					<select id="Area_ID">
						<option value="-1">选择地区</option>
					</select>
					<span class="tag_error" id="area_error_tag" style="display: none">地区不合法</span>
				</td>
			</tr>
			<tr>
				<td class="tag">现居地</td>
				<td>
					<input name="Location" type="text" id="Location" />
				</td>
				<span class="tag_error" id="location_error_tag" style="display: none">居住地不超过25字符</span>
			</tr>
			<tr>
				<td class="tag">手机/电话</td>
				<td>
					<input name="Phone" type="text" id="Phone" />
				</td>
				<span class="tag_error"  id="telephone_error_tag" style="display: none">手机/电话不合法</span>
			</tr>
			<tr>
				<td class="tag">电子邮箱</td>
				<td>
					<input name="Mail" type="text" id="Mail" />
				</td>
				<span class="tag_error"  id="mail_error_tag" style="display: none">邮箱不合法</span>
			</tr>
			<tr>
				<td class="tag">密码</td>
				<td>
					<input name="Password" type="password" id="Password" />
				</td>
				<span class="tag_error"  id="password_error_tag" style="display: none">密码不少于6位，不超过20位</span>
			</tr>
			<tr>
				<td class="tag">重复密码</td>
				<td>
					<input type="password" id="confirm_password" />
					<span class="tag_error"  id="cfm_password_error_tag" style="display: none">密码不少于6位</span>
				</td>
			</tr>
            <tr>
            <br />
            	<td colspan="2">
            		<input value="注册" type="button" id="register" onclick="confirm_register()"/>
            	    <a href="../index.php">回主页</a>
            	</td>
            </tr>
		</table>
		</div>
	</body>
	
	
</html>