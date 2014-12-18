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

function deleteBlack(blackListId){
	$.ajax({
		url:"blackList.php?cmd=delete&blacklistId="+blackListId,
		type:"POST",
		dataType:"text",
		success:function(data){
			if(data=="ERROR"){
				artDialog({content:'服务器出错，删除失败，请重试！', style:'error'}, function(){});
			} else {
				artDialog({content:'删除成功！', style:'succeed'}, function(){
					window.location.href="blackList.php";
				});
			}
		}
	});
}

function page(pageNo)
{
	 if(pageNo == -1) {
		 pageNo = $('#pageNum').val();
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
			 var service = $("#serviceSelectHidden").val();
			 window.location.href="blackList.php?pageNo="+pageNo+"&page=page";

		 }
		 
	 }
}
</script>
 <body>
 <h5 class="title102"><em>入侵检测黑名单</em></h5>
<div class="box102 p20">
<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4" style="text-align: center;">
	<tr width="100%">
		<th width="10%">编号</th>
       	<th>IP地址</th>
        <th class="border_r0"><a href="addBlackIp.php" class="neibu">添加</a></th>
	</tr>
	<?php 
	if(count($blackList) > 0) {
		foreach ($blackList as $black) {
			?>
			<tr>
			<td><?php echo $black['UIpID']?></td>
			<td><?php echo $black['UIp']?></td>
			<td class="border_r0">
            	<a href="#" class="neibu" style="color: white;" onclick="deleteBlack(<?php echo $black['UIpID']?>);">删除</a>
            </td>
			</tr>
			<?php
		}
		
	} else {
			
	}
	?>	
</table> 
<?php echo $page->toString()?>
</div>
 </body>
 </html>