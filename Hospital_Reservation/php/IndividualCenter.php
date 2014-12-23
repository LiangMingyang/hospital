<?php 
require_once '../include/common.inc.php';
require_once '../include/global.func.php';
include header_inc();
header('Cache-Control:no-cache,must-revalidate');  
header('Pragma:no-cache'); 
if(!isset($_SESSION))
session_start();
if($_SESSION['isUser']==""){
   		$_SESSION['isUser']=$_POST['isUser'];
   		if($_SESSION['isUser']=='1'){
   	  		$_SESSION["Province_ID"]=$_POST["Province_ID"];
      		$_SESSION["Province_Name"]=$_POST['Province_Name'];
      		$_SESSION["Credit_Rank"]=$_POST['Credit_Rank'];
      		$_SESSION["UserName"]=$_POST['UserName'];
      		$_SESSION["User_ID"]=$_POST['User_ID'];  
	  		$_SESSION["Credit_Rank"]=$_POST["Credit_Rank"];
      		$_SESSION["Area_ID"]=$_POST['Area_ID'];
      		$_SESSION["Area_Name"]=$_POST['Area_Name'];
      		$_SESSION["Appointment_Limit"]=$_POST['Appointment_Limit'];
      		$_SESSION["Identity_ID"]=$_POST['Identity_ID'];			 	
	  		$_SESSION["Sex"]=$_POST["Sex"];
      		$_SESSION["Birthday"]=$_POST['Birthday'];
      		$_SESSION["Location"]=$_POST['Location'];
      		$_SESSION["Phone"]=$_POST['Phone'];
	  		$_SESSION["Mail"]=$_POST['Mail'];		
	  		$_SESSION['LastLogInTime']=$_POST['LastLogInTime'];	
			unset($_SESSION['rd_token']);
		    $_SESSION['rd_token']=""; 				 
   		}
   		else if($_SESSION['isUser']=='0'){
   	 		$_SESSION['Admin_ID']=$_POST['Admin_ID'];
	 		$_SESSION['Admin_Name']=$_POST['Admin_Name'];
	 		$_SESSION['isSuper']=$_POST['isSuper'];
	 		$_SESSION['LastLogInTime']=$_POST['LastLogInTime'];
			unset($_SESSION['rd_token']);
		    $_SESSION['rd_token']="";
   		}
}
  if($_SESSION['rd_token']=='#'||$_SESSION['isUser']!="1"&&$_SESSION['isUser']!="0"){
 	 echo "<script>window.location.href='../index.php'</script>";
  }
  //print_r($_SESSION);
  
?>

<link href="../include/main.css" rel="stylesheet" type="text/css" />
<link href="../css/IndividualCenter.css" rel="stylesheet" type="text/css" />
<script src="../include/artDialog/artDialog.js?skin=default"></script>
<script src="../include/artDialog/plugins/iframeTools.source.js"></script>
<script language="JavaScript" src="../include/sha1.js"></script>
<script language="JavaScript" src="../js/IndividualCenter.js"> </script>

<!-- 
<script type="text/javascript">   
var myTime = setTimeout("Timeout()", 6000*30);   //30分钟超时

function resetTime() {   
    clearTimeout(myTime);   
    myTime = setTimeout('Timeout()', 6000*30);   
}  
  
function Timeout() {   
//    alert("您的登录已超时, 请点确定后重新登录!");   
    window.open('system/login.php', '_parent');
}   
//document.doocumentElement.click=resetTime;   
$('html').bind('keydown', function() { resetTime(); });
$(document).bind("click", function (e) {
	 resetTime();
	 alert("reset:"+myTime); 
});
</script>
 -->

<!--
<script type="text/javascript" src="<?php echo JS_PATH?>qipaoAlarm.js"></script>

-->



</script>
<body>

<!--头部-->
<div id="header" class="clearfix">
	<div id="user_info" style="display: none">
		<input type="text" style="display: none"  id="ID" value="1"/>
		<input type="text" style="display: none"  id="isUser" value='<?php echo $_SESSION['isUser'] ?>' />
	</div>
	<div class="hl">
    	<div class="logo fl"><img src="../images/logo_tmp.png"/></div> 
    </div>
    <div class="clear"></div>    
</div>
<!--导航-->
<div class="title1">
	<input type="text" id="Admin_ID" style="display:none" name="<?php echo $_SESSION['Admin_Name'] ?> "
	 value=" <?php  echo $_SESSION['Admin_ID'] ?> " />
	<input type="text" style="display:none" id="User_ID" name= "<?php echo $_SESSION['UserName'] ?> "
	 value=" <?php  echo $_SESSION['User_ID'] ?>" />
    <div class="ml-20 fl">返回位置：<a href="../">首页</a><em id="secondNav"></em></div>
    <div class="fr mr-32">
        <em><?php
