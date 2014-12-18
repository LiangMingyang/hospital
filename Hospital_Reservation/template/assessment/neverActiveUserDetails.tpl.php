<?php
/**
 * privilege.tpl.php-.
 * @author Fu Cheng
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-5-8,created by Fu Cheng
 */
 include header_inc();
 ?>
<script src="<?php echo JS_PATH?>highcharts/highcharts.js"></script>
<script src="<?php echo JS_PATH?>highcharts/modules/exporting.js"></script>
<script type="text/javascript">
function neverPage(pageNo)
{
	goToPage(pageNo,'never');
}
function goToPage(pageNo,type)
{
		if(pageNo == -1){
			pageNo = $('#pageNum').val();
		}
		window.location.href="activeUserDetails.php?cmd=unactive&targetServiceId="+$("#serviceIdHidden").val()+"&page=neverPage&pageNo="+pageNo;
}
</script>

 <body>
 <h5 class="title102"><em>从未活动用户</em></h5>

<!-- 从未活动过的用户 -->
<div class="box102 p20">
<p style="font-family:'Lucida Grande', 'Lucida Sans Unicode', Verdana, Arial, Helvetica, sans-serif;font-size:16px;color:#274b6d;fill:#274b6d;" align="center">从未活动过的用户</p>
  	<br/>
  	<input type="hidden" name="serviceIdHidden" id="serviceIdHidden" value="<?php echo $targetServiceId?>"/>
  	<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
		<tr>
			<th width="8%">编号</th>
			<th width="10%">用户名</th>
			<th width="20%">所在数据库</th>
			<th>数据库设置的权限</th>
		</tr>
		<?php 
		if($unactiveUserList){
		foreach ($unactiveUserList as $user) {
			?>
			<tr>
				<td><?php echo $user['id']?></td>
				<td><?php echo $user['username']?></td>
				<td><?php 
				foreach ($services as $service){
					if($user['service_id']==$service['ServiceId']){
						echo $service['ServerName'].":",$service['Protocol'].":".$service['ServiceName'];
						break;
					}
				}
				?></td>
				<td align="left">
				<?php 
					$userPrivStr = $user['db_privilege'];
					$privList = explode(",", $userPrivStr);
					$count=1;
					$showStr = "";
					foreach ($privList as $priv) {
						if($count%7==0){
							$showStr .= "<br/>";
						} else {
							$showStr .= $priv.",";
						}
						$count++;
					}
					echo $showStr;
				?></td>
			</tr>
			<?php
		}
		}
		?>
	</table>
	<?php if($neverPage) echo $neverPage->toString()?>
</div>
<div class="box102 p20" style="text-align: center;width: 100%;">
<center>
<div class="btn" style="width: 100px;">
    <a href="longTimeUser.php" class="neibu">返回</a>
</div>
</center>
</div>
 </body>
 </html>
