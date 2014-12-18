<?php
/**
 * report.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-3-16,created by Xu Guozhi
 * 2014-1-10,modified by zhangxin
 */
include header_inc();
 ?>
 <script>
 $(function(){
	 $('#newReport').dialog({
		 	autoOpen: false,
			resizable: true,
			height:'auto',
			width:'auto',
			modal: true,
			position:"top",
			title:"生成新报告",
			buttons: {
				"确定": function(){
					document.newReportFrm.submit();
					$(this).dialog("close");
				},
				"取消": function() {
					$( this ).dialog( "close" );
				}
			}
	 });

	 
});
 
 function reportPage(pageNo)
 {
	 
	 if(pageNo == -1) {
		 pageNo = $('#reportPageNum').val();
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
			 tplId = $("#tplIdHidden").val();
			 window.location.href="report.php?tplId="+tplId+"&page=reportPage&pageNo="+pageNo;
		 }
		 
	 }
	 
 }

 function deleteReport(tplId,reportId,name,format)
 {
	 $.post(WEB_ROOT+'report/report.php?tplId='+tplId+'&cmd=delete',{
		    'format':format,
			'reportId':reportId,
			'fileName':name
		},function(data){
			if(data == "OK"){
//				alert("删除成功！");
//				artDialog({content:'删除成功！', style:'succeed'}, function(){
					window.location.href="report.php?tplId="+tplId;
//				});
			} else {
//				alert("服务器出错，删除失败！请重试！");
				artDialog({content:'服务器出错，删除失败！请重试！', style:'error'}, function(){
					window.location.href="report.php?tplId="+tplId;
				});
			} 
		});
 }

 function deleteAllReport(){
	 $.post(WEB_ROOT+'report/report.php?cmd=deleteAll',{
		 
		},function(data){
			if(data == "OK"){
//				alert("删除成功！");
//				artDialog({content:'全部删除成功！', style:'succeed'}, function(){
					window.location.href="report.php?tplId=1";
//				});
			} else {
//				alert("服务器出错，删除失败！请重试！");
				artDialog({content:'服务器出错，删除失败！请重试！', style:'error'}, function(){
					window.location.href="report.php?tplId=1";
				});
			} 
		});
	 }

function deletebyDate(){
	$.post(WEB_ROOT+'report/report.php?cmd=deletebydate',{
		 'beginDate':$("#beginDate").val(),
	     'endDate':$("#endDate").val()
	},function(data){
		if(data == "OK"){
//			alert("删除成功！");
//			artDialog({content:$("#beginDate").val()+'至'+$("#endDate").val()+'内的报表删除成功！', style:'succeed'}, function(){
				window.location.href="report.php?tplId=1";
//			});
		} else {
//			alert("服务器出错，删除失败！请重试！");
			artDialog({content:'服务器出错，删除失败！请重试！', style:'error'}, function(){
				window.location.href="report.php?tplId=1";
			});
		} 
	});
}
 </script>
 <body>
<h5 class="title102"><em>已生成的报告</em><span style="padding-top:0px"><a href="javascript:void(0)" onclick="deleteAllReport()" class="neibu"><b>全部删除</b></a>&nbsp;<a href="javascript:void(0)" onclick="$('#newReport').dialog('open');" class="neibu"><b>生成新报告</b></a></span></h5>

<div class="box102 p20">
<div>
		<form name="reportOpeForm" method="post">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr><td class="border_r0" align="center">
                    <input name="beginDate" id='beginDate' size="15" value='<?php echo $beginDate?$beginDate:date('Y-m-01');?>' class="Wdate" onClick="WdatePicker()" type="text">
                    至
                    <input name="endDate" id='endDate' size="15" value='<?php echo $endDate?$endDate:date('Y-m-d');?>' maxlength="10" class="Wdate" onClick="WdatePicker()" type="text">
                    <a href="javascript:void(0)" onclick="deletebyDate()" class="neibu">删除</a> 
                 </td></tr>
		</table>
		</form>
</div>
<br />
<hr />
<input type="hidden" name="tplIdHidden" id="tplIdHidden" value="<?php echo $tplId?>"/>
<!-- 
<input type="hidden" name="reportPageNum" id="reportPageNum" value="<?php echo $pageNo?>"/>
 -->
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">		
		<tr><th>名称</th><th>格式</th><th>备注</th><th class="border_r0">创建日期</th><th>操作</th>
					<?php if($filelist){foreach ($filelist as $file){?>
		<tr>
			<td><a href="<?php echo $tplId?>/<?php echo $file['Name']?>" target="_blank"><?php echo $file['Name']?></a></td>
			<td><?php echo $file['ReportFormat']?></td>
			<td><?php echo $file['Remark']?></td>
			<td><?php echo $file['CreateTime']?></td>
			<td class="border_r0"><a href="#" class="neibu" style="color: white;" onclick="deleteReport(<?php echo $file['TplID']?>,<?php echo $file['ReportId']?>,'<?php echo $file['Name']?>','<?php echo $file['ReportFormat']?>');">删除</a></td>
		</tr>
		<?php }}?>				
	</table>
	<?php echo $page->toString()?>
</div>

<div id="newReport" style="display:none;">
	<form action="" target="_blank" name="newReportFrm">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab5">
		<tr><td>选择数据的日期:</td>
		<td><input name="startDate" id='startDate' value='<?php echo $startDate?$startDate:date('Y-m-01');?>' maxlength="10" class="Wdate" onClick="WdatePicker()" type="text">
		<input name="endDate" id='endDate' value='<?php echo $endDate?$endDate:date('Y-m-d');?>' maxlength="10" class="Wdate" onClick="WdatePicker()" type="text">
		</td>
		</tr>
		<tr><th>报告格式</th><td><select name="format"><option value="pdf">pdf</option><option value="html">html</option></td>
		<input type="hidden" name="cmd" value="generate"/>
		<input type="hidden" name="tplId" value="<?php echo $tplId?>"/>
	</table>
	</form>
</div>
 </body>
 </html>