<?php
/**
 * shortcut.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-3-1,created by Xu Guozhi
 */
require_once 'include/common.inc.php';
require_once 'include/global.func.php';
//require_once 'include/session_timeout.inc.php';
 ?>
 <?php include header_inc() ?>
 <script type="text/javascript">
function showPosition(content){
	obj = parent.secondNav;
	obj.innerHTML=" \\ "+content;
}
</script>
 <!-- 
 <body>
  -->
 <div class="page">
 <table width="717" border="0" align="center" style="clear:both; margin-top:80px;">
  <tr>
    <td height="150" ><div class="page_tp">

<?php 
$baseRole = $_SESSION['baseRole'];
$uid = $_SESSION['id'];
if($baseRole=='1'&& $uid!='4') {//system admin
	?>
	<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>user2_small.jpg" border="0" /></a>
<h6>用户管理</h6>
<p>点击这里进行用户管理，添加用户，修改用户等。<a href="system/userMgr.php">马上管理>></a></p>
</div>		
	</div></td>
    <td height="150"><div class="page_tp">
<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>user_small.jpg" border="0" /></a>
<h6>角色管理</h6>
<p>点击这里进行角色管理，添加角色，修改角色权限等。<a href="system/roleMgr.php">马上管理>></a></p>
</div>		
	</div></td>
  </tr>
  <tr>
    <td height="150"><div class="page_tp">
<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>pic3.jpg" border="0" /></a>
<h6>归档配置</h6>
<p>点击这里可以配置归档数据库信息。<a href="system/archive_database.php">马上配置>></a></p>
</div>		
	</div></td>
    <td height="150"><div class="page_tp">
<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>email_small.jpg" border="0" /></a>
<h6>邮件配置</h6>
<p>点击这里可以配置邮件报警的邮件信息。<a href="system/ssmtp_email.php">马上配置>></a></p>
</div>			
	</div></td>
  </tr>
  <tr>
    <td height="150">
    <!-- 
    <div class="page_tp">
		<div class="page_tp_nr1">
		<a><img src="<?php echo IMAGE_PATH?>pic5.jpg" border="0" /></a>
		<h6>升级</h6>
		<p>点击这里进行系统升级。<a href="#">马上开始扫描>></a></p>
		</div>	
	</div>
     -->
    </td>
    <td height="150" >&nbsp;</td>
  </tr>
  
</table>
</div>
	
	<?php
} else if($baseRole=='1'&& $uid=='4'){//rights admin
?>
<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>user2_small.jpg" border="0" /></a>
<h6>用户审核</h6>
<p>点击这里进行用户审核。。<a href="system/userReview.php">马上审核>></a></p>
</div>		
	</div></td>
    <td height="150"><div class="page_tp">
<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>user_small.jpg" border="0" /></a>
<h6>角色审核</h6>
<p>点击这里进行角色审核。<a href="system/roleReview.php">马上审核>></a></p>
</div>		
	</div></td>
  </tr>
  <tr>
    <td height="150"><div class="page_tp">
<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>pic3.jpg" border="0" /></a>
<h6>归档配置</h6>
<p>点击这里可以配置归档数据库信息。<a href="system/archive_database.php">马上配置>></a></p>
</div>		
	</div></td>
    <td height="150"><div class="page_tp">
<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>email_small.jpg" border="0" /></a>
<h6>邮件配置</h6>
<p>点击这里可以配置邮件报警的邮件信息。<a href="system/ssmtp_email.php">马上配置>></a></p>
</div>			
	</div></td>
  </tr>
  <tr>
    <td height="150">
    <!-- 
    <div class="page_tp">
		<div class="page_tp_nr1">
		<a><img src="<?php echo IMAGE_PATH?>pic5.jpg" border="0" /></a>
		<h6>升级</h6>
		<p>点击这里进行系统升级。<a href="#">马上开始扫描>></a></p>
		</div>	
	</div>
     -->
    </td>
    <td height="150" >&nbsp;</td>
  </tr>
  
</table>
</div>
<?php	
}else if($baseRole=='2') {//operator
	?>
	<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>pic2.jpg" border="0" /></a>
<h6>策略定制</h6>
<p>点击这里进行审计策略定制，个性化选择审计规则制定策略。<a href="policy/policyMgr.php" onclick="showPosition('策略定制');">马上配置>></a></p>
</div>		

<!--
<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>pic1.jpg" border="0" /></a>
<h6>入侵检测</h6>
<p>点击这里进行入侵检测规则的配置和管理。<a href="ids/idsRules.php" onclick="showPosition('入侵检测');">马上配置>></a></p>
</div>
-->		
	</div></td>
    <td height="150">
<div class="page_tp">
<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>archive_small.jpg" border="0" /></a>
<h6>数据备份</h6>
<p>点击这里进行数据备份和恢复。<a href="backup/backup.php" onclick="showPosition('数据备份');">马上备份>></a></p>
</div>
		
<!--
<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>pic2.jpg" border="0" /></a>
<h6>策略定制</h6>
<p>点击这里进行审计策略定制，个性化选择审计规则制定策略。<a href="policy/policyMgr.php" onclick="showPosition('策略定制');">马上配置>></a></p>
</div>
-->
	</div></td>
  </tr>
  <tr>
    <td height="150"><div class="page_tp">
<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>pic3.jpg" border="0" /></a>
<h6>审计结果</h6>
<p>点击这里可以查看审计出来的结果列表。<a href="monitor/auditResult.php" onclick="showPosition('审计结果');">马上查看>></a></p>
</div>		
	</div></td>
    <td height="150"><div class="page_tp">
<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>pic4.jpg" border="0" /></a>
<h6>统计报表</h6>
<p>点击这里可以查看风险事件，流量等统计信息。<a href="report/static.php" onclick="showPosition('统计报表');">马上查看>></a></p>
</div>			
	</div></td>
  </tr>
  <tr>
    <td height="150">
    <!-- 
    <div class="page_tp">
		<div class="page_tp_nr1">
		<a><img src="<?php echo IMAGE_PATH?>pic5.jpg" border="0" /></a>
		<h6>升级</h6>
		<p>点击这里进行系统升级。<a href="#">马上开始扫描>></a></p>
		</div>	
	</div>
     -->
    </td>
    <td height="150" >&nbsp;</td>
  </tr>
  
</table>
</div>
	
	
	<?php
} else if($baseRole=='3') {//auditor
	?>
	<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>pic1.jpg" border="0" /></a>
<h6>日志审计</h6>
<p>点击这里进行审计日志管理。<a href="log/userlog.php?usr=mgr" onclick="showPosition('审计日志管理');">马上管理>></a></p>
</div>		
	</div></td>
    <td height="150"><div class="page_tp">
<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>pic2.jpg" border="0" /></a>
<h6>数据备份</h6>
<p>点击这里进行能将数据进行备份。<a href="backup/backup.php?tab=log" onclick="showPosition('数据备份');">马上备份>></a></p>
</div>		
	</div></td>
  </tr>
  <tr>
    <td height="150"><div class="page_tp">
<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>pic3.jpg" border="0" /></a>
<h6>数据还原</h6>
<p>点击这里可以将数据进行还原。<a href="backup/restore.php?tab=log" onclick="showPosition('数据还原');">马上还原>></a></p>
</div>		
	</div></td>
    <td height="150"><div class="page_tp">
<div class="page_tp_nr1">
<a><img src="<?php echo IMAGE_PATH?>archive_small.jpg" border="0" /></a>
<h6>数据归档</h6>
<p>点击这里可以将数据进行归档。<a href="backup/archive.php?tab=log" onclick="showPosition('数据归档');">马上归档>></a></p>
</div>			
	</div></td>
  </tr>
  <tr>
    <td height="150">
    <!-- 
    <div class="page_tp">
		<div class="page_tp_nr1">
		<a><img src="<?php echo IMAGE_PATH?>pic5.jpg" border="0" /></a>
		<h6>升级</h6>
		<p>点击这里进行系统升级。<a href="#">马上开始扫描>></a></p>
		</div>	
	</div>
     -->
    </td>
    <td height="150" >&nbsp;</td>
  </tr>
  
</table>
</div>
	<?php
}
?>
<!-- 

</body>
</html>
-->