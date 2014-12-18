<?php
/**
 * login.php-登录页面.
 */
require_once 'include/common.inc.php';
require_once 'include/global.func.php';
include header_inc();
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户登录</title>
<link href="<?php echo CSS_PATH ?>main.css" rel="stylesheet" type="text/css" />

<link id="artDialogSkin" href="<?php echo CSS_PATH?>artDialog/skin/aero/aero.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo CSS_PATH?>artDialog/artDialog.js"></script>

<script type="text/javascript" src="<?php echo JS_PATH?>jquery-1.6.4.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>web.js"></script>
<style type="text/css">
html{height:100%;}
body{ background:#637e92 url(<?php echo IMAGE_PATH ?>loginbg.jpg) no-repeat center top; height:100%;}
.loginmainbg{ background:url(<?php echo IMAGE_PATH ?>loginmainbg_02.jpg) no-repeat; width:980px; overflow:hidden; min-height:600px; margin:0 auto; _height:600px; height:100%;}
.ipt1{ background:none; border:none; width:202px; height:32px; line-height:30px; font-size:14px; color:#666; padding-left:40px; }
.chekbox{margin:43px 0 0 265px;*margin:35px 0 0 265px}
.mt18{margin-top:20px;}
.mt25{margin-top:20px;}
.mt{margin-top:-100px;padding-left:115px;}
.iptbox{margin:290px 0 0 384px;}
.vd{ background:none; border:none;width:83px; height:32px; line-height:30px; font-size:14px; padding-left:20px;color:#666;margin-top:25px;}
</style>
<script>
var WEB_ROOT = '<?php echo WEB_ROOT?>';
		    function onlogin()
		    {
		        var loginName = document.login_form.username.value;
		        var passwd = document.login_form.password.value;
                
				if(check_danger(loginName)||check_danger(passwd)){
					return false;
				}
		        if (loginName.length == 0 || passwd.length == 0)
		        {
//		            alert("无效的用户或口令");
		            artDialog({content:'无效的用户或口令！', style:'alert'}, function(){});
		            return false;
		        }
		        return true;
		    }

		
</script>
</head>

<!-- 
<body onload="goTop()">
 -->
<body>
<div class="loginmainbg">
  <div class="iptbox">
    <form name='login_form' method='post' action='<?php echo WEB_ROOT?>system/login.php' onsubmit='return onlogin();'>
		<div>
		    <input name="username" type="text" class="ipt1"/>
		</div>
			<input type="hidden" name="dosubmit" value="true"/>
		<div class="mt25">
		    <input name="password" type="password" class="ipt1" />
		</div>
		<div>
		    <input name="validatecode" type="text" class="vd"/>
		</div>
	    <div class="mt18" >
		    <input type="image" src="<?php echo IMAGE_PATH ?>login_03.jpg" style="margin-right:23px;"/>
		    <input type="image" src="<?php echo IMAGE_PATH ?>login_05.jpg"  onclick="document.login_form.reset();return false;"/>
	    </div>
	    <div class="mt">
	        <img src="../template/auth-code.php" onclick="javascript:this.src='../template/auth-code.php?tm='+Math.random();" />
	    </div>
    </form>
  </div>
</div>
</body>
<script>
<?php 
		if($is_succ === 'Locked')
		{
//		   echo "alert('登录失败，用户已被锁定！','登录失败');";
		   echo "artDialog({content:'登录失败，用户已被锁定！', style:'error'}, function(){});";
		}elseif ($is_succ ==='validatecode_Error'){
		    echo "artDialog({content:'验证码错误，请重试！', style:'error'}, function(){});";
		    //echo "artDialog({content:'$_SESSION['code']', style:'error'}, function(){});"
		}else if($is_succ === 'UserName_Error'){
//		    echo "alert('用户名错误，或用户不存在','登录失败');";
//			echo "alert('用户名或密码错误，请重试！','登录失败');";
			echo "artDialog({content:'用户名或密码错误，请重试！', style:'error'}, function(){});";
		}else if($is_succ=== 'PWD_Error'){
//		    echo "alert('密码错误，请重试','登录失败');";
//		    echo "alert('用户名或密码错误，请重试！','登录失败');";
		    echo "artDialog({content:'用户名或密码错误，请重试！', style:'error'}, function(){});";
		}else if($is_succ==='noReviewed'){
			echo "artDialog({content:'用户还未通过审核，请等待授权管理员审核！', style:'error'}, function(){});";
		}else if($is_succ==='UserNamePWD_Illegal'){
			echo "artDialog({content:'用户名或密码含有非法字符，请重试！', style:'error'}, function(){});";
		}
		unset($is_succ);
		?>
</script>
</html>
 