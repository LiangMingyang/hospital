<?php
/**
 * login.php-登录页面.
 */
require_once '../include/common.inc.php';
require_once '../include/global.func.php';
include header_inc();
/*unset($_SESSION);
unset($_POST);
//if(!isset($_SESSION))
//session_unset();
//session_destroy();
session_start();
//$_SESSION['rd_token']='#';*/
session_start();
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<form id="backinfo_User" action="<?php $_SESSION['tiaozhuan']="1";if (isset($_REQUEST['lastweb'])) echo $_REQUEST['lastweb'];else echo "IndividualCenter.php";?>" method="post" style="display: none">
	<input id="Province_ID" name="Province_ID" type="text"/>
	<input id="Province_Name" name="Province_Name" type="text"/>
	<input id="Area_ID" name="Area_ID" type="text"/>
	<input id="Area_Name" name="Area_Name" type="text"/>
    <input id="Credit_Rank" name="Credit_Rank" type="text"/>
    <input id="UserName"  name="UserName" type="text"/> 
    <input id="User_ID" name="User_ID" type="text"/> 
    <input id="Identity_ID" name="Identity_ID" type="text"/>
    <input id="Appointment_Limit" name="Appointment_Limit" type="text"/>
    <input id="Sex"  name="Sex" type="text"/> 
    <input id="Birthday" name="Birthday" type="text"/> 
    <input id="Location" name="Location" type="text"/>
	<input id="Phone" name="Phone" type="text"/>
    <input id="Mail" name="Mail" type="text"/>
    <input id="isUser_1" name="isUser" value="1" type="text" />
    <input id="LastLogInTime_User"  name="LastLogInTime" type="text"/>
</form>
<form id="backinfo_Admin" action="<?php $_SESSION['tiaozhuan']="1";if (isset($_REQUEST['lastweb'])) echo $_REQUEST['lastweb'];else echo "IndividualCenter.php";?>" method="post" style="display: none">
    <input id="Admin_ID" name="Admin_ID" type="text" />
    <input id="Admin_Name" name="Admin_Name" type="text" />
    <input id="isSuper" name="isSuper" type="text"/> 
    <input id="isUser_2" name="isUser" value="0" type="text" />
    <input id="LastLogInTime_Admin"  name="LastLogInTime" type="text"/>
</form>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户登录</title>
<link href="../include/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"  src="../include/artDialog/artDialog.js?skin=default"></script>
<script type="text/javascript"  src="../include/artDialog/plugins/iframeTools.source.js"></script>
<script type="text/javascript" src="../include/jquery-2.1.1.js"></script>
<script type="text/javascript"  src="../include/web.js"></script>
<script type="text/javascript"  src="../include/sha1.js"></script>
<link href="../css/login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/login.js"></script>
</head>

<!-- 
<body onload="goTop()">
 -->
<body>
<div class="loginmainbg">
  <div class="iptbox">
    <table name='login_form'>
		<div class="mt25">
		    <input id="loginname" name="loginname" type="text" value="请输入身份证号" class="ipt1" onmousedown="clear_blank(this)"/>
		</div>
		<div class="mt25">
		    <input id="password" name="password" type="password" class="ipt1" />
		</div>
		<div class="mt25">
			<input class="identity" checked="true" type="radio" name="radiobutton" value="1" onchange="changeReminder()" /> <span class="id_name">用户</span>
			<input class="identity" type="radio" name="radiobutton" value="0" onchange="changeReminder()"/> <span class="id_name">管理员</span>
		</div>
	    <div class="mt25" >
		    <input id="log_btn" type="image" src="../images/login_03.jpg" onclick="login()"/>
		    <a href="../php/register.php">去注册</a>
		    <input id="register_btn" type="image" src="../images/login_05.jpg" onclick="find_pwd()"/>
	    </div>
    </table>
  </div>
</div>
<div id="find_pwd_div" style="display: none">
	<span>请输入您的身份证号：  </span>
	<input type="text" id="Identity_ID" />
	<br />
	<input type="button" id="send_mail_btn" onclick="send_mail()" value="发送邮件" />
</div>
</body>
<script>


</script>
</html>
 