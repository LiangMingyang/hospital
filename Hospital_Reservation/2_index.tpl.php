<?php 
require_once '../include/common.inc.php';
require_once '../include/global.func.php';
include header_inc();

if(!isset($_SESSION))
session_start();
if($_SESSION['isUser']=='#'){
 	echo "<script>window.location.href='unkonwn.php'</script>";
 }
 else {
 	echo "isUser=".$_POST['isUser'];
 }
   $_SESSION['isUser']=$_POST['isUser'];
   if($_SESSION['isUser']=='1'){
   	  $_SESSION["Province_ID"]=$_POST["Province_ID"];
      $_SESSION["Province_Name"]=$_POST['Province_Name'];
      $_SESSION["Credit_Rank"]=$_POST['Credit_Rank'];
      $_SESSION["User_Name"]=$_POST['User_Name'];
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
   }
   else{
   	 $_SESSION['Admin_ID']=$_POST['Admin_ID'];
	 $_SESSION['Admin_Name']=$_POST['Admin_Name'];
	 $_SESSION['isSuper']=$_POST['isSuper'];
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
<body onload="goTop()">

<!--头部-->
<div id="header" class="clearfix">
	<div class="hl">
    	<div class="logo fl"><img src="../images/logo_tmp.png"/></div> 
    </div>
    <div class="clear"></div>    
</div>
<!--导航-->
<div class="title1">
    <div class="ml-20 fl">当前所在位置：<a href="<?php echo WEB_ROOT?>">首页</a><em id="secondNav"></em></div>
    <div class="fr mr-32">
        <em><?php
if (isset($_SESSION['User_Name']) && $_SESSION['User_Name'] != '')
    echo $_SESSION['User_Name'];
else
    echo "用户";
?>，欢迎您!</em>
        <em class="ml-20 mr-32"><?php 
        if($_SESSION['lastLoginTime']=='')
        	echo '';
        else 
        	echo "您上次登录系统是在".$_SESSION['lastLoginTime'];
        ?>
        </em>
      	<!-- <a href="#">修改密码</a> -->
      	<!-- 
      	<a href="javascript:void(0);" onclick="updatePass();">修改密码</a>
      	 -->
        <a style="cursor: pointer" onclick="logout()" class=" ml-20">退出登录</a>
    </div>
</div>
<!--内容-->
<div id="content">
    	<!--左侧-->
        <div class="conleft">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#457387"><tr><td>
    
        	<div>
            <p><span>预约记录</span><em class="array">&nbsp;</em></p>
            <ul style="display:none">
            	   <li><a onclick="check_reservation()">查看当前预约</a></li>
		           <li><a onclick="check_history()">查看历史预约</a></li>
            </ul>
            </div>
            <div>
            <p><span>个人信息</span><em class="array">&nbsp;</em></p>
            <ul style="display:none">
            	   <li><a onclick="set_individual_info()">配置个人信息</a></li>
		           <li><a onclick="cash_in()">账户充值</a></li>
            </ul>
            </div>
            <div>
            <p>
            <span>管理医院</span><em class="array">&nbsp;</em>
            </p>
            <ul style="display:none">
				<li><a onclick="create_hospital()">创建医院</a></li>
				<li><a onclick="del_hospital()">删除医院</a></li>
				<li><a onclick="config_hospital()">配置医院信息</a></li>
				<li><a onclick="config_doctor()">配置医生信息</a></li>
			</ul>
            </div>
            <div>
            <p>
            <span>管理用户</span><em class="array">&nbsp;</em>
            </p>
            <ul style="display:none">
				<li><a onclick="check_user()">审核用户</a></li>
				<li><a onclick="config_user()">配置用户信息</a></li>
			</ul>
            </div>
            <div>
            <p>
            <span>管理管理员</span><em class="array">&nbsp;</em>
            </p>
            <ul style="display:none">
				<li><a onclick="create_admin()">创建管理员</a></li>
				<li><a onclick="config_admin">配置管理员信息</a></li>
			</ul>
            </div>
           </table>
        </div>       
        <!--右侧-->
        <div class="conright">     
        	<iframe  id='rightFrame' width="100%" id="frame" frameborder="no" border="0" scrolling="no"></iframe>
		</div>
</div>


</body>
</html>