if($_SESSION['isUser']==0){
	if(isset($_SESSION['Admin_Name'])&&$_SESSION["Admin_Name"]=="")
	echo $_SESSION['Admin_Name'];
	else 
	echo "管理员";
}
else if($_SESSION['isUser']==1){
	if (isset($_SESSION['UserName']) && $_SESSION['UserName'] != '')
    echo $_SESSION['UserName'];
	else 
	echo "用户";
}
?>，欢迎您!</em>
        <em class="ml-20 mr-32"><?php 
        if($_SESSION['LastLogInTime']=='')
        	echo '';
        else 
        	echo "您上次登录系统是在".$_SESSION['LastLogInTime'];
        ?>
        </em>
      	<a style="cursor: pointer" onclick="changePwd()" class=" ml-20">修改密码</a>
        <a style="cursor: pointer" onclick="logout()" class=" ml-20">退出登录</a>
    </div>
</div>
<!--内容-->
<div id="content">
    	<!--左侧-->
        <div class="conleft">
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#457387"><tr><td>
    
        		<div <?php if($_SESSION['isUser']=='0') echo "style='display:none''" ?> >
            		<p><span>预约记录</span><em class="array">&nbsp;</em></p>
            		<ul style="display:none">
            	   		<li><a onclick="check_reservation()">查看当前预约</a></li>
		           		<li><a onclick="check_history()">查看历史预约</a></li>
           			 </ul>
            	</div>
            	<div <?php if($_SESSION['isUser']=='0') echo "style='display:none''" ?>>
            		<p><span>个人信息</span><em class="array">&nbsp;</em></p>
            		<ul style="display:none">
		           		<li><a onclick="cash_in()">账户充值</a></li>
            		</ul>
            	</div>	
            	<div <?php if($_SESSION['isUser']=='1') echo "style='display:none''" ?>>
            		<p><span>管理医院</span><em class="array">&nbsp;</em></p>
            		<ul style="display:none">
						<li <?php if($_SESSION['isSuper']!='1') echo "style='display:none''" ?> ><a onclick="create_hospital()" >添加医院</a></li>
						<li <?php if($_SESSION['isSuper']!='1') echo "style='display:none''" ?> ><a onclick="config_hospital()">配置医院信息</a></li>
						<li <?php if($_SESSION['isSuper']=='1') echo "style='display:none''" ?> ><a  onclick="config_hospital_ordinary_admin()">配置医院信息</a></li>
						<li <?php if($_SESSION['isSuper']=='1') echo "style='display:none''" ?> ><a onclick="create_doctor()">添加医生</a></li>
						<li <?php if($_SESSION['isSuper']=='1') echo "style='display:none''" ?> ><a onclick="config_doctor()">配置医生信息</a></li>
					</ul>
            	</div>
            	<div <?php if($_SESSION['isUser']=='1') echo "style='display:none''" ?>>
            		<p><span>管理用户</span><em class="array">&nbsp;</em></p>
            		<ul style="display:none">
						<li><a onclick="check_user()">审核用户</a></li>
						<li><a onclick="config_user()">配置用户信息</a></li>
					</ul>
            	</div>
            
            	<div <?php if($_SESSION['isSuper']!='1'|| $_SESSION['isUser']=='1') echo "style='display:none''" ?>>
            		<p><span>管理管理员</span><em class="array">&nbsp;</em></p>
            		<ul style="display:none">
						<li><a onclick="create_admin()">创建管理员</a></li>
						<li><a onclick="config_admin()">配置管理员信息</a></li>
					</ul>
            	</div>
           </table>
        </div>       
        <!--右侧-->
        <div class="conright" id="content_page">     
        	<iframe  id='rightFrame' width="100%" id="frame" frameborder="no" border="0" scrolling="no"></iframe>
		</div>
</div>
<div id="changePwd_div" style="display: none">
	<span>原密码&nbsp;&nbsp;&nbsp;</span>
	<input type="password" id="old_pwd" />
	<br />
	<span id="old_incorrect" style="display: none">原密码不正确</span>
	<br />
	<span>新密码&nbsp;&nbsp;&nbsp;</span>
	<input type="password" id="new_pwd" />
	<br />
	<br />
	<span>再次确认</span>
	<input type="password" id="confirm_pwd" />
	<br />
	<span id="pwd_no_match" style="display: none">两次输入新密码不一致</span>
	<br />
	<input type="button" id="confirm_btn" onclick="confirm_pwd()" value="确认"/>
	<input type="button" id="cancel_btn"  onclick="cancel_pwd()" value="取消" />
</div>

</body>
</html>
