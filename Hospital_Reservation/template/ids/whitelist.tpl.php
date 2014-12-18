<?php
/**
 * whitelist.pl.php-.
 * @author Fu Cheng
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-10,created by Fu Cheng
 */
 include header_inc();
 ?>
 <script type="text/javascript">
function select(){
	var ServiceId = $("#ServiceId").val();
	window.location.href="whitelist.php?ServiceId="+ServiceId;
}
function disableWhite(whilelistId) {
//	window.location.href="whitelist.php?cmd=disable&whitelistId="+whilelistId;
	$.ajax({
		url:"whitelist.php?cmd=disable&whitelistId="+whilelistId,
		type:"POST",
		dataType:"text",
		success:function(data){
			if(data=="ERROR"){
				artDialog({content:'服务器出错，禁用失败，请重试！', style:'error'}, function(){});
			} else {
				artDialog({content:'禁用成功！', style:'succeed'}, function(){
					window.location.href="whitelist.php";
				});
			}
		}
	});
}
function enableWhite(whilelistId) {
//	window.location.href="whitelist.php?cmd=enable&whitelistId="+whilelistId;
	$.ajax({
		url:"whitelist.php?cmd=enable&whitelistId="+whilelistId,
		type:"POST",
		dataType:"text",
		success:function(data){
			if(data=="ERROR"){
				artDialog({content:'服务器出错，启用失败，请重试！', style:'error'}, function(){});
			} else {
				artDialog({content:'启用成功！', style:'succeed'}, function(){
					window.location.href="whitelist.php";
				});
			}
		}
	});
}
function deleteWhite(whilelistId){
	$.ajax({
		url:"whitelist.php?cmd=delete&whitelistId="+whilelistId,
		type:"POST",
		dataType:"text",
		success:function(data){
			if(data=="ERROR"){
				artDialog({content:'服务器出错，删除失败，请重试！', style:'error'}, function(){});
			} else {
				artDialog({content:'删除成功！', style:'succeed'}, function(){
					window.location.href="whitelist.php";
				});
			}
		}
	});
}
function updateWhite(whilelistId) {
	window.location.href="whitelistInfo.php?whitelistId="+whilelistId;
}

function whitePage(pageNo)
{
//	 if(pageNo == -1){
//		pageNo = $('#whitePageNum').val();
//	 }
//	 window.location.href="whitelist.php?page=whitePage&pageNo="+pageNo;

	 
	 if(pageNo == -1) {
		 pageNo = $('#whitePageNum').val();
	 }
	 var re = /^[1-9]\d*$/;
	 pageCount = $("#pageCountHidden").val();
	 if ((!re.test(pageNo)) || (parseInt(pageNo) > parseInt(pageCount)))
	 {
	   	 alert("必须为正整数，且不能大于"+pageCount);
	 } else {
		 var currentPageNo = parseInt($(".numon").html());
		 if(parseInt(pageNo)==currentPageNo){
			alert("当前为"+pageNo+"页");
		 } else{
			 window.location.href="whitelist.php?page=whitePage&pageNo="+pageNo;
		 } 
	 }
}
</script>
 <body>
 <h5 class="title102"><em>入侵检测白名单</em></h5>
<div class="box102 p20">
  <form action="<?php echo WEB_ROOT?>ids/whitelist.php?cmd=select" method="post">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
             	<tbody>
                	<tr>
						<td align="center">
                        	数据库：
                        	<select name='ServiceId' id='ServiceId' style="width: 250px;">
                        	<option value="">全部数据库</option>
                        <?php foreach($Services as $service){?>
                        <option value='<?php echo $service['ServiceId']?>' <?php echo $service['ServiceId']==$ServiceId?'selected':''?>><?php echo $service['ServerName'].':'.$service['Name'].':'.$service['ServiceName'];?> </option>
                        <?php }?>
                        </select>
                        &nbsp;&nbsp;
                        <a href="#" class="neibu" onclick="select();"><b>查询</b></a>
                        <a href="whitelistInfo.php" class="neibu"><b>添加</b></a></td>
            
                        
                     </tr>            
		</tbody>
	</table>
  </form>
</div>

<div class="box102 p20">
<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4" style="text-align: center;">
	<tr width="100%">
		<th width="10%">数据库</th>
       	<th width="20%">IP范围名称</th>
       	<th width="10%">开始IP</th>
        <th width="10%">结束IP</th> 
        <th width="10%">启用状态</th> 
        <th>操作</th> 
	</tr>
	<?php 
	if(count($whitelistList) > 0) {
		foreach ($whitelistList as $white) {
			?>
			<tr>
			<td><?php echo $white['ServerName'].":".$white['ServiceName'].":".$white['Protocol']?></td>
			<td><?php echo $white['RangeName']?></td>
			<td><?php echo $white['StartIP']?></td>
			<td><?php echo $white['EndIP']?></td>
			<td><?php 
			if ($white['Enabled']==1) {
				echo "启用";
			}else{
				echo "禁用";
			}
			?></td>
			<td class="border_r0">
            	<?php if($white['Enabled']==1){
            		?>
            		<a href="#" class="neibu" style="color: white;" onclick="disableWhite(<?php echo $white['WhitelistId']?>);">禁用</a>
            		<?php
            	}else{
            		?>
            		<a href="#" class="neibu" style="color: white;" onclick="enableWhite(<?php echo $white['WhitelistId']?>);">启用</a>
            		<?php
            	}?>
            	<a href="#" class="neibu" style="color: white;" onclick="updateWhite(<?php echo $white['WhitelistId']?>);">修改</a>
            	<a href="#" class="neibu" style="color: white;" onclick="deleteWhite(<?php echo $white['WhitelistId']?>);">删除</a>
            </td>
			</tr>
			<?php
		}
		
	} else {
			
	}
	?>	
</table> 
</div>
<div class="box102 p20">
<?php echo $page->toString()?>
</div>
 </body>
 </html>
