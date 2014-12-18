<?php
/**
 * 数据归档
 * archive.tpl.php-.
 * @author Chenhuan<iconverseme@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-27,created by Chenhuan
 */
include header_inc();
 ?>
<script type="text/javascript" src="<?php echo JS_PATH?>backup/backup.js?"></script>
<script type="text/javascript">
<!--
function archive() {
	document.archiveForm.submit();
}
//-->
</script>
<body onload="getSysInfo()">
<h5 class="title102"><em>数据归档</em></h5>
<!-- 以下部分用来自动归档，判断是否需要自动归档 -->
<!-- 
<div class="box102 p20">
		<font style="font-size: 14px;">数据库所在磁盘当前使用情况：</font>
					<table border="0" cellspacing="0" cellpadding="0" width="450" class="tab2">
			       		<tr>
			           	<td><div id='disk'></div></td>
			       		</tr>
		</table>
		<?php if($percentage>80){
			?>
			<font color="red">数据库所在磁盘当前已用<?php echo $percentage."%"?>，请归档！</font>
			<?php
		} else {
			?>
			<font color="green">数据库所在磁盘当前已用<?php echo $percentage."%"?>，可不归档！</font>
			<?php	
		}
		?>
</div>
-->
<div class="box102 p20">
	<div class="tabContent">
		
		<div style="">
		<table border="0" cellspacing="0" width="100%" cellpadding="0" class="tab3">
			<tr>
				<td>用户可以定期的对数据库里面的数据进行归档。</td>
			</tr>
		</table>
		</div>
	
		<div style="margin-top:30px;">
		<form action="archive.php?cmd=archive" name="archiveForm" method="post">
			<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab1">    
                    <tr>
                    	<td class="btn" colspan="<?php echo count($backupTableList)?>">
                        	<a href="#" class="tijiao" onclick="archive();">归档</a><a href="javascript:history.go(-1);" class="repire">返回</a>
                        </td>   
                    </tr>
             </table>   
		</form>
		</div>
	</div>
</div>
<script type="text/javascript">
swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "disk", "450", "200", "9.0.0", "expressInstall.swf",{"data-file":"<?php echo WEB_ROOT?>pie.json"}, {"wmode":"transparent"} );
</script>
</body>
</html>