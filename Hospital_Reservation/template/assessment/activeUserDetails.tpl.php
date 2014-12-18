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
		window.location.href="activeUserDetails.php?cmd=longTime&days="+$("#daysHidden").val()+"&targetServiceId="+$("#serviceIdHidden").val()+"&page=neverPage&pageNo="+pageNo;
}
</script>

 <body>
 <h5 class="title102"><em>长时间未活动的用户</em></h5>


<!-- 长时间未活动的用户显示 -->
<div class="box102 p20">
  <p style="font-family:'Lucida Grande', 'Lucida Sans Unicode', Verdana, Arial, Helvetica, sans-serif;font-size:16px;color:#274b6d;fill:#274b6d;" align="center">长时间未活动的用户</p>
  <br/>
  <input type="hidden" name="serviceIdHidden" id="serviceIdHidden" value="<?php echo $targetServiceId?>"/>
  <input type="hidden" name="daysHidden" id="daysHidden" value="<?php echo $days?>"/>
  	<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
		<tr>
			<th width="10%">编号</th>
			<th width="20%">用户名</th>
			<th>所在数据库</th>
			<th>未活动天数</th>
		</tr>
		<?php 
		if($userList){
		foreach ($userList as $user) {
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
				<td>
				<?php echo $user['diff_days']?>
				</td>
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
