<?php 
require_once 'include/common.inc.php';
require_once 'include/global.func.php';
include header_inc();
?>
<style type="text/css">
    .popWindow{
        text-align: center;
        z-index:2;
        width:600px;
        height:300px;
        left: 50%;
        top: 50%;
        margin-left: -250px;
        margin-top: -150px;
        position: absolute;
        background:#FFFFFF;
    }
    .head-box{
        width:500px;
        height:25px;
        background:#4A4AFF;
    }
    .maskLayer {
        background-color:#9D9D9D;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        filter: alpha(opacity=50);
        opacity: 0.5;
        z-index: 1;
        position: absolute;
    }
</style>
<style>
body{background:#e3e3e3 url(<?php echo IMAGE_PATH?>bg2.jpg) repeat-x; height:100%;}
</style>
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

<script type="text/javascript" src="<?php echo JS_PATH?>qipaoAlarm.js"></script>
<body onload="goTop()">

<!--头部-->
<div id="header" class="clearfix">
	<div class="hl">
    	<div class="logo fl"><img src="<?php echo IMAGE_PATH?>logo.png"/></div> 
    </div>
    <div class="clear"></div>    
</div>

<!--导航-->
<div class="title1">
    <div class="ml-20 fl">当前所在位置：<a href="<?php echo WEB_ROOT?>">首页</a><em id="secondNav"></em></div>
    <div class="fr mr-32">
        <em><?php
if (isset($_SESSION['fullName']) && $_SESSION['fullName'] != '')
    echo $_SESSION['fullName'];
else
    echo $_SESSION['username'];
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
        <a href="javascript:void(0);" onclick="logout()" class=" ml-20">退出登录</a>
    </div>
</div>

<!--内容-->
<div id="content">
    	<!--左侧-->
        <div class="conleft">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#457387"><tr><td>
        	<?php
        	foreach($main_menus as $menu){ 
        	?>
        	<div>
            <p><span class="licon<?php echo ($menu['MenuID']);?>"><?php echo $menu['MenuText']?></span><em class="array">&nbsp;</em></p>
            <ul style="display:none">
            	<?php
            	    for($i = 0; $i < count($submenu[$menu['MenuID']]); $i++)
            	    {
            	        $item = $submenu[$menu['MenuID']][$i];
            	?>
                <li class="<?php if($i == 0) echo 'first';?> <?php if($i ==count($submenu[$menu['MenuID']])-1) echo 'last'?>">
                <a href="javascript:void(0);" onclick="command('<?php echo $item['Module']?>','<?php echo $item['Command']?>','<?php echo $item['CmdParam']?>','<?php echo $item['MenuText']?>')"><?php echo $item['MenuText']?></a></li>
				<?php }?>
            </ul>
            </div>
            <?php }?>
            </td></tr></table>
        </div>       
        <!--右侧-->
        <div class="conright">
        	<div style="padding:20px;">
            <!--列表模块-->     
        	<iframe src="<?php echo WEB_ROOT?>shortcut.php" id='rightFrame' width="100%" id="frame" frameborder="no" border="0" scrolling="no"></iframe>
             </div>
             
             
        <div class="clear"></div>
		</div>
</div>
<div id="alarmDialog" style="display:none;">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
		<caption><font style="color:red;">未审核的报警信息列表</font></caption>
		<thead>
		<tr>
			<th>数据库</th>
			<th>风险次数</th>
			<th>未审核风险次数</th>
			<th>IP数</th>
		</tr>
		</thead>
		<tbody id="alarmInfoTbody"></tbody>
	</table>
</div>

<!--  -->
<div id="popWindow" class="popWindow" style="display: none;">
       <img src="<?php echo IMAGE_PATH?>waiting_backup.jpg" width="100%">
    </div>
    <div id="maskLayer" class="maskLayer" style="display: none;">
    </div>
</body>
</html>
